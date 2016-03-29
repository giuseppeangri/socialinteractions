(function() {
	
	/*
	 * Copyright (c) 2015, Giuseppe Angri - info@giuseppeangri.com
	 * All rights reserved.
	 * Copyrights licensed under The GNU GPLv3 License.
	 * See this for terms: http://choosealicense.com/licenses/gpl-3.0/
	 */
	
	'use strict';
	
	angular
		.module('app.users')
		.factory('Users', Users);
	
	Users.$inject = ['$resource', 'WS_URL'];	
	
	function Users($resource, WS_URL) {
		
		var url = WS_URL + 'users/:id';
		var usersFactory = $resource(
			url,
			{ id : '@id' },
			{ 
				getStatus 								: { url : url + '/getStatus', 																		method : 'GET', isArray : false, 	cache : true },
				getStatusCount 						: { url : url + '/getStatusCount', 																method : 'GET', isArray : false, 	cache : true },
				getStatusCountByDate			: { url : url + '/getStatusCountByDate/:dateStart/:dateEnd',			method : 'GET', isArray : false, 	cache : true },
				getComments 							: { url : url + '/getComments', 																	method : 'GET', isArray : false, 	cache : false },
				getCommentsCount 					: { url : url + '/getCommentsCount',															method : 'GET', isArray : false, 	cache : false },
				getCommentsCountByDate		: { url : url + '/getCommentsCountByDate/:dateStart/:dateEnd', 		method : 'GET', isArray : false, 	cache : true },
				getLikes 									: { url : url + '/getLikes', 																			method : 'GET', isArray : false, 	cache : false },
				getLikesCount 						: { url : url + '/getLikesCount', 																method : 'GET', isArray : false, 	cache : false },
				getLikesCountByDate				: { url : url + '/getLikesCountByDate/:dateStart/:dateEnd', 			method : 'GET', isArray : false, 	cache : true },
				getEngagement 						: { url : url + '/getEngagement', 																method : 'GET', isArray : false, 	cache : false },
				getEngagementCount				: { url : url + '/getEngagementCount',														method : 'GET', isArray : false, 	cache : false },
				getEngagementCountByDate	: { url : url + '/getEngagementCountByDate/:dateStart/:dateEnd',	method : 'GET', isArray : false, 	cache : true },
				getFriends 								: { url : url + '/getFriends', 																		method : 'GET', isArray : false,	cache : true },
				getFriendsCount 					: { url : url + '/getFriendsCount', 															method : 'GET', isArray : false, 	cache : true },
				getFriendsCountByDate			: { url : url + '/getFriendsCountByDate/:dateStart/:dateEnd', 		method : 'GET', isArray : false, 	cache : true },
				getFollowers 							: { url : url + '/getFollowers', 																	method : 'GET', isArray : false,	cache : true },
				getFollowersCount 				: { url : url + '/getFollowersCount', 														method : 'GET', isArray : false, 	cache : true },
				getFollowersCountByDate		: { url : url + '/getFollowersCountByDate/:dateStart/:dateEnd', 	method : 'GET', isArray : false, 	cache : true },
			}
		);
			
		return usersFactory;
	}
	
})();
