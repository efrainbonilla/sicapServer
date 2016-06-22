define(function(require) {
	'use strict';

	function ComercioAdmin($provide, NgAdminConfigurationProvider, TcomercioAdminProvider) {
		$provide.factory('ComercioAdmin', ['$rootScope', 'RestWrapper', 'UtilityService', function($rootScope, RestWrapper, UtilityService) {
			var nga = NgAdminConfigurationProvider;
			var tcom = TcomercioAdminProvider.$get();
			var util = UtilityService;

			var comercio = nga.entity('comercios')
				.identifier(nga.field('com_id'))
				.label('Comercios');

			var comercioCreateView = require('../../view/comercioCreateView.html');
			var comercioEditView = require('../../view/comercioEditView.html');
			var comercioShowView = require('../../view/comercioShowView.html');

			comercio.listView()
				.infinitePagination(false)
				.fields([
					nga.field('com_rif').label('list.com_rif'),
					nga.field('com_nomb_estb').label('list.com_nomb_estb'),
					nga.field('com_num_ptte').label('list.com_num_ptte'),
					nga.field('com_num_lic').label('list.com_num_lic'),

					nga.field('mcom', 'reference_many')
                    .targetEntity(tcom)
                    .targetField(nga.field('tcom_nomb'))
                    .singleApiCall(function (postIds) {
                    	console.log(postIds,"");
	                    //return { 'tcom_id[]': postIds };
	                }),
	                /*.singleApiCall(ids => {
                    ,
                    //.cssClasses('hidden-xs')
                    	console.log(ids);
                     	return {'id': ids };
                 	})*/


					nga.field('com_act_ecnma').label('list.com_act_ecnma'),
					nga.field('com_prop').label('list.com_prop')
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


					/*nga.field('filters[mcom]', 'choice')
					.label('Tipo de comercio')
					.choices(function(entry, scope) {

						util.choicetComercio()(entry, scope);

						$rootScope.$broadcast('choice:tcomercios:get');

						return [];
					}),*/
				])
				.listActions(['edit', 'delete', 'show']);

			comercio.creationView()
				.fields([
					nga.field('com_rif_fix', 'choice')
					.validation({
						required: true
					})
					.choices([{
						label: 'V',
						value: 'V'
					}, {
						label: 'J',
						value: 'J'
					}, {
						label: 'G',
						value: 'G'
					}]),

					nga.field('com_rif')
					.validation({
						required: true,
						minlength: 9,
						maxlength: 15
					}),

					nga.field('com_nomb_estb')
					.validation({
						required: true,
						minlength: 5,
						maxlength: 100
					}),
					nga.field('com_num_ptte')
					.validation({
						required: false,
						minlength: 4,
						maxlength: 10
					}),
					nga.field('com_num_lic')
					.validation({
						required: false,
						minlength: 4,
						maxlength: 10
					}),
					nga.field('com_telef_fijo')
					.validation({
						required: true,
						minlength: 11,
						maxlength: 11
					}),
					nga.field('com_act_ecnma')
					.validation({
						required: true,
						minlength: 5,
						maxlength: 100
					}),

					nga.field('direccion.edo', 'choice')
					.label('edo_nomb')
					.validation({
						required: true
					})
					.attributes({
						'on-select': 'selEdo($item, $model)'
					})
					.choices(function(entry, scope) {

						util.choiceEstado()(entry, scope);

						$rootScope.$broadcast('choice:estados:get', {
							value: '22'
						}, '22');

						return [];
					}),

					nga.field('direccion.muni', 'choice')
					.label('muni_nomb')
					.validation({
						required: true
					})
					.attributes({
						'on-select': 'selMuni($item, $model)'
					})
					.choices(util.choiceMunicipio()),

					nga.field('direccion.parroq', 'choice')
					.label('parroq_nomb')
					.validation({
						required: true
					})
					.attributes({
						'on-select': 'selParroq($item, $model)'
					})
					.choices(util.choiceParroquia()),

					nga.field('direccion.zona', 'choice')
					.label('zona_nomb')
					.validation({
						required: true
					})
					.choices(util.choiceZona()),

					nga.field('direccion.av_calle')
					.label('av_calle')
					.validation({
						required: true,
						minlength: 2,
						maxlength: 50
					}),
					nga.field('direccion.pto_ref')
					.label('pto_ref')
					.validation({
						required: true,
						minlength: 4,
						maxlength: 100
					}),

					nga.field('com_prop_nac', 'choice')
					.choices(util.choiceNac())
					.validation({
						required: true
					}),

					nga.field('com_prop_cedu')
					.validation({
						required: true,
						minlength: 7,
						maxlength: 15
					}),
					nga.field('com_prop_nomb')
					.validation({
						required: true,
						minlength: 3,
						maxlength: 100
					}),
					nga.field('com_prop_apell')
					.validation({
						required: true,
						minlength: 3,
						maxlength: 100
					}),
					nga.field('com_prop_telef_cel')
					.validation({
						required: true,
						minlength: 11,
						maxlength: 11
					}),

					nga.field('mcom', 'reference_many')
					.label('Tipo de comercio')
                    .targetEntity(tcom)
                    .targetField(nga.field('tcom_nomb'))
                    .filters(function(search) {
                        return search ? { q: search } : null;
                    })
                    .remoteComplete(true, { refreshDelay: 300 }),

                    nga.field('com_sada_chk', 'boolean'),
					nga.field('com_sada_codi')
					.validation({
						required: false,
						maxlength: 11
					})
					.attributes({
						"ng-disabled": "!entry.values['com_sada_chk']"
					}),

					nga.field('com_fechptte_ini')
					.validation({
						required: false,
						minlength: 10,
						maxlength: 10
					}),
					nga.field('com_fechptte_fin')
					.validation({
						required: false,
						minlength: 10,
						maxlength: 10
					}),
					nga.field('com_capit', 'number')
					.validation({
						required: false,
						minlength: 1,
						maxlength: 100
					})
					.format('0.00')
					.attributes({
						'autocomplete': 'false',
						'ng-autocomplete': 'false'
					}),
				])
				.template(comercioCreateView);

			comercio.editionView()
				.fields([
					nga.field('com_rif')
					.validation({
						required: true,
						minlength: 10,
						maxlength: 15
					}),

					nga.field('com_nomb_estb')
					.validation({
						required: true,
						minlength: 5,
						maxlength: 100
					}),
					nga.field('com_num_ptte')
					.validation({
						required: false,
						minlength: 4,
						maxlength: 10
					}),
					nga.field('com_num_lic')
					.validation({
						required: false,
						minlength: 4,
						maxlength: 10
					}),
					nga.field('com_telef_fijo')
					.validation({
						required: true,
						minlength: 11,
						maxlength: 11
					}),
					nga.field('com_act_ecnma')
					.validation({
						required: true,
						minlength: 5,
						maxlength: 100
					}),

					nga.field('direccion.edo', 'choice')
					.label('edo_nomb')
					.validation({
						required: true
					})
					.attributes({
						'on-select': 'selEdo($item, $model)'
					})
					.choices(function(entry, scope) {


						var edoCodi, paisId;
						edoCodi = entry.values['direccion.edo'] = entry.values['direccion.edo.edo_codi'];
						paisId = entry.values['direccion.edo.pais.pais_id'];
						delete entry.values['direccion.com'];
						delete entry.values['direccion.dire_id'];

						util.choiceEstado()(entry, scope);

						$rootScope.$broadcast('choice:estados:get', {
							value: paisId
						}, paisId);

						return [];
					}),

					nga.field('direccion.muni', 'choice')
					.label('muni_nomb')
					.validation({
						required: true
					})
					.attributes({
						'on-select': 'selMuni($item, $model)'
					})
					.choices(function(entry, scope) {
						var muniCodi, edoCodi;
						muniCodi = entry.values['direccion.muni'] = entry.values['direccion.muni.muni_codi'];
						edoCodi = entry.values['direccion.edo.edo_codi'];

						util.choiceMunicipio()(entry, scope);

						$rootScope.$broadcast('choice:municipios:get', {
							value: edoCodi
						}, edoCodi);

						return [];
					}),

					nga.field('direccion.parroq', 'choice')
					.label('parroq_nomb')
					.validation({
						required: true
					})
					.attributes({
						'on-select': 'selParroq($item, $model)'
					})
					.choices(function(entry, scope) {
						var parroqCodi, muniCodi;

						parroqCodi = entry.values['direccion.parroq'] = entry.values['direccion.parroq.parroq_codi'];
						muniCodi = entry.values['direccion.muni.muni_codi'];

						util.choiceParroquia()(entry, scope);

						$rootScope.$broadcast('choice:parroquias:get', {
							value: muniCodi
						}, muniCodi);

						return [];
					}),

					nga.field('direccion.zona', 'choice')
					.label('zona_nomb')
					.validation({
						required: true
					})
					.choices(function(entry, scope) {
						var zonaId, parroqCodi;
						zonaId = entry.values['direccion.zona'] = entry.values['direccion.zona.zona_id'];
						parroqCodi = entry.values['direccion.parroq.parroq_codi'];

						util.choiceZona()(entry, scope);

						$rootScope.$broadcast('choice:zonas:get', {
							value: parroqCodi
						}, parroqCodi);

						return [];
					}),

					nga.field('direccion.av_calle')
					.label('av_calle')
					.validation({
						required: true,
						minlength: 2,
						maxlength: 50
					}),

					nga.field('direccion.pto_ref')
					.label('pto_ref')
					.validation({
						required: true,
						minlength: 4,
						maxlength: 100
					}),

					nga.field('com_prop_nac', 'choice')
					.choices(util.choiceNac())
					.validation({
						required: true
					}),

					nga.field('com_prop_cedu')
					.validation({
						required: true,
						minlength: 7,
						maxlength: 15
					}),
					nga.field('com_prop_nomb')
					.validation({
						required: true,
						minlength: 3,
						maxlength: 100
					}),
					nga.field('com_prop_apell')
					.validation({
						required: true,
						minlength: 3,
						maxlength: 100
					}),
					nga.field('com_prop_telef_cel')
					.validation({
						required: true,
						minlength: 11,
						maxlength: 11
					}),

					nga.field('mcom', 'reference_many')
					.label('Tipo de comercio')
                    .targetEntity(tcom)
                    .targetField(nga.field('tcom_nomb'))
                    .filters(function(search) {
                        return search ? { q: search } : null;
                    })
                    .remoteComplete(false, { refreshDelay: 300 }),

                    nga.field('com_sada_chk', 'boolean'),

					nga.field('com_sada_codi')
					.validation({
						required: false,
						maxlength: 11
					}),

					nga.field('com_fechptte_ini')
					.validation({
						required: false,
						minlength: 10,
						maxlength: 10
					}),
					nga.field('com_fechptte_fin')
					.validation({
						required: false,
						minlength: 10,
						maxlength: 10
					}),
					nga.field('com_capit', 'number')
					.validation({
						required: false,
						minlength: 1,
						maxlength: 100
					})
					.format('0.00'),
				])
				.template(comercioEditView);


			comercio.showView()
				.fields([
					nga.field('com_rif').label('show.com_rif'),
					nga.field('com_nomb_estb').label('show.com_nomb_estb'),
					nga.field('com_num_ptte').label('show.com_num_ptte'),

					nga.field('com_fechptte_ini', 'date'),
					nga.field('com_fechptte_fin', 'date'),
					nga.field('com_capit'),

					nga.field('com_num_lic').label('show.com_num_lic'),
					nga.field('com_telef_fijo').label('show.com_telef_fijo'),
					nga.field('com_act_ecnma').label('show.com_act_ecnma'),
					nga.field('com_prop_nac').label('show.com_prop_nac'),
					nga.field('com_prop_cedu').label('show.com_prop_cedu'),
					nga.field('com_prop_nomb').label('show.com_prop_nomb'),
					nga.field('com_prop_apell').label('show.com_prop_apell'),
					nga.field('com_prop_telef_cel').label('show.com_prop_telef_cel'),
					nga.field('direccion.edo.edo_nomb').label('edo_nomb'),
					nga.field('direccion.muni.muni_nomb').label('muni_nomb'),
					nga.field('direccion.parroq.parroq_nomb').label('parroq_nomb'),
					nga.field('direccion.zona.zona_nomb').label('zona_nomb'),
					nga.field('direccion.av_calle').label('av_calle'),
					nga.field('direccion.pto_ref').label('pto_ref'),
				])
				.template(comercioShowView);

			return comercio;
		}]);
	}
	ComercioAdmin.$inject = ['$provide', 'NgAdminConfigurationProvider', 'TcomercioAdminProvider'];

	return ComercioAdmin;
});