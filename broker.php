#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('login.php.inc');
require_once('functions.inc');

function get_userinfo($username)
{
    $name = $username;
    echo ('the is $name!!!!!' . $name);
    exec("python USER_INFO.py '".$name."'" ,$output,$result);
    echo log_api_data($output);
    return $output;
}

function log_api_data($userinfo) {
    $db = mysqli_connect('localhost', 'emile', 'Password7!', 'authtest');

    $s = "SELECT * FROM reddit_data WHERE redditorID ='". $userinfo[1] . "';";
    echo $s;
    ($t = mysqli_query($db, $s) or die(mysqli_errno($db))); 
    $num = mysqli_num_rows($t);
    $result = false;
    echo $num;
    if ($num == 1){
	echo "already exists";
        $result = true;
    }
    else {
        $s = "INSERT INTO reddit_data VALUES('".$userinfo[1]."', '".$userinfo[0]."', CAST('". $userinfo[2] ."' AS DATE), '".$userinfo[3]."');";
        $t = (mysqli_query($db, $s));
    
	    echo $result;
    }
    //echo $result;
    return $result;
}

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
