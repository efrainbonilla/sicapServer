/*global define*/

define(function() {
	'use strict';

	var HistoryDatepickerComerciosController = function($scope) {

		//DatePicker
		$scope.today = function() {
			$scope.query.from = new Date();
			$scope.query.to = new Date();
		};
		$scope.today();

		$scope.clear = function () {
			$scope.query.from = null;
			$scope.query.to = null;
		};

		// Disable weekend selection
		$scope.disabled = function(date, mode) {
			console.log(date, mode, "disabled");
			return false;
			return ( mode === 'day' && ( date.getDay() === 0 || date.getDay() === 6 ) );
		};

		$scope.toggleMin = function() {
			//$scope.minDate = $scope.minDate ? null : new Date();
			$scope.minDate = '2015-06-01';
			$scope.maxDate = new Date();

		};
		$scope.toggleMin();

		$scope.open = function($event) {
			$event.preventDefault();
			$event.stopPropagation();

			$scope.opened = true;
		};

		$scope.dateOptions = {
			formatYear: 'yy',
			startingDay: 1
		};

		$scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate', 'dd/MM/yyyy'];
		$scope.format = $scope.formats[4];

		var tomorrow = new Date();
		tomorrow.setDate(tomorrow.getDate() + 1);
		var afterTomorrow = new Date();
		afterTomorrow.setDate(tomorrow.getDate() + 2);
		$scope.events =
		[
			{
				date: tomorrow,
				status: 'full'
			},
			{
				date: afterTomorrow,
				status: 'partially'
			}
		];

		$scope.getDayClass = function(date, mode) {
			if (mode === 'day') {
				var dayToCheck = new Date(date).setHours(0,0,0,0);

				for (var i=0;i<$scope.events.length;i++){
					var currentDay = new Date($scope.events[i].date).setHours(0,0,0,0);

					if (dayToCheck === currentDay) {
						return $scope.events[i].status;
					}
				}
			}

			return '';
	 	};
	};

	HistoryDatepickerComerciosController.$inject = ['$scope'];

	return HistoryDatepickerComerciosController;
});