/*global define*/

define(function (require) {
    'use strict';

    var sicaTransportController = require('./sicaTransportController');

    function sicaTransportDirective() {
        return {
            restrict: 'E',
            scope: {
                field: '&',
                form: '&',
                formreg: '&',
                entry: '=',
                entity: '&',
                'datastore': '&'
            },
            controllerAs: 'transport',
            controller: sicaTransportController,
            template:
`<div class="bs-callout bs-callout-warning">
    <div class="page-header">
        <h4>Transporte
            <small>
                <div class="pull-right form-horizontal col-md-4">
                    <div class="row">
                        <label class="col-sm-5 control-label">
                            Placa vehiculo<span>&nbsp;*</span>&nbsp;
                        </label>
                        <div class="input-group">
                            <input type="text" ng-model="placaTransport" placeholder="Ejm. XXX-XXXX" class="form-control"></input>
                            <span class="input-group-addon" ng-click="transport.addTransport(placaTransport)"><i class="glyphicon glyphicon-plus-sign"></i></span>
                        </div>
                    </div>
                </div>
            </small>
        </h4>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <fieldset>
                <div class="bs-callout bs-callout-warning" ng-repeat="(key, value) in transports track by $index" >
                    <div class="page-header">
                        <h4>Placa vehiculo:
                            <div style="float:none; display: inline-block;">
                                <input type="text" name="placa" id="placa" class="form-control" ng-model="entry.values['transport'][$index].placa">
                            </div>
                            <small>
                                <div class="pull-right">
                                    <div class="btn-group" dropdown>
                                        <button type="button" class="btn btn-default">Acción</button>
                                        <button type="button" class="btn btn-default dropdown-toggle" dropdown-toggle>
                                            <span class="caret"></span>
                                            <span class="sr-only">Split button!</span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a ng-click="transport.removeTransport(key)">Borrar</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </small>
                        </h4>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <label for="" class="control-label requerid">
                                    Marca <span class="requerid">&nbsp;*</span>&nbsp;
                                </label>
                            <div class="input-group">
                                <ui-select on-select="transport.selMarca($item, $model)" ng-model="entry.values['transport'][$index].marca" ng-required="true" id="marca" name="marca">
                                    <ui-select-match allow-clear="false" placeholder="Valores de filtro">{{ $select.selected.label }}</ui-select-match>
                                    <ui-select-choices repeat="item.value as item in marcas | filter: {label: $select.search} track by $index">
                                        {{ item.label }}
                                    </ui-select-choices>
                                </ui-select>
                                <span class="input-group-btn">
                                    <button ng-click="transport.getMarcas()" class="btn btn-default">
                                        <span class="glyphicon glyphicon-refresh"></span>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label for="" class="control-label requerid">
                                    Modelo <span class="requerid">&nbsp;*</span>&nbsp;
                                </label>
                                <ui-select ng-model="entry.values['transport'][$index].modelo" ng-required="true" id="modelo" name="modelo">
                                    <ui-select-match allow-clear="false" placeholder="Valores de filtro">{{ $select.selected.label }}</ui-select-match>
                                    <ui-select-choices repeat="item.value as item in modelos | filter: {label: $select.search} track by $index">
                                        {{ item.label }}
                                    </ui-select-choices>
                                </ui-select>
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label for="" class="control-label requerid">
                                    Descripción <span class="requerid">&nbsp;*</span>&nbsp;
                                </label>
                                <input type="text" name="desc" id="desc" class="form-control" required="required" ng-model="entry.values['transport'][$index].desc">
                            </div>
                        </div>
                    </div>
                    <div class="page-header">
                        <h5>Conductor </h5>
                    </div>
                    <div class="row">
                         <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label for="" class="control-label requerid">
                                    Cédula <span class="requerid">&nbsp;*</span>&nbsp;
                                </label>
                                <input type="text" name="cedu" id="cedu" class="form-control" required="required" ng-model="entry.values['transport'][$index].cedu">
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label for="" class="control-label requerid">
                                    Nombres <span class="requerid">&nbsp;*</span>&nbsp;
                                </label>
                                <input type="text" name="nomb" id="nomb" class="form-control" required="required" ng-model="entry.values['transport'][$index].nomb">
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label for="" class="control-label requerid">
                                    Apellidos <span class="requerid">&nbsp;*</span>&nbsp;
                                </label>
                                <input type="text" name="apell" id="apell" class="form-control" required="required" ng-model="entry.values['transport'][$index].apell">
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label for="" class="control-label requerid">
                                    N° Licencia <span class="requerid">&nbsp;*</span>&nbsp;
                                </label>
                                <input type="text" name="lic" id="lic" class="form-control" required="required" ng-model="entry.values['transport'][$index].lic">
                            </div>
                        </div>
                    </div>
                </div>

            </fieldset>
        </div>
    </div>
</div>`
        };
    }

    sicaTransportDirective.$inject = [];

    return sicaTransportDirective;
});
