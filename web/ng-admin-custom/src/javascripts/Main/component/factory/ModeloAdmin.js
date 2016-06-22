define(function(require) {
	'use strict';

	function ModeloAdmin($provide, NgAdminConfigurationProvider, MarcaAdminProvider) {
		$provide.factory('ModeloAdmin', ['$rootScope', 'RestWrapper', 'UtilityService', function($rootScope, RestWrapper, UtilityService) {
			var nga = NgAdminConfigurationProvider;
			var marca = MarcaAdminProvider;
			var util = UtilityService;

			var modelo = nga.entity('modelos')
				.identifier(nga.field('modelo_id'))
				.label('Modelos');

			modelo.listView()
				.infinitePagination(false)
				.fields([
					nga.field('modelo_id').label('modelo_id'),
					nga.field('modelo_anio').label('modelo_anio'),
					nga.field('modelo_nomb').label('modelo_nomb'),
					nga.field('marca.marca_nomb').label('marca_nomb'),
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

					nga.field('filters[marca]', 'choice')
					.label('Marca')
					.choices(function(entry, scope) {

						util.choiceMarca()(entry, scope);

						$rootScope.$broadcast('choice:marcas:get');

						return [];
					}),
				])
				.listActions(['edit', 'delete', 'show']);

			modelo.creationView()
				.fields([
					nga.field('marca', 'choice')
					.label('marca_nomb')
					.choices(function(entry, scope) {

						util.choiceMarca()(entry, scope);

						$rootScope.$broadcast('choice:marcas:get');

						return [];
					}),

					nga.field('modelo_nomb').label('modelo_nomb'),
					nga.field('modelo_anio').label('modelo_anio'),
				]);

			modelo.editionView()
				.fields([
					nga.field('marca', 'choice')
					.label('marca_nomb')
					.choices(function(entry, scope) {

						entry.values['marca'] = entry.values['marca.marca_id'];

						util.choiceMarca()(entry, scope);

						$rootScope.$broadcast('choice:marcas:get');

						return [];
					}),

					nga.field('modelo_nomb').label('modelo_nomb'),
					nga.field('modelo_anio').label('modelo_anio'),
				]);

			modelo.showView()
				.fields([
					nga.field('modelo_id').label('modelo_id'),
					nga.field('modelo_anio').label('modelo_anio'),
					nga.field('modelo_nomb').label('modelo_nomb'),
					nga.field('marca.marca_nomb').label('marca_nomb')
				]);

			return modelo;
		}]);
	}
	ModeloAdmin.$inject = ['$provide', 'NgAdminConfigurationProvider', 'MarcaAdminProvider'];

	return ModeloAdmin;
});