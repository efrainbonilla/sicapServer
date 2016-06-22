
var MainModule = angular.module('mainMod', ['ng-admin', 'ui.router', 'boxuk.translation', 'angularMoment']);
MainModule.constant('appConfig', window.config || {});
MainModule.controller('AppCtrl', require('./component/controller/AppController'));
MainModule.controller('ModalLoginCtrl', require('./component/controller/ModalLoginController'));
MainModule.controller('ModalLogoutCtrl', require('./component/controller/ModalLogoutController'));
MainModule.controller('ModalAccessDeniedDeCtrl', require('./component/controller/ModalAccessDeniedController'));
MainModule.controller('ModalDetailComercioCtrl', require('./component/controller/ModalDetailComercioController'));
MainModule.controller('SessionDropdownCtrl', require('./component/controller/SessionDropdownController'));

MainModule.factory('AuthenticationService', require('./component/factory/AuthenticationService'));
MainModule.factory('UtilityService', require('./component/factory/UtilityService'));

MainModule.controller('PageController', require('./component/controller/PageController'));
MainModule.controller('LoginController', require('./component/controller/LoginController'));
MainModule.controller('RegisterController', require('./component/controller/RegisterController'));
MainModule.controller('LostpasswordController', require('./component/controller/LostpasswordController'));
MainModule.controller('HomeController', require('./component/controller/HomeController'));
MainModule.controller('ProfileController', require('./component/controller/ProfileController'));
MainModule.controller('ChangePasswordController', require('./component/controller/ChangePasswordController'));
MainModule.controller('ResettingController', require('./component/controller/ResettingController'));
MainModule.controller('ResettingResetController', require('./component/controller/ResettingResetController'));

MainModule.controller('ReportesControlSicapController', require('./component/controller/ReportesControlSicapController'));
MainModule.controller('BetweenController', require('./component/controller/BetweenController'));

MainModule.controller('HistoryDatepickerComerciosController', require('./component/controller/HistoryDatepickerComerciosController'));
MainModule.controller('DatepickerRegdiarioController', require('./component/controller/DatepickerRegdiarioController'));
MainModule.controller('DatepickerComercioController', require('./component/controller/DatepickerComercioController'));
MainModule.controller('DashboardBetweenReportController', require('./component/controller/DashboardBetweenReportController'));

MainModule.controller('HandlePrintController', require('./component/controller/HandlePrintController'));

MainModule.directive('sicaDatagrid', require('./component/directive/sicaDatagrid'));
MainModule.directive('sicaInvoice', require('./component/directive/sicaInvoice'));
MainModule.directive('sicaTransport', require('./component/directive/sicaTransport'));
MainModule.directive('sicapDashboardBetweenDatagrid', require('./component/directive/sicapDashboardBetweenDatagrid'));

MainModule.config(require('./config/routing'));

MainModule.config(require('./component/factory/AjusteAdmin'));
MainModule.config(require('./component/factory/AjusteReporteAdmin'));
MainModule.config(require('./component/factory/UserAdmin'));

MainModule.config(require('./component/factory/PaisAdmin'));
MainModule.config(require('./component/factory/EstadoAdmin'));
MainModule.config(require('./component/factory/MunicipioAdmin'));
MainModule.config(require('./component/factory/ParroquiaAdmin'));
MainModule.config(require('./component/factory/ZonaAdmin'));

MainModule.config(require('./component/factory/TcomercioAdmin'));
MainModule.config(require('./component/factory/ComercioAdmin'));
MainModule.config(require('./component/factory/MedidaAdmin'));
MainModule.config(require('./component/factory/ProductoAdmin'));
MainModule.config(require('./component/factory/RegdiarioAdmin'));

MainModule.config(require('./component/factory/MarcaAdmin'));
MainModule.config(require('./component/factory/ModeloAdmin'));
MainModule.config(require('./component/factory/ProdlimiteAdmin'));
MainModule.config(require('./component/factory/ComrepresAdmin'));

MainModule.config(require('./component/factory/CategoriaAdmin'));
MainModule.config(require('./component/factory/GrupoAdmin'));
MainModule.config(require('./component/factory/SgrupoAdmin'));

MainModule.config(require('./config/InterceptorAdmin'));
MainModule.config(require('./config/ConfigAdmin'));
MainModule.config(require('./config/notification'));

MainModule.provider('UserService', require('./component/service/UserService'));

MainModule.run(require('./run/initGlobal'));
MainModule.run(require('./run/LoaderToken'));
MainModule.run(require('./run/initMoment'));