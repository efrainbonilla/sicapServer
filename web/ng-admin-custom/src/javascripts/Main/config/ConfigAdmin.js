/*global define*/
define(function() {
	'use strict';

	var baseApiUrl = location.protocol + '//' + location.hostname + (location.port ? ':' + location.port : '') + '/api/';

	var customHeaderTemplate = require('../view/layoutNavbar.html');
	var customLayoutTemplate = require('../view/layout.html');

	var customListViewTemplate = require('../../Crud/list/listLayout.html');
	var customDeleteViewTemplate = require('../../Crud/delete/delete.html');
	var customBatchDeleteTemplate = require('../../Crud/delete/batchDelete.html');
	var customEditViewTemplate = require('../../Crud/form/edit.html');
	var customShowViewTemplate = require('../../Crud/show/show.html');
	var customCreateViewTemplate = require('../../Crud/form/create.html');

	var customDashboardTemplate = require('../view/dashboard.html');

	function ConfigAdmin(
		NgAdminConfigurationProvider,
		appConfig,

		UserAdminProvider,
		AjusteAdminProvider,
		AjusteReporteAdminProvider,

		PaisAdminProvider,
		EstadoAdminProvider,
		MunicipioAdminProvider,
		ParroquiaAdminProvider,
		ZonaAdminProvider,

		ComercioAdminProvider,
		TcomercioAdminProvider,
		ProductoAdminProvider,
		MedidaAdminProvider,
		RegdiarioAdminProvider,
		MarcaAdminProvider,
		ModeloAdminProvider,
		ProdlimiteAdminProvider,
		ComrepresAdminProvider,
		CategoriaAdminProvider,
		GrupoAdminProvider,
		SgrupoAdminProvider) {

		var nga = NgAdminConfigurationProvider;

		var admin = NgAdminConfigurationProvider
			.application(appConfig.webapp_title)
			.baseApiUrl(baseApiUrl);

		admin
			.addEntity(UserAdminProvider.$get())
			.addEntity(AjusteAdminProvider.$get())
			.addEntity(AjusteReporteAdminProvider.$get())

			.addEntity(PaisAdminProvider.$get())
			.addEntity(EstadoAdminProvider.$get())
			.addEntity(MunicipioAdminProvider.$get())
			.addEntity(ParroquiaAdminProvider.$get())
			.addEntity(ZonaAdminProvider.$get())

			.addEntity(TcomercioAdminProvider.$get())
			.addEntity(ComercioAdminProvider.$get())
			.addEntity(ProductoAdminProvider.$get())
			.addEntity(MedidaAdminProvider.$get())
			.addEntity(RegdiarioAdminProvider.$get())
			.addEntity(MarcaAdminProvider.$get())
			.addEntity(ModeloAdminProvider.$get())
			.addEntity(ProdlimiteAdminProvider.$get())
			.addEntity(ComrepresAdminProvider.$get())
			.addEntity(CategoriaAdminProvider.$get())
			.addEntity(GrupoAdminProvider.$get())
			.addEntity(SgrupoAdminProvider.$get())
		;

		admin.menu(nga.menu()
			.addChild(nga.menu().title('Escritorio').icon('<span class="fa fa-dashboard"> </span>').link('/dashboard'))
			.addChild(nga.menu().title('Usuario').icon('<span class="fa fa-user"> </span>')
				.addChild(nga.menu().title('Perfil').icon('<span class="fa fa-user"> </span>').link('/profile/show'))
				.addChild(nga.menu().title('Cuenta').icon('<span class="fa fa-user"> </span>').link('/profile/edit'))
				.addChild(nga.menu().title('Contraseña').icon('<span class="fa fa-lock"> </span>').link('/profile/change-password'))
			)
			.addChild(nga.menu().title('Configuración').icon('<span class="fa fa-gears"> </span>')
				.addChild(nga.menu(AjusteAdminProvider.$get()).icon('<span class="fa fa-gears"> </span>'))
				.addChild(nga.menu(AjusteReporteAdminProvider.$get()))
				.addChild(nga.menu(UserAdminProvider.$get()).icon('<span class="fa fa-users"> </span>'))

				.addChild(nga.menu(PaisAdminProvider.$get()))
				.addChild(nga.menu(EstadoAdminProvider.$get()))
				.addChild(nga.menu(MunicipioAdminProvider.$get()))
				.addChild(nga.menu(ParroquiaAdminProvider.$get()))
				.addChild(nga.menu(ZonaAdminProvider.$get()))

				.addChild(nga.menu(MarcaAdminProvider.$get()).icon('<span class="fa fa-truck"> </span>'))
				.addChild(nga.menu(ModeloAdminProvider.$get()).icon('<span class="fa fa-truck"> </span>'))
				.addChild(nga.menu(CategoriaAdminProvider.$get()))
				.addChild(nga.menu(GrupoAdminProvider.$get()))
				.addChild(nga.menu(SgrupoAdminProvider.$get()))
				.addChild(nga.menu(MedidaAdminProvider.$get()))
			)
			.addChild(nga.menu().title('Control SICAP').icon('<span class="fa fa-key"> </span>')
				.addChild(nga.menu(TcomercioAdminProvider.$get()))
				.addChild(nga.menu(ComercioAdminProvider.$get()))
				.addChild(nga.menu(ComrepresAdminProvider.$get()))
				.addChild(nga.menu(ProdlimiteAdminProvider.$get()))
				.addChild(nga.menu(ProductoAdminProvider.$get()))
				.addChild(nga.menu().title('Nuevo Registro diario').link('/regdiarios/create'))
				.addChild(nga.menu(RegdiarioAdminProvider.$get()))
				.addChild(nga.menu().title('Reportes').icon('<span class="fa fa-user"> </span>').link('/controlsicap/reportes'))
			)
		);

		var customTemplate = {
			'DeleteView': customDeleteViewTemplate,
			'EditView': customEditViewTemplate,
			'ListView': customListViewTemplate,
			'ShowView': customShowViewTemplate,
			'CreateView': customCreateViewTemplate,
			'BatchDeleteView': customBatchDeleteTemplate
		};

		admin.customTemplate(function(viewName) {
			if (customTemplate[viewName]) {
				return customTemplate[viewName];
			}
		});

		admin.header(customHeaderTemplate);

		/*admin.dashboard(nga.dashboard()
	    	.addCollection(nga.collection(UserAdminProvider.$get()).title('Usuarios'))
	    );*/

		admin.dashboard(nga.dashboard()
			/*.addCollection(nga.collection(ComercioAdminProvider.$get())
				.fields([
					nga.field('com_rif').label('list.com_rif'),
					nga.field('com_nomb_estb').label('list.com_nomb_estb'),
					nga.field('com_prop').label('list.com_prop')
				])
			)*/

			.template(customDashboardTemplate)
		);

		NgAdminConfigurationProvider.configure(admin);
	}

	ConfigAdmin.$inject = [
		'NgAdminConfigurationProvider',
		'appConfig',
		'UserAdminProvider',
		'AjusteAdminProvider',
		'AjusteReporteAdminProvider',

		'PaisAdminProvider',
		'EstadoAdminProvider',
		'MunicipioAdminProvider',
		'ParroquiaAdminProvider',
		'ZonaAdminProvider',

		'ComercioAdminProvider',
		'TcomercioAdminProvider',
		'ProductoAdminProvider',
		'MedidaAdminProvider',
		'RegdiarioAdminProvider',
		'MarcaAdminProvider',
		'ModeloAdminProvider',
		'ProdlimiteAdminProvider',
		'ComrepresAdminProvider',
		'CategoriaAdminProvider',
		'GrupoAdminProvider',
		'SgrupoAdminProvider',
	];

	return ConfigAdmin;
});