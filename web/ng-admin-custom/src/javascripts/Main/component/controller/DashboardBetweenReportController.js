export default class DashboardBetweenReportController {
	constructor($scope, RestWrapper, progression, notification, UtilityService) {
		this.$scope = $scope;
		this.progression = progression;
		this.notification = notification;
		this.util = UtilityService;
		this.rest = RestWrapper;

		let events = {
			all: 'alls',
			day: 'days',
			dayBefore: 'daysBefore',
			week: 'weeks',
			weekBefore: 'weeksBefore',
			month: 'months',
			monthBefore: 'monthsBefore'
		};

		for (var key in events) {
			var value = events[key];

			this.$scope[value] = [];
			var cb = (key, value) => {
				this.$scope[key] = ($event) => {
					this.getOne(key, (response) => {
						this.$scope[value] = response;
					});
				}
			}

			cb(key, value);
		}

		this.$scope.$on('$destroy', this.destroy.bind(this));
	}

	getOne(dateFormat, cb) {

		this.progression.start();

		var dataDate = {
			optionDate: 'del',
			dataDate: {
				dateFormat: dateFormat
			}
		};

		var queryString = this.util.toQueryString(dataDate);

		this.rest
			.getOne('report', '/api/comercios/report?' + queryString)
			.then((data) => {
				this.progression.done();
				cb(data.originalElement);
			}, (response) => {
				this.progression.done();
				console.log(response.originalElement, "failed");
			});
	}

	destroy() {
		this.$scope = undefined;
		this.progression = undefined;
		this.notification = undefined;
		this.util = undefined;
		this.rest = undefined;
	}
}

DashboardBetweenReportController.$inject = ['$scope', 'RestWrapper', 'progression', 'notification', 'UtilityService'];