/*global define*/

define(function (require) {
    'use strict';

    var sicaInvoiceController = require('./sicaInvoiceController');

    function sicaInvoiceDirective() {
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
            controllerAs: 'invoice',
            controller: sicaInvoiceController,
            template:
`<div class="bs-callout bs-callout-info">
    <div class="page-header">
        <h4>Facturas
            <small>
                <div class="pull-right form-horizontal col-md-4">
                    <div class="row">
                        <label class="col-sm-5 control-label">
                            Código factura<span>&nbsp;*</span>&nbsp;
                        </label>
                        <div class="input-group">
                            <input type="text" ng-model="codeInvoice" placeholder="Ejm. 010101010" class="form-control"></input>
                            <span class="input-group-addon" ng-click="invoice.addInvoice(codeInvoice)"><i class="glyphicon glyphicon-plus-sign"></i></span>
                        </div>
                    </div>
                </div>
            </small>
        </h4>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="bs-callout bs-callout-info" ng-repeat="(key, value) in invoices track by $index">
                <div class="page-header">
                    <h4>Código factura:
                        <div style="float:none; display: inline-block;">
                            <input type="text" name="invoice" id="invoice" class="form-control" ng-model="entry.values['invoice'][$index].invoice">
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
                                        <li><a ng-click="invoice.removeInvoice(key)">Borrar</a></li>
                                    </ul>
                                </div>
                            </div>
                        </small>
                    </h4>
                </div>

                <div class="page-header">
                    <h4 class="text-right">
                        Productos &nbsp;&nbsp;
                        <small>
                            <div class="pull-right">
                                <div class="btn-group" dropdown>
                                    <button type="button" class="btn btn-default">Acciones</button>
                                    <button type="button" class="btn btn-default dropdown-toggle" dropdown-toggle>
                                        <span class="caret"></span>
                                        <span class="sr-only">Split button!</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a ng-click="invoice.addItem(key)">Agregar</a></li>
                                        <!--<li class="divider"></li>
                                        <li><a  ng-click="invoice.removeItem(key)">Borrar</a></li>-->
                                    </ul>
                                </div>
                            </div>
                        </small>
                    </h4>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                         <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="30%">Producto</th>
                                    <th width="34%" colspan="2">Prestación de producto</th>
                                    <th width="12%">Cantidad</th>
                                    <th width="20%">Denominación</th>
                                    <th width="4%">Accíon</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="(akey, avalue) in value.products track by $index">
                                    <td>
                                    <div class="input-group">
                                        <ui-select on-select="invoice.selProd($item, $model)" ng-model="entry.values['invoice'][key].product[$index].prod" ng-required="true" id="prod" name="prod">
                                            <ui-select-match allow-clear="false" placeholder="Valores de filtro">{{ $select.selected.label }}</ui-select-match>
                                            <ui-select-choices group-by="'sgrup'" repeat="item.value as item in productos | filter: {label: $select.search} track by $index">
                                                {{ item.label }}
                                            </ui-select-choices>
                                        </ui-select>
                                        <span class="input-group-btn">
                                            <button ng-click="invoice.getProductos()" class="btn btn-default">
                                                <span class="glyphicon glyphicon-refresh"></span>
                                            </button>
                                        </span>
                                    </div>
                                    </td>
                                    <td width="12%"><input type="text" ng-model="entry.values['invoice'][key].product[$index].prestc_num" name="prestc_num" id="prestc_num" class="form-control" required="required"></td>
                                    <td>
                                        <ui-select ng-model="entry.values['invoice'][key].product[$index].prestc" ng-required="true" id="prestc" name="prestc">
                                            <ui-select-match allow-clear="false" placeholder="Valores de filtro">{{ $select.selected.label }}</ui-select-match>
                                            <ui-select-choices group-by="'mag'" repeat="item.value as item in prestaciones | filter: {label: $select.search} track by $index">
                                                {{ item.label }}
                                            </ui-select-choices>
                                        </ui-select>
                                    </td>
                                    <td><input type="number" ng-model="entry.values['invoice'][key].product[$index].cant" name="cant" id="cant" class="form-control" required="required"></td>
                                    <td>
                                    <div class="input-group">
                                        <ui-select ng-model="entry.values['invoice'][key].product[$index].med" ng-required="true" id="med" name="med">
                                            <ui-select-match allow-clear="false" placeholder="Valores de filtro">{{ $select.selected.label }}</ui-select-match>
                                            <ui-select-choices group-by="'mag'" repeat="item.value as item in medidas | filter: {label: $select.search} track by $index">
                                                {{ item.label }}
                                            </ui-select-choices>
                                        </ui-select>
                                        <span class="input-group-btn">
                                            <button ng-click="invoice.getMedidas()" class="btn btn-default">
                                                <span class="glyphicon glyphicon-refresh"></span>
                                            </button>
                                        </span>
                                    </div>
                                    </td>
                                    <td>
                                        <a class="btn btn-default ng-binding btn-xs pull-right" ng-click="removeItem(key, akey)">
                                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>&nbsp;
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!--
                        -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label for="" class="control-label requerid">
                                Total BsF. <span class="requerid">&nbsp;*</span>&nbsp;
                            </label>
                            <input type="text" name="total" ng-model="entry.values['invoice'][$index].total" class="form-control" required="required">
                            <span> {{entry.values['invoice'][$index].total | currency:"Bs.F "}} </span>
                       
                        </div>
                    </div>
                    <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                        <div class="form-group">
                            <label for="" class="control-label requerid">
                                Observación </span>&nbsp;
                            </label>
                            <input type="text" name="obs" ng-model="entry.values['invoice'][$index].obs" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>`
        };
    }

    sicaInvoiceDirective.$inject = [];

    return sicaInvoiceDirective;
});
