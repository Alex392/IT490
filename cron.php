#!/usr/bin/php
<?php

function new_campaign_entry($subreddit, $subject, $content, $hour)
{
    $date = date('Y-m-d\TH:i:sP', time());
    $entry = array ($subreddit, $subject, $content, $hour, $date);

    $file = fopen('autopost.csv', 'a');
    fputcsv($file, $entry);
    fclose($file);
}
new_campaign_entry('TheTestLife','Test','Bob',1);

$file = fopen('autopost.csv', 'r');

while (($line = fgetcsv($file)) !== false) {
    print_r($line);

    $date = date('Y-m-d\TH:i:sP', time());
    $date = date_create($date);
    $date2 = date_create($line[4]);
    echo gettype($date2);
    $diff = $date->diff($date2);

    $hours = $diff->h;

    if($hours >= $line[3]) {
        echo exec("python SUBREDDIT_POST.py '".$line[0]."' '".$line[1]."' '".$line[2]."'", $output, $result);
    }

}
fclose($file);
?>