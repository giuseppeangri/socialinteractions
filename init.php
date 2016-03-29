<?php

	$route            = 'socialinteractions.';
	$route_ws         = 'socialinteractions.ws.';
	$path             = 'admin/plugins/socialinteractions/';
	$path_ws          = 'admin/plugins/socialinteractions/webservice/';
	$ctrl_main        = 'SOCIALINTERACTIONS_CTRL_Main';
	$ctrl_users       = 'SOCIALINTERACTIONS_CTRL_WsUsers';
	$ctrl_status      = 'SOCIALINTERACTIONS_CTRL_WsStatus';
	$ctrl_comments    = 'SOCIALINTERACTIONS_CTRL_WsComments';
	$ctrl_likes       = 'SOCIALINTERACTIONS_CTRL_WsLikes';
	$ctrl_friendships = 'SOCIALINTERACTIONS_CTRL_WsFriendships';
	$ctrl_followers   = 'SOCIALINTERACTIONS_CTRL_WsFollowers';
	
  ////////////////////////////////////////////////////////////////////////////////
  //  WEBSERVICE ROUTES
  ////////////////////////////////////////////////////////////////////////////////
  
    // USER RESOURCE
    OW::getRouter()->addRoute(new OW_Route($route_ws.'users.index', 										$path_ws.'users', 																									$ctrl_users, 'index'));
    OW::getRouter()->addRoute(new OW_Route($route_ws.'users.show', 											$path_ws.'users/:id', 																							$ctrl_users, 'show'));
    OW::getRouter()->addRoute(new OW_Route($route_ws.'users.getStatus', 								$path_ws.'users/:id/getStatus', 																		$ctrl_users, 'getStatus'));
    OW::getRouter()->addRoute(new OW_Route($route_ws.'users.getStatusCount', 						$path_ws.'users/:id/getStatusCount', 																$ctrl_users, 'getStatusCount'));
    OW::getRouter()->addRoute(new OW_Route($route_ws.'users.getStatusCountByDate',			$path_ws.'users/:id/getStatusCountByDate/:dateStart/:dateEnd',			$ctrl_users, 'getStatusCountByDate'));
    OW::getRouter()->addRoute(new OW_Route($route_ws.'users.getComments', 							$path_ws.'users/:id/getComments', 																	$ctrl_users, 'getComments'));
    OW::getRouter()->addRoute(new OW_Route($route_ws.'users.getCommentsCount', 					$path_ws.'users/:id/getCommentsCount', 															$ctrl_users, 'getCommentsCount'));
    OW::getRouter()->addRoute(new OW_Route($route_ws.'users.getCommentsCountByDate',		$path_ws.'users/:id/getCommentsCountByDate/:dateStart/:dateEnd',		$ctrl_users, 'getCommentsCountByDate'));
    OW::getRouter()->addRoute(new OW_Route($route_ws.'users.getLikes', 									$path_ws.'users/:id/getLikes', 																			$ctrl_users, 'getLikes'));
    OW::getRouter()->addRoute(new OW_Route($route_ws.'users.getLikesCount', 						$path_ws.'users/:id/getLikesCount', 																$ctrl_users, 'getLikesCount'));
    OW::getRouter()->addRoute(new OW_Route($route_ws.'users.getLikesCountByDate',				$path_ws.'users/:id/getLikesCountByDate/:dateStart/:dateEnd',				$ctrl_users, 'getLikesCountByDate'));
    OW::getRouter()->addRoute(new OW_Route($route_ws.'users.getEngagement', 						$path_ws.'users/:id/getEngagement', 																$ctrl_users, 'getEngagement'));
    OW::getRouter()->addRoute(new OW_Route($route_ws.'users.getEngagementCount', 				$path_ws.'users/:id/getEngagementCount', 														$ctrl_users, 'getEngagementCount'));
    OW::getRouter()->addRoute(new OW_Route($route_ws.'users.getEngagementCountByDate',	$path_ws.'users/:id/getEngagementCountByDate/:dateStart/:dateEnd',	$ctrl_users, 'getEngagementCountByDate'));
    OW::getRouter()->addRoute(new OW_Route($route_ws.'users.getFriends', 								$path_ws.'users/:id/getFriends', 																		$ctrl_users, 'getFriends'));
    OW::getRouter()->addRoute(new OW_Route($route_ws.'users.getFriendsCount', 					$path_ws.'users/:id/getFriendsCount', 															$ctrl_users, 'getFriendsCount'));
    OW::getRouter()->addRoute(new OW_Route($route_ws.'users.getFriendsCountByDate',			$path_ws.'users/:id/getFriendsCountByDate/:dateStart/:dateEnd',			$ctrl_users, 'getFriendsCountByDate'));
    OW::getRouter()->addRoute(new OW_Route($route_ws.'users.getFollowers', 							$path_ws.'users/:id/getFollowers', 																	$ctrl_users, 'getFollowers'));
    OW::getRouter()->addRoute(new OW_Route($route_ws.'users.getFollowersCount', 				$path_ws.'users/:id/getFollowersCount', 														$ctrl_users, 'getFollowersCount'));	
    OW::getRouter()->addRoute(new OW_Route($route_ws.'users.getFollowersCountByDate',		$path_ws.'users/:id/getFollowersCountByDate/:dateStart/:dateEnd',		$ctrl_users, 'getFollowersCountByDate'));

    // STATUS RESOURCE
    OW::getRouter()->addRoute(new OW_Route($route_ws.'status.index', 								$path_ws.'status', 																			$ctrl_status, 'index'));
    OW::getRouter()->addRoute(new OW_Route($route_ws.'status.indexByDate', 					$path_ws.'status/getByDate/:dateStart/:dateEnd', 				$ctrl_status, 'indexByDate'));
    OW::getRouter()->addRoute(new OW_Route($route_ws.'status.count', 								$path_ws.'status/count', 																$ctrl_status, 'count'));
    OW::getRouter()->addRoute(new OW_Route($route_ws.'status.countByDate', 					$path_ws.'status/countByDate/:dateStart/:dateEnd',			$ctrl_status, 'countByDate'));
    OW::getRouter()->addRoute(new OW_Route($route_ws.'status.show', 								$path_ws.'status/:id', 																	$ctrl_status, 'show'));
    OW::getRouter()->addRoute(new OW_Route($route_ws.'status.getEngagement', 				$path_ws.'status/:id/getEngagement', 										$ctrl_status, 'getEngagement'));
    OW::getRouter()->addRoute(new OW_Route($route_ws.'status.getEngagementCount',		$path_ws.'status/:id/getEngagementCount', 							$ctrl_status, 'getEngagementCount'));
    OW::getRouter()->addRoute(new OW_Route($route_ws.'status.getEngagementUsers', 	$path_ws.'status/:id/getEngagementUsers', 							$ctrl_status, 'getEngagementUsers'));
    
    // COMMENTS RESOURCE
    OW::getRouter()->addRoute(new OW_Route($route_ws.'comments.index', 							$path_ws.'comments', 																		$ctrl_comments, 'index'));
    OW::getRouter()->addRoute(new OW_Route($route_ws.'comments.indexByDate', 				$path_ws.'comments/getByDate/:dateStart/:dateEnd',			$ctrl_comments, 'indexByDate'));
    OW::getRouter()->addRoute(new OW_Route($route_ws.'comments.count', 							$path_ws.'comments/count', 															$ctrl_comments, 'count'));
    OW::getRouter()->addRoute(new OW_Route($route_ws.'comments.countByDate', 				$path_ws.'comments/countByDate/:dateStart/:dateEnd',		$ctrl_comments, 'countByDate'));
    
    // LIKES RESOURCE
    OW::getRouter()->addRoute(new OW_Route($route_ws.'likes.index', 								$path_ws.'likes', 																			$ctrl_likes, 'index'));
    OW::getRouter()->addRoute(new OW_Route($route_ws.'likes.indexByDate', 					$path_ws.'likes/getByDate/:dateStart/:dateEnd', 				$ctrl_likes, 'indexByDate'));
    OW::getRouter()->addRoute(new OW_Route($route_ws.'likes.count', 								$path_ws.'likes/count', 																$ctrl_likes, 'count'));
    OW::getRouter()->addRoute(new OW_Route($route_ws.'likes.countByDate', 					$path_ws.'likes/countByDate/:dateStart/:dateEnd',				$ctrl_likes, 'countByDate'));
    
    // FRIENDSHIPS RESOURCE
    OW::getRouter()->addRoute(new OW_Route($route_ws.'friendships.index', 					$path_ws.'friendships', 																$ctrl_friendships, 'index'));
    OW::getRouter()->addRoute(new OW_Route($route_ws.'friendships.indexByDate', 		$path_ws.'friendships/getByDate/:dateStart/:dateEnd', 	$ctrl_friendships, 'indexByDate'));
    OW::getRouter()->addRoute(new OW_Route($route_ws.'friendships.count', 					$path_ws.'friendships/count', 													$ctrl_friendships, 'count'));
    OW::getRouter()->addRoute(new OW_Route($route_ws.'friendships.countByDate', 		$path_ws.'friendships/countByDate/:dateStart/:dateEnd',	$ctrl_friendships, 'countByDate'));
    
    // FOLLOWERS RESOURCE
    OW::getRouter()->addRoute(new OW_Route($route_ws.'followers.index', 						$path_ws.'followers', 																	$ctrl_followers, 'index'));
    OW::getRouter()->addRoute(new OW_Route($route_ws.'followers.indexByDate', 			$path_ws.'followers/getByDate/:dateStart/:dateEnd',			$ctrl_followers, 'indexByDate'));
    OW::getRouter()->addRoute(new OW_Route($route_ws.'followers.count', 						$path_ws.'followers/count', 														$ctrl_followers, 'count'));
    OW::getRouter()->addRoute(new OW_Route($route_ws.'followers.countByDate', 			$path_ws.'followers/countByDate/:dateStart/:dateEnd',		$ctrl_followers, 'countByDate'));

  ////////////////////////////////////////////////////////////////////////////////
  //  VIEWS ROUTES
  ////////////////////////////////////////////////////////////////////////////////

    OW::getRouter()->addRoute(new OW_Route($route.'main', 		$path, 						$ctrl_main, 'index'));

?>
