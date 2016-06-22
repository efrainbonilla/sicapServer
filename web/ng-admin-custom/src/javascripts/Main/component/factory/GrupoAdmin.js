define(function(require) {
	'use strict';

	function GrupoAdmin($provide, NgAdminConfigurationProvider, CategoriaAdminProvider) {
		$provide.factory('GrupoAdmin', ['$rootScope', 'RestWrapper', 'UtilityService', function($rootScope, RestWrapper, UtilityService) {
			var nga = NgAdminConfigurationProvider;
			var util = UtilityService;
			var categoria = CategoriaAdminProvider.$get();

			var grupo = nga.entity('grupos')
				.identifier(nga.field('grup_id'))
				.label('Grupo I');

			grupo.listView()
				.infinitePagination(false)
				.fields([
					nga.field('grup_id').label('grup_id'),
					nga.field('grup_nomb').label('grup_nomb'),
					nga.field('cat.cat_nomb').label('cat_nomb'),
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

			grupo.creationView()
				.fields([
					nga.field('cat', 'choice')
					.label('cat_nomb')
					.choices(function(entry, scope) {

						util.choiceCategoria()(entry, scope);

						$rootScope.$broadcast('choice:categorias:get');

						return [];
					}),

					nga.field('grup_nomb').label('grup_nomb'),
				]);

			grupo.editionView()
				.fields([
					nga.field('cat', 'choice')
					.label('cat_nomb')
					.choices(function(entry, scope) {

						entry.values['cat'] = entry.values['cat.cat_id'];

						util.choiceCategoria()(entry, scope);

						$rootScope.$broadcast('choice:categorias:get');

						return [];
					}),

					nga.field('grup_nomb').label('grup_nomb'),
				]);

			grupo.showView()
				.fields([
					nga.field('grup_id').label('grup_id'),
					nga.field('grup_nomb').label('grup_nomb'),

					nga.field('cat.cat_id', 'reference')
					.label('cat_nomb')
					.targetEntity(categoria)
					.targetField(nga.field('cat_nomb')),
				]);

			return grupo;
		}]);
	}
	GrupoAdmin.$inject = ['$provide', 'NgAdminConfigurationProvider', 'CategoriaAdminProvider'];

	return GrupoAdmin;
});