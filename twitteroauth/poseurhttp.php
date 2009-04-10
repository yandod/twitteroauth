<?php

/**
 * @file
 * PHP lib for making HTTP connections.
 */
class PoseurHTTP{
  /* Host URL Exampe: http://twitter.com */
  var $host;
  /* Full URL the request is being made too. Example: http://twitter.com/help/test.xml */
  var $http_url;
  var $method = 'GET';
  var $postfield = array();
  // Options
  var $timeout = 20;
  var $connecttimeout = 20;
  var $ssl_verifypeer = FALSE;
  // Response vars
  var $last_http_status;

  function __construct($host) {
    $this->host = $host;
  }

  function get($url, $data = FALSE) {
    $this->http_url = $url;
    if ($data) {
      $this->http_url .= '?'.$this->buildQueryString($data);
    }
    return $this->makeHTTPRequest();
  }

  function post($url, $data) {
    $this->http_url = $url;
    $this->method = 'POST';
    $this->postfield = $this->buildQueryString($data);
  return $this->makeHTTPRequest();
  }

  function makeHTTPRequest() {/*{{{*/
    $ci = curl_init();
    /* Curl settings */
    curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, $this->connecttimeout);
    curl_setopt($ci, CURLOPT_TIMEOUT, $this->timeout);
    curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ci, CURLOPT_HTTPHEADER, array('Expect:'));
    curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, $this->ssl_verifypeer);
    curl_setopt($ci, CURLOPT_URL, $this->http_url);
    if ('POST' === $this->method) {
      curl_setopt($ci, CURLOPT_POST, TRUE);
      curl_setopt($ci, CURLOPT_POSTFIELDS, $this->postfield);
    }
    /* Curl response and cleanup */
    $response = curl_exec($ci);
    /* If Curl fails to connect a second time */
    if (0 === $response) {
      $response = curl_exec($ci);
    }
    $this->last_http_status = curl_getinfo($ci, CURLINFO_HTTP_CODE);
    curl_close ($ci);
    return $response;
  }/*}}}*/

  function buildQueryString($data) {
    $query_string = '';
    $query_string_array = array();
    if (is_array($data)) {
      foreach ($data as $key => $value) {
        $query_string_array[] = implode('=', array(urlencode($key), urlencode($value)));
      }
      $query_string = implode('&',$query_string_array);
    } else {
      $query_string = $data;
    }
    return $query_string;
  }

  function parseQueryString($query_string) {
    $array = array();
    foreach (explode('&', $query_string) as $param) {
      $pair = explode('=', $param, 2);
      if (count($pair) != 2) continue;
      $array[urldecode($pair[0])] = urldecode($pair[1]);
    }
    return $array;
  }
}