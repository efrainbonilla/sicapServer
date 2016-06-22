define(function(require) {
	'use strict';

	function CategoriaAdmin($provide, NgAdminConfigurationProvider) {
		$provide.factory('CategoriaAdmin', ['$rootScope', 'RestWrapper', 'UtilityService', function($rootScope, RestWrapper, UtilityService) {
			var nga = NgAdminConfigurationProvider;

			var util = UtilityService;

			var categoria = nga.entity('categorias')
				.identifier(nga.field('cat_id'))
				.label('Categorías');

			categoria.listView()
				.infinitePagination(false)
				.fields([
					nga.field('cat_id').label('cat_id'),
					nga.field('cat_nomb').label('cat_nomb'),
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

			categoria.creationView()
				.title('Crear nueva categoría')
				.fields([
					nga.field('cat_nomb').label('cat_nomb'),
				]);

			categoria.editionView()
				.title('Actualizar categoría #{{ ::entry.identifierValue }}')
				.fields([
					nga.field('cat_nomb').label('cat_nomb'),
				]);

			categoria.showView()
				.title('Detalle categoría #{{ ::entry.identifierValue }}')
				.fields([
					nga.field('cat_id').label('cat_id'),
					nga.field('cat_nomb').label('cat_nomb'),
				]);

			return categoria;
		}]);
	}
	CategoriaAdmin.$inject = ['$provide', 'NgAdminConfigurationProvider'];

	return CategoriaAdmin;
});