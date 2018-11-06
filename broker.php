#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('login.php.inc');
require_once('functions.inc');
/*
*/

function get_userinfo($username)
{
    echo ('Getting profile information for ' . $name . '...');
    exec("python USER_INFO.py '".$name."'" ,$output,$result);
    echo log_api_data($output);
    return $output;
}

// function start_campaign($username, $password, $subreddit, $topic)
// {
//     echo ('Starting campaign on user ' . $username . ' on ' . $topic . '...');
//     exec("python START_CAMPAGIN.py '".$username."' '".$topic."'" ,$output,$result);
//     return $output;
// }

function subreddit_post($subreddit, $subject, $content) {
    echo ('Posting ' . $subject . ' on subreddit ' . $subreddit . '...');
    exec("python SUBREDDIT_POST.py '".$subreddit."' '".$subject."' '".$content."'" ,$output,$result);
    return $output;
}

function key_players($postID) {
    echo ('');
    exec("python SUBREDDIT_POST.py '".$name."' '".$topic."'" ,$output,$result);
    return $output;
}

function requestProcessor($request)
{
    echo "received request" . PHP_EOL;
    var_dump($request);
    
    
    if (!isset($request['type'])) {
        return "ERROR: unsupported message type";
    }
    switch ($request['type']) {
        case "user_info":
            return get_userinfo($request['username']);
        case "campaign":
            return start_campaign($request['username'], $request['password'], $request['subreddit'], $request['topic']);
        case "agg_thread":
            return doRegister($request['username'], $request['password']);
        case "agg_users":
            return doValidate($request['sessionId']);
        case "post":
            return post($request['username'], $request['password'], $request['topic']);
    }
    //log_message($request);
    return array(
        "returnCode" => '0',
        'message' => "Server received request and processed"
    );
}

$server = new rabbitMQServer("RabbitMQ.ini", "testServer");
echo "testRabbitMQServer BEGIN" . PHP_EOL;
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END" . PHP_EOL;
exit();
?>
