/*global define*/

define(function (require) {
    'use strict';

    var sicaDatagridController = require('./sicaDatagridController');

    function sicaDatagridDirective() {
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
            controllerAs: 'datagrid',
            controller: sicaDatagridController,
            template:
`<table class="grid table table-condensed table-hover table-striped">
    <thead>
        <tr>
            <th ng-repeat="field in fields track by $index" ng-class="'ng-admin-column'">
                <a>
                    {{ field.name | trans }}
                </a>
            </th>
            <th class="ng-admin-column-actions">
                Acciones
            </th>
        </tr>
    </thead>

    <tbody>
        <tr ng-repeat="entry in entries">
            <td ng-repeat="field in fields track by $index">
                <span>{{ entry[field.name] }}</span>
            </td>
            <td class="ng-admin-column-actions">
                <a class="btn btn-default ng-binding btn-xs" ng-click="gotoShowPopup(entry)">
                    <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&nbsp;
                </a>
                <a class="btn btn-default ng-binding btn-xs" ng-click="gotoChecked($event, entry)">
                    <span class="glyphicon glyphicon-unchecked" aria-hidden="true"></span>&nbsp;
                </a>
            </td>
        </tr>
    </tbody>
</table>`
        };
    }

    sicaDatagridDirective.$inject = [];

    return sicaDatagridDirective;
});
