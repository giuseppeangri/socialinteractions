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
  class SOCIALINTERACTIONS_CTRL_WsComments extends ADMIN_CTRL_Abstract {

    private $comment_dao;

    /**
     *
     *
     */
    public function __construct() {
      $this->comment_dao = BOL_CommentDao::getInstance();
    }

    /**
     *
     *
     */
    public function index() {

      $comments_byDao = $this->comment_dao->findAll();

      $comments = array();

      foreach ($comments_byDao as $comment_byDao) {

        // get action array from object
          $comment = get_object_vars ($comment_byDao);

        // get data from action array
          $id_comment   = $comment['id'];
          $id_entity    = $comment['commentEntityId'];
          $comment_text = $comment['message'];
          $user_id      = $comment['userId'];
          $timestamp    = date('Y/m/d H:s', $comment['createStamp']);

        // add entry to status array
          $comments[] = array(
            'id'        => $id_comment,
            'entity_id' => $id_entity,
            'message'   => $comment_text,
            'user_id'   => $user_id,
            'timestamp' => $timestamp
          );

      }

      $response['action'] = array(
        'status'      => 1,
        'name'        => 'comments.index',
        'description' => ''
      );

      $response['data'] = $comments;

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
      $example->andFieldBetween('createStamp', $timeStart, $timeEnd);

	    $comments_byDao = $this->comment_dao->findListByExample($example);

      $comments = array();

      foreach ($comments_byDao as $comment_byDao) {

        // get action array from object
          $comment = get_object_vars ($comment_byDao);

        // get data from action array
          $id_comment   = $comment['id'];
          $id_entity    = $comment['commentEntityId'];
          $comment_text = $comment['message'];
          $user_id      = $comment['userId'];
          $timestamp    = date('Y/m/d H:s', $comment['createStamp']);

        // add entry to status array
          $comments[] = array(
            'id'        => $id_comment,
            'entity_id' => $id_entity,
            'message'   => $comment_text,
            'user_id'   => $user_id,
            'timestamp' => $timestamp
          );

      }

      $response['action'] = array(
        'status'      => 1,
        'name'        => 'comments.indexByDate',
        'description' => ''
      );

      $response['data'] = $comments;

      header('Content-Type: application/json');
      echo json_encode($response);

      exit();

    }
    
    /**
     *
     *
     */
    public function count() {

      $commentsCount_byDao = $this->comment_dao->countAll();
      
      $commentsCount = array(
        'count'        => intval($commentsCount_byDao)
      );

      $response['action'] = array(
        'status'      => 1,
        'name'        => 'comments.count',
        'description' => ''
      );

      $response['data'] = $commentsCount;

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
      $example->andFieldBetween('createStamp', $timeStart, $timeEnd);

      $commentsCount_byDao = $this->comment_dao->countByExample($example);
      
      $commentsCount = array(
        'count'        => intval($commentsCount_byDao)
      );

      $response['action'] = array(
        'status'      => 1,
        'name'        => 'comments.countByDate',
        'description' => ''
      );

      $response['data'] = $commentsCount;

      header('Content-Type: application/json');
      echo json_encode($response);

      exit();

    }

  }

?>
