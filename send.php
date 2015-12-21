<?php


    if ( isset($_GET['screen_name']) ) {
        $screen_name    = $_GET['screen_name'];
        $message        = $_GET['message'];
    } else {
        die("erreur, absence du screen_name");
    }


    ini_get('display_errors');
    session_start();

    define('CONSUMER_KEY', ("Cxn4HC5yMIRcJ9qIRC4pcL7Up"));
    define('CONSUMER_SECRET', ("GuqC2Cmj38BEqdlpwYZLknegOHAV4Dd7RWK8IKv6XwG5eG1QmH"));
    define('OAUTH_CALLBACK', ("https://dev.socialshaker.com/pierre/twitter_partnership_popupV2/callback.php"));


    require 'vendor/abraham/twitteroauth/autoload.php';
    use Abraham\TwitterOAuth\TwitterOAuth;

    if ( isset($_SESSION['access_token']) ) {
        $t = $_SESSION['access_token'];
        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $t['oauth_token'], $t['oauth_token_secret']);

        //$rates    = $connection->get("application/rate_limit_status", array("resources" => "lists"));
        //$messages = $connection->post("direct_messages/new", array("text" => "hello world2", "screen_name" => $screen_name));
        //$messages = $connection->post("statuses/update", array("status" => "@" . $screen_name . " Salut 2", "trim_user" => "true") );
          //$messages = $connection->post("statuses/update", array("status" => "@" . $screen_name . " ". $message, "trim_user" => "true") );
    }
