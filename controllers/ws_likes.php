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
  class SOCIALINTERACTIONS_CTRL_WsLikes extends ADMIN_CTRL_Abstract {

    private $like_dao;

    /**
     *
     *
     */
    public function __construct() {
      $this->like_dao = NEWSFEED_BOL_LikeDao::getInstance();
    }

    /**
     *
     *
     */
    public function index() {

      $likes_byDao = $this->like_dao->findAll();

      $likes = array();

      foreach ($likes_byDao as $like_byDao) {

        // get action array from object
          $like = get_object_vars ($like_byDao);

        // get data from action array
          $id_like     = $like['id'];
          $entity_type = $like['entityType'];
          $id_entity   = $like['entityId'];
          $user_id     = $like['userId'];
          $timestamp   = date('Y/m/d H:s', $like['timeStamp']);

        // add entry to status array
          $likes[] = array(
            'id'          => $id_like,
            'entity_type' => $entity_type,
            'entity_id'   => $id_entity,
            'user_id'     => $user_id,
            'timestamp'   => $timestamp
          );

      }

      $response['action'] = array(
        'status'      => 1,
        'name'        => 'likes.index',
        'description' => ''
      );

      $response['data'] = $likes;

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
      $example->andFieldBetween('timeStamp', $timeStart, $timeEnd);

	    $likes_byDao = $this->like_dao->findListByExample($example);

      $likes = array();

      foreach ($likes_byDao as $like_byDao) {

        // get action array from object
          $like = get_object_vars ($like_byDao);

        // get data from action array
          $id_like     = $like['id'];
          $entity_type = $like['entityType'];
          $id_entity   = $like['entityId'];
          $user_id     = $like['userId'];
          $timestamp   = date('Y/m/d H:s', $like['timeStamp']);

        // add entry to status array
          $likes[] = array(
            'id'          => $id_like,
            'entity_type' => $entity_type,
            'entity_id'   => $id_entity,
            'user_id'     => $user_id,
            'timestamp'   => $timestamp
          );

      }

      $response['action'] = array(
        'status'      => 1,
        'name'        => 'likes.indexByDate',
        'description' => ''
      );

      $response['data'] = $likes;

      header('Content-Type: application/json');
      echo json_encode($response);

      exit();

    }
    
    /**
     *
     *
     */
    public function count() {

      $likesCount_byDao = $this->like_dao->countAll();
      
      $likesCount = array(
        'count' => intval($likesCount_byDao)
      );

      $response['action'] = array(
        'status'      => 1,
        'name'        => 'likes.count',
        'description' => ''
      );

      $response['data'] = $likesCount;

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
      $example->andFieldBetween('timeStamp', $timeStart, $timeEnd);

      $likesCount_byDao = $this->like_dao->countByExample($example);
      
      $likesCount = array(
        'count' => intval($likesCount_byDao)
      );

      $response['action'] = array(
        'status'      => 1,
        'name'        => 'likes.countByDate',
        'description' => ''
      );

      $response['data'] = $likesCount;

      header('Content-Type: application/json');
      echo json_encode($response);

      exit();

    }

  }

?>
