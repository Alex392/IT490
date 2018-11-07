#!/usr/bin/php
<?php
    $file = fopen('autopost.csv', 'r');
    while (($line = fgetcsv($file)) !== FALSE) {
      print_r($line);

      exec("python SUBREDDIT_POST.py '".$line[0]."' '".$line[1]."' '".$line[2]."'" ,$output,$result);
    }
    fclose($file);
?>