#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('login.php.inc');
require_once('functions.inc');
require_once('cron.php');
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

function start_campaign($subredditname, $title, $post, $hour)
{
    echo ($subredditname);
    echo ('Starting campaign on Sub-reddit ' . $subredditname . ' about ' . $title . '...');
    exec("python SUBREDDIT_POST.py '".$subredditname."' '".$title."' '".$post."'" ,$output,$result);
    $output = json_encode($output);
    new_campaign_entry($subredditname, $title, $post, $hour);
    return $output;
}

function subreddit_post($username, $password, $subreddit, $subject, $message) {
    echo ('Posting ' . $subject . ' by user ' . $username . ' on subreddit ' . $subreddit . '...');
    exec("python SUBREDDIT_POST.py '".$username."' '".$topic."'" ,$output,$result);
    return $output;
}

function key_threads($topic, $limit) {
    echo ('Searching for ' . $limit . ' threads on topic: ' . $topic);
    exec("python KEY_THREADS.py '".$limit."' '".$topic."'" ,$output,$result);
    $output = json_encode($output);
    return $output;
}
function key_users($topic, $limit) {
    echo ('Searching for ' . $limit . ' users on topic: ' . $topic);
    exec("python KEY_PLAYERS.py '".$limit."' '".$topic."'" ,$output,$result);
    $output = json_encode($output);
    return $output;
}

function post_comment($id, $message) {
    echo ("Posting: '" . $message . "' on thread ID " . $id);
    exec("python POST_COMMENT.py '".$id."' '".$message."'" ,$output,$result);
    $output = json_encode($output);
    return $output;
}
function thread_id($topic) {
    echo ("Searching for: '" . $topic . "' ....");
    exec("python TITLE_ID.py '".$topic."'",$output,$result);
    $output = json_encode($output);
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
            return start_campaign($request['name'], $request['title'], $request['post'],$request['hour']);
        case "key_threads":
            return key_threads($request['keyword'], $request['limit']);
        case "key_players":
            return key_users($request['keyword'], $request['limit']);
        case "post_comment":
            return post_comment($request['id'], $request['comment']);
        case "thread_id":
            return thread_id($request['keyword']);
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
