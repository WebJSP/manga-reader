<?php
        require_once('../config/config.inc.php');
	require('../phplib/mlemos/http.php');
	require('../phplib/mlemos/oauth_client.php');
        session_start();
        
	$client = new oauth_client_class;
	$client->debug = 1;
	$client->debug_http = 1;
	$client->server = 'Twitter';
	$client->redirect_uri = 'http://'.$_SERVER['HTTP_HOST'].
		dirname(strtok($_SERVER['REQUEST_URI'],'?')).'/login_with_twitter.php';

	$client->client_id = TWITTER_CONSUMER_KEY; $application_line = __LINE__;
	$client->client_secret = TWITTER_CONSUMER_SECRET;

	if(strlen($client->client_id) == 0 || strlen($client->client_secret) == 0)
            die('Please go to Twitter Apps page https://dev.twitter.com/apps/new , '.
                'create an application, and in the line '.$application_line.
                ' set the client_id to Consumer key and client_secret with Consumer secret. '.
                'The Callback URL must be '.$client->redirect_uri.' If you want to post to '.
                'the user timeline, make sure the application you create has write permissions');

	if(($success = $client->Initialize())) {
            if(($success = $client->Process())) {
                if(strlen($client->access_token)) {
                    $success = $client->CallAPI(
                        'https://api.twitter.com/1.1/account/verify_credentials.json', 
                        'GET', array(), array('FailOnAccessError'=>true), $user);
                }
            }
            $success = $client->Finalize($success);
	}
	if($client->exit) {
            exit;
        }
	if ($success) {
            $_SESSION["access_token"] = $client->access_token;
            $_SESSION["access_token_secret"] = $client->access_token_secret;
            $_SESSION["client_id"] = $client->client_id;
            $_SESSION["client_secret"] = $client->client_secret;
            $_SESSION["id"] = $user->id;
            $_SESSION["name"] = $user->name;
            $_SESSION["screen_name"] = $user->screen_name;
            header("Location: dashboard.php");
	} else {
            session_destroy();
            header("Location: ${$client->redirect_uri}");
	}

?>