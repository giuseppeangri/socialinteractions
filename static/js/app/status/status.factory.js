(function() {
	
	/*
	 * Copyright (c) 2015, Giuseppe Angri - info@giuseppeangri.com
	 * All rights reserved.
	 * Copyrights licensed under The GNU GPLv3 License.
	 * See this for terms: http://choosealicense.com/licenses/gpl-3.0/
	 */
	
	'use strict';
	
	angular
		.module('app.status')
		.factory('Status', Status);
	
	Status.$inject = ['$resource', 'WS_URL'];	
	
	function Status($resource, WS_URL) {
		
		var url = WS_URL + 'status/:id';
		var statusFactory = $resource(
			url,
			{ id : '@id' },
			{ 
				getByDate 						: { url : url + '/getByDate/:dateStart/:dateEnd', 			method : 'GET', isArray : false, 	cache : true },
				count 								: { url : url + '/count', 															method : 'GET', isArray : false, 	cache : true },
				countByDate						: { url : url + '/countByDate/:dateStart/:dateEnd',			method : 'GET', isArray : false, 	cache : true },
				getEngagement 				: { url : url + '/getEngagement', 											method : 'GET', isArray : false, 	cache : true },
				getEngagementCount 		: { url : url + '/getEngagementCount', 									method : 'GET', isArray : false, 	cache : true },
				getEngagementUsers		: { url : url + '/getEngagementUsers', 									method : 'GET', isArray : false, 	cache : true }
			}
		);
			
		return statusFactory;
	}
	
})();
