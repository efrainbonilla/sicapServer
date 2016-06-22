define(function(require) {
	'use strict';

	function SgrupoAdmin($provide, NgAdminConfigurationProvider, CategoriaAdminProvider, GrupoAdminProvider) {
		$provide.factory('SgrupoAdmin', ['$rootScope', 'RestWrapper', 'UtilityService', function($rootScope, RestWrapper, UtilityService) {
			var nga = NgAdminConfigurationProvider;
			var util = UtilityService;
			var categoria = CategoriaAdminProvider.$get();
			var grupo = GrupoAdminProvider.$get();

			var sgrupo = nga.entity('sgrupos')
				.identifier(nga.field('sgrup_id'))
				.label('Grupo II');

			sgrupo.listView()
				.infinitePagination(false)
				.fields([
					nga.field('sgrup_id').label('sgrup_id'),
					nga.field('sgrup_nomb').label('sgrup_nomb'),
					nga.field('grup.grup_nomb').label('grup_nomb'),
					nga.field('grup.cat.cat_nomb').label('cat_nomb'),
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

			sgrupo.creationView()
				.fields([
					nga.field('cat', 'choice')
					.label('cat_nomb')
					.validation({
						required: true
					})
					.attributes({
						'on-select': 'selCat($item, $model)'
					})
					.choices(function(entry, scope) {

						util.choiceCategoria()(entry, scope);

						$rootScope.$broadcast('choice:categorias:get');

						scope.selCat = function($item, $model) {
							$rootScope.$broadcast('choice:grupos:get', $item, $model);
						};

						return [];
					}),

					nga.field('grup', 'choice')
					.label('grup_nomb')
					.validation({
						required: true
					})
					.choices(function(entry, scope) {

						util.choiceGrupo()(entry, scope);

						scope.selGrup = function($item, $model) {
							$rootScope.$broadcast('choice:sgrupos:get', $item, $model);
						};

						return [];
					}),

					nga.field('sgrup_nomb')
					.label('sgrup_nomb')
					.validation({
						required: true
					}),
				]);

			sgrupo.editionView()
				.fields([
					nga.field('cat', 'choice')
					.label('cat_nomb')
					.validation({
						required: true
					})
					.attributes({
						'on-select': 'selCat($item, $model)'
					})
					.choices(function(entry, scope) {

						entry.values['cat'] = entry.values['grup.cat.cat_id'];

						util.choiceCategoria()(entry, scope);

						$rootScope.$broadcast('choice:categorias:get');

						scope.selCat = function($item, $model) {
							$rootScope.$broadcast('choice:grupos:get', $item, $model);
						};

						return [];
					}),

					nga.field('grup', 'choice')
					.label('grup_nomb')
					.validation({
						required: true
					})
					.choices(function(entry, scope) {
						var catId;
						catId = entry.values['grup.cat.cat_id'];
						entry.values['grup'] = entry.values['grup.grup_id'];

						util.choiceGrupo()(entry, scope);

						$rootScope.$broadcast('choice:grupos:get', {
							value: catId
						}, catId);

						return [];
					}),

					nga.field('sgrup_nomb')
					.label('sgrup_nomb')
					.validation({
						required: true
					}),
				]);

			sgrupo.showView()
				.fields([
					nga.field('cat.cat_id', 'reference')
					.label('cat_nomb')
					.targetEntity(categoria)
					.targetField(nga.field('cat_nomb')),

					nga.field('grup.grup_id', 'reference')
					.label('grup_nomb')
					.targetEntity(grupo)
					.targetField(nga.field('grup_nomb')),

					nga.field('sgrup_nomb').label('sgrup_nomb'),
					nga.field('sgrup_id').label('sgrup_id'),
				]);

			return sgrupo;
		}]);
	}
	SgrupoAdmin.$inject = ['$provide', 'NgAdminConfigurationProvider', 'CategoriaAdminProvider', 'GrupoAdminProvider'];

	return SgrupoAdmin;
});