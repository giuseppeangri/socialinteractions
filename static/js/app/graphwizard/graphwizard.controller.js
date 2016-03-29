(function() {
	
	/*
	 * Copyright (c) 2015, Giuseppe Angri - info@giuseppeangri.com
	 * All rights reserved.
	 * Copyrights licensed under The GNU GPLv3 License.
	 * See this for terms: http://choosealicense.com/licenses/gpl-3.0/
	 */

	'use strict';

	angular
		.module('app.graphwizard')
		.controller('GraphwizardController', GraphwizardController)

	GraphwizardController.$inject = ['$scope', 'Users', 'Status', 'Comments', 'Likes', 'Friendships', 'Followers', '$q'];

	function GraphwizardController($scope, Users, Status, Comments, Likes, Friendships, Followers, $q) {

		var gc = this;

		gc.inizialize     = inizialize;
		
		gc.generateGraph  = generateGraph;
		gc.applyPreferences  = applyPreferences;
		gc.drawGraph      = drawGraph;
		
		gc.getData_users          = getData_users;
		gc.makeNodes_users        = makeNodes_users;
		
		gc.getData_status         = getData_status;
		gc.makeNodes_status       = makeNodes_status;
		
		gc.getData_singleuser     = getData_singleuser;
		gc.makeNodes_singleuser   = makeNodes_singleuser;
		
		gc.getData_singlestatus   = getData_singlestatus;
		gc.makeNodes_singlestatus = makeNodes_singlestatus;
		
		gc.getData_edge_friendship = getData_edge_friendship;
		gc.getData_edge_samegroup  = getData_edge_samegroup;
		gc.getData_edge_sameauthor = getData_edge_sameauthor;
		gc.getData_edge_sameuser   = getData_edge_sameuser;
		
		gc.getData_user_friends    = getData_user_friends;
		gc.getData_user_status     = getData_user_status;
		gc.getData_user_comments   = getData_user_comments;
		gc.getData_user_likes      = getData_user_likes;
		gc.getData_status_author   = getData_status_author;
		gc.getData_status_comments = getData_status_comments;
		gc.getData_status_likes    = getData_status_likes;
		gc.getData_status_engauth  = getData_status_engauth;
		
		gc.pref_user_friends    = pref_user_friends;
		gc.pref_user_followers  = pref_user_followers;
		gc.pref_user_status     = pref_user_status;
		gc.pref_user_comments   = pref_user_comments;
		gc.pref_user_likes      = pref_user_likes;
		gc.pref_user_engagement = pref_user_engagement;
		
		gc.pref_status_comments   = pref_status_comments;
		gc.pref_status_likes      = pref_status_likes;
		gc.pref_status_engagement = pref_status_engagement;
		
		gc.pref_atLeast = pref_atLeast;
		gc.pref_atMost = pref_atMost;

		inizialize();

		return gc;

		function inizialize() {
			
			$scope.graphwizard = {};
			$scope.graphwizard.preferences = {};
			$scope.radiusArray = [];
			
			$scope.graphwizard.nodesType = [
				{
					name : 'Users',
					getData 	: gc.getData_users,
					makeNodes : gc.makeNodes_users,
					edges : [
						{
							name : 'Nothing',
							getData : function() {}
						},
						{
							name : 'Friendship',
							getData : gc.getData_edge_friendship
						},
						{
							name : 'Same Group',
							getData : gc.getData_edge_samegroup
						}
					],
					preferences : [
						{
							name : 'Node Radius',
							type : 'select',
							getData : function() {},
							options : [
								{
									name : 'Friend\'s Number',
									getData : gc.pref_user_friends
								},
								{
									name : 'Follower\'s Number',
									getData : gc.pref_user_followers
								},
								{
									name : 'Status Number',
									getData : gc.pref_user_status
								},
								{
									name : 'Comment\'s Number',
									getData : gc.pref_user_comments
								},
								{
									name : 'Like\'s Number',
									getData : gc.pref_user_likes
								},
								{
									name : 'Engagement\'s Number',
									getData : gc.pref_user_engagement
								},
							]
						},
						{
							name : 'Friends',
							type : 'input',
							getData : gc.pref_user_friends,
							options : [
								{
									name : 'At Least',
									apply : gc.pref_atLeast
								},
								{
									name : 'At Most',
									apply : gc.pref_atMost
								}
							]
						},
						{
							name : 'Follower',
							type : 'input',
							getData : gc.pref_user_followers,
							options : [
								{
									name : 'At Least',
									apply : gc.pref_atLeast
								},
								{
									name : 'At Most',
									apply : gc.pref_atMost
								}
							]
						},
						{
							name : 'Status',
							type : 'input',
							getData : gc.pref_user_status,
							options : [
								{
									name : 'At Least',
									apply : gc.pref_atLeast
								},
								{
									name : 'At Most',
									apply : gc.pref_atMost
								}
							]
						},
						{
							name : 'Likes',
							type : 'input',
							getData : gc.pref_user_likes,
							options : [
								{
									name : 'At Least',
									apply : gc.pref_atLeast
								},
								{
									name : 'At Most',
									apply : gc.pref_atMost
								}
							]
						},
						{
							name : 'Comments',
							type : 'input',
							getData : gc.pref_user_comments,
							options : [
								{
									name : 'At Least',
									apply : gc.pref_atLeast
								},
								{
									name : 'At Most',
									apply : gc.pref_atMost
								}
							]
						},
						{
							name : 'Engagements',
							type : 'input',
							getData : gc.pref_user_engagement,
							options : [
								{
									name : 'At Least',
									apply : gc.pref_atLeast
								},
								{
									name : 'At Most',
									apply : gc.pref_atMost
								}
							]
						}
					]
				},
				{
					name : 'Newsfeed Status',
					getData : gc.getData_status,
					makeNodes : gc.makeNodes_status,
					edges : [
						{
							name : 'Nothing',
							getData : function() {}
						},
						{
							name : 'Same Author',
							getData : gc.getData_edge_sameauthor
						},
						{
							name : 'Same User in Engagement',
							getData : gc.getData_edge_sameuser
						}
					],
					preferences : [
						{
							name : 'Node Radius',
							type : 'select',
							options : [
								{
									name : 'Comment\'s Number',
									getData : gc.pref_status_comments,
								},
								{
									name : 'Like\'s Number',
									getData : gc.pref_status_likes,
								},
								{
									name : 'Engagement\'s Number',
									getData : gc.pref_status_engagement,
								},
							]
						},
						{
							name : 'Date',
							type : 'input',
							options : [
								{
									name : 'Date Start',
								},
								{
									name : 'Date End',
								}
							]
						},
						{
							name : 'Likes',
							type : 'input',
							getData : gc.pref_status_likes,
							options : [
								{
									name : 'At Least',
									apply : gc.pref_atLeast
								},
								{
									name : 'At Most',
									apply : gc.pref_atMost
								}
							]
						},
						{
							name : 'Comments',
							type : 'input',
							getData : gc.pref_status_comments,
							options : [
								{
									name : 'At Least',
									apply : gc.pref_atLeast
								},
								{
									name : 'At Most',
									apply : gc.pref_atMost
								}
							]
						},
						{
							name : 'Engagements',
							type : 'input',
							getData : gc.pref_status_engagement,
							options : [
								{
									name : 'At Least',
									apply : gc.pref_atLeast
								},
								{
									name : 'At Most',
									apply : gc.pref_atMost
								}
							]
						}
					]
				},
				{
					name : 'Single User',
					getData : gc.getData_singleuser,
					makeNodes : gc.makeNodes_singleuser,
					otherNodes : [
						{
							name : 'Friends',
							getData : gc.getData_user_friends,
							selected : false
						},
						{
							name : 'Status',
							getData : gc.getData_user_status,
							selected : false
						},
						{
							name : 'Comments',
							getData : gc.getData_user_comments,
							selected : false
						},
						{
							name : 'Likes',
							getData : gc.getData_user_likes,
							selected : false
						}
					],
					preferences : [
						{
							name : 'User Search',
							type : 'input',
							options : [
								{
									name : 'Insert ID, Username or Email',
								}
							]
						}
					]
				},
				{
					name : 'Single Status',
					getData : gc.getData_singlestatus,
					makeNodes : gc.makeNodes_singlestatus,
					otherNodes : [
						{
							name : 'Author',
							getData : gc.getData_status_author,
							selected : false
						},
						{
							name : 'Comments',
							getData : gc.getData_status_comments,
							selected : false
						},
						{
							name : 'Likes',
							getData : gc.getData_status_likes,
							selected : false
						},
						{
							name : 'Engagement\'s Author',
							getData : gc.getData_status_engauth,
							selected : false
						}
					],
					preferences : [
						{
							name : 'Status Search',
							type : 'input',
							options : [
								{
									name : 'Insert ID',
								}
							]
						}
					]
				},
			];
			
		}
		
		function getData_users() {
			
			return Users.get().$promise.then(function(result) {
				
				if(result.action.status) {
					
					$scope.graphwizard.users = new Array();
					result.data.forEach(function(item) {
						
						item.enabled = true;
						$scope.graphwizard.users[item.id] = item;
						
					});
					
					$scope.graphwizard.selectedNode.nodes = $scope.graphwizard.users;
					
				}
				
			});
			
		}
		
		function makeNodes_users() {
			
			$scope.graphwizard.users.forEach(function(item) {
				
				if(item.enabled) {
					
					var id = 'user_'+item.id;
					
					$scope.dataSource.nodes.push({
						'id' : id,
						'caption' : item.realname,
						'type' : 'user',
						'radius' : item.radius
					});
				}
				
			});
			
		}
		
		function getData_status() {
			
			return Status.get().$promise.then(function(result) {
				
				if(result.action.status) {
					
					$scope.graphwizard.status = new Array();
					result.data.forEach(function(item) {
						
						item.enabled = true;
						$scope.graphwizard.status[item.id] = item;
						
					});
					
					$scope.graphwizard.selectedNode.nodes = $scope.graphwizard.status;
				}
				
			});
			
		}
		
		function makeNodes_status() {
			
			$scope.graphwizard.status.forEach(function(item) {
				
				if(item.enabled) {
					
					var id = 'status_'+item.id;
						
					$scope.dataSource.nodes.push({
						'id' : id,
						'caption' : item.status,
						'type' : 'status',
						'radius' : item.radius
					});
				}
				
			});
			
		}
		
		function getData_singleuser() {
			
			var user_id = $scope.graphwizard.selectedNode.preferences[0].options[0].value; 
			
			return Users.get({ id : user_id }).$promise.then(function(result) {
				
				if(result.action.status) {
					
					$scope.graphwizard.user = result.data;
							
				}
				
			});
			
		}
		
		function makeNodes_singleuser() {
			
			var id = 'user_'+$scope.graphwizard.user.id;
						
			$scope.dataSource.nodes.push({
				'id' : id,
				'caption' : $scope.graphwizard.user.realname,
				'type' : 'user'
			});
			
		}
		
		function getData_singlestatus() {
			
			var status_id = $scope.graphwizard.selectedNode.preferences[0].options[0].value;
			
			return Status.get({ id : status_id }).$promise.then(function(result) {

				if(result.action.status) {
					
					$scope.graphwizard.status = result.data;
		
				}
				
			});
			
		}
		
		function makeNodes_singlestatus() {
						
			var id = 'status_'+$scope.graphwizard.status.id;
						
			$scope.dataSource.nodes.push({
				'id' : id,
				'caption' : $scope.graphwizard.status.status,
				'type' : 'status'
			});
			
		}
		
		function getData_edge_friendship() {
			
			var promises = [];
			
			$scope.graphwizard.edges_friendship = new Array();
			$scope.graphwizard.check_friendship = new Array();
			
			$scope.graphwizard.users.forEach(function(item) {
				
				if(item.enabled) {
					
					promises.push(Users.getFriends({ id : item.id }).$promise.then(function(result) {
						
						if(result.action.status){
							
							result.data.forEach(function(item) {
								
								if( $scope.graphwizard.users[item.friend_id] ) {
									
									if($scope.graphwizard.check_friendship[item.user_id]) {
										
										if($scope.graphwizard.check_friendship[item.friend_id]) {
											
											if(!$scope.graphwizard.check_friendship[item.friend_id][item.user_id]) {
												$scope.graphwizard.check_friendship[item.user_id][item.friend_id] = true;
												$scope.dataSource.edges.push({
													'source' : 'user_'+item.user_id,
													'target' : 'user_'+item.friend_id,
													'type' : 'friend'
												});

											}
										}
										else {
											$scope.graphwizard.check_friendship[item.user_id][item.friend_id] = true;
											$scope.dataSource.edges.push({
												'source' : 'user_'+item.user_id,
												'target' : 'user_'+item.friend_id,
												'type' : 'friend'
											});

										}
										
									}
									else if($scope.graphwizard.check_friendship[item.friend_id]) {
										if(!$scope.graphwizard.check_friendship[item.friend_id][item.user_id]) {
											$scope.graphwizard.check_friendship[item.friend_id][item.user_id] = true;
											$scope.dataSource.edges.push({
												'source' : 'user_'+item.friend_id,
												'target' : 'user_'+item.user_id,
												'type' : 'friend'
											});

										}
									}
									else {
										$scope.graphwizard.check_friendship[item.user_id] = new Array();
										$scope.graphwizard.check_friendship[item.user_id][item.friend_id] = true;
										$scope.dataSource.edges.push({
											'source' : 'user_'+item.user_id,
											'target' : 'user_'+item.friend_id,
											'type' : 'friend'
										});

									}
									
								}
																
							});
							
						}
						
					}));
					
				}
				
				
			});
			
			return promises;
						
		}
		
		function getData_edge_samegroup() {
			
		}
		
		function getData_edge_sameauthor() {
			
			var authors = new Array();
			
			$scope.graphwizard.status.forEach(function(item) {
				
				if(item.enabled) {
					
					if(authors[item.user_id]) {
						authors[item.user_id].push({ status_id : item.id });
					}
					else {
						authors[item.user_id] = new Array();
						authors[item.user_id].push({ status_id : item.id });
					}
					
				}
				
			});
			
			$scope.graphwizard.edges_sameauthor = new Array();
			
			authors.forEach(function(author) {
				
				for(var i=0; i<author.length; i++) {
				
					for(var j=i+1; j<author.length; j++) {
						
						$scope.dataSource.edges.push({
							'source' : 'status_'+author[i].status_id,
							'target' : 'status_'+author[j].status_id,
							'type' : 'status'
						});
						
					}
					
				}
								
			});
			
		}
		
		function getData_edge_sameuser() {
			
			var promises  = [];
			var statusEng = [];
			var users     = [];
			var check = [];
			
			$scope.graphwizard.edges_sameuser = [];
			
			$scope.graphwizard.status.forEach(function(status) {
				
				if(status.enabled) {
					
					promises.push(Status.getEngagementUsers({ id : status.id }).$promise.then(function(result) {
						
						if(result.action.status) {
							statusEng.push(result.data);
						}
						
					}));
					
				}
				
			});
			
			$q.all(promises).then(function() {
				
				statusEng.forEach(function(singleStatus) {
					
					singleStatus.engagement_users.forEach(function(user) {
						
						if(users[user]) {
							users[user].push(singleStatus.status_id);
						}
						else {
							users[user] = [];
							users[user].push(singleStatus.status_id);
						}
						
					});
					
				});
				
				users.forEach(function(user) {
					
					for(var i=0; i<user.length; i++) {
					
						for(var j=i+1; j<user.length; j++) {
							
							if( check[ user[i] ] ) {
								
								if(!check[ user[i] ][ user[j] ]) {
									check[ user[i] ][ user[j] ] = true;
									
									$scope.dataSource.edges.push({
										'source' : 'status_'+user[i],
										'target' : 'status_'+user[j],
										'type' : 'status'
									});

								}
								
							}
							else if( check[ user[j] ] ) {
								
								if(!check[ user[j] ][ user[i] ]) {
									check[ user[j] ][ user[i] ] = true;
									$scope.dataSource.edges.push({
										'source' : 'status_'+user[i],
										'target' : 'status_'+user[j],
										'type' : 'status'
									});

								}
								
							}
							else {
								check[ user[i] ] = [];
								check[ user[i] ][ user[j] ] = true;
								$scope.dataSource.edges.push({
									'source' : 'status_'+user[i],
									'target' : 'status_'+user[j],
									'type' : 'status'
								});

							}
							
						}
						
					}
									
				});
				
			});
			
			return promises;
			
		}
		
		function getData_user_friends(user_id) {
			
// 			var user_id = $scope.graphwizard.preferences.User_ID; 
			
			return Users.getFriends({ id : user_id }).$promise.then(function(result) {
				
				if(result.action.status) {
					
					result.data.forEach(function(user) {
						
						var id = 'user_'+user.friend_id;
						
						$scope.dataSource.nodes.push({
							'id' : id,
							'caption' : id,
							'type' : 'user'
						});
						
						$scope.dataSource.edges.push({
							'source' : 'user_'+user_id,
							'target' : id,
							'type' : 'friend'
						});
						
					});
		
				}
				
			});
			
		}
		
		function getData_user_status(user_id) {
			
// 			var user_id = $scope.graphwizard.preferences.User_ID; 
			
			return Users.getStatus({ id : user_id }).$promise.then(function(result) {
				
				if(result.action.status) {
					
					result.data.forEach(function(status) {
						
						var id = 'status_'+status.id;
						
						$scope.dataSource.nodes.push({
							'id' : id,
							'caption' : status.status,
							'type' : 'status'
						});
						
						$scope.dataSource.edges.push({
							'source' : 'user_'+user_id,
							'target' : id,
							'type' : 'status'
						});
						
					});
		
				}
				
			});
			
		}
		
		function getData_user_comments(user_id) {
			
// 			var user_id = $scope.graphwizard.preferences.User_ID; 
			
			return Users.getComments({ id : user_id }).$promise.then(function(result) {
				
				if(result.action.status) {
					
					result.data.forEach(function(comment, index) {
						
						var id = 'comment_'+index;
						
						$scope.dataSource.nodes.push({
							'id' : id,
							'caption' : comment.message,
							'type' : 'comment'
						});
						
						$scope.dataSource.edges.push({
							'source' : 'user_'+user_id,
							'target' : id,
							'type' : 'comment'
						});
						
					});
		
				}
				
			});
			
		}
		
		function getData_user_likes(user_id) {
			
// 			var user_id = $scope.graphwizard.preferences.User_ID; 
			
			return Users.getLikes({ id : user_id }).$promise.then(function(result) {
				
				if(result.action.status) {
					
					result.data.forEach(function(like, index) {
						
						var id = 'like_'+like.entityId;
						
						$scope.dataSource.nodes.push({
							'id' : id,
							'caption' : 'Like at '+like.timestamp,
							'type' : 'like'
						});
						
						$scope.dataSource.edges.push({
							'source' : 'user_'+user_id,
							'target' : id,
							'type' : 'like'
						});
						
					});
		
				}
				
			});
			
		}
		
		function getData_status_author(status_id) {
			
// 			var status_id = $scope.graphwizard.preferences.Status_ID;
			var author_id = $scope.graphwizard.status.user_id;
			
			console.log(author_id);
			
			return Users.get({ id : author_id }).$promise.then(function(result) {
				
				if(result.action.status) {
					
					var user = result.data;
					
					var id = 'user_'+user.id;
					
					$scope.dataSource.nodes.push({
						'id' : id,
						'caption' : user.realname,
						'type' : 'user'
					});
					
					$scope.dataSource.edges.push({
						'source' : 'status_'+status_id,
						'target' : id,
						'type' : 'friend'
					});
		
				}
				
			});
			
		}
		
		function getData_status_comments(status_id) {
			
// 			var status_id = $scope.graphwizard.preferences.Status_ID; 
			
			return Status.getEngagement({ id : status_id }).$promise.then(function(result) {
				
				if(result.action.status) {
					
					var check_author = [];
					
					result.data.comments.forEach(function(comment, index) {
						
						var id_comment = 'comment_'+index;
						
						$scope.dataSource.nodes.push({
							'id' : id_comment,
							'caption' : comment.message,
							'type' : 'comment'
						});
						
						$scope.dataSource.edges.push({
							'source' : 'status_'+status_id,
							'target' : id_comment,
							'type' : 'comment'
						});
						
						if($scope.graphwizard.selectedNode.otherNodes[3].selected) {
							
							if( !check_author[comment.user_id] ) {
								
								check_author[comment.user_id] = true;
								
								Users.get({ id : comment.user_id }).$promise.then(function(resultUser) {
									
									if(resultUser.action.status) {
										
										var user = resultUser.data;
										
										var id_user = 'user_'+user.id;
										
										$scope.dataSource.nodes.push({
											'id' : id_user,
											'caption' : user.realname,
											'type' : 'user'
										});
										
										$scope.dataSource.edges.push({
											'source' : id_comment,
											'target' : id_user,
											'type' : 'user'
										});
										
									}
									
								});
								
							}
							
						}
						
					});
		
				}
				
			});
			
		}
		
		function getData_status_likes(status_id) {
			
// 			var status_id = $scope.graphwizard.preferences.Status_ID; 
			
			return Status.getEngagement({ id : status_id }).$promise.then(function(result) {
				
				if(result.action.status) {
					
					result.data.likes.forEach(function(like, index) {
						
						var id = 'like_'+index;
						
						$scope.dataSource.nodes.push({
							'id' : id,
							'caption' : 'Like at '+like.timestamp,
							'type' : 'like'
						});
						
						$scope.dataSource.edges.push({
							'source' : 'status_'+status_id,
							'target' : id,
							'type' : 'like'
						});
						
					});
		
				}
				
			});
			
		}
		
		function getData_status_engauth() {
			
		}
		
		function pref_user_friends(node, preference) {
						
			return Users.getFriendsCount({ id : node.id }).$promise.then(function(result) {
				
				if(result.action.status) {
					$scope.radiusArray.push(result.data.count);
					node[preference.name] = result.data.count;
				}
				
			});
			
		}
		
		function pref_user_followers(node, preference) {
			
			return Users.getFollowersCount({ id : node.id }).$promise.then(function(result) {
				
				if(result.action.status) {
					$scope.radiusArray.push(result.data.count);
					node[preference.name] = result.data.count;
				}
				
			});
			
		}
		
		function pref_user_status(node, preference) {
			
			return Users.getStatusCount({ id : node.id }).$promise.then(function(result) {
				
				if(result.action.status) {
					$scope.radiusArray.push(result.data.count);
					node[preference.name] = result.data.count;
				}
				
			});
			
		}
		
		function pref_user_comments(node, preference) {
			
			return Users.getCommentsCount({ id : node.id }).$promise.then(function(result) {
				
				if(result.action.status) {
					$scope.radiusArray.push(result.data.count);
					node[preference.name] = result.data.count;
				}
				
			});
			
		}
		
		function pref_user_likes(node, preference) {
			
			return Users.getLikesCount({ id : node.id }).$promise.then(function(result) {
				
				if(result.action.status) {
					$scope.radiusArray.push(result.data.count);
					node[preference.name] = result.data.count;
				}
				
			});
			
		}
		
		function pref_user_engagement(node, preference) {
			
			return Users.getEngagementCount({ id : node.id }).$promise.then(function(result) {
				
				if(result.action.status) {
					$scope.radiusArray.push(result.data.total);
					node[preference.name] = result.data.total;
				}
				
			});
			
		}
		
		function pref_status_comments(status, preference) {
			
			return Status.getEngagementCount({ id : status.id }).$promise.then(function(result) {
				
				if(result.action.status) {
					$scope.radiusArray.push(result.data.commentCount);
					status[preference.name] = result.data.commentCount;
				}
				
			});
			
		}
		
		function pref_status_likes(status, preference) {
			
			return Status.getEngagementCount({ id : status.id }).$promise.then(function(result) {
				
				if(result.action.status) {
					$scope.radiusArray.push(result.data.likeCount);
					status[preference.name] = result.data.likeCount;
				}
				
			});
			
		}
		
		function pref_status_engagement(status, preference) {
			
			return Status.getEngagementCount({ id : status.id }).$promise.then(function(result) {
				
				if(result.action.status) {
					$scope.radiusArray.push(result.data.total);
					status[preference.name] = result.data.total;
				}
				
			});
			
		}
		
		function pref_atLeast(node, prefValue, inputValue) {
						
			if(node.enabled) {
				
				if(prefValue < inputValue)
					node.enabled = false;
				
			}
			
		}
		
		function pref_atMost(node, prefValue, inputValue) {
			
			if(node.enabled) {
				
				if(prefValue > inputValue)
					node.enabled = false;
				
			}
			
		}
    
    ////////////////////////////////////////////////////////////////////////
    
    function generateGraph() {
	    
	    $scope.loading_graph = true;
	    $scope.data_graph = false;
	    
	    var graphDiv = angular.element('#graph');
	    var svgObj = graphDiv.children(1);
	    svgObj.remove();
	    
	    $scope.al = new Alchemy();
	    
	    $scope.dataSource = {
				nodes : [],
				edges : []
			};
			
	    $scope.radiusArray = [];
			
			if($scope.graphwizard.selectedNode.cached) {
								
				gc.applyPreferences();
				
			}
			else {
	    
		    $scope.graphwizard.selectedNode.getData().then(function() {
			    
			    $scope.graphwizard.selectedNode.cached = true;
			    
					gc.applyPreferences();
			    
		    });
	    
	    }
	    
    }
    
    function applyPreferences() {
	    
	    var promises = [];
	    
	    if($scope.graphwizard.selectedNode.edges) {
		    
		    $scope.graphwizard.selectedNode.nodes.forEach(function(node) {
			    
			    if($scope.graphwizard.selectedNode.cached)
				    node.enabled = true;
			    
			    $scope.graphwizard.selectedNode.preferences.forEach(function(preference) {
				    
				    if(preference.selectedOption) {
					    
					    promises.push(preference.selectedOption.getData(node, { name : 'radius' } ));
					    
				    }
				    else {
					    
							preference.options.forEach(function(option) {
															
								if(option.value) {
									
									if(node[preference.name]) {
										
										option.apply(node, node[preference.name], option.value);
										
									}
									else {
										
										promises.push(preference.getData(node, preference).then(function() {
											
											option.apply(node, node[preference.name], option.value);
											
										}));
										
									}
									
								}
								
							});	
										    
				    }
				    
			    });
			    
		    });
		    
		    $q.all(promises).then(function() {

			    $scope.graphwizard.selectedNode.makeNodes();
		    
			    var promises = $scope.graphwizard.selectedEdge.getData();
			    
			    $q.all(promises).then(function() {
				    gc.drawGraph();
				    $scope.loading_graph = false;
				    $scope.data_graph = true;
			    });

		    });
		    
	    }
	    else {
		    
		    $scope.graphwizard.selectedNode.otherNodes.forEach(function(node) {
			    
			    if(node.selected)
						promises.push(node.getData($scope.graphwizard.selectedNode.preferences[0].options[0].value));	
			    
		    });
		    
		    $q.all(promises).then(function() {
			    $scope.graphwizard.selectedNode.makeNodes();
			    gc.drawGraph();
			    $scope.loading_graph = false;
			    $scope.data_graph = true;
		    });
		    
	    }
	   	    
    }
    
		function drawGraph() {
			
			var rscale = d3.scale.linear()
			  .domain([0,d3.max($scope.radiusArray)])
			  .range([10,100])

			var config = {
				dataSource		: $scope.dataSource,
				divSelector		: '#graph',
				graphHeight: function(){ return 500; },
				forceLocked		: true,
				nodeTypes : { 
					'type' : [
						'user',
						'status',
						'like', 
						'comment'
					]
				},
        nodeStyle: {
	        'all' : {
		        'captionColor': '#2F3235',
            'captionBackground': null,
            'captionSize': 12,
	        },
	        'user' : {
		        'radius': function(n) {
			        
			        if(n._properties.radius) {
								return rscale(n._properties.radius);
			        }
				      else {
					      return 20;
				      }
			        
		        },
            'color'  : 'rgba(44, 96, 142, 0.8)',
            'borderColor': 'rgba(9, 37, 65, 0.8)',
            'borderWidth': 5,
            'captionColor': '#2F3235',
            'captionBackground': null,
            'captionSize': 22,
        		'selected': {
          		'color'  : 'rgba(44, 96, 142, 1)',
            	'borderColor': 'rgba(9, 37, 65, 1)'
        		},
      			'highlighted': {
          		'color'  : 'rgba(44, 96, 142, 1)',
            	'borderColor': 'rgba(9, 37, 65, 1)'
        		},
      			'hidden': {
          		'color'  : 'rgba(44, 96, 142, 0)',
            	'borderColor': 'rgba(9, 37, 65, 0)'
        		}
	        },
	        'status' : {
		        'radius': function(n) {
			        
			        if(n._properties.radius) {
								return rscale(n._properties.radius);
			        }
				      else {
					      return 20;
				      }
			        
		        },
            'color'  : 'rgba(255, 84, 13, 0.8)',
            'borderColor': 'rgba(232, 44, 12, 0.8)',
            'borderWidth': 5,
            'captionColor': '#2F3235',
            'captionBackground': '#2F3235',
            'captionSize': 12,
        		'selected': {
          		'color'  : 'rgba(255, 84, 13, 1)',
            	'borderColor': 'rgba(232, 44, 12, 1)'
        		},
      			'highlighted': {
          		'color'  : 'rgba(255, 84, 13, 1)',
            	'borderColor': 'rgba(232, 44, 12, 1)'
        		},
      			'hidden': {
          		'color'  : 'rgba(255, 84, 13, 0)',
            	'borderColor': 'rgba(232, 44, 12, 0)'
        		}
	        },
	        'like' : {
	          'radius': function(n) {
			        
			        if(n._properties.radius) {
								return rscale(n._properties.radius);
			        }
				      else {
					      return 20;
				      }
			        
		        },
            'color'  : 'rgba(2, 115, 94, 0.8)',
            'borderColor': 'rgba(1, 35, 38, 0.8)',
            'borderWidth': 3,
            'captionColor': '#2F3235',
            'captionBackground': null,
            'captionSize': 12,
            'selected': {
          		'color'  : 'rgba(2, 115, 94, 1)',
            	'borderColor': 'rgba(1, 35, 38, 1)'
        		},
      			'highlighted': {
          		'color'  : 'rgba(2, 115, 94, 1)',
            	'borderColor': 'rgba(1, 35, 38, 1)'
        		},
      			'hidden': {
          		'color'  : 'rgba(253, 240, 13, 0)',
            	'borderColor': 'rgba(253, 240, 13, 0)'
        		}
	        },
	        'comment' : {
	          'radius': function(n) {
			        
			        if(n._properties.radius) {
								return rscale(n._properties.radius);
			        }
				      else {
					      return 20;
				      }
			        
		        },
            'color'  : 'rgba(127, 0, 0, 0.8)',
            'borderColor': 'rgba(64, 0, 0, 0.8)',
            'borderWidth': 3,
            'captionColor': '#2F3235',
            'captionBackground': null,
            'captionSize': 12,
            'selected': {
          		'color'  : 'rgba(127, 0, 0, 1)',
            	'borderColor': 'rgba(64, 0, 0, 1)'
        		},
      			'highlighted': {
          		'color'  : 'rgba(127, 0, 0, 1)',
            	'borderColor': 'rgba(64, 0, 0, 1)'
        		},
      			'hidden': {
          		'color'  : 'rgba(0, 243, 31, 0)',
            	'borderColor': 'rgba(0, 243, 31, 0)'
        		}
	        }
	      },
				edgeCaption : 'type',

				edgeTypes : { 
					'type' : [
						'friend', 
						'status', 
						'like', 
						'comment'
					]
				},
        edgeStyle: {
        	'all' : {
        		'color' : 'grey',
        		'opacity' : 0.3,
        		'selected': {
          		'opacity': 1
        		},
      			'highlighted': {
          		'opacity': 1
        		},
      			'hidden': {
          		'opacity': 0
        		}
        	},
        	'friend' : {
	          'width' : 5,
	          'color' : 'rgb(9, 37, 65)',
	          'opacity' : 0.8,
        		'selected': {
          		'opacity': 1
        		},
      			'highlighted': {
          		'opacity': 1
        		},
      			'hidden': {
          		'opacity': 0
        		}
	        },
	        'status' : {
	          'width' : 5,
	          'color' : 'rgb(232, 44, 12)',
	          'opacity' : 0.8,
        		'selected': {
          		'opacity': 1
        		},
      			'highlighted': {
          		'opacity': 1
        		},
      			'hidden': {
          		'opacity': 0
        		}
	        },
	        'like' : {
	          'width' : 5,
	          'color' : 'rgb(1, 35, 38)',
	          'opacity' : 0.8,
        		'selected': {
          		'opacity': 1
        		},
      			'highlighted': {
          		'opacity': 1
        		},
      			'hidden': {
          		'opacity': 0
        		}
	        },
	        'comment' : {
	          'width' : 5,
	          'color' : 'rgb(64, 0, 0)',
	          'opacity' : 0.8,
        		'selected': {
          		'opacity': 1
        		},
      			'highlighted': {
          		'opacity': 1
        		},
      			'hidden': {
          		'opacity': 0
        		}
	        }
	      },
	      nodeClick 		: function(el) {

					var function_name = el.getProperties('caption');
					if( gc[function_name] != undefined )
						gc[function_name]();

				}
			};

			$scope.al.begin(config);
			
// 			window.algsa = $scope.al;
			
		}
		
	}

})();
