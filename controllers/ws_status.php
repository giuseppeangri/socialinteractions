<?php
	
	/*
	 * Copyright (c) 2015, Giuseppe Angri - info@giuseppeangri.com
	 * All rights reserved.
	 * Copyrights licensed under The GNU GPLv3 License.
	 * See this for terms: http://choosealicense.com/licenses/gpl-3.0/
	 */

  /**
   *
   *
   */
  class SOCIALINTERACTIONS_CTRL_WsStatus extends ADMIN_CTRL_Abstract {

    private $action_dao;
    private $activity_dao;
    private $comment_dao;
    private $like_dao;

	  private $pluginKey  = 'newsfeed';
    private $entityType = 'user-status';

    /**
     *
     *
     */
    public function __construct() {
      $this->action_dao   = NEWSFEED_BOL_ActionDao::getInstance();
      $this->activity_dao = NEWSFEED_BOL_ActivityDao::getInstance();
      $this->comment_dao  = BOL_CommentDao::getInstance();
      $this->like_dao     = NEWSFEED_BOL_LikeDao::getInstance();
    }

    /**
     *
     *
     */
    public function index() {

      $example = new OW_Example();
      $example->andFieldEqual('pluginKey', $this->pluginKey);
      $example->andFieldEqual('entityType', $this->entityType);

      $actions_byDao = $this->action_dao->findListByExample($example);

      $status = array();

      foreach ($actions_byDao as $action_byDao) {

        // get action array from object
          $action = get_object_vars ($action_byDao);

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
          $activity = get_object_vars($activity_byDao);

          $timestamp = date('Y/m/d H:s', $activity['timeStamp']);

        // add entry to status array
          $status[] = array(
            'id'        => $id_status,
            'status'    => $status_text,
            'user_id'   => $user_id,
            'timestamp' => $timestamp
          );

      }

      $response['action'] = array(
        'status'      => 1,
        'name'        => 'status.index',
        'description' => ''
      );

      $response['data'] = $status;

      header('Content-Type: application/json');
      echo json_encode($response);

      exit();

    }
    
    /**
     *
     *
     */
    public function indexByDate($params) {
	    
	    $param_dateStart = urldecode($params['dateStart']);
	    $param_dateEnd   = urldecode($params['dateEnd']);
	    
	    $timeStart       = strtotime($param_dateStart.' 00:00');
	    $timeEnd         = strtotime($param_dateEnd.' 24:00');

      $example = new OW_Example();
      $example->andFieldEqual('pluginKey', $this->pluginKey);
      $example->andFieldEqual('entityType', $this->entityType);

      $actions_byDao = $this->action_dao->findListByExample($example);

      $status = array();

      foreach ($actions_byDao as $action_byDao) {

        // get action array from object
          $action = get_object_vars ($action_byDao);

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
          $example->andFieldBetween('timeStamp', $timeStart, $timeEnd);

          $activity_byDao = $this->activity_dao->findObjectByExample($example);
          
          if(!is_null($activity_byDao)) {
	          $activity  = get_object_vars($activity_byDao);
	          
	          $timestamp = date('Y/m/d H:s', $activity['timeStamp']);
	          
		        // add entry to status array
		          $status[] = array(
		            'id'        => $id_status,
		            'status'    => $status_text,
		            'user_id'   => $user_id,
		            'timestamp' => $timestamp
		          );
          }

      }

      $response['action'] = array(
        'status'      => 1,
        'name'        => 'status.indexByDate',
        'description' => ''
      );

      $response['data'] = $status;

      header('Content-Type: application/json');
      echo json_encode($response);

      exit();

    }

    /**
     *
     *
     */
    public function show($params) {

      $param_id = urldecode($params['id']);

      $example = new OW_Example();
      $example->andFieldEqual('entityId', $param_id);
      $example->andFieldEqual('pluginKey', $this->pluginKey);
      $example->andFieldEqual('entityType', $this->entityType);

      $action_byDao = $this->action_dao->findObjectByExample($example);

      if( is_null($action_byDao) ) {
        $status = [];
      }
      else {

        // get action array from object
          $action = get_object_vars ($action_byDao);

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
          $status = array(
            'id'        => $id_status,
            'status'    => $status_text,
            'user_id'   => $user_id,
            'timestamp' => $timestamp
          );
      }

      $response['action'] = array(
        'status'      => 1,
        'name'        => 'status.show',
        'description' => ''
      );

      $response['data'] = $status;

      header('Content-Type: application/json');

      echo json_encode($response, JSON_PRETTY_PRINT);

      exit();

    }
    
    /**
     *
     *
     */
    public function count() {
	    
	    $example = new OW_Example();
      $example->andFieldEqual('pluginKey', $this->pluginKey);
      $example->andFieldEqual('entityType', $this->entityType);

      $statusCount_byDao = $this->action_dao->countByExample($example);
      
      $statusCount = array(
        'count' => intval($statusCount_byDao)
      );

      $response['action'] = array(
        'status'      => 1,
        'name'        => 'status.count',
        'description' => ''
      );

      $response['data'] = $statusCount;

      header('Content-Type: application/json');
      echo json_encode($response);

      exit();

    }
    
    /**
     *
     *
     */
    public function countByDate($params) {
	    
	    $param_dateStart = urldecode($params['dateStart']);
	    $param_dateEnd   = urldecode($params['dateEnd']);
	    
	    $timeStart       = strtotime($param_dateStart.' 00:00');
	    $timeEnd         = strtotime($param_dateEnd.' 24:00');

      $example = new OW_Example();
      $example->andFieldEqual('pluginKey', $this->pluginKey);
      $example->andFieldEqual('entityType', $this->entityType);

      $actions_byDao = $this->action_dao->findListByExample($example);

      $statusCount_byDao = 0;

      foreach ($actions_byDao as $action_byDao) {

        // get action array from object
          $action = get_object_vars ($action_byDao);

          $id_action   = $action['id'];

        // join with activity (to get timestamp)
          $example = new OW_Example();
          $example->andFieldEqual('actionId', $id_action);
          $example->andFieldEqual('activityType', 'create');
          $example->andFieldBetween('timeStamp', $timeStart, $timeEnd);

          $activity_byDao = $this->activity_dao->findObjectByExample($example);
          
          if(!is_null($activity_byDao)) {
	          $statusCount_byDao++;
          }

      }

      $statusCount = array(
        'count' => intval($statusCount_byDao)
      );

      $response['action'] = array(
        'status'      => 1,
        'name'        => 'status.countByDate',
        'description' => ''
      );

      $response['data'] = $statusCount;

      header('Content-Type: application/json');
      echo json_encode($response);

      exit();

    }

    /**
     *
     *
     */
    public function getEngagement($params) {

      $param_id = urldecode($params['id']);

      $comments_byDao = $this->comment_dao->findFullCommentList($this->entityType, $param_id);
      $likes_byDao    = $this->like_dao->findByEntity($this->entityType, $param_id);

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
        'name'        => 'status.getEngagement',
        'description' => ''
      );

      $response['data'] = $engagement;

      header('Content-Type: application/json');

      echo json_encode($response, JSON_PRETTY_PRINT);

      exit();

    }

    /**
     *
     *
     */
    public function getEngagementCount($params) {

      $param_id = urldecode($params['id']);

      $commentCount_byDao = $this->comment_dao->findCommentCount($this->entityType, $param_id);
      $likeCount_byDao    = $this->like_dao->findCountByEntity($this->entityType, $param_id);

      $engagementCount = [
        'commentCount' => intval($commentCount_byDao),
        'likeCount'    => intval($likeCount_byDao),
        'total'        => intval($commentCount_byDao) + intval($likeCount_byDao)
      ];

      $response['action'] = array(
        'status'      => 1,
        'name'        => 'status.getEngagementCount',
        'description' => ''
      );

      $response['data'] = $engagementCount;

      header('Content-Type: application/json');

      echo json_encode($response, JSON_PRETTY_PRINT);

      exit();

    }
    
    /**
     *
     *
     */
    public function getEngagementUsers($params) {

      $param_id = urldecode($params['id']);

      $comments_byDao = $this->comment_dao->findFullCommentList($this->entityType, $param_id);
      $likes_byDao    = $this->like_dao->findByEntity($this->entityType, $param_id);

      $this->engagementUsers = array(
	      'status_id'        => $param_id,
	      'engagement_users' => array() 
      );

      if( !is_null($comments_byDao) ) {

        foreach ($comments_byDao as $comment_byDao) {

          $comment = get_object_vars($comment_byDao);

          $user_id = intval($comment['userId']);
                    
          if( !in_array($user_id, $this->engagementUsers['engagement_users']) ) {
	          $this->engagementUsers['engagement_users'][] = $user_id;
          }
         
        }

      }

      if( !is_null($likes_byDao) ) {

        foreach ($likes_byDao as $like_byDao) {

          $like    = get_object_vars($like_byDao);

          $user_id = intval($like['userId']);
          
					if( !in_array($user_id, $this->engagementUsers['engagement_users']) ) {
	          $this->engagementUsers['engagement_users'][] = $user_id;
          }
        }

      }

      $response['action'] = array(
        'status'      => 1,
        'name'        => 'status.getEngagementUsers',
        'description' => ''
      );

      $response['data'] = $this->engagementUsers;

      header('Content-Type: application/json');

      echo json_encode($response, JSON_PRETTY_PRINT);

      exit();

    }

  }

?>
