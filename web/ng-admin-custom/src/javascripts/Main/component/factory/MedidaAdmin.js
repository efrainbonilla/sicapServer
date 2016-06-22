define(function(require) {
	'use strict';

	function MedidaAdmin($provide, NgAdminConfigurationProvider) {
		$provide.factory('MedidaAdmin', ['$rootScope', 'RestWrapper', 'UtilityService', function($rootScope, RestWrapper, UtilityService) {
			var nga = NgAdminConfigurationProvider;

			var util = UtilityService;

			var medida = nga.entity('medidas')
				.identifier(nga.field('med_id'))
				.label('Unidades de Medidas');

			medida.listView()
				.infinitePagination(false)
				.title('Lista de Unidades de Medidas')
				.fields([
					nga.field('med_id').label('med_id'),
					nga.field('med_nomb').label('med_nomb'),
					nga.field('med_simb').label('med_simb'),
					nga.field('mag.mag_nomb').label('Magnitud'),
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

			medida.creationView()
				.title('Crear nuevo Unidad de Medida')
				.fields([
					nga.field('mag', 'choice')
					.label('Magnitud')
					.choices(function(entry, scope) {

						util.choiceMagnitud()(entry, scope);

						$rootScope.$broadcast('choice:magnitudes:get');

						return [];
					}),

					nga.field('med_nomb').label('med_nomb'),
					nga.field('med_simb').label('med_simb'),
				]);

			medida.editionView()
				.title('Actualizar medida #{{ ::entry.identifierValue }}')
				.fields([
					nga.field('mag', 'choice')
					.label('Magnitud')
					.choices(function(entry, scope) {

						entry.values['mag'] = entry.values['mag.mag_id'];

						util.choiceMagnitud()(entry, scope);

						$rootScope.$broadcast('choice:magnitudes:get');

						return [];
					}),
					nga.field('med_nomb').label('med_nomb'),
					nga.field('med_simb').label('med_simb'),
				]);

			medida.showView()
				.title('Detalle medida #{{ ::entry.identifierValue }}')
				.fields([
					nga.field('med_id').label('med_id'),
					medida.creationView().fields(),
				]);

			return medida;
		}]);
	}
	MedidaAdmin.$inject = ['$provide', 'NgAdminConfigurationProvider'];

	return MedidaAdmin;
});