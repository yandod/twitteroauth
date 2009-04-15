<?php
/**
 * @file
 * Get a request token from twitter and present authorization URL to user
 */
/* Start session and load lib */
session_start();
require_once('twitteroauth/twitteroauth.php');

/* Check status */
switch ($_SESSION['oauth_status']) {
  case 'oldtoken':
    $status_text = 'The request was to old. Please try again.';
    unset($_SESSION['oauth_status']);
    break;
}

/* Create TwitterOAuth object and get request token */
$connection = new TwitterOAuth($consumer_key, $consumer_secret);
/* Save consumer keys into TwitterOAuth object and SESSION for use on other pages */
$connection->consumer_key = $_SESSION['consumer_key'] = 'CONSUMER_KEY_GOES_HERE';
$connection->consumer_secret = $_SESSION['consumer_secret'] = 'CONSUMER_SECRET_GOES_HERE';

/* Get request token */
$request_token_array = $connection->getRequestToken();

/* Save request token to session */
$_SESSION['oauth_token'] = $token = $request_token_array['oauth_token'];
$_SESSION['oauth_token_secret'] = $request_token_array['oauth_token_secret'];

/* If last connection fails don't display authorization link */
switch ($connection->last_http_status) {
  case 200:
    /* Build authorize URL */
    $authorize_url = $connection->getAuthorizeURL($token, $oauth_callback);
    $content = '<a href="'.$authorize_url.'"><img src="/connect.gif" alt="Sign in with Twitter"/></a>';
    break;
  default:
    $content = 'Something went wrong please try again later.';
    break;
}

/* Include HTML to display on the page */
include('html.inc');