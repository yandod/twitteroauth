<?php
/**
 * @file
 * Take the user when they return from Twitter. Get access tokens.
 * Verify credentials and redirect to based on response from Twitter.
 */

/* Start session and load lib */
session_start();
require_once('twitteroauth/twitteroauth.php');

/* If the oauth_token is old redirect to the connect page. */
$request_key = $_REQUEST['oauth_token'];
if (isset($request_key) && !strcomp($_SESSION['oauth_token'], $request_key)) {
  $_SESSION['oauth_status'] = 'oldtoken';
  header('Location: ./connect.php');
}

/* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
$connection = new TwitterOAuth($consumer_key, $consumer_secret, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

/* Request access tokens from twitter */
$access_token_array = $connection->getAccessToken();

/* Save the access tokens. Normally these would be saved in a database for future use. */
$_SESSION['access_token'] = $access_token_array['oauth_token'];
$_SESSION['access_token_secret'] = $access_token_array['oauth_token_secret'];
$_SESSION['user_id'] = $user_id = $_REQUEST['user_id'];
$_SESSION['screen_name'] = $_REQUEST['screen_name'];

/* Remove no longer needed request tokens */
unset($_SESSION['oauth_token']);
unset($_SESSION['oauth_token_secret']);

/* If HTTP response is 200 continue otherwise send to connect page to retry */
if (200 == $connection->last_http_status) {
  /* The user has been verified and the access tokens can be saved for future use */
  $_SESSION['status'] = 'verified';
  header('Location: ./index.php');
} else {
  /* Save HTTP status for error dialog on connnect page.*/
  $_SESSION['status'] = $connection->last_http_status;
  header('Location: ./connect.php');
}