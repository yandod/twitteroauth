<?php
/**
 * @file
 * Clears PHP sessions and redirects to the connect page.
 */

/* Load and clear sessions */
session_start();
session_destroy();

/* Require twitteroauth file */
require_once('twitteroauth/twitteroauth.php');
/* Redirect to page with the connect to Twitter option. */
header('Location: '.$home_page.'/connect.php');