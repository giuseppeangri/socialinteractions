<?php
	
	/*
	 * Copyright (c) 2015, Giuseppe Angri - info@giuseppeangri.com
	 * All rights reserved.
	 * Copyrights licensed under The GNU GPLv3 License.
	 * See this for terms: http://choosealicense.com/licenses/gpl-3.0/
	 */

  /*
   *
   *
   */
  class SOCIALINTERACTIONS_CTRL_WsUsers extends ADMIN_CTRL_Abstract {

    private $user_dao;
    private $question_data_dao;
    
    private $action_dao;
    private $activity_dao;
    private $comment_dao;
    private $like_dao;
    private $friendship_dao;
    private $follow_dao;
    private $avatar_dao;

    /*
     *
     *
     */
    public function __construct() {
      $this->user_dao          = BOL_UserDao::getInstance();
      $this->question_data_dao = BOL_QuestionDataDao::getInstance();
      
      $this->action_dao        = NEWSFEED_BOL_ActionDao::getInstance();
      $this->activity_dao      = NEWSFEED_BOL_ActivityDao::getInstance();
      $this->comment_dao       = BOL_CommentDao::getInstance();
      $this->like_dao          = NEWSFEED_BOL_LikeDao::getInstance();
      $this->friendship_dao    = FRIENDS_BOL_FriendshipDao::getInstance();
      $this->follow_dao        = NEWSFEED_BOL_FollowDao::getInstance();
      $this->avatar_dao        = BOL_AvatarDao::getInstance();
    }

    /*
     *
     *
     */
    public function index() {
	    
      $users_byDao = $this->user_dao->findAll();

      $users = array();

      foreach ($users_byDao as $user_byDao) {

        // get user array from object
          $user = get_object_vars ($user_byDao);

        // get data from user array
          $id       = $user['id'];
          $email    = $user['email'];
          $username = $user['username'];
          $joinDate = date('Y/m/d', $user['joinStamp']);

        // join with question_data (to get realname, sex, birthdate)
          $question_data_byDao = $this->question_data_dao->findByQuestionsNameList(array('realname', 'sex', 'birthdate'), $id);

          $questions = array();
          foreach ($question_data_byDao as $key => $value) {
            $question = get_object_vars($value);
            $questions[ $question['questionName'] ] = $question;
          }
					
					if( isset($questions['realname']) ) {
	          $realname = $questions['realname']['textValue'];
					}
					else {
						$realname = '';
					}
					
					if( isset($questions['sex']) ) {
						
	          if ($questions['sex']['intValue'] = 1) {
	            $sex = 'male';
	          }
	          else {
	            $sex = 'female';
	          }
						
					}
					else {
						$sex = '';
					}
					
					if( isset($questions['birthdate']) ) {
	          $birthdate = date('Y/m/d', strtotime($questions['birthdate']['dateValue']));
					}
					else {
						$birthdate = '';
					}
					
				// join with avatar (to get avatar)
          $avatar_byDao = $this->avatar_dao->findByUserId($id);
          
          if(isset($avatar_byDao)){
	          $avatarObj = array();
	          foreach ($avatar_byDao as $key => $value) {
	            $avatarObj[ $key ] = $value;
	          }
	          
	          $baseUrl = 'http://';
						$origin = str_replace('index.php', '', $_SERVER['PHP_SELF']);
						$baseUrl = $baseUrl.$_SERVER['SERVER_NAME'].$origin;
	          
				    $avatar          = $baseUrl . '/ow_userfiles/plugins/base/avatars/avatar_'.$avatarObj['id'].'_'.$avatarObj['hash'].'.jpg';
	          $avatar_big      = $baseUrl . '/ow_userfiles/plugins/base/avatars/avatar_big_'.$avatarObj['id'].'_'.$avatarObj['hash'].'.jpg';
	          $avatar_original = $baseUrl . '/ow_userfiles/plugins/base/avatars/avatar_original_'.$avatarObj['id'].'_'.$avatarObj['hash'].'.jpg';
          }
          else {
	          $avatar          = '';
	          $avatar_big      = '';
	          $avatar_original = '';
          }
          
					
        // add entry to users array
          $users[] = array(
            'id'              => $id,
            'email'           => $email,
            'username'        => $username,
            'realname'        => $realname,
            'sex'             => $sex,
            'birthdate'       => $birthdate,
            'joinDate'        => $joinDate,
            'avatar'          => $avatar,
            'avatar_big'      => $avatar_big,
            'avatar_original' => $avatar_original
          );

      }

      $response['action'] = array(
        'status'      => 1,
        'name'        => 'users.index',
        'description' => ''
      );

      $response['data'] = $users;

      header('Content-Type: application/json');

      echo json_encode($response, JSON_PRETTY_PRINT);

      exit();

    }

    /**
     * Returns user for provided id/username/email.
     *
     * @param string $var
     * @return BOL_User
     */
    private function findUserByIdOrUsernameOrEmail($var) {

      $example = new OW_Example();
      $example->andFieldEqual('id', trim($var));

      $result = $this->user_dao->findObjectByExample($example);

      if( $result !== null ) {
        return $result;
      }

      $example = new OW_Example();
      $example->andFieldEqual('username', trim($var));

      $result = $this->user_dao->findObjectByExample($example);

      if( $result !== null ) {
        return $result;
      }

      $example = new OW_Example();
      $example->andFieldEqual('email', trim($var));

      $result = $this->user_dao->findObjectByExample($example);

      return $result;

    }

    /*
     *
     *
     */
    public function show($params) {

      $param_id = urldecode($params['id']);

      $user_byDao = $this->findUserByIdOrUsernameOrEmail($param_id);

      if( is_null($user_byDao) ) {
        $user_toReturn = [];
      }
      else {

        // get user array from object
          $user = get_object_vars ($user_byDao);

        // get data from user array
          $id       = $user['id'];
          $email    = $user['email'];
          $username = $user['username'];
          $joinDate = date('Y/m/d', $user['joinStamp']);

        // join with question_data (to get realname, sex, birthdate)
          $question_data_byDao = $this->question_data_dao->findByQuestionsNameList(array('realname', 'sex', 'birthdate'), $id);

          $questions = array();
          foreach ($question_data_byDao as $key => $value) {
            $question = get_object_vars($value);
            $questions[ $question['questionName'] ] = $question;
          }

          if( isset($questions['realname']) ) {
	          $realname = $questions['realname']['textValue'];
					}
					else {
						$realname = '';
					}
					
					if( isset($questions['sex']) ) {
						
	          if ($questions['sex']['intValue'] = 1) {
	            $sex = 'male';
	          }
	          else {
	            $sex = 'female';
	          }
						
					}
					else {
						$sex = '';
					}
					
					if( isset($questions['birthdate']) ) {
	          $birthdate = date('Y/m/d', strtotime($questions['birthdate']['dateValue']));
					}
					else {
						$birthdate = '';
					}
					
				// join with avatar (to get avatar)
          $avatar_byDao = $this->avatar_dao->findByUserId($id);
          
          if(isset($avatar_byDao)){
	          $avatarObj = array();
	          foreach ($avatar_byDao as $key => $value) {
	            $avatarObj[ $key ] = $value;
	          }
	          
	          $baseUrl = 'http://';
						$origin = str_replace('index.php', '', $_SERVER['PHP_SELF']);
						$baseUrl = $baseUrl.$_SERVER['SERVER_NAME'].$origin;
	          
				    $avatar          = $baseUrl . '/ow_userfiles/plugins/base/avatars/avatar_'.$avatarObj['id'].'_'.$avatarObj['hash'].'.jpg';
	          $avatar_big      = $baseUrl . '/ow_userfiles/plugins/base/avatars/avatar_big_'.$avatarObj['id'].'_'.$avatarObj['hash'].'.jpg';
	          $avatar_original = $baseUrl . '/ow_userfiles/plugins/base/avatars/avatar_original_'.$avatarObj['id'].'_'.$avatarObj['hash'].'.jpg';
          }
          else {
	          $avatar          = '';
	          $avatar_big      = '';
	          $avatar_original = '';
          }

        // add entry to users array
          $user_toReturn = array(
            'id'              => $id,
            'email'           => $email,
            'username'        => $username,
            'realname'        => $realname,
            'sex'             => $sex,
            'birthdate'       => $birthdate,
            'joinDate'        => $joinDate,
            'avatar'          => $avatar,
            'avatar_big'      => $avatar_big,
            'avatar_original' => $avatar_original
          );

      }

      $response['action'] = array(
        'status'      => 1,
        'name'        => 'users.show',
        'description' => ''
      );

      $response['data'] = $user_toReturn;

      header('Content-Type: application/json');

      echo json_encode($response, JSON_PRETTY_PRINT);

      exit();

    }
    
    /*
	   * 
	   * 
	   */ 
    public function getStatus($params) {
	    	    
	    $param_id = urldecode($params['id']);

      $actions_byDao = $this->action_dao->findListByUserId($param_id);

      $status_toReturn = array();
 	             
      foreach($actions_byDao as $action_byDao) {
       
        // get actions array from object
          $action = get_object_vars ($action_byDao);
        
        $entityType = 'user-status';
        $pluginKey  = 'newsfeed';
        
        if( (strcmp($action['entityType'], $entityType) == 0) && (strcmp($action['pluginKey'], $pluginKey) == 0) ) {
          
          // get data from action array
	          $id_action   = $action['id'];
	          $id_status   = $action['entityId'];
	
	          $data        = get_object_vars ( json_decode( $action['data']) );
	          $data_data   = get_object_vars ( $data['data'] );
	
	          $status_text = $data_data['status'];
	          $user_id     = $data_data['userId'];
	
	        // join with activity (to get timestamp)
	          $example = new OW_Example();
	          $example->andFieldEqual('actionId', $id_action);
	          $example->andFieldEqual('activityType', 'create');
	
	          $activity_byDao = $this->activity_dao->findObjectByExample($example);
	          $activity       = get_object_vars($activity_byDao);
	
	          $timestamp      = date('Y/m/d H:s', $activity['timeStamp']);
	
	        // add entry to status array
	          $status_toReturn[] = array(
	            'id'        => $id_status,
	            'status'    => $status_text,
	            'user_id'   => $user_id,
	            'timestamp' => $timestamp
	          );
          
        }
	      
      }
      
      $response['action'] = array(
        'status'      => 1,
        'name'        => 'users.getStatus',
        'description' => ''
      );

      $response['data'] = $status_toReturn;

      header('Content-Type: application/json');

      echo json_encode($response, JSON_PRETTY_PRINT);

      exit();
	    
    }
    
    /*
	   * 
	   * 
	   */ 
    public function getStatusCount($params) {
	    
	    $param_id = urldecode($params['id']);

			$actions_byDao = $this->action_dao->findListByUserId($param_id);      
			
			$status_count  = 0;
				             
      foreach($actions_byDao as $action_byDao) {
       
        // get actions array from object
          $action = get_object_vars ($action_byDao);
        
        $entityType = 'user-status';
        $pluginKey  = 'newsfeed';
        
        if( (strcmp($action['entityType'], $entityType) == 0) && (strcmp($action['pluginKey'], $pluginKey) == 0) ) {
          
          $status_count++;
          
        }
	      
      }
      
      $status_toReturn = array(
        'count' => $status_count
      );
       
      $response['action'] = array(
        'status'      => 1,
        'name'        => 'users.getStatusCount',
        'description' => ''
      );

      $response['data'] = $status_toReturn;

      header('Content-Type: application/json');

      echo json_encode($response, JSON_PRETTY_PRINT);

      exit();
	    
    }
    
    /*
	   * 
	   * 
	   */ 
    public function getStatusCountByDate($params) {
	    
	    $param_id = urldecode($params['id']);
	    
	    $param_dateStart = urldecode($params['dateStart']);
	    $param_dateEnd   = urldecode($params['dateEnd']);
	    
	    $timeStart       = strtotime($param_dateStart.' 00:00');
	    $timeEnd         = strtotime($param_dateEnd.' 24:00');

			$actions_byDao = $this->action_dao->findListByUserId($param_id);      
			
			$status_count  = 0;
				             
      foreach($actions_byDao as $action_byDao) {
       
        // get actions array from object
          $action = get_object_vars ($action_byDao);
        
        $entityType = 'user-status';
        $pluginKey  = 'newsfeed';
        
        if( (strcmp($action['entityType'], $entityType) == 0) && (strcmp($action['pluginKey'], $pluginKey) == 0) ) {
	        
	        $id_action   = $action['id'];

	        // join with activity (to get timestamp)
	          $example = new OW_Example();
	          $example->andFieldEqual('actionId', $id_action);
	          $example->andFieldEqual('activityType', 'create');
	          $example->andFieldBetween('timeStamp', $timeStart, $timeEnd);
	
	          $activity_byDao = $this->activity_dao->findObjectByExample($example);
	          
	          if(!is_null($activity_byDao)) {
		          $status_count++;
	          }

        }
	      
      }
      
      $status_toReturn = array(
        'count' => $status_count
      );
       
      $response['action'] = array(
        'status'      => 1,
        'name'        => 'users.getStatusCountByDate',
        'description' => ''
      );

      $response['data'] = $status_toReturn;

      header('Content-Type: application/json');

      echo json_encode($response, JSON_PRETTY_PRINT);

      exit();
	    
    }

    /*
	   * 
	   * 
	   */ 
    public function getComments($params) {
	    
	    $param_id = urldecode($params['id']);
      
      $example = new OW_Example();
      $example->andFieldEqual('userId', $param_id);

      $comments_byDao = $this->comment_dao->findListByExample($example);

      $comments_toReturn = array();
	      	             
      foreach($comments_byDao as $comment_byDao) {
       
        // get actions array from object
          $comment = get_object_vars ($comment_byDao);
          
        $message   = $comment['message'];
        $user_id   = intval($comment['userId']);
        $timestamp = date('Y/m/d H:s', $comment['createStamp']);

        $comments_toReturn[] = array(
          'message'   => $message,
          'user_id'   => $user_id,
          'timestamp' => $timestamp
        );
	      
      }

      $response['action'] = array(
        'status'      => 1,
        'name'        => 'users.getComments',
        'description' => ''
      );

      $response['data'] = $comments_toReturn;

      header('Content-Type: application/json');

      echo json_encode($response, JSON_PRETTY_PRINT);

      exit();
	    
    }
    
    /*
	   * 
	   * 
	   */ 
    public function getCommentsCount($params) {
	    
	    $param_id = urldecode($params['id']);
      
      $example = new OW_Example();
      $example->andFieldEqual('userId', $param_id);

      $commentsCount_byDao = $this->comment_dao->countByExample($example);
      
      $commentsCount_toReturn = [
        'count' => intval($commentsCount_byDao)
      ];
	      	             
      $response['action'] = array(
        'status'      => 1,
        'name'        => 'users.getComments',
        'description' => ''
      );

      $response['data'] = $commentsCount_toReturn;

      header('Content-Type: application/json');

      echo json_encode($response, JSON_PRETTY_PRINT);

      exit();
	    
    }
    
    /*
	   * 
	   * 
	   */ 
    public function getCommentsCountByDate($params) {
	    
	    $param_id = urldecode($params['id']);
	    
	    $param_dateStart = urldecode($params['dateStart']);
	    $param_dateEnd   = urldecode($params['dateEnd']);
	    
	    $timeStart       = strtotime($param_dateStart.' 00:00');
	    $timeEnd         = strtotime($param_dateEnd.' 24:00');
      
      $example = new OW_Example();
      $example->andFieldEqual('userId', $param_id);
      $example->andFieldBetween('createStamp', $timeStart, $timeEnd);

      $commentsCount_byDao = $this->comment_dao->countByExample($example);
      
      $commentsCount_toReturn = [
        'count' => intval($commentsCount_byDao)
      ];
	      	             
      $response['action'] = array(
        'status'      => 1,
        'name'        => 'users.getCommentsByDate',
        'description' => ''
      );

      $response['data'] = $commentsCount_toReturn;

      header('Content-Type: application/json');

      echo json_encode($response, JSON_PRETTY_PRINT);

      exit();
	    
    }

    /*
	   * 
	   * 
	   */ 
    public function getLikes($params) {
	    
	    $param_id = urldecode($params['id']);
      
      $example = new OW_Example();
      $example->andFieldEqual('userId', $param_id);

      $likes_byDao = $this->like_dao->findListByExample($example);

      $likes_toReturn = array();
	      	             
      foreach($likes_byDao as $like_byDao) {
       
        // get actions array from object
          $like = get_object_vars ($like_byDao);
          
        $user_id    = intval($like['userId']);
        $entityType = $like['entityType'];
        $entityId   = $like['entityId'];
        $timestamp  = date('Y/m/d H:s', $like['timeStamp']);

        $likes_toReturn[] = array(
          'user_id'    => $user_id,
          'entityType' => $entityType,
          'entityId'   => $entityId,
          'timestamp'  => $timestamp
        );
	      
      }

      $response['action'] = array(
        'status'      => 1,
        'name'        => 'users.getLikes',
        'description' => ''
      );

      $response['data'] = $likes_toReturn;

      header('Content-Type: application/json');

      echo json_encode($response, JSON_PRETTY_PRINT);

      exit();
	    
    }
    
    /*
	   * 
	   * 
	   */ 
    public function getLikesCount($params) {
	    
	    $param_id = urldecode($params['id']);
      
      $example = new OW_Example();
      $example->andFieldEqual('userId', $param_id);

      $likesCount_byDao = $this->like_dao->countByExample($example);
      
      $likesCount_toReturn = [
        'count' => intval($likesCount_byDao)
      ];

      $response['action'] = array(
        'status'      => 1,
        'name'        => 'users.getLikesCount',
        'description' => ''
      );

      $response['data'] = $likesCount_toReturn;

      header('Content-Type: application/json');

      echo json_encode($response, JSON_PRETTY_PRINT);

      exit();
	    
    }
    
    /*
	   * 
	   * 
	   */ 
    public function getLikesCountByDate($params) {
	    
	    $param_id = urldecode($params['id']);
	    
	    $param_dateStart = urldecode($params['dateStart']);
	    $param_dateEnd   = urldecode($params['dateEnd']);
	    
	    $timeStart       = strtotime($param_dateStart.' 00:00');
	    $timeEnd         = strtotime($param_dateEnd.' 24:00');
      
      $example = new OW_Example();
      $example->andFieldEqual('userId', $param_id);
      $example->andFieldBetween('timeStamp', $timeStart, $timeEnd);

      $likesCount_byDao = $this->like_dao->countByExample($example);
      
      $likesCount_toReturn = [
        'count' => intval($likesCount_byDao)
      ];

      $response['action'] = array(
        'status'      => 1,
        'name'        => 'users.getLikesCount',
        'description' => ''
      );

      $response['data'] = $likesCount_toReturn;

      header('Content-Type: application/json');

      echo json_encode($response, JSON_PRETTY_PRINT);

      exit();
	    
    }
    
    /*
	   * 
	   * 
	   */ 
    public function getEngagement($params) {
	    
	    $param_id = urldecode($params['id']);
      
      $example = new OW_Example();
      $example->andFieldEqual('userId', $param_id);

      $comments_byDao = $this->comment_dao->findListByExample($example);
      $likes_byDao    = $this->like_dao->findListByExample($example);
      
      $engagement = array(
        'comments' => array(),
        'likes'    => array()
      );

      if( !is_null($comments_byDao) ) {

        foreach ($comments_byDao as $comment_byDao) {

          $comment   = get_object_vars($comment_byDao);

          $message   = $comment['message'];
          $user_id   = intval($comment['userId']);
          $timestamp = date('Y/m/d H:s', $comment['createStamp']);

          $engagement['comments'][] = array(
            'message'   => $message,
            'user_id'   => $user_id,
            'timestamp' => $timestamp
          );

        }

      }

      if( !is_null($likes_byDao) ) {

        foreach ($likes_byDao as $like_byDao) {

          $like      = get_object_vars($like_byDao);

          $user_id   = $like['userId'];
          $timestamp = date('Y/m/d H:s', $like['timeStamp']);

          $engagement['likes'][] = array(
            'user_id'   => intval($user_id),
            'timestamp' => $timestamp
          );

        }

      }

      $response['action'] = array(
        'status'      => 1,
        'name'        => 'users.getEngagement',
        'description' => ''
      );

      $response['data'] = $engagement;

      header('Content-Type: application/json');

      echo json_encode($response, JSON_PRETTY_PRINT);

      exit();
	    
    }
    
    /*
	   * 
	   * 
	   */ 
    public function getEngagementCount($params) {
	    
	    $param_id = urldecode($params['id']);
      
      $example = new OW_Example();
      $example->andFieldEqual('userId', $param_id);

			$commentsCount_byDao = $this->comment_dao->countByExample($example);
      $likesCount_byDao = $this->like_dao->countByExample($example);
            
      $engagementCount = [
        'commentCount' => intval($commentsCount_byDao),
        'likeCount'    => intval($likesCount_byDao),
        'total'        => intval($commentsCount_byDao) + intval($likesCount_byDao)
      ];

      $response['action'] = array(
        'status'      => 1,
        'name'        => 'users.getEngagementCount',
        'description' => ''
      );

      $response['data'] = $engagementCount;

      header('Content-Type: application/json');

      echo json_encode($response, JSON_PRETTY_PRINT);

      exit();
	    
    }
    
    /*
	   * 
	   * 
	   */ 
    public function getEngagementCountByDate($params) {
	    
	    $param_id = urldecode($params['id']);
	    
	    $param_dateStart = urldecode($params['dateStart']);
	    $param_dateEnd   = urldecode($params['dateEnd']);
	    
	    $timeStart       = strtotime($param_dateStart.' 00:00');
	    $timeEnd         = strtotime($param_dateEnd.' 24:00');
      
      $example = new OW_Example();
      $example->andFieldEqual('userId', $param_id);
      $example->andFieldBetween('createStamp', $timeStart, $timeEnd);

			$commentsCount_byDao = $this->comment_dao->countByExample($example);
			
      $example = new OW_Example();
      $example->andFieldEqual('userId', $param_id);
      $example->andFieldBetween('timeStamp', $timeStart, $timeEnd);
      
      $likesCount_byDao = $this->like_dao->countByExample($example);
            
      $engagementCount = [
        'commentCount' => intval($commentsCount_byDao),
        'likeCount'    => intval($likesCount_byDao),
        'total'        => intval($commentsCount_byDao) + intval($likesCount_byDao)
      ];

      $response['action'] = array(
        'status'      => 1,
        'name'        => 'users.getEngagementCountByDate',
        'description' => ''
      );

      $response['data'] = $engagementCount;

      header('Content-Type: application/json');

      echo json_encode($response, JSON_PRETTY_PRINT);

      exit();
	    
    }

    /*
	   * 
	   * 
	   */ 
    public function getFriends($params) {
	    
	    $param_id = urldecode($params['id']);
	    
	    $friendships_byDao = $this->friendship_dao->findFriendshipListByUserId($param_id);
	    
	    $friendships_toReturn = array();
	      	             
      foreach($friendships_byDao as $friendship_byDao) {
       
        // find Friendship By Id to get Timestamp
			    $friendshipFind_byDao = $this->friendship_dao->findById($friendship_byDao->id);
		    
        // get actions array from object
          $friendship = get_object_vars($friendshipFind_byDao);
          
        $user_id   = intval($friendship['userId']);
        $friend_id = intval($friendship['friendId']);
        
        // check if the friendship is reverse
        if($param_id == $friend_id) {
	        $user_id   = intval($friendship['friendId']);
	        $friend_id = intval($friendship['userId']);
        }
        
        $timestamp = date('Y/m/d H:s', $friendship['timeStamp']);

        $friendships_toReturn[] = array(
          'user_id'   => $user_id,
          'friend_id' => $friend_id,
          'timestamp' => $timestamp
        );
	      
      }

      $response['action'] = array(
        'status'      => 1,
        'name'        => 'users.getFriends',
        'description' => ''
      );

      $response['data'] = $friendships_toReturn;

      header('Content-Type: application/json');

      echo json_encode($response, JSON_PRETTY_PRINT);

      exit();
	    
    }
    
    /*
	   * 
	   * 
	   */ 
    public function getFriendsCount($params) {
	    
	    $param_id = urldecode($params['id']);
	    
	    $friendsCount_byDao = $this->friendship_dao->findUserFriendsCount($param_id);
	    	    
	    $friendsCount_toReturn = [
        'count' => intval($friendsCount_byDao)
      ];

      $response['action'] = array(
        'status'      => 1,
        'name'        => 'users.getFriendsCount',
        'description' => ''
      );

      $response['data'] = $friendsCount_toReturn;

      header('Content-Type: application/json');

      echo json_encode($response, JSON_PRETTY_PRINT);

      exit();
	    
    }
    
    /*
	   * 
	   * 
	   */ 
    public function getFriendsCountByDate($params) {
	    
	    $param_id = urldecode($params['id']);
	    
	    $param_dateStart = urldecode($params['dateStart']);
	    $param_dateEnd   = urldecode($params['dateEnd']);
	    
	    $timeStart       = strtotime($param_dateStart.' 00:00');
	    $timeEnd         = strtotime($param_dateEnd.' 24:00');
	    
	    $friendsCount = 0;
      
      $example = new OW_Example();
      $example->andFieldEqual('userId', $param_id);
      $example->andFieldBetween('timeStamp', $timeStart, $timeEnd);
	    
	    $friendsCount_byDao = $this->friendship_dao->countByExample($example);
	    
	    $friendsCount += intval($friendsCount_byDao);
	    
	    $example = new OW_Example();
      $example->andFieldEqual('friendId', $param_id);
      $example->andFieldBetween('timeStamp', $timeStart, $timeEnd);
	    
	    $friendsCount_byDao = $this->friendship_dao->countByExample($example);
	    
	    $friendsCount += intval($friendsCount_byDao);
	    
	    $friendsCount_toReturn = [
        'count' => $friendsCount
      ];

      $response['action'] = array(
        'status'      => 1,
        'name'        => 'users.getFriendsCountByDate',
        'description' => ''
      );

      $response['data'] = $friendsCount_toReturn;

      header('Content-Type: application/json');

      echo json_encode($response, JSON_PRETTY_PRINT);

      exit();
	    
    }
    
    /*
	   * 
	   * 
	   */ 
    public function getFollowers($params) {
	    
	    $param_id = urldecode($params['id']);
	    
	    $followers_byDao = $this->follow_dao->findList('user', $param_id, 'everybody');
	    
	    $followers = array();

      foreach ($followers_byDao as $follower_byDao) {

        // get action array from object
          $follower = get_object_vars ($follower_byDao);

        // get data from action array
          $follower_user_id = $follower['userId'];
          $timestamp        = date('Y/m/d H:s', $follower['followTime']);

        // add entry to status array
          $followers[] = array(
            'follower_user_id' => $follower_user_id,
            'timestamp'        => $timestamp
          );

      }

      $response['action'] = array(
        'status'      => 1,
        'name'        => 'users.getFollowers',
        'description' => ''
      );

      $response['data'] = $followers;
	    
      header('Content-Type: application/json');

      echo json_encode($response, JSON_PRETTY_PRINT);

      exit();
	    
    }
    
    /*
	   * 
	   * 
	   */ 
    public function getFollowersCount($params) {
	    
	    $param_id = urldecode($params['id']);
	    
	    $example = new OW_Example();
      $example->andFieldEqual('feedType', 'user');
      $example->andFieldEqual('feedId', $param_id);
      $example->andFieldEqual('permission', 'everybody');
      
      $followersCount_byDao = $this->follow_dao->countByExample($example);
      
      $followersCount = array(
        'count' => intval($followersCount_byDao)
      );

      $response['action'] = array(
        'status'      => 1,
        'name'        => 'users.getFollowersCount',
        'description' => ''
      );

      $response['data'] = $followersCount;

      header('Content-Type: application/json');
      echo json_encode($response);

      exit();
	    
    }
    
    /*
	   * 
	   * 
	   */ 
    public function getFollowersCountByDate($params) {
	    
	    $param_id = urldecode($params['id']);
	    
	    $param_dateStart = urldecode($params['dateStart']);
	    $param_dateEnd   = urldecode($params['dateEnd']);
	    
	    $timeStart       = strtotime($param_dateStart.' 00:00');
	    $timeEnd         = strtotime($param_dateEnd.' 24:00');
	    
	    $example = new OW_Example();
      $example->andFieldEqual('feedType', 'user');
      $example->andFieldEqual('feedId', $param_id);
      $example->andFieldEqual('permission', 'everybody');
      $example->andFieldBetween('followTime', $timeStart, $timeEnd);
      
      $followersCount_byDao = $this->follow_dao->countByExample($example);
      
      $followersCount = array(
        'count' => intval($followersCount_byDao)
      );

      $response['action'] = array(
        'status'      => 1,
        'name'        => 'users.getFollowersCountByDate',
        'description' => ''
      );

      $response['data'] = $followersCount;

      header('Content-Type: application/json');
      echo json_encode($response);

      exit();
	    
    }

  }

?>
