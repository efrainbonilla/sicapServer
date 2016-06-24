<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comercio;
use AppBundle\Entity\Mcomercio;
use AppBundle\Form\ComercioType;
use FOS\RestBundle\Controller\Annotations\Get;
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
 * Comercio controller.
 *
 * @RouteResource("Comercio")
 */
class ComercioRESTController extends VoryxController
{
    /**
     * Get a Comercio entity.
     *
     * @View(serializerEnableMaxDepthChecks=true)
     *
     * @return Response
     */
    public function getAction(Comercio $entity)
    {
        return $entity;
    }
    /**
     * Get all Comercio entities.
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
            $entity = $em->getRepository('AppBundle:Comercio');

            if (!empty($q)) {
                $filters_ = array(
                    'comRif' => '',
                    'comNombEstb' => '',
                    'comNumPtte' => '',
                    'comNumLic' => '',
                    'comPropNomb' => '',
                    'comPropApell' => '',
                    'comActEcnma' => '',
                );

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
     * Create a Comercio entity.
     *
     * @View(statusCode=201, serializerEnableMaxDepthChecks=true)
     *
     * @param Request $request
     *
     * @return Response
     */
    public function postAction(Request $request)
    {
        $request->request->set('comRif', $request->request->get('comRifFix').$request->request->get('comRif'));

        if (!$request->request->get('comSadaChk')) {
            $request->request->set('comSadaCodi', '');
        }

        $from = $request->request->get('comFechptteIni');
        $to = $request->request->get('comFechptteFin');

        $ptteIni = new \DateTime($from);
        $ptteFin = new \DateTime($to);

        $entity = new Comercio();

        $this->mcomEntity($request, $entity);

        $entity->setComFechptteIni($ptteIni);
        $entity->setComFechptteFin($ptteFin);

        $form = $this->createForm(new ComercioType(), $entity, array('method' => $request->getMethod()));
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
     * Update a Comercio entity.
     *
     * @View(serializerEnableMaxDepthChecks=true)
     *
     * @param Request $request
     * @param $entity
     *
     * @return Response
     */
    public function putAction(Request $request, Comercio $entity)
    {
        if (!$request->request->get('comSadaChk')) {
            $request->request->set('comSadaCodi', '');
        }

        $from = $request->request->get('comFechptteIni');
        $to = $request->request->get('comFechptteFin');

        $ptteIni = empty($from)? null : new \DateTime($from);
        $ptteFin = empty($to)? null : new \DateTime($to);

        $entity->setComFechptteIni($ptteIni);
        $entity->setComFechptteFin($ptteFin);

        $this->mcomEntity($request, $entity);
        try {
            $em = $this->getDoctrine()->getManager();
            $request->setMethod('PATCH'); //Treat all PUTs as PATCH
            $form = $this->createForm(new ComercioType(), $entity, array('method' => $request->getMethod()));
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

    public function mcomEntity(Request $request, Comercio $entity)
    {
        if (is_array($request->request->get('mcom'))) {
            $tcom = $request->request->get('mcom');
            $em = $this->getDoctrine()->getManager();
            $entityMcom = $em->getRepository('AppBundle:Mcomercio')->findBy(array('com' => $entity->getComId()));

            $mcomIds = array();
            foreach ($entityMcom as $key => $enti) {
                $tcomId = $enti->getTcom()->getTcomId();
                if (in_array($tcomId, $tcom)) {
                    if (($key = array_search($tcomId, $tcom)) !== false) {
                        unset($tcom[$key]);
                    }
                } else {
                    $mcomIds[] = $enti;
                }
            }

            //delete entity
            foreach ($mcomIds as $key => $value) {
                $em->remove($value);
            }

            if ($mcomIds) {
                $em->flush();
            }

            //add entity
            foreach ($tcom as $key => $value) {
                $entityTcomercio = $em->getRepository('AppBundle:Tcomercio')->find($value);
                if ($entityTcomercio) {
                    $entityMcomercio = new Mcomercio();
                    $entityMcomercio->setTcom($entityTcomercio);
                    $entity->addMcom($entityMcomercio);
                }
            }
        }
    }

    /**
     * Partial Update to a Comercio entity.
     *
     * @View(serializerEnableMaxDepthChecks=true)
     *
     * @param Request $request
     * @param $entity
     *
     * @return Response
     */
    public function patchAction(Request $request, Comercio $entity)
    {
        return $this->putAction($request, $entity);
    }
    /**
     * Delete a Comercio entity.
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
    public function deleteAction(Request $request, Comercio $entity)
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
     * Get detail comercio entity.
     *
     * @View(serializerEnableMaxDepthChecks=true)
     * @Get
     *
     * @return Response
     */
    public function detailAction(Comercio $entity)
    {
        return array($entity);
        /*return array(array('entity' => 'Comercio'));*/
    }

    /**
     * @QueryParam(name="optionDate", nullable=true,  description="Report option date")
     * @QueryParam(name="dataDate", nullable=true, array=true, description="Report by fields. Must be an array. &dataDate[field]=value")
     * @QueryParam(name="optionGral", nullable=true, description="Report option general")
     * @QueryParam(name="dataGral", nullable=true, array=true, description="Report by fields. Must be an array. &dataGral[field]=value")
     * @return array
     */
    public function reportQuery(ParamFetcherInterface $paramFetcher, $comId = null)
    {
        $optionDate = $paramFetcher->get('optionDate');
        $dataDate = !is_null($paramFetcher->get('dataDate')) ? $paramFetcher->get('dataDate') : array();

        $optionGral = $paramFetcher->get('optionGral');
        $dataGral = !is_null($paramFetcher->get('dataGral')) ? $paramFetcher->get('dataGral') : array();

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:RegDiario');
        $dateFormatCustom = array('day', 'dayBefore', 'week', 'weekBefore', 'month', 'monthBefore', 'all');
        $dateFormatYear = array('January','February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');

        $dateFrom = $dateTo = null;

        if ($optionDate === 'between' && $dataDate['dateFrom'] && $dataDate['dateTo']) {
            $dateFrom = new \DateTime($dataDate['dateFrom']);
            $dateTo = new \DateTime($dataDate['dateTo']);
        } elseif ($optionDate === 'del' && in_array($dataDate['dateFormat'], $dateFormatCustom)) {
            $now = new \DateTime('now');
            switch ($dataDate['dateFormat']) {
                case 'day':
                    $dateFrom = $dateTo = new \DateTime();
                    break;
                case 'dayBefore':
                    $dateFrom = $dateTo = new \DateTime('-1 days');
                    break;
                case 'week':
                    if (date('N') == 7) {
                        $dateFrom = new \DateTime('-7 days Monday this week' . $now->format('Y-m-d'));
                        $dateTo = new \DateTime('-7 days Sunday this week' . $now->format('Y-m-d'));
                    } else {
                        $dateFrom = new \DateTime('Monday this week' . $now->format('Y-m-d'));
                        $dateTo = new \DateTime('Sunday this week' . $now->format('Y-m-d'));
                    }
                    break;
                case 'weekBefore':
                    if (date('N') == 7) {
                        $dateFrom = new \DateTime('-7 days Monday last week' . $now->format('Y-m-d'));
                        $dateTo = new \DateTime('-7 days Sunday last week' . $now->format('Y-m-d'));
                    } else {
                        $dateFrom = new \DateTime('Monday last week' . $now->format('Y-m-d'));
                        $dateTo = new \DateTime('Sunday last week' . $now->format('Y-m-d'));
                    }
                    break;
                case 'month':
                    $dateFrom = new \DateTime('first day of this month' . $now->format('Y-m-d'));
                    $dateTo = new \DateTime('last day of this month' . $now->format('Y-m-d'));
                    break;
                case 'monthBefore':
                    $dateFrom = new \DateTime('first day of last month' . $now->format('Y-m-d'));
                    $dateTo = new \DateTime('last day of last month' . $now->format('Y-m-d'));
                    break;

                case 'all':
                    $dateFrom = new \DateTime('2015-01-01');
                    $dateTo = $now;
                    break;
            }
        } elseif ($optionDate === 'del' && in_array($dataDate['dateFormat'], $dateFormatYear)) {
            $now = new \DateTime('now');

            $dateFormat = $dataDate['dateFormat'];
            $year = ($dataDate['year'])?: $now->format('Y');

            $dateFrom = new \DateTime('first day of this month ' . $dateFormat . ' ' . $year);
            $dateTo = new \DateTime('last day of this month '  . $dateFormat . ' ' . $year);
        }

        if (!($dateFrom || $dateTo)) {
            return FOSView::create("failed date value $dateFrom || $dateTo", Codes::HTTP_INTERNAL_SERVER_ERROR);
        }

        $data = array();
        if ($optionGral === 'all') {
        } elseif ($optionGral === 'prod') {
            $data['prodId'] = $dataGral['prod'];
        } elseif ($optionGral === 'group1') {
            $data['group1'] = $dataGral['group1'];
        } elseif ($optionGral === 'group2') {
            $data['group1'] = $dataGral['group1'];
            $data['group2'] = $dataGral['group2'];
        } elseif ($optionGral === 'group3') {
            $data['group1'] = $dataGral['group1'];
            $data['group2'] = $dataGral['group2'];
            $data['group3'] = $dataGral['group3'];
        }

        if ($comId) {
            $data['comId'] = $comId;
        }

        return array($dateFrom, $dateTo, $data);

        return $results;
    }

    /**
     * Get report comercio entity.
     *
     * @View(serializerEnableMaxDepthChecks=true)
     * @Get
     * @QueryParam(name="optionDate", nullable=true,  description="Report option date")
     * @QueryParam(name="dataDate", nullable=true, array=true, description="Report by fields. Must be an array. &dataDate[field]=value")
     * @QueryParam(name="optionGral", nullable=true, description="Report option general")
     * @QueryParam(name="dataGral", nullable=true, array=true, description="Report by fields. Must be an array. &dataGral[field]=value")
     *
     * @return Response
     */
    public function reportAction(ParamFetcherInterface $paramFetcher, $comId = null)
    {
        list($dateFrom, $dateTo, $data) = $this->reportQuery($paramFetcher, $comId);

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:RegDiario');

        return $entity->getByDateBetween($dateFrom, $dateTo, $data);
    }

    /**
     * Get report comercio.
     *
     * @View(serializerEnableMaxDepthChecks=true)
     * @Get("comercios/report")
     *
     * @QueryParam(name="optionDate", nullable=true,  description="Report option date")
     * @QueryParam(name="dataDate", nullable=true, array=true, description="Report by fields. Must be an array. &dataDate[field]=value")
     * @QueryParam(name="optionGral", nullable=true, description="Report option general")
     * @QueryParam(name="dataGral", nullable=true, array=true, description="Report by fields. Must be an array. &dataGral[field]=value")
     *
     * @return Response
     */
    public function reportsAction(ParamFetcherInterface $paramFetcher)
    {
        return $this->reportAction($paramFetcher, null);
    }

    /**
     * Get report comercio.
     *
     * @View(serializerEnableMaxDepthChecks=true)
     * @Get("comercios/r")
     *
     * @QueryParam(name="optionDate", nullable=true,  description="Report option date")
     * @QueryParam(name="dataDate", nullable=true, array=true, description="Report by fields. Must be an array. &dataDate[field]=value")
     * @QueryParam(name="optionGral", nullable=true, description="Report option general")
     * @QueryParam(name="dataGral", nullable=true, array=true, description="Report by fields. Must be an array. &dataGral[field]=value")
     * @QueryParam(name="uriReport", nullable=true, description="")
     *
     * @return Response
     */
    public function rptAction(ParamFetcherInterface $paramFetcher)
    {
        list($dateFrom, $dateTo, $data) = $this->reportQuery($paramFetcher);

        $from = $dateFrom->format('Y-m-d').' 00:00:00';
        $to = $dateTo->format('Y-m-d').' 23:59:59';
        $uriReport = !is_null($paramFetcher->get('uriReport')) ? $paramFetcher->get('uriReport') : null;

        if (!$uriReport) {
            return FOSView::create("failed uriReport value $uriReport", Codes::HTTP_INTERNAL_SERVER_ERROR);
        }

        $username = $this->getUser()->getUserName();

        $param = array(
            'action'  => 'comercio',
            'report'  => $uriReport,
            'format' => 'pdf',
            'param' => array(
                'dateFrom' => "\"$from\"",
                'dateTo' => "\"$to\"",
                'username' =>"\"$username\""
            )
        );

        return array(
            'url' => $this->generateUrl('reports_q', $param),
            'parameters' => $param
        );
    }

    /**
     * Get all Comercio entities.
     *
     * @View(serializerEnableMaxDepthChecks=true)
     * @Get
     *
     * @param ParamFetcherInterface $paramFetcher
     *
     * @return Response
     *
     * @QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing notes.")
     * @QueryParam(name="limit", requirements="\d+", default="20", description="How many notes to return.")
     * @QueryParam(name="order_by", nullable=true, array=true, description="Order by fields. Must be an array ie. &order_by[name]=ASC&order_by[description]=DESC")
     */
    public function listAction(ParamFetcherInterface $paramFetcher, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Comercio');

        $results = $entity->getLcomercios();

        return $results;
    }
}
