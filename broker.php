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
	    echo get_userinfo($request['username']);
            return get_userinfo($request['username']);
        case "register":
            return doRegister($request['username'], $request['password']);
        case "validate_session":
            return doValidate($request['sessionId']);
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
