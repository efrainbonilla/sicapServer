define(function(require) {
	'use strict';

	function ProdlimiteAdmin($provide, NgAdminConfigurationProvider) {
		$provide.factory('ProdlimiteAdmin', ['$rootScope', 'RestWrapper', 'UtilityService', function($rootScope, RestWrapper, UtilityService) {
			var nga = NgAdminConfigurationProvider;
			var util = UtilityService;

			var prodlimite = nga.entity('prodlimites')
				.identifier(nga.field('prodl_id'))
				.label('Productos por comercio');

			prodlimite.listView()
				.infinitePagination(false)
				.title('Lista de limite de productos por comercio')
				.fields([
					nga.field('prodl_id').label('prodl_id'),
					nga.field('com.com_rif').label('com_rif'),
					nga.field('com.com_nomb_estb').label('com_nomb_estb'),
					nga.field('prod.prod_nomb').label('prodl_prod_nomb'),
					nga.field('prodl_cant').label('prodl_cant'),
					nga.field('med.med_nomb').label('prodl_dnm_nomb'),
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

					nga.field('filters[com]', 'choice')
					.label('Establecimiento - RIF')
					.choices(function(entry, scope) {

						util.choiceComercio()(entry, scope);

						$rootScope.$broadcast('choice:comercios:get');

						return [];
					}),
				])
				.listActions(['edit', 'delete', 'show']);

			prodlimite.creationView()
				.title('Asignar nuevo producto a comercio')
				.fields([
					nga.field('com', 'choice')
					.label('prodl_rif_estb')
					.validation({
						required: true
					})
					.choices(function(entry, scope) {

						util.choiceComercio()(entry, scope);

						$rootScope.$broadcast('choice:comercios:get');

						return [];
					}),

					nga.field('prod', 'choice')
					.label('prodl_prod_nomb')
					.validation({
						required: true
					})
					.choices(function(entry, scope) {

						util.choiceProducto()(entry, scope);

						$rootScope.$broadcast('choice:productos:get');

						return [];
					}),

					nga.field('prodl_cant', 'number').label('prodl_cant')
					.validation({
						required: true
					}),

					nga.field('med', 'choice')
					.label('prodl_dnm_nomb')
					.validation({
						required: true
					})
					.choices(function(entry, scope) {

						util.choiceMedida()(entry, scope);

						$rootScope.$broadcast('choice:medidas:get');

						return [];
					}),

					nga.field('prodl_status').label('prodl_status'),
					nga.field('prodl_ruta').label('prodl_ruta'),
				]);

			prodlimite.editionView()
				.title('Actualizar producto por comercio #{{ ::entry.identifierValue }}')
				.fields([
					nga.field('com', 'choice')
					.label('prodl_rif_estb')
					.validation({
						required: true
					})
					.choices(function(entry, scope) {

						entry.values['com'] = entry.values['com.com_id'];

						util.choiceComercio()(entry, scope);

						$rootScope.$broadcast('choice:comercios:get');

						return [];
					}),

					nga.field('prod', 'choice')
					.label('prodl_prod_nomb')
					.validation({
						required: true
					})
					.choices(function(entry, scope) {

						entry.values['prod'] = entry.values['prod.prod_id'];

						util.choiceProducto()(entry, scope);

						$rootScope.$broadcast('choice:productos:get');

						return [];
					}),

					nga.field('prodl_cant', 'number').label('prodl_cant')
					.validation({
						required: true
					}),

					nga.field('med', 'choice')
					.label('prodl_dnm_nomb')
					.validation({
						required: true
					})
					.choices(function(entry, scope) {

						entry.values['med'] = entry.values['med.med_id'];

						util.choiceMedida()(entry, scope);

						$rootScope.$broadcast('choice:medidas:get');

						return [];
					}),

					nga.field('prodl_status').label('prodl_status'),
					nga.field('prodl_ruta').label('prodl_ruta'),
				]);

			prodlimite.showView()
				.title('Detalle producto por comercio #{{ ::entry.identifierValue }}')
				.fields([
					nga.field('prodl_id').label('prodl_id'),

					nga.field('com.com_rif').label('com_rif'),
					nga.field('com.com_nomb_estb').label('com_nomb_estb'),
					nga.field('com.com_nomb_repres').label('com_nomb_repres'),
					nga.field('prod.prod_nomb').label('prodl_prod_nomb'),
					nga.field('med.med_nomb').label('prodl_dnm_nomb'),

					nga.field('prodl_status').label('prodl_status'),
					nga.field('prodl_ruta').label('prodl_ruta'),
				]);

			return prodlimite;
		}]);
	}
	ProdlimiteAdmin.$inject = ['$provide', 'NgAdminConfigurationProvider'];

	return ProdlimiteAdmin;
});