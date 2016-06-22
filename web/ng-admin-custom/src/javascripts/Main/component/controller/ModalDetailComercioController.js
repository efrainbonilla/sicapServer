define(function () {
	'use strict';

	var ModalDetailComercioController = function ($scope, $modalInstance, UtilityService, items, entries) {

		$scope.items = items;
		$scope.entries = entries;
		$scope.entry = $scope.entries[0];

		var util = UtilityService;

		util.apiComercioDetail({}, $scope.entry.value).then(function (response) {
			$scope.items = response.data.originalElement;
		});



		$scope.cancel = function () {
			$modalInstance.close();
		};
	};

	ModalDetailComercioController.$inject = ['$scope', '$modalInstance', 'UtilityService', 'items', 'entries'];

	return ModalDetailComercioController;
});