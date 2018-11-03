#!/usr/bin/php
<?php
require_once('rabbitMQLib.inc');
/*
function log_message($request)
{
    $log_file = fopen($log, "a+");
    $message = "";
    $keys = array_keys($array);
    $key = current($keys);
    $written = "";

    $s = "ID: " . $log_id . "\n";
    fwrite($log_file, $s);
    $written .= $s;
    foreach ($request as &$value) {
        $s = "\t" . $key . ": " . $value . "\n";
        fwrite($log_file, $s);
        $key = next($keys);
        $written .= $s;
    }

    fwrite($log_id, "END " . $log_id . ":\n");
    $log_id++;

    return $written;
}

*/ 
function log_api_data($userinfo) {
    $db = new mysqli('192.168.0.124', 'emile', 'Password7!', 'authtest');
    $s = "SELECT * FROM reddit_data WHERE redditorID ='". $userinfo[3] . "';";
    ($t = mysqli_query($db, $s) or die(mysqli_errno($db))); 
    $num = mysqli_num_rows($t);
    echo $num;
    if ($num == 1){
	echo "already exists";
        $result = true;
    }
    else {
	echo var_dump($userinfo);
	$fuck = 0;
	if ($userinfo[5] == 'True'){
		$fuck = 1;	
	}
	echo ($fuck);
        $s = "INSERT INTO reddit_data VALUES('".$userinfo[3]."', '".$userinfo[2]."', CAST('". $userinfo[4] ."' AS DATE), " . $fuck . ");";
	echo $s;
        $t = (mysqli_query($db, $s) or die(mysqli_errno($db)));
	echo "recorded in database";
	$result = true;
    
    }
    echo $result;
    return $result;
}
?>
