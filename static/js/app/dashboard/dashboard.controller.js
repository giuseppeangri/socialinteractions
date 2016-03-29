(function() {
	
	/*
	 * Copyright (c) 2015, Giuseppe Angri - info@giuseppeangri.com
	 * All rights reserved.
	 * Copyrights licensed under The GNU GPLv3 License.
	 * See this for terms: http://choosealicense.com/licenses/gpl-3.0/
	 */

	'use strict';

	angular
		.module('app.dashboard')
		.controller('DashboardController', DashboardController)

	DashboardController.$inject = ['$scope', 'Status', 'Comments', 'Likes', 'Friendships', 'Followers', '$q'];

	function DashboardController($scope, Status, Comments, Likes, Friendships, Followers, $q) {

		var dc = this;

		dc.inizialize     = inizialize;
		dc.updateSelected = updateSelected;

		inizialize();

		return dc;

		function inizialize() {
			
			var dateStartObj = new Date();
			dateStartObj.setDate(dateStartObj.getDate()-7);
			
			var dateEndObj = new Date();
			
			var dateStart = dateStartObj.toISOString().substr(0, 10);
			var dateEnd   = dateEndObj.toISOString().substr(0, 10);
			
			$scope.dashboard_entities = [
				{
					name : 'Newsfeed Status',
					getData : function() {
						 
						$scope.loading = true;
						
						var promises = [];
						
						promises.push(Status.countByDate({ dateStart : dateEnd, dateEnd : dateEnd }).$promise.then(function(result) {
						
						if(result.action.status) {
						 $scope.selected.today = result.data.count;
						}
						
						}));
						
						promises.push(Status.countByDate({ dateStart : dateStart, dateEnd : dateEnd }).$promise.then(function(result) {
						
						if(result.action.status) {
						 $scope.selected.lastWeek = result.data.count;
						}
						
						}));
						
						promises.push(Status.count().$promise.then(function(result) {
						
						if(result.action.status) {
						 $scope.selected.total = result.data.count;
						}
						
						}));
						
						$q.all(promises).then(function() {
							$scope.loading = false;
						});
						 
				  }
				},
				{
					name : 'Comments',
					getData : function() {
						
						$scope.loading = true;
						
						var promises = [];
						
						promises.push(Comments.countByDate({ dateStart : dateEnd, dateEnd : dateEnd }).$promise.then(function(result) {
						
						if(result.action.status) {
						 $scope.selected.today = result.data.count;
						}
						
						}));
						
						promises.push(Comments.countByDate({ dateStart : dateStart, dateEnd : dateEnd }).$promise.then(function(result) {
						
						if(result.action.status) {
						 $scope.selected.lastWeek = result.data.count;
						}
						
						}));
						
						promises.push(Comments.count().$promise.then(function(result) {
						
						if(result.action.status) {
						 $scope.selected.total = result.data.count;
						}
						
						}));
						
						$q.all(promises).then(function() {
							$scope.loading = false;
						});
						 
				  }
				},
				{
					name : 'Likes',
					getData : function() {
						 
						$scope.loading = true;
						
						var promises = [];
						
						promises.push(Likes.countByDate({ dateStart : dateEnd, dateEnd : dateEnd }).$promise.then(function(result) {
						
						if(result.action.status) {
						 $scope.selected.today = result.data.count;
						}
						
						}));
						
						promises.push(Likes.countByDate({ dateStart : dateStart, dateEnd : dateEnd }).$promise.then(function(result) {
						
						if(result.action.status) {
						 $scope.selected.lastWeek = result.data.count;
						}
						
						}));
						
						promises.push(Likes.count().$promise.then(function(result) {
						
						if(result.action.status) {
						 $scope.selected.total = result.data.count;
						}
						
						}));
						
						$q.all(promises).then(function() {
							$scope.loading = false;
						});
						 
				  }
				},
				{
					name : 'Friendships',
					getData : function() {
						
						$scope.loading = true;
						
						var promises = [];
						
						promises.push(Friendships.countByDate({ dateStart : dateEnd, dateEnd : dateEnd }).$promise.then(function(result) {
						
						if(result.action.status) {
						 $scope.selected.today = result.data.count;
						}
						
						}));
						
						promises.push(Friendships.countByDate({ dateStart : dateStart, dateEnd : dateEnd }).$promise.then(function(result) {
						
						if(result.action.status) {
						 $scope.selected.lastWeek = result.data.count;
						}
						
						}));
						
						promises.push(Friendships.count().$promise.then(function(result) {
						
						if(result.action.status) {
						 $scope.selected.total = result.data.count;
						}
						
						}));
						
						$q.all(promises).then(function() {
							$scope.loading = false;
						});
						
				  }
				},
				{
					name : 'Followers',
					getData : function() {
						
						$scope.loading = true;
						
						var promises = [];
						
						promises.push(Followers.countByDate({ dateStart : dateEnd, dateEnd : dateEnd }).$promise.then(function(result) {
						
						if(result.action.status) {
						 $scope.selected.today = result.data.count;
						}
						
						}));
						
						promises.push(Followers.countByDate({ dateStart : dateStart, dateEnd : dateEnd }).$promise.then(function(result) {
						
						if(result.action.status) {
						 $scope.selected.lastWeek = result.data.count;
						}
						
						}));
						
						promises.push(Followers.count().$promise.then(function(result) {
						
						if(result.action.status) {
						 $scope.selected.total = result.data.count;
						}
						
						}));
						
						$q.all(promises).then(function() {
							$scope.loading = false;
						});
						
				  }
				},
			];
			
			$scope.dashboard_selected = -1;
			
		}
		
		function updateSelected(index) {  
			$scope.dashboard_selected = index;
			$scope.selected           = $scope.dashboard_entities[index];
			$scope.selected.getData();
    };

	}

})();
