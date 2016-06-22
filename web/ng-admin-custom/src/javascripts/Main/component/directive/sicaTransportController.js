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
    function TransportController($scope, $rootScope, $stateParams, $log, UtilityService) {

        $scope.entity = $scope.entity();
        $scope.entry = $scope.entry;
        $scope.field = $scope.field();
        $scope.form = $scope.form();
        $scope.formreg = $scope.formreg();
        $scope.datastore = $scope.datastore();
        $scope.transports = [];

        this.$scope = $scope;
        this.$log = $log;

        this.util = UtilityService;
        this.keyName = 'transport';

        $scope.marcas = [];
        $scope.modelos = [];

        this.getMarcas();

        $scope.addTransport = this.addTransport.bind(this);
        $scope.removeTransport = this.removeTransport.bind(this);

        $scope.$on('$destroy', this.destroy.bind(this));
    }

    TransportController.prototype.getMarcas = function() {
        var oThis = this;
        this.util.apiMarca().then(function(response) {
            oThis.$scope.marcas = oThis.util.dataPrepare(response.data.originalElement, [{
                label: 'marca_nomb'
            }, {
                value: 'marca_id'
            }]);
        });
    };

    TransportController.prototype.selMarca = function($item, $model) {
        this.getModelo($item, $model);
    };

    TransportController.prototype.getModelo = function($item, $model) {
        var oThis = this;
        this.util.apiModelo($item, $model).then(function(response) {
            oThis.$scope.modelos = oThis.util.dataPrepare(response.data.originalElement, [{
                label: 'model_anio'
            }, {
                anio: 'modelo_anio'
            }, {
                value: 'modelo_id'
            }]);
        });
    };

    TransportController.prototype.addTransport = function(value) {
        if (this.util.isEmpty(this.util.trim(value))) {
            return;
        }

        this.$scope.placaTransport = '';

        this.$scope.transports.push(value);

        if (!angular.isDefined(this.$scope.entry.values[this.keyName])){
            this.$scope.entry.values[this.keyName] = [];
        }

        var index = this.$scope.transports.length -1;

        if (!this.$scope.entry.values[this.keyName][index]) {
            this.$scope.entry.values[this.keyName][index] = {};
        }

        this.$scope.entry.values[this.keyName][index].placa = value;
    };

    TransportController.prototype.removeTransport = function(index) {

        if (index >= 0 && index < this.$scope.transports.length) {
            this.$scope.transports.splice(index, 1);
            this.$scope.entry.values[this.keyName].splice(index, 1);
        }

        console.log(index, "remove key", this.$scope.transports);
    };

    TransportController.prototype.selectInvoice = function(entry) {
        var selection = this.$scope.selection.slice();

        var index = selection.indexOf(entry);

        if (index === -1) {
            this.$cope.selection = selection.concat(entry);
            return;
        }
        selection.splice(index, 1);
        this.$scope.selection = selection;
    };

    TransportController.prototype.destroy = function() {
        this.$scope = undefined;
        this.$log = undefined;
    };

    TransportController.$inject = ['$scope', '$rootScope', '$stateParams', '$log', 'UtilityService'];

    return TransportController;
});