(function() {
	
	/*
	 * Copyright (c) 2015, Giuseppe Angri - info@giuseppeangri.com
	 * All rights reserved.
	 * Copyrights licensed under The GNU GPLv3 License.
	 * See this for terms: http://choosealicense.com/licenses/gpl-3.0/
	 */

	'use strict';

	angular
		.module('app.main')
		.controller('MainController', MainController)

	MainController.$inject = ['$scope'];

	function MainController($scope) {

		var mc = this;

		mc.inizialize  = inizialize;
		mc.showSection = showSection;
		
		inizialize();

		return mc;

		function inizialize() {
			
			var lodash = _.noConflict();

			$scope.plugin_section = 1;

		}
		
		function showSection(id) {
			$scope.plugin_section = id;
		}

	}

})();
