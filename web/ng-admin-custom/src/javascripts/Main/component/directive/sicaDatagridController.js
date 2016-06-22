/*global define*/

define(function(require) {
    'use strict';

    var detailComercioTemplate = require('../../view/layoutModalDetailComercio.html');

    /**
     *
     * @param {$scope} $scope
     * @param {$rootScope} $rootScope
     * @param {$location} $location
     * @param {$stateParams} $stateParams
     * @param {$log} $log
     *
     * @constructor
     */
    function DatagridController($scope, $rootScope, $modal, $document, $stateParams, $log) {

        $scope.entity = $scope.entity();
        $scope.field = $scope.field();
        $scope.form = $scope.form();
        $scope.formreg = $scope.formreg();
        $scope.datastore = $scope.datastore();

        console.log($scope.field, "field form");

        this.$scope = $scope;
        this.$log = $log;

        $scope.entries = [];

        this.choiceGrid = $rootScope.$on('choice:grid:render', function (e, $item) {
            $scope.entries = $item;
        });

        $scope.selection = [];
        $scope.fields = [{
            name: 'rif'
        }, {
            name: 'estb'
        }, {
            name: 'prop'
        }, {
            name: 'ptte'
        }, {
            name: 'lic'
        }];

        $scope.listActions = ['show', 'check'];

        $scope.gotoShowPopup = function(entry) {
            $scope.open();
        };


        $scope.gotoChecked =function($event, entry) {

            var ffilter  = angular.element($document[0].querySelector('#ffilter'));
            var fform  = angular.element($document[0].querySelector('#fform'));

           var el = (function(){
               if ($event.target.nodeName === 'SPAN') {
                  return angular.element($event.target).parent();
               } else {
                  return angular.element($event.target);
               }
           })();

           var span = el.children();

           if (span.hasClass('glyphicon-unchecked')) {
                span.removeClass('glyphicon-unchecked');
                span.addClass('glyphicon-check');

                ffilter.attr('disabled', 'true');
                fform.removeAttr('disabled');
           } else {
                span.removeClass('glyphicon-check');
                span.addClass('glyphicon-unchecked');

                ffilter.removeAttr('disabled');
                fform.attr('disabled', 'true');
           }
        };

        $scope.items = [{loading: true}];

        $scope.open = function () {
            var modalInstance = $modal.open({
                animation: true,
                template: detailComercioTemplate,
                controller: 'ModalDetailComercioCtrl',
                size: 'lg',
                resolve: {
                    items: function () {
                        return $scope.items;
                    },
                    entries: function() {
                        return $scope.entries;
                    }
                }
            });

            modalInstance.result.then(function (selectedItem) {
                $scope.selected = selectedItem;
            }, function () {
                $log.info('Modal dismissed at: ' + new Date());
            });

        };

        var oThis = $scope.formreg;
        $scope.formreg.submitCreation = function ($event) {
            $event.preventDefault();
            if (!oThis.validateEntry()) {
                return;
            }
            var entity = oThis.entity;
            var view = oThis.view;
            var route = !entity.editionView().enabled ? 'show' : 'edit';
            var restEntry = oThis.$scope.entry.transformToRest(view.fields());
            console.log(restEntry, route, "submitCreation");

            oThis.progression.start();
            oThis.WriteQueries
                .createOne(view, restEntry)
                .then(rawEntry => {
                    oThis.progression.done();
                    oThis.notification.log('Element successfully created.', { addnCls: 'humane-flatty-success' });
                    var entry = view.mapEntry(rawEntry);
                    oThis.$state.go(oThis.$state.get(route), { entity: entity.name(), id: entry.identifierValue });
                }, oThis.handleError.bind(oThis));
        };

        $scope.$on('$destroy', this.destroy.bind(this));
    }

    /**
     * Return 'even'|'odd' based on the index parameter
     *
     * @param {Number} index
     * @returns {string}
     */
    DatagridController.prototype.itemClass = function(index) {
        return (index % 2 === 0) ? 'even' : 'odd';
    };



    DatagridController.prototype.toggleSelect = function(entry) {
        var selection = this.$scope.selection.slice();

        var index = selection.indexOf(entry);

        if (index === -1) {
            this.$scope.selection = selection.concat(entry);
            return;
        }
        selection.splice(index, 1);
        this.$scope.selection = selection;
    };

    DatagridController.prototype.toggleSelectAll = function() {

        if (this.$scope.selection.length < this.$scope.entries.length) {
            this.$scope.selection = this.$scope.entries;
            return;
        }

        this.$scope.selection = [];
    };

    DatagridController.prototype.destroy = function () {
        this.choiceGrid = undefined;
        this.$log = undefined;
    };

    DatagridController.$inject = ['$scope', '$rootScope', '$modal', '$document', '$stateParams', '$log'];

    return DatagridController;
});