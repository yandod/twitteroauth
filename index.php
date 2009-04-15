<?php
/**
 * @file
 * User has successfully authenticated with Twitter. Access tokens saved to session and DB.
 */
/* Load required lib files. */
session_start();
require_once('twitteroauth/twitteroauth.php');

/* Home page. Change to the location  */
$home_page = 'http://twitteroauth.labs.poseurtech.com';
/* Callback URL */
$oauth_callback = $home_page.'/callback.php';

/* Get user access tokens out of the session. */
$user_key = $_SESSION['access_token'];
$user_secret = $_SESSION['access_token_secret'];

/* If access tokens are not available redirect to connect page. */
if (empty($user_key) || empty($user_secret)) {
    header('Location: '.$home_page.'/clearsessions.php');
}

/* Create a TwitterOauth object with consumer/user tokens. */
$connection = new TwitterOAuth($user_key, $user_secret);
/* Save consumer keys into TwitterOAuth object. */
$connection->consumer_key = $_SESSION['consumer_key'];
$connection->consumer_secret = $_SESSION['consumer_secret'];

/* This example get the xml feed. Ignore to get json. */
$connection->return_format = 'xml';
/* Add your application's consumer keys here */
$connection->consumer_key = '';
$connection->consumer_secret = '';

/* Build menu */
$menu = <<<END
  <a href="$home_page/index.php">Test</a> |
  <a href="$home_page/index.php?method=verify_credentials">Verify credentials</a> |
  <a href="$home_page/index.php?method=get_public_timeline">Get public timeline</a> |
  <a href="$home_page/index.php?method=get_replies">Get mentions</a> |
  <a href="$home_page/index.php?method=get_direct_messages">Get direct messages</a>
  <hr />
END;

/* If method is set change API call made. Test is called by default. */
$method = $_GET['method'];
$content = '<pre>'.$connection->makeRequest($method).'</pre>';

/* Some example calls */
//$connection->makeRequest('create_status', array('status' => date(DATE_RFC822)));
//$connection->makeRequest('verify_credentials');
//$connection->makeRequest('destroy_status', array('id' => 1273539422));
//$connection->makeRequest('follow_user', array('id' => 9436992));
//$connection->makeRequest('show_user', array('screen_name' => 'abraham'));
//$connection->makeRequest('create_direct_message', array('user' => 'abraham', 'text' => date(DATE_RFC822)));

/* Include HTML to display on the page */
include('html.inc');