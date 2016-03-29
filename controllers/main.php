<?php
	
	/*
	 * Copyright (c) 2015, Giuseppe Angri - info@giuseppeangri.com
	 * All rights reserved.
	 * Copyrights licensed under The GNU GPLv3 License.
	 * See this for terms: http://choosealicense.com/licenses/gpl-3.0/
	 */

  class SOCIALINTERACTIONS_CTRL_Main extends ADMIN_CTRL_Abstract {

    public function index() {

      $this->setPageTitle(OW::getLanguage()->text('socialinteractions', 'main_page_title'));
      
      $this->assign('staticDir', OW::getPluginManager()->getPlugin("socialinteractions")->getStaticUrl());
			
			// CSS Import: AlchemyJS
      OW::getDocument()->addStyleSheet( OW::getPluginManager()->getPlugin('socialinteractions')->getStaticCssUrl().'vendor/alchemy/0.4.2/alchemy.min.css' );
			
			// CSS Import: Custom CSS
      OW::getDocument()->addStyleSheet( OW::getPluginManager()->getPlugin('socialinteractions')->getStaticCssUrl().'main.css' );
			
			// JS Import: AlchemyJS
      OW::getDocument()->addScript(OW::getPluginManager()->getPlugin("socialinteractions")->getStaticJsUrl() . "vendor/alchemy/0.4.2/scripts/vendor.js");
      OW::getDocument()->addScript(OW::getPluginManager()->getPlugin("socialinteractions")->getStaticJsUrl() . "vendor/jquery-migrate/1.2.1/jquery-migrate-1.2.1.min.js");
      OW::getDocument()->addScript(OW::getPluginManager()->getPlugin("socialinteractions")->getStaticJsUrl() . "vendor/alchemy/0.4.2/alchemy.js");
			
			// JS Import: AngularJS
      OW::getDocument()->addScript(OW::getPluginManager()->getPlugin("socialinteractions")->getStaticJsUrl() . "vendor/angularjs/1.3.16/angular.min.js");
      OW::getDocument()->addScript(OW::getPluginManager()->getPlugin("socialinteractions")->getStaticJsUrl() . "vendor/angularjs/1.3.16/angular-resource.min.js");
			
			// JS Import: Application JS
      OW::getDocument()->addScript(OW::getPluginManager()->getPlugin("socialinteractions")->getStaticJsUrl() . "app/app.module.js");

      OW::getDocument()->addScript(OW::getPluginManager()->getPlugin("socialinteractions")->getStaticJsUrl() . "app/core/core.module.js");
      OW::getDocument()->addScript(OW::getPluginManager()->getPlugin("socialinteractions")->getStaticJsUrl() . "app/core/core.config.js");

      OW::getDocument()->addScript(OW::getPluginManager()->getPlugin("socialinteractions")->getStaticJsUrl() . "app/main/main.module.js");
      OW::getDocument()->addScript(OW::getPluginManager()->getPlugin("socialinteractions")->getStaticJsUrl() . "app/main/main.controller.js");
      
      OW::getDocument()->addScript(OW::getPluginManager()->getPlugin("socialinteractions")->getStaticJsUrl() . "app/dashboard/dashboard.module.js");
      OW::getDocument()->addScript(OW::getPluginManager()->getPlugin("socialinteractions")->getStaticJsUrl() . "app/dashboard/dashboard.controller.js");
      
      OW::getDocument()->addScript(OW::getPluginManager()->getPlugin("socialinteractions")->getStaticJsUrl() . "app/userinfo/userinfo.module.js");
      OW::getDocument()->addScript(OW::getPluginManager()->getPlugin("socialinteractions")->getStaticJsUrl() . "app/userinfo/userinfo.controller.js");
      
      OW::getDocument()->addScript(OW::getPluginManager()->getPlugin("socialinteractions")->getStaticJsUrl() . "app/graphwizard/graphwizard.module.js");
      OW::getDocument()->addScript(OW::getPluginManager()->getPlugin("socialinteractions")->getStaticJsUrl() . "app/graphwizard/graphwizard.controller.js");

      OW::getDocument()->addScript(OW::getPluginManager()->getPlugin("socialinteractions")->getStaticJsUrl() . "app/users/users.module.js");
      OW::getDocument()->addScript(OW::getPluginManager()->getPlugin("socialinteractions")->getStaticJsUrl() . "app/users/users.factory.js");
      
      OW::getDocument()->addScript(OW::getPluginManager()->getPlugin("socialinteractions")->getStaticJsUrl() . "app/status/status.module.js");
      OW::getDocument()->addScript(OW::getPluginManager()->getPlugin("socialinteractions")->getStaticJsUrl() . "app/status/status.factory.js");
      
      OW::getDocument()->addScript(OW::getPluginManager()->getPlugin("socialinteractions")->getStaticJsUrl() . "app/comments/comments.module.js");
      OW::getDocument()->addScript(OW::getPluginManager()->getPlugin("socialinteractions")->getStaticJsUrl() . "app/comments/comments.factory.js");
      
      OW::getDocument()->addScript(OW::getPluginManager()->getPlugin("socialinteractions")->getStaticJsUrl() . "app/likes/likes.module.js");
      OW::getDocument()->addScript(OW::getPluginManager()->getPlugin("socialinteractions")->getStaticJsUrl() . "app/likes/likes.factory.js");
      
      OW::getDocument()->addScript(OW::getPluginManager()->getPlugin("socialinteractions")->getStaticJsUrl() . "app/followers/followers.module.js");
      OW::getDocument()->addScript(OW::getPluginManager()->getPlugin("socialinteractions")->getStaticJsUrl() . "app/followers/followers.factory.js");
      
      OW::getDocument()->addScript(OW::getPluginManager()->getPlugin("socialinteractions")->getStaticJsUrl() . "app/friendships/friendships.module.js");
      OW::getDocument()->addScript(OW::getPluginManager()->getPlugin("socialinteractions")->getStaticJsUrl() . "app/friendships/friendships.factory.js");

    }

  }

?>
