<?php
require 'ChatAPI/events/MyEvents.php';
require 'ChatAPI/whatsprot.class.php';
function onMessage($mynumber, $from, $id, $type, $time, $name, $body)
{
    echo "Message from $from: $name:\n$body\n\n";
}

$username = "60177002929";
$nickname = "ressphere";
$password = "6AH6VErDZ/lXPbDEiGk44D3zCKM="; // HVdfWdIXo+O88+DeCWFEyH2QGfw=
$identity = "";
$debug = true;
$log = true;

$w = new WhatsProt($username, $nickname, $debug, $log);
$events = new MyEvents($w);
$events->setEventsToListenFor($events->activeEvents); //You can also pass in your own array with a list of events to listen too instead.

//Now continue with your script.
$w->connect();
$w->loginWithPassword($password);

$target = '60125211031'; // The number of the person you are sending the message
$message = 'Hi! :) this is a test message';

$w->sendMessage($target , $message);



?>
