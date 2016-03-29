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
  class SOCIALINTERACTIONS_CTRL_WsFriendships extends ADMIN_CTRL_Abstract {
	  
	  private $friendship_dao;

    /**
     *
     *
     */
    public function __construct() {
      $this->friendship_dao = FRIENDS_BOL_FriendshipDao::getInstance();
    }

    /**
     *
     *
     */
    public function index() {

      $friendships_byDao = $this->friendship_dao->findAllActiveFriendships();

      $friendships = array();

      foreach ($friendships_byDao as $friendship_byDao) {

        // get action array from object
          $friendship = get_object_vars ($friendship_byDao);

        // get data from action array
          $id_friendship = $friendship['id'];
          $user_id       = $friendship['userId'];
          $friend_id     = $friendship['friendId'];
          $timestamp     = date('Y/m/d H:s', $friendship['timeStamp']);

        // add entry to status array
          $friendships[] = array(
            'id'        => $id_friendship,
            'user_id'   => $user_id,
            'friend_id' => $user_id,
            'timestamp' => $timestamp
          );

      }

      $response['action'] = array(
        'status'      => 1,
        'name'        => 'friendships.index',
        'description' => ''
      );

      $response['data'] = $friendships;

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
      $example->andFieldEqual('status', 'active');
      $example->andFieldBetween('timeStamp', $timeStart, $timeEnd);
      
      $friendships_byDao = $this->friendship_dao->findListByExample($example);

      $friendships = array();

      foreach ($friendships_byDao as $friendship_byDao) {

        // get action array from object
          $friendship = get_object_vars ($friendship_byDao);

        // get data from action array
          $id_friendship = $friendship['id'];
          $user_id       = $friendship['userId'];
          $friend_id     = $friendship['friendId'];
          $timestamp     = date('Y/m/d H:s', $friendship['timeStamp']);

        // add entry to status array
          $friendships[] = array(
            'id'        => $id_friendship,
            'user_id'   => $user_id,
            'friend_id' => $user_id,
            'timestamp' => $timestamp
          );

      }

      $response['action'] = array(
        'status'      => 1,
        'name'        => 'friendships.index',
        'description' => ''
      );

      $response['data'] = $friendships;

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
      $example->andFieldEqual('status', 'active');
      
      $friendshipsCount_byDao = $this->friendship_dao->countByExample($example);
      
      $friendshipsCount = array(
        'count' => intval($friendshipsCount_byDao)
      );

      $response['action'] = array(
        'status'      => 1,
        'name'        => 'friendships.count',
        'description' => ''
      );

      $response['data'] = $friendshipsCount;

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
      $example->andFieldEqual('status', 'active');
      $example->andFieldBetween('timeStamp', $timeStart, $timeEnd);
      
      $friendshipsCount_byDao = $this->friendship_dao->countByExample($example);
      
      $friendshipsCount = array(
        'count' => intval($friendshipsCount_byDao)
      );

      $response['action'] = array(
        'status'      => 1,
        'name'        => 'friendships.countByDate',
        'description' => ''
      );

      $response['data'] = $friendshipsCount;

      header('Content-Type: application/json');
      echo json_encode($response);

      exit();

    }

  }

?>
