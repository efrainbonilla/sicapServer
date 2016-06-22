/*global define*/

define(function() {
	'use strict';

	var DatepickerComercioController = function($scope) {

		//DatePicker
		$scope.today = function() {
			/*$scope.entry.values['optionDate'] = 'dateNow';
			$scope.entry.values['dateNow'] = new Date();
			$scope.entry.values['dateOther'] = new Date();*/
		};
		$scope.today();

		$scope.clear = function () {
			$scope.entry.values['com_fechptte_ini'] = null;
			$scope.entry.values['com_fechptte_fin'] = null;
		};

		// Disable weekend selection
		$scope.disabled = function(date, mode) {
			//console.log(date, mode, "disabled");
			return false;
			return ( mode === 'day' && ( date.getDay() === 0 || date.getDay() === 6 ) );
		};

		$scope.toggleMin = function() {
			//$scope.minDate = $scope.minDate ? null : new Date();
			var dt = new Date();

			$scope.minDate = '2015-01-01';
			$scope.maxDate = new Date((dt.getFullYear()+1) + '-' + (dt.getMonth()+1) + '-' +(dt.getDay() +1));

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

	DatepickerComercioController.$inject = ['$scope'];

	return DatepickerComercioController;
});