define(function(require) {
	'use strict';

	function ComrepresAdmin($provide, NgAdminConfigurationProvider) {
		$provide.factory('ComrepresAdmin', ['$rootScope', 'RestWrapper', 'UtilityService', function($rootScope, RestWrapper, UtilityService) {
			var nga = NgAdminConfigurationProvider;
			var util = UtilityService;

			var comrepres = nga.entity('comrepres')
				.identifier(nga.field('repres_id'))
				.label('Representantes de Comercios');

			comrepres.listView()
				.infinitePagination(false)
				.title('Lista de representantes de Comercios')
				.fields([
					nga.field('repres_id').label('repres_id'),
					nga.field('com.com_rif').label('com_rif'),
					nga.field('com.com_nomb_estb').label('com_nomb_estb'),
					nga.field('repres').label('com_repres'),
					nga.field('repres_nac').label('repres_nac'),
					nga.field('repres_telef_cel').label('repres_telef_cel'),
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

			comrepres.creationView()
				.title('Agregar nuevo representante a Comercio')
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

					nga.field('repres_nac', 'choice')
					.label('repres_nac')
					.choices(util.choiceNac())
					.validation({
						required: true
					}),
					nga.field('repres_cedu').label('repres_cedu')
					.validation({
						required: true,
						minlength: 7,
						maxlength: 15
					}),
					nga.field('repres_nomb').label('repres_nomb')
					.validation({
						required: true,
						minlength: 3,
						maxlength: 100
					}),
					nga.field('repres_apell').label('repres_apell')
					.validation({
						required: true,
						minlength: 3,
						maxlength: 100
					}),
					nga.field('repres_telef_cel').label('repres_telef_cel')
					.validation({
						required: true,
						minlength: 11,
						maxlength: 11
					}),
				]);

			comrepres.editionView()
				.title('Actualizar representante #{{ ::entry.identifierValue }} de Comercio {{ ::entry.values[\'com.com_rif\'] }}')
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

					nga.field('repres_nac', 'choice')
					.label('repres_nac')
					.choices(util.choiceNac())
					.validation({
						required: true
					}),
					nga.field('repres_cedu').label('repres_cedu')
					.validation({
						required: true,
						minlength: 7,
						maxlength: 15
					}),
					nga.field('repres_nomb').label('repres_nomb')
					.validation({
						required: true,
						minlength: 3,
						maxlength: 100
					}),
					nga.field('repres_apell').label('repres_apell')
					.validation({
						required: true,
						minlength: 3,
						maxlength: 100
					}),
					nga.field('repres_telef_cel').label('repres_telef_cel')
					.validation({
						required: true,
						minlength: 11,
						maxlength: 11
					}),
				]);

			comrepres.showView()
				.title('Detalle representante #{{ ::entry.identifierValue }} de Comercio {{ ::entry.values[\'com.com_rif\'] }}')
				.fields([

					nga.field('com.com_rif').label('com_rif'),
					nga.field('com.com_nomb_estb').label('com_nomb_estb'),
					nga.field('com.com_prop').label('com_prop'),

					nga.field('repres_id').label('repres_id'),
					nga.field('repres').label('com_repres'),
					nga.field('repres_nac').label('repres_nac'),
					nga.field('repres_telef_cel').label('repres_telef_cel'),
				]);

			return comrepres;
		}]);
	}
	ComrepresAdmin.$inject = ['$provide', 'NgAdminConfigurationProvider'];

	return ComrepresAdmin;
});