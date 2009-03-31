<?php

$global_twitter_parameters = array('source', 'callback', 'supress_response_codes');

$twitter_methods = array(
  /* Status Methods */
  'get_public_timeline' => array(
    'path' => 'statuses/public_timeline',
    'methods' => array('GET'),
    'formats' => array('xml', 'json', 'rss', 'atom'),
    'parameters' => NULL,
  ),
  'get_friends_timeline' => array(
    'path' => 'statuses/friends_timeline',
    'formats' => array('xml', 'json', 'rss', 'atom'),
    'methods' => array('GET'),
    'parameters' => array('since', 'since_id', 'count', 'page'),
  ),
  'get_user_timeline' => array(
    'path' => 'statuses/user_timeline',
    'formats' => array('xml', 'json', 'rss', 'atom'),
    'methods' => array('GET'),
    'parameters' => array('id', 'since', 'since_id', 'count', 'page'),
  ),
  "show_status" => array(
    'path' => 'statuses/show',
    'formats' => array('xml', 'json'),
    'methods' => array('GET'),
    'parameters' => array('id' => TRUE),
  ),
  'create_status' => array(
    'path' => 'statuses/update',
    'formats' => array('xml', 'json'),
    'methods' => array('POST'),
    'parameters' => array('status' => TRUE, 'in_reply_to_status_id'),
  ),
  'get_replies' => array(
    'path' => 'statuses/replies',
    'formats' => array('xml', 'json', 'rss', 'atom'),
    'methods' => array('GET'),
    'parameters' => array('since', 'since_id', 'page'),
  ),
  'destroy_status' => array(
    'path' => 'statuses/destroy',
    'formats' => array('xml', 'json'),
    'methods' => array('POST', 'DELETE'),
    'parameters' => array('id' => TRUE),
  ),

  /* User Methods */
  'get_friends' => array(
    'path' => 'statuses/friends',
    'formats' => array('xml', 'json'),
    'methods' => array('GET'),
    'parameters' => array('id', 'page')
  ),
  'get_followers' => array(
    'path' => 'statuses/followers',
    'formats' => array('xml', 'json'),
    'methods' => array('GET'),
    'parameters' => array('id', 'page')
  ),
  'show_user' => array(
    'path' => 'users/show',
    'formats' => array('xml', 'json'),
    'methods' => array('GET'),
    'parameters' => array('id', 'email', 'user_id', 'screen_name')
  ),

  /* Direct Message Methods */
  'get_direct_messages' => array(
    'path' => 'direct_messages',
    'formats' => array('xml', 'json', 'rss', 'atom'),
    'methods' => array('GET'),
    'parameters' => array('since', 'since_id', 'page')
  ),
  'get_sent_direct_messages' => array(
    'path' => 'direct_messages/sent',
    'formats' => array('xml', 'json'),
    'methods' => array('GET'),
    'parameters' => array('since', 'since_id', 'page')
  ),
  'create_direct_message' => array(
    'path' => 'direct_messages/new',
    'formats' => array('xml', 'json'),
    'methods' => array('POST'),
    'parameters' => array('user' => TRUE, 'text' => TRUE)
  ),
  'destroy_direct_message' => array(
    'path' => 'direct_messages/destroy',
    'formats' => array('xml', 'json'),
    'methods' => array('POST', 'DELETE'),
    'parameters' => array('id' => TRUE)
  ),

  /* Friendship Methods */
  'create_friendship' => array(
    'path' => 'friendships/create',
    'formats' => array('xml', 'json'),
    'methods' => array('POST'),
    'parameters' => array('id' => TRUE, 'follow'),
  ),
  'destroy_friendship' => array(
    'path' => 'friendships/destroy',
    'formats' => array('xml', 'json'),
    'methods' => array('POST', 'DELETE'),
    'parameters' => array('id' => TRUE),
  ),
  'does_friendship_exist' => array(
    'path' => 'friendships/exists',
    'formats' => array('xml', 'json'),
    'methods' => array('POST', 'DELETE'),
    'parameters' => array('user_a' => TRUE, 'user_b' => TRUE),
  ),

  /* Social Graph Methods */
  'get_friend_ids' => array(
    'path' => 'friends/ids',
    'formats' => array('xml', 'json'),
    'methods' => array('GET'),
    'parameters' => array('id'),
  ),
  'get_follower_ids' => array(
    'path' => 'followers/ids',
    'formats' => array('xml', 'json'),
    'methods' => array('GET'),
    'parameters' => array('id'),
  ),

  /* Account Methods */
  'verify_credentials' => array(
    'path' => 'account/verify_credentials',
    'formats' => array('xml', 'json'),
    'methods' => array('POST'),
    'parameters' => NULL,
  ),
  'end_session' => array(
    'path' => 'account/end_session',
    'formats' => array('xml', 'json'),
    'methods' => array('POST'),
    'parameters' => NULL,
  ),
  'update_deliver_device' => array(
    'path' => 'account/update_deliver_device',
    'formats' => array('xml', 'json'),
    'methods' => array('POST'),
    'parameters' => array('device' => TRUE),
  ),
  'update_profile_colors' => array(
    'path' => 'account/update_profile_colors',
    'formats' => array('xml', 'json'),
    'methods' => array('POST'),
    'parameters' => array(
      'profile_background_color',
      'profile_text_color',
      'profile_link_color',
      'profile_sidebar_fill_color',
      'profile_sidebar_border_color'
    ),
  ),
  'update_profile_image' => array(
    'path' => 'account/update_profile_image',
    'formats' => array('xml', 'json'),
    'methods' => array('POST'),
    'parameters' => array('image' => TRUE),
  ),
  'update_profile_background_image' => array(
    'path' => 'account/update_profile_image',
    'formats' => array('xml', 'json'),
    'methods' => array('POST'),
    'parameters' => array('image' => TRUE),
  ),
  'get_rate_limit_status' => array(
    'path' => 'account/rate_limit_status',
    'formats' => array('xml', 'json'),
    'methods' => array('GET'),
    'parameters' => NULL,
  ),
  'update_profile' => array(
    'path' => 'account/update_profile',
    'formats' => array('xml', 'json'),
    'methods' => array('GET'),
    'parameters' => array('name', 'email', 'url', 'location', 'description'),
  ),

  /* Favorite Methods */
  'get_favorites' => array(
    'path' => 'favorites',
    'formats' => array('xml', 'json', 'rss', 'atom'),
    'methods' => array('GET'),
    'parameters' => array('id', 'page'),
  ),
  'create_favorite' => array(
    'path' => 'favorites/create',
    'formats' => array('xml', 'json'),
    'methods' => array('POST'),
    'parameters' => array('id' => TRUE),
  ),
  'destroy_favorite' => array(
    'path' => 'favorites/destroy',
    'formats' => array('xml', 'json'),
    'methods' => array('POST', 'DELETE'),
    'parameters' => array('id' => TRUE),
  ),

  /* Notification Methods */
  'follow_user' => array(
    'path' => 'notifications/follow',
    'formats' => array('xml', 'json'),
    'methods' => array('POST'),
    'parameters' => array('id' => TRUE),
  ),
  'leave_user' => array(
    'path' => 'notifications/leave',
    'formats' => array('xml', 'json'),
    'methods' => array('POST'),
    'parameters' => array('id' => TRUE),
  ),

  /* Block Methods */
  'creat_block' => array(
    'path' => 'blocks/create',
    'formats' => array('xml', 'json'),
    'methods' => array('POST'),
    'parameters' => array('id' => TRUE),
  ),
  'destroy_block' => array(
    'path' => 'blocks/destroy',
    'formats' => array('xml', 'json'),
    'methods' => array('POST', 'DELETE'),
    'parameters' => array('id' => TRUE),
  ),

  /* Help Methods */
  'test' => array(
    'path' => 'help/test',
    'formats' => array('xml', 'json'),
    'methods' => array('GET'),
    'parameters' => NULL,
  ),
);