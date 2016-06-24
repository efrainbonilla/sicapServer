<?php

namespace AppBundle\Controller;

use AppBundle\Entity\FactProducto;
use AppBundle\Entity\Factura;
use AppBundle\Entity\RegDiario;
use AppBundle\Entity\Transporte;
use AppBundle\Form\RegDiarioType;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View as FOSView;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Voryx\RESTGeneratorBundle\Controller\VoryxController;

/**
 * RegDiario controller.
 *
 * @RouteResource("RegDiario")
 */
class RegDiarioRESTController extends VoryxController
{
    /**
     * Get a RegDiario entity.
     *
     * @View(serializerEnableMaxDepthChecks=true)
     *
     * @return Response
     */
    public function getAction(RegDiario $entity)
    {
        return $entity;
    }
    /**
     * Get all RegDiario entities.
     *
     * @View(serializerEnableMaxDepthChecks=true)
     *
     * @param ParamFetcherInterface $paramFetcher
     *
     * @return Response
     *
     * @QueryParam(name="q", nullable=true, description="Search text.")
     * @QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing notes.")
     * @QueryParam(name="limit", requirements="\d+", default="20", description="How many notes to return.")
     * @QueryParam(name="order_by", nullable=true, array=true, description="Order by fields. Must be an array ie. &order_by[name]=ASC&order_by[description]=DESC")
     * @QueryParam(name="filters", nullable=true, array=true, description="Filter by fields. Must be an array ie. &filters[id]=3")
     * @QueryParam(name="filters_operator", default="LIKE %...%", description="Option filter operator.")
     */
    public function cgetAction(ParamFetcherInterface $paramFetcher, Request $request)
    {
        try {
            $q = $paramFetcher->get('q');
            $offset = $paramFetcher->get('offset');
            $limit = $paramFetcher->get('limit');
            $order_by = $paramFetcher->get('order_by');
            $filters = !is_null($paramFetcher->get('filters')) ? $paramFetcher->get('filters') : array();
            $filters_operator = $paramFetcher->get('filters_operator');

            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:RegDiario');

            $order_by = array('regFech' => 'DESC', 'com' => 'DESC'/*, 'regId' => 'DESC'*/);

            if (!empty($q)) {
                $filters_ = array('regFech' => '');
                $filters = array_merge($filters, $filters_);

                $adapter = $entity->findByAdapter($filters, $order_by, $q, $filters_operator);
                $nbResults = $adapter->getNbResults();
                $entities = $adapter->getSlice($offset, $limit)->getArrayCopy();
            } else {
                $nbResults = $entity->getNbResults();
                $entities = ($nbResults > 0) ? $entity->findBy($filters, $order_by, $limit, $offset) : array();
            }

            if ($entities) {
                $request->attributes->set('_x_total_count', $nbResults);

                return $entities;
            }

            return FOSView::create('Not Found', Codes::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return FOSView::create($e->getMessage(), Codes::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * Create a RegDiario entity.
     *
     * @View(statusCode=201, serializerEnableMaxDepthChecks=true)
     *
     * @param Request $request
     *
     * @return Response
     */
    public function postAction(Request $request)
    {
        $data = $request->request->all();
        $transports = $request->request->get('transport');
        $invoices = $request->request->get('invoice');
        $optionDate = $request->request->get('optionDate');
        $dateNow = $request->request->get('dateNow');
        $dateOther = $request->request->get('dateOther');

        if (!((is_array($transports) && count($transports) > 0) && (is_array($invoices) && count($invoices) > 0))) {
            return FOSView::create('Error en el formulario', Codes::HTTP_INTERNAL_SERVER_ERROR);
        }

        foreach (array('dateNow', 'dateOther', 'optionDate') as $item) {
            if (!in_array($item, array_keys($data))) {
                return FOSView::create('Clave '. $item . ' Error en el formulario', Codes::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

        $now = new \DateTime('now');

        if ($optionDate === 'dateNow') {
            $dateNow = $now;
            $request->request->set('regFech', $dateNow->format('Y-m-d') . ' ' . $now->format('H:i:s'));
        } else {
            $dateOther = new \DateTime($dateOther);
            $request->request->set('regFech', $dateOther->format('Y-m-d') . ' ' . $now->format('H:i:s'));
        }

        $handle_error = false;
        foreach ($transports as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $akey => $avalue) {
                    if (in_array($akey, array('placa', 'marca', 'modelo', 'desc', 'cedu', 'nomb', 'apell', 'lic')) && !empty($avalue)) {
                        $handle_error = false;
                    } else {
                        $handle_error = true;
                        break;
                    }
                }
                if ($handle_error) {
                    break;
                }
            } else {
                $handle_error = true;
                break;
            }
        }

        if ($handle_error) {
            return FOSView::create('Campos invalidos.', Codes::HTTP_INTERNAL_SERVER_ERROR);
        }

        foreach ($invoices as $key => $value) {
            if (isset($value['product']) && is_array($value['product']) && (count($value['product']) > 0)) {
                foreach ($value['product'] as $akey => $avalue) {
                    foreach ($avalue as $bkey => $bvalue) {
                        if (!in_array($bkey, array('prod', 'prestc', 'cant', 'med', 'prestcNum'))) {
                            $handle_error = true;
                            break;
                        }
                    }
                    if ($handle_error) {
                        break;
                    }
                }
                if ($handle_error) {
                    break;
                }
            } else {
                $handle_error = true;
                break;
            }
        }

        if ($handle_error) {
            return FOSView::create('Campos invalidos.', Codes::HTTP_INTERNAL_SERVER_ERROR);
        }

        $em = $this->getDoctrine()->getManager();
        $entity = new RegDiario();

        foreach ($transports as $key => $value) {
            $entityTransp = new Transporte();
            $entityTransp->setTranspPlaca($value['placa']);
            $entityTransp->setTranspDesc($value['desc']);
            $entityTransp->setChofCedu($value['cedu']);
            $entityTransp->setChofNomb($value['nomb']);
            $entityTransp->setChofApell($value['apell']);
            $entityTransp->setChofNumLic($value['lic']);
            $entityTransp->setMarca($em->getRepository('AppBundle:TranspMarca')->find($value['marca']));
            $entityTransp->setModelo($em->getRepository('AppBundle:TranspModelo')->find($value['modelo']));
            $entity->addTransp($entityTransp);
        }

        foreach ($invoices as $key => $value) {
            $entityFactura = new Factura();
            $entityFactura->setFactCodi($value['invoice']);
            $entityFactura->setFactTotal($value['total']);
            $entityFactura->setFactObs(isset($value['obs'])? $value['obs'] : '');
            $entity->addFact($entityFactura);

            foreach ($value['product'] as $akey => $avalue) {
                $entityFactProducto = new FactProducto();
                $entityFactProducto->setProd($em->getRepository('AppBundle:Producto')->find($avalue['prod']));
                $entityFactProducto->setPrestcNum($avalue['prestcNum']);
                $entityFactProducto->setPrestcMed($em->getRepository('AppBundle:Medida')->find($avalue['prestc']));
                $entityFactProducto->setFprodCant($avalue['cant']);
                $entityFactProducto->setMed($em->getRepository('AppBundle:Medida')->find($avalue['med']));
                $entityFactura->addFactProd($entityFactProducto);
            }
        }

        $entity->setUser($this->getUserData());
        $regFech = $request->request->get('regFech');

        $entity->setRegFech(new \DateTime($regFech));

        $form = $this->createForm(new RegDiarioType(), $entity, array('method' => $request->getMethod()));
        $this->removeExtraFields($request, $form);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $entity;
        }

        return FOSView::create(array('errors' => $form->getErrors()), Codes::HTTP_INTERNAL_SERVER_ERROR);
    }
    /**
     * Update a RegDiario entity.
     *
     * @View(serializerEnableMaxDepthChecks=true)
     *
     * @param Request $request
     * @param $entity
     *
     * @return Response
     */
    public function putAction(Request $request, RegDiario $entity)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $request->setMethod('PATCH'); //Treat all PUTs as PATCH
            $form = $this->createForm(new RegDiarioType(), $entity, array('method' => $request->getMethod()));
            $this->removeExtraFields($request, $form);
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em->flush();

                return $entity;
            }

            return FOSView::create(array('errors' => $form->getErrors()), Codes::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            return FOSView::create($e->getMessage(), Codes::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * Partial Update to a RegDiario entity.
     *
     * @View(serializerEnableMaxDepthChecks=true)
     *
     * @param Request $request
     * @param $entity
     *
     * @return Response
     */
    public function patchAction(Request $request, RegDiario $entity)
    {
        return $this->putAction($request, $entity);
    }
    /**
     * Delete a RegDiario entity.
     *
     * @View(statusCode=204)
     *
     * @param Request $request
     * @param $entity
     *
     * @internal param $id
     *
     * @return Response
     */
    public function deleteAction(Request $request, RegDiario $entity)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $em->remove($entity);
            $em->flush();

            return;
        } catch (\Exception $e) {
            return FOSView::create($e->getMessage(), Codes::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get GuiaComerciante entity
     *
     * @View(serializerEnableMaxDepthChecks=true)
     *
     * @return Response
     *
     */
    public function comerciantesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:RegDiario');

        return $entity->getComerciantes();
    }

    /**
     * User data.
     *
     * @return Object User
     */
    public function getUserData()
    {
        $userManager = $this->container->get('fos_user.user_manager');

        return $userManager->findUserByUsername($this->getUser()->getUserName());
    }
}
