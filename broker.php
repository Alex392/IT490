#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('login.php.inc');
require_once('functions.inc');

<<<<<<< HEAD
function get_userinfo($username)
{
$name = $username;
echo ('the is $name!!!!!' . $name);
exec("python USER_INFO.py '".$name."'" ,$output,$result);
return $output;
}

=======
function start_campaign($username, $password, $subreddit, $topic)
{
    $command = '/bin/usr/python2.7 START_CAMPAIGN.py ' . $username . " " . $password . " " . $subreddit . " " . $topic;
    $output = shell_exec($command);
}

function doRegister($username, $password)
{
    $result = true;

    return $result;
}
>>>>>>> 28f02917946baf43f52e0960461074c312c5c700

function requestProcessor($request)
{
    echo "received request" . PHP_EOL;
    var_dump($request);
    
    
    if (!isset($request['type'])) {
        return "ERROR: unsupported message type";
    }
    switch ($request['type']) {
<<<<<<< HEAD
        case "user_info":
            return get_userinfo($request['username']);
        case "register":
=======
        case "campaign":
            return start_campaign($request['username'], $request['password'], $request['subreddit'], $request['topic']);
        case "agg_thread":
>>>>>>> 28f02917946baf43f52e0960461074c312c5c700
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
