define(function(require) {
	'use strict';

	function TcomercioAdmin($provide, NgAdminConfigurationProvider) {
		$provide.factory('TcomercioAdmin', ['$rootScope', 'RestWrapper', 'UtilityService', function($rootScope, RestWrapper, UtilityService) {
			var nga = NgAdminConfigurationProvider;

			var util = UtilityService;

			var tcomercio = nga.entity('tcomercios')
				.identifier(nga.field('tcom_id'))
				.label('Tipos de comercios');

			tcomercio.listView()
				.infinitePagination(false)
				.title('Lista tipos de comercios')
				.fields([
					nga.field('tcom_id').label('tcom_id'),
					nga.field('tcom_nomb').label('tcom_nomb'),
					nga.field('tcom_desc').label('tcom_desc'),
				])
				.filters([
					nga.field('q', 'template')
					.label('')
					.pinned(true)
					.template('<div class="input-group"><input type="text" ng-model="value" ng-model-options="{debounce: 1500}" placeholder="Buscar" class="form-control"></input><span ng-click="$parent.filterCtrl.filter()" class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span></div>'),

					nga.field('filters_operator', 'choice')
					.label('Operador SQL')
					.choices(util.filterOperators()),

					nga.field('limit', 'choice')
					.label('Mostrar limite')
					.choices(util.filterLimit()),
				])
				.listActions(['edit', 'delete', 'show']);

			tcomercio.creationView()
				.title('Crear nuevo tipo de comercio')
				.fields([
					nga.field('tcom_nomb').label('tcom_nomb'),
					nga.field('tcom_desc').label('tcom_desc'),
				]);

			tcomercio.editionView()
				.title('Actualizar tipo de comercio #{{ ::entry.identifierValue }}')
				.fields([
					tcomercio.creationView().fields(),
				]);

			tcomercio.showView()
				.title('Detalle tipo de comercio #{{ ::entry.identifierValue }}')
				.fields([
					nga.field('tcom_id').label('tcom_id'),
					tcomercio.creationView().fields(),
				]);

			return tcomercio;
		}]);
	}
	TcomercioAdmin.$inject = ['$provide', 'NgAdminConfigurationProvider'];

	return TcomercioAdmin;
});