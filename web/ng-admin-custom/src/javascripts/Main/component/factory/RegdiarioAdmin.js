define(function(require) {
	'use strict';

	function RegdiarioAdmin($provide, NgAdminConfigurationProvider) {
		$provide.factory('RegdiarioAdmin', ['$rootScope', 'RestWrapper', 'UtilityService', function($rootScope, RestWrapper, UtilityService) {
			var nga = NgAdminConfigurationProvider;

			var util = UtilityService;

			var regdiario = nga.entity('regdiarios')
				.identifier(nga.field('reg_id'))
				.label('Registro diario');

			var regdiarioCreateView = require('../../view/regdiarioCreateView.html');
			var regdiarioShowView = require('../../view/regdiarioShowView.html');


			regdiario.listView()
				.infinitePagination(false)
				.title('Lista registro diario')
				.fields([
					nga.field('reg_id').label('reg_id'),
					nga.field('com.com_estb_rif').label('list.com_nomb_estb'),
					nga.field('com.com_prop').label('list.com_prop'),
					nga.field('reg_fech','date').label('Fecha registro'),
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
					.label('Comercio')
					.choices(function(entry, scope) {

						util.choiceLiteComercio()(entry, scope);

						$rootScope.$broadcast('choice:litecomercios:get');

						return [];
					}),
				])
				.listActions(['edit', 'delete', 'show']);

			regdiario.creationView()
				.title('Nuevo registro')
				.fields([
					nga.field('com', 'choice')
					.label('prodl_rif_estb')
					.validation({
						required: true
					})
					.attributes({
						'on-select': 'selCom($item, $model)',
						/*'ng-disabled': 'true',*/
					})
					.choices(function(entry, scope) {

						scope.selCom = selCom;

						util.choiceLiteComercio({
							label: 'com_estb_rif',
							value: 'com_id',
							rif: 'com_rif',
							estb: 'com_nomb_estb',
							prop: 'com_prop',
							ptte: 'com_num_ptte',
							lic: 'com_num_lic',
						})(entry, scope);

						$rootScope.$broadcast('choice:litecomercios:get');

						return [];

						function selCom ($item, $model) {
							$rootScope.$broadcast('choice:grid:render', [$item]);
						}
					}),
				])
				.template(regdiarioCreateView);

			regdiario.editionView()
				.title('Actualizar registro #{{ ::entry.identifierValue }}')
				.fields([
				]);

			regdiario.showView()
				.title('Detalle registro #{{ ::entry.identifierValue }}')
				.fields([
					nga.field('reg_id').label('reg_id'),
					nga.field('reg_fech').label('reg_fech'),
					nga.field('com.com_rif').label('com_rif'),
					nga.field('com.com_nomb_estb').label('com_nomb_estb'),
					nga.field('com.com_prop').label('com_prop'),
					nga.field('fact.com_prop').label('com_prop'),
				])
				.template(regdiarioShowView);


			return regdiario;
		}]);
	}
	RegdiarioAdmin.$inject = ['$provide', 'NgAdminConfigurationProvider'];

	return RegdiarioAdmin;
});