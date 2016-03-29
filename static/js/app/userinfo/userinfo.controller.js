(function() {
	
	/*
	 * Copyright (c) 2015, Giuseppe Angri - info@giuseppeangri.com
	 * All rights reserved.
	 * Copyrights licensed under The GNU GPLv3 License.
	 * See this for terms: http://choosealicense.com/licenses/gpl-3.0/
	 */

	'use strict';

	angular
		.module('app.userinfo')
		.controller('UserInfoController', UserInfoController)

	UserInfoController.$inject = ['$scope', 'Users', '$q'];

	function UserInfoController($scope, Users, $q) {

		var uc = this;

		uc.inizialize     = inizialize;
		uc.getData        = getData;
		uc.updateSelected = updateSelected;
		
		inizialize();

		return uc;

		function inizialize() {
			
			$scope.preferences = {};
			
			$scope.entities = [
				{
					name : 'User Info',
					getData : function() {
						
						var entity = this;
						
						$scope.promises.push(Users.get({ id : $scope.id }).$promise.then(function(result) {
							
							if(result.action.status) {
								entity.data = result.data;
								$scope.user = result.data;
							}
							
						}));

					}
				},
				{
					name : 'Status',
					getData : function() {
						
						var entity = this;
						
						$scope.promises.push(Users.getStatusCount({ id : $scope.id }).$promise.then(function(result) {
							
							if(result.action.status) {
								entity.total = result.data.count;
							}
							
						}));
						
						$scope.promises.push(Users.getStatusCountByDate({ id : $scope.id, dateStart : $scope.dateEnd, dateEnd : $scope.dateEnd }).$promise.then(function(result) {
							
							if(result.action.status) {
								entity.today = result.data.count;
							}
							
						}));
						
						$scope.promises.push(Users.getStatusCountByDate({ id : $scope.id, dateStart : $scope.dateStart, dateEnd : $scope.dateEnd }).$promise.then(function(result) {
							
							if(result.action.status) {
								entity.lastWeek = result.data.count;
							}
							
						}));

					}
				},
				{
					name : 'Comments',
					getData : function() {
						
						var entity = this;
						
						$scope.promises.push(Users.getCommentsCount({ id : $scope.id }).$promise.then(function(result) {
							
							if(result.action.status) {
								entity.total = result.data.count;
							}
							
						}));
						
						$scope.promises.push(Users.getCommentsCountByDate({ id : $scope.id, dateStart : $scope.dateEnd, dateEnd : $scope.dateEnd }).$promise.then(function(result) {
							
							if(result.action.status) {
								entity.today = result.data.count;
							}
							
						}));
						
						$scope.promises.push(Users.getCommentsCountByDate({ id : $scope.id, dateStart : $scope.dateStart, dateEnd : $scope.dateEnd }).$promise.then(function(result) {
							
							if(result.action.status) {
								entity.lastWeek = result.data.count;
							}
							
						}));

					}
				},
				{
					name : 'Likes',
					getData : function() {
						
						var entity = this;
						
						$scope.promises.push(Users.getLikesCount({ id : $scope.id }).$promise.then(function(result) {
							
							if(result.action.status) {
								entity.total = result.data.count;
							}
							
						}));
						
						$scope.promises.push(Users.getLikesCountByDate({ id : $scope.id, dateStart : $scope.dateEnd, dateEnd : $scope.dateEnd }).$promise.then(function(result) {
							
							if(result.action.status) {
								entity.today = result.data.count;
							}
							
						}));
						
						$scope.promises.push(Users.getLikesCountByDate({ id : $scope.id, dateStart : $scope.dateStart, dateEnd : $scope.dateEnd }).$promise.then(function(result) {
							
							if(result.action.status) {
								entity.lastWeek = result.data.count;
							}
							
						}));

					}
				},
				{
					name : 'Friends',
					getData : function() {
						
						var entity = this;
						
						$scope.promises.push(Users.getFriendsCount({ id : $scope.id }).$promise.then(function(result) {
							
							if(result.action.status) {
								entity.total = result.data.count;
							}
							
						}));
						
						$scope.promises.push(Users.getFriendsCountByDate({ id : $scope.id, dateStart : $scope.dateEnd, dateEnd : $scope.dateEnd }).$promise.then(function(result) {
							
							if(result.action.status) {
								entity.today = result.data.count;
							}
							
						}));
						
						$scope.promises.push(Users.getFriendsCountByDate({ id : $scope.id, dateStart : $scope.dateStart, dateEnd : $scope.dateEnd }).$promise.then(function(result) {
							
							if(result.action.status) {
								entity.lastWeek = result.data.count;
							}
							
						}));

					}
				},
				{
					name : 'Followers',
					getData : function() {
						
						var entity = this;
						
						$scope.promises.push(Users.getFollowersCount({ id : $scope.id }).$promise.then(function(result) {
							
							if(result.action.status) {
								entity.total = result.data.count;
							}
							
						}));
						
						$scope.promises.push(Users.getFollowersCountByDate({ id : $scope.id, dateStart : $scope.dateEnd, dateEnd : $scope.dateEnd }).$promise.then(function(result) {
							
							if(result.action.status) {
								entity.today = result.data.count;
							}
							
						}));
						
						$scope.promises.push(Users.getFollowersCountByDate({ id : $scope.id, dateStart : $scope.dateStart, dateEnd : $scope.dateEnd }).$promise.then(function(result) {
							
							if(result.action.status) {
								entity.lastWeek = result.data.count;
							}
							
						}));

					}
				},
			];

		}
		
		function getData() {
			
			$scope.data = false;
			$scope.loading = true;
			
			var dateStartObj = new Date();
			dateStartObj.setDate(dateStartObj.getDate()-7);
			
			var dateEndObj = new Date();
			
			$scope.dateStart = dateStartObj.toISOString().substr(0, 10);
			$scope.dateEnd   = dateEndObj.toISOString().substr(0, 10);
			
			$scope.id = $scope.preferences.userId;
			
			$scope.promises = [];
			
			$scope.entities.forEach(function(entity) {
				
				entity.getData();
				
			});
			
			$q.all($scope.promises).then(function() {
				$scope.data = true;
				$scope.loading = false;
				
				$scope.index_selected = 0;
				$scope.selected       = $scope.entities[0];
			});
			
		}
		
		function updateSelected(index) {  
			
			$scope.index_selected = index;
			$scope.selected       = $scope.entities[index];
						
    };

	}

})();
