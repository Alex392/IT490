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
function log_api_data($userinfo)
{
    $db = new mysqli('192.168.0.124', 'emile', 'Password7!', 'authtest');
    $s = "SELECT * FROM reddit_data WHERE redditorID ='". $userinfo[3] . "';";
    ($t = mysqli_query($db, $s) or die(mysqli_errno($db)));
    $num = mysqli_num_rows($t);
    //echo $num;
    if ($num == 1) {
        echo "already exists";
        $result = true;
    } else {
        //echo var_dump($userinfo);
        $verified = 0;
        if ($userinfo[3] == 'True') {
            $verified = 1;
        }
        //echo($verified);
        $s = "INSERT INTO reddit_data VALUES('".$userinfo[1]."', '".$userinfo[0]."', CAST('". $userinfo[2] ."' AS DATE), " . $verified . ");";
        //echo $s;
        $t = (mysqli_query($db, $s) or die(mysqli_errno($db)));
        echo "recorded in database";
        $result = true;
    }
    //echo $result;
    return $result;
}
?>
