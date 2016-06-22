define(function(require) {
	'use strict';

	function MarcaAdmin($provide, NgAdminConfigurationProvider) {
		$provide.factory('MarcaAdmin', ['$rootScope', 'RestWrapper', 'UtilityService', function($rootScope, RestWrapper, UtilityService) {
			var nga = NgAdminConfigurationProvider;

			var util = UtilityService;

			var marca = nga.entity('marcas')
				.identifier(nga.field('marca_id'))
				.label('Marcas');

			marca.listView()
				.infinitePagination(false)
				.fields([
					nga.field('marca_id').label('marca_id'),
					nga.field('marca_nomb').label('marca_nomb'),
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

			marca.creationView()
				.fields([
					nga.field('marca_nomb').label('marca_nomb'),
				]);

			marca.editionView()
				.fields([
					marca.creationView().fields(),
				]);

			marca.showView()
				.fields([
					nga.field('marca_id').label('marca_id'),
					marca.creationView().fields(),
				]);

			return marca;
		}]);
	}
	MarcaAdmin.$inject = ['$provide', 'NgAdminConfigurationProvider'];

	return MarcaAdmin;
});