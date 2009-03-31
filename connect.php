<?php

/**
 * @file
 * Get a request token from twitter and present authorization URL to user
 */

/* Sessions are used to keep track of tokens while user authenticates with twitter */
session_start();
// require twitterOAuth files
require_once('twitteroauth/twitteroauth.lib.php');
echo '<pre>';
$connection = new TwitterOauth($consumer_key, $consumer_secret);
$connection->getRequestToken();

var_dump($connection->getStatus());
var_dump($connection->getHeaders());
var_dump($connection->getContent());
$status = $_REQUEST['status'];

switch ($status) {
  case 'oldtoken':
    $status_text = 'The request was to old. Please try again.';
    break;
}

$connection->callback_url = $callback_url;

//$request_token_array = $connection->getRequestToken();
/* Save tokens for later */
$_SESSION['oauth_token'] = $token = $request_token_array['oauth_token'];
$_SESSION['oauth_token_secret'] = $request_token_array['oauth_token_secret'];
var_dump($_SESSION);
$authorize_url = $connection->getAuthorizeURL($token, $callback_url);

$content = '<a href="'.$authorize_url.'">'.$authorize_url.'</a>';
//var_dump($connection);
//echo '============================';
//var_dump($_SESSION);


echo '</pre>';
?>

<html>
  <head>
    <title>Twitter OAuth in PHP</title>
  </head>
  <body>
    <h2>Welcome to a Twitter OAuth PHP example.</h2>

    <p>This site is a basic showcase of Twitters new OAuth authentication method. If you are having issues try <a href='http://twitteroauth.labs.poseurtech.com/clearsessions.php'>clearing your session<a>.</p>

    <p>
      Links:
      <a href='http://github.com/poseurtech/twitteroauth'>Source Code</a> |
      <a href='https://docs.google.com/View?docID=dcf2dzzs_2339fzbfsf4'>Documentation</a> |
      Contact @<a href='http://twitter.com/poseurtech'>poseurtech</a>
    </p>
    <hr />
    <?php if (isset($status)) { ?>
      <?php echo '<h3>'.$status_text.'</h3>'; ?>
    <?php } ?>
    <p>
      <pre>
        <?php print_r($content); ?>
      <pre>
    </p>

  </body>
</html>