/*global define*/

define(function(require) {
    'use strict';
    /**
     *
     * @param {$scope} $scope
     * @param {$rootScope} $rootScope
     * @param {$stateParams} $stateParams
     * @param {$log} $log
     *
     * @constructor
     */
    function InvoiceController($scope, $rootScope, $stateParams, $log, UtilityService) {

        $scope.entity = $scope.entity();
        $scope.field = $scope.field();
        $scope.form = $scope.form();
        $scope.formreg = $scope.formreg();
        $scope.datastore = $scope.datastore();
        $scope.invoices = [];

        $scope.products = ['0'];
        $scope.productos = [];
        $scope.prestaciones = [];
        $scope.medidas = [];

        this.$scope = $scope;
        this.$log = $log;

        this.util = UtilityService;
        this.keyName = 'invoice';

        this.getProductos();
        this.getMedidas();

        $scope.addInvoice = this.addInvoice.bind(this);
        $scope.removeInvoice = this.removeInvoice.bind(this);

        $scope.addItem = this.addItem.bind(this);
        $scope.removeItem = this.removeItem.bind(this);

        $scope.$on('$destroy', this.destroy.bind(this));

    }

    InvoiceController.prototype.getProductos = function () {
        var oThis = this;
        this.util.apiProducto().then(function (response) {
            oThis.$scope.productos = oThis.util.dataPrepare(response.data.originalElement, [{
                label: 'prod_nomb'
            }, {
                value: 'prod_id'
            }, {
                sgrup: 'sgrup.sgrup_nomb'
            }]);
        });
    };

    InvoiceController.prototype.selProd = function ($item, $model) {
        this.getPrestaciones($item, $model);
    };

    InvoiceController.prototype.getMedidas = function () {
        var oThis = this;
        this.util.apiMedida().then(function (response) {

            oThis.$scope.medidas = oThis.util.dataPrepare(response.data.originalElement, [{
                label: 'med_nomb'
            }, {
                value: 'med_id'
            }, {
                mag: 'mag.mag_nomb'
            }]);
        });
    };

    InvoiceController.prototype.getPrestaciones = function ($item, $model) {
        var oThis = this;
        this.util.apiPrestacion($item, $model).then(function (response) {

            oThis.$scope.prestaciones = oThis.util.dataPrepare(response.data.originalElement, [{
                label: 'med.med_nomb'
            }, {
                value: 'med.med_id'
            }, {
                mag: 'med.mag.mag_nomb'
            }]);

            if (oThis.$scope.prestaciones.length === 0) {
                oThis.$scope.prestaciones = oThis.$scope.medidas;
            }
        });
    };

    InvoiceController.prototype.addInvoice = function (value) {
        if (this.util.isEmpty(this.util.trim(value))) {
            return;
        }

        this.$scope.codeInvoice  = '';

        this.$scope.invoices.push({value: value, products: [0]});

        if (!angular.isDefined(this.$scope.entry.values[this.keyName])){
            this.$scope.entry.values[this.keyName] = [];
        }

        var index = this.$scope.invoices.length -1;

        if (!this.$scope.entry.values[this.keyName][index]) {
            this.$scope.entry.values[this.keyName][index] = {};
        }

        this.$scope.entry.values[this.keyName][index].invoice = value;
        this.$scope.entry.values[this.keyName][index].product = [];
    };

    InvoiceController.prototype.removeInvoice = function (index) {
        if (index >= 0 && index < this.$scope.invoices.length) {
            this.$scope.invoices.splice(index, 1);
            this.$scope.entry.values[this.keyName].splice(index, 1);
        }
    };

    InvoiceController.prototype.addItem = function(indexInvoice) {
        var indexProducts = this.$scope.invoices[indexInvoice].products.length;
        this.$scope.invoices[indexInvoice].products.push(indexProducts);
    };

    InvoiceController.prototype.removeItem = function (indexInvoice, indexItem) {
        if (indexInvoice >= 0 && indexInvoice < this.$scope.invoices[indexInvoice].products.length) {
            this.$scope.invoices[indexInvoice].products.splice(indexItem, 1);
            this.$scope.entry.values[this.keyName][indexInvoice].product.splice(indexItem, 1);
        }
    };

    InvoiceController.prototype.destroy = function () {
        this.$scope = undefined;
        this.$log = undefined;
    };

    InvoiceController.$inject = ['$scope', '$rootScope', '$stateParams', '$log', 'UtilityService'];

    return InvoiceController;
});