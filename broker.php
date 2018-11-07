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
    echo ('Getting profile information for ' . $username . '...');
    exec("python USER_INFO.py '".$username."'" ,$output,$result);
    $temp = $output;    
    $output = json_encode($output);
    
    //echo gettype($output);
    //echo ('  [after decode]=> ');
    //echo gettype($temp);

    if($temp[0] != 'NULL') {
        echo log_api_data($temp);
    }
    else {
        $output = 'That user name is available';
    }
    return $output;
}

function start_campaign($subreditname, $title, $post)
{
    $space = " ";
    echo ($subreditname);
    echo ('Starting campaign on Sub-reddit ' . $subreditname . ' about ' . $title . '...');
    exec("python SUBREDDIT_POST.py '".$subreditname."' '".$title."' '".$post."'" ,$output,$result);
    $output = json_encode($output);
     
    return $output;
}

function subreddit_post($username, $password, $subreddit, $subject, $message) {
    echo ('Posting ' . $subject . ' by user ' . $username . ' on subreddit ' . $subreddit . '...');
    exec("python SUBREDDIT_POST.py '".$username."' '".$topic."'" ,$output,$result);
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
            return start_campaign($request['name'], $request['title'], $request['post']);
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
//$server = new rabbitMQServer("RMQ_Campaign.ini", "testServer");
//echo "Campaign BEGIN" . PHP_EOL;
//$server->process_requests('requestProcessor');
//echo "Campaign END" . PHP_EOL;
exit();
?>
