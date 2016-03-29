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
  class SOCIALINTERACTIONS_CTRL_WsFollowers extends ADMIN_CTRL_Abstract {
	  
	  private $follow_dao;

    /**
     *
     *
     */
    public function __construct() {
      $this->follow_dao = NEWSFEED_BOL_FollowDao::getInstance();
    }

    /**
     *
     *
     */
    public function index() {
	    
	    $example = new OW_Example();
      $example->andFieldEqual('feedType', 'user');
      $example->andFieldEqual('permission', 'everybody');
      
      $followers_byDao = $this->follow_dao->findListByExample($example);

      $followers = array();

      foreach ($followers_byDao as $follower_byDao) {

        // get action array from object
          $follower = get_object_vars ($follower_byDao);

        // get data from action array
          $user_id          = $follower['userId'];
          $follower_user_id = $follower['feedId'];
          $timestamp        = date('Y/m/d H:s', $follower['followTime']);

        // add entry to status array
          $followers[] = array(
            'user_id'          => $user_id,
            'follower_user_id' => $follower_user_id,
            'timestamp'        => $timestamp
          );

      }

      $response['action'] = array(
        'status'      => 1,
        'name'        => 'followers.index',
        'description' => ''
      );

      $response['data'] = $followers;

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
      $example->andFieldEqual('feedType', 'user');
      $example->andFieldEqual('permission', 'everybody');
      $example->andFieldBetween('followTime', $timeStart, $timeEnd);
      
      $followers_byDao = $this->follow_dao->findListByExample($example);

      $followers = array();

      foreach ($followers_byDao as $follower_byDao) {

        // get action array from object
          $follower = get_object_vars ($follower_byDao);

        // get data from action array
          $user_id          = $follower['userId'];
          $follower_user_id = $follower['feedId'];
          $timestamp        = date('Y/m/d H:s', $follower['followTime']);

        // add entry to status array
          $followers[] = array(
            'user_id'          => $user_id,
            'follower_user_id' => $follower_user_id,
            'timestamp'        => $timestamp
          );

      }

      $response['action'] = array(
        'status'      => 1,
        'name'        => 'followers.indexByDate',
        'description' => ''
      );

      $response['data'] = $followers;

      header('Content-Type: application/json');
      echo json_encode($response);

      exit();

    }
    
    /**
     *
     *
     */
    public function count() {

      $example = new OW_Example();
      $example->andFieldEqual('feedType', 'user');
      $example->andFieldEqual('permission', 'everybody');
      
      $followersCount_byDao = $this->follow_dao->countByExample($example);
      
      $followersCount = array(
        'count' => intval($followersCount_byDao)
      );

      $response['action'] = array(
        'status'      => 1,
        'name'        => 'followers.count',
        'description' => ''
      );

      $response['data'] = $followersCount;

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
      $example->andFieldEqual('feedType', 'user');
      $example->andFieldEqual('permission', 'everybody');
      $example->andFieldBetween('followTime', $timeStart, $timeEnd);
      
      $followersCount_byDao = $this->follow_dao->countByExample($example);
      
      $followersCount = array(
        'count' => intval($followersCount_byDao)
      );

      $response['action'] = array(
        'status'      => 1,
        'name'        => 'followers.countByDate',
        'description' => ''
      );

      $response['data'] = $followersCount;

      header('Content-Type: application/json');
      echo json_encode($response);

      exit();

    }

  }

?>
