<?php
function connect(){

$dbconfig = [
    'username'=> 'root',
    'password'=> '',
    'host'=> 'localhost',
    'database'=> 'csc'
];

    $db = new mysqli($dbconfig['host'], $dbconfig['username'], $dbconfig['password'], $dbconfig['database']);

    if($db->connect_error){
        trigger_error('Unable to connect: ' . $db->connect_errno);
    }

    return $db;
}
