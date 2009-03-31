<?php

/**
 * @file
 * Clears PHP sessions and redirects to the homepage.
 */
session_start();
session_destroy();

require_once('twitteroauth/twitteroauth.config.php');

header('Location: '.$home_page.'/connect.php');