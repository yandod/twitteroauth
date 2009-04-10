<?php

/**
 * @file
 * Build and proccess Twitter OAuth requests.
 */

/* Load required lib files */
require_once('OAuth.php');
require_once('poseurhttp.php');
require_once('twitteroauth.methods.php');

/* Home page */
$home_page = 'http://twitteroauth.labs.poseurtech.com';
/* Callback URL */
$oauth_callback = $home_page.'/callback.php';
/* Consumer key from Twitter */
$consumer_key = '';
/* Consumer secret from Twitter */
$consumer_secret = '';

/**
 * Twitter OAuth class
 */
class TwitterOAuth extends PoseurHTTP {/*{{{*/

  /* Set up the API root URL */
  public $host = "https://twitter.com";
  public $return_format = 'json';
  public $decode = FALSE;

  /**
   * Set API URLS
   */
  function requestTokenPath() { return '/oauth/request_token'; }
  function authorizeURL() { return '/oauth/authorize'; }
  function accessTokenURL() { return '/oauth/access_token'; }

  /**
   * Debug helpers
   */
  function lastStatusCode() { return $this->http_status; }
  function lastAPICall() { return $this->last_api_call; }

  /**
   * construct TwitterOAuth object
   */
  function __construct($consumer_key, $consumer_secret, $oauth_token = NULL, $oauth_token_secret = NULL) {/*{{{*/
    $this->sha1_method = new OAuthSignatureMethod_HMAC_SHA1();
    $this->consumer = new OAuthConsumer($consumer_key, $consumer_secret);
    if (!empty($oauth_token) && !empty($oauth_token_secret)) {
      $this->token = new OAuthConsumer($oauth_token, $oauth_token_secret);
    } else {
      $this->token = NULL;
    }
  }/*}}}*/

  /**
   * Get a request_token from Twitter
   *
   * @returns a key/value array containing oauth_token and oauth_token_secret
   */
  function getRequestToken() {/*{{{*/
    $this->http_url = $this->host.$this->requestTokenPath();
    $request = $this->oAuthRequest();
    $token = $this->parseQueryString($request);
    $this->token = new OAuthConsumer($token['oauth_token'], $token['oauth_token_secret']);
    return $token;
  }/*}}}*/

  /**
   * Get the authorize URL
   *
   * @returns a string
   */
  function getAuthorizeURL($token, $oauth_callback) {/*{{{*/
    if (is_array($token)) $token = $token['oauth_token'];
    if (!empty($oauth_callback)) $oauth_callback = '&oauth_callback=' . $oauth_callback;
    return $this->host.$this->authorizeURL() .'?oauth_token=' . $token . $oauth_callback;
  }/*}}}*/

  /**
   * Exchange the request token and secret for an access token and
   * secret, to sign API calls.
   *
   * @returns array("oauth_token" => the access token,
   *                "oauth_token_secret" => the access secret)
   */
  function getAccessToken($token = NULL) {/*{{{*/
    $this->http_url = $this->host.$this->accessTokenURL();
    $request = $this->oAuthRequest();
    $token = $this->parseQueryString($request);
    $this->token = new OAuthConsumer($token['oauth_token'], $token['oauth_token_secret']);
    return $token;
  }/*}}}*/

  /**
   * Make request against Twitters API.
   * TODO Add tests to make sure call is valid.
   */
  function makeRequest($method_name = FALSE, $parameters = array()) {/*{{{*/
    global $twitter_methods;
    if (!$method_name) {
      $method_name = 'test';
    }
    $method_info = $twitter_methods[$method_name];
    if (isset($this->parameters['id'])) {
      $url_array = array($this->host, '/', $method_info['path'], '/', $parameters['id'], '.', $this->return_format);
    } else {
      $url_array = array($this->host, '/', $method_info['path'], '.', $this->return_format);
    }
    $this->method = $method_info['methods'][0];
    $this->http_url = implode('', $url_array);
    $this->postfield = $parameters;
    $result = $this->oAuthRequest();
    if (200 === $this->last_http_status && 'json' === $this->return_format && $this->decode) {
      $result = json_decode($result);
    }
    return $result;
  }/*}}}*/

  /**
   * Format and sign an OAuth / API request
   */
  function oAuthRequest() {/*{{{*/
    $method = $this->method;
    if (empty($method)) {
      $method = empty($this->postfield) ? "GET" : "POST";
    }
    $request = OAuthRequest::from_consumer_and_token($this->consumer, $this->token, $method, $this->http_url, $this->postfield);
    $request->sign_request($this->sha1_method, $this->consumer, $this->token);
    switch ($method) {
      case 'GET':
        return $this->get($request->to_url());
      case 'POST':
        return $this->post($request->get_normalized_http_url(), $request->to_postdata());
    }
  }/*}}}*/
}/*}}}*/