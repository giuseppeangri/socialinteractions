(function() {
	
	/*
	 * Copyright (c) 2015, Giuseppe Angri - info@giuseppeangri.com
	 * All rights reserved.
	 * Copyrights licensed under The GNU GPLv3 License.
	 * See this for terms: http://choosealicense.com/licenses/gpl-3.0/
	 */

	'use strict';

	angular
		.module('app', [
			'app.core',
			'app.main',
			'app.dashboard',
			'app.userinfo',
			'app.graphwizard',
			'app.users',
			'app.status',
			'app.comments',
			'app.likes',
			'app.friendships',
			'app.followers',
		]);

})();
