define(function(require) {
	'use strict';

	function ProductoAdmin($provide, NgAdminConfigurationProvider, MedidaAdminProvider) {
		$provide.factory('ProductoAdmin', ['$rootScope', 'RestWrapper', 'UtilityService', function($rootScope, RestWrapper, UtilityService) {
			var nga = NgAdminConfigurationProvider;

			var util = UtilityService;
			var medida = MedidaAdminProvider.$get();

			var producto = nga.entity('productos')
				.identifier(nga.field('prod_id'))
				.label('Productos');

			producto.listView()
				.infinitePagination(false)
				.fields([
					nga.field('prod_id').label('prod_id'),
					nga.field('prod_nomb').label('prod_nomb'),
					nga.field('sgrup.sgrup_nomb').label('sgrup_nomb'),
					nga.field('grup.grup_nomb').label('grup_nomb'),
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

			producto.creationView()
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
					.attributes({
						'on-select': 'selGrup($item, $model)'
					})
					.choices(function(entry, scope) {

						util.choiceGrupo()(entry, scope);

						scope.selGrup = function($item, $model) {
							$rootScope.$broadcast('choice:sgrupos:get', $item, $model);
						};

						return [];
					}),

					nga.field('sgrup', 'choice')
					.label('sgrup_nomb')
					.validation({
						required: true
					})
					.choices(function(entry, scope) {

						util.choiceSgrupo()(entry, scope);

						return [];
					}),

					nga.field('prod_nomb').label('prod_nomb'),

					nga.field('prestc', 'reference_many')
					.label('Unidad de medida')
                    .targetEntity(medida)
                    .targetField(nga.field('med_nomb'))
                    .filters(function(search) {
                        return search ? { q: search } : null;
                    })
                    .remoteComplete(true, { refreshDelay: 300 })
				]);

			producto.editionView()
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

						entry.values['cat'] = entry.values['cat.cat_id'];

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
					.attributes({
						'on-select': 'selGrup($item, $model)'
					})
					.choices(function(entry, scope) {
						var catId;
						catId = entry.values['cat.cat_id'];
						entry.values['grup'] = entry.values['grup.grup_id'];

						util.choiceGrupo()(entry, scope);

						$rootScope.$broadcast('choice:grupos:get', {
							value: catId
						}, catId);

						scope.selGrup = function($item, $model) {
							$rootScope.$broadcast('choice:sgrupos:get', $item, $model);
						};

						return [];
					}),

					nga.field('sgrup', 'choice')
					.label('sgrup_nomb')
					.validation({
						required: true
					})
					.choices(function(entry, scope) {

						var grupId;
						grupId = entry.values['grup.grup_id'];
						entry.values['sgrup'] = entry.values['sgrup.sgrup_id'];

						util.choiceSgrupo()(entry, scope);

						$rootScope.$broadcast('choice:sgrupos:get', {
							value: grupId
						}, grupId);

						return [];
					}),

					nga.field('prod_nomb').label('prod_nomb'),

					nga.field('prestc', 'reference_many')
					.label('Unidad de medida')
                    .targetEntity(medida)
                    .targetField(nga.field('med_nomb'))
                    .filters(function(search) {
                        return search ? { q: search } : null;
                    })
                    .remoteComplete(false, { refreshDelay: 300 })
				]);

			producto.showView()
				.fields([
					nga.field('prod_id').label('prod_id'),
					nga.field('prod_nomb').label('prod_nomb'),
					nga.field('sgrup.sgrup_nomb').label('sgrup_nomb'),
					nga.field('grup.grup_nomb').label('grup_nomb'),
					nga.field('cat.cat_nomb').label('cat_nomb'),
				]);

			return producto;
		}]);
	}
	ProductoAdmin.$inject = ['$provide', 'NgAdminConfigurationProvider', 'MedidaAdminProvider'];

	return ProductoAdmin;
});