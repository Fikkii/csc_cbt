<?php
function connect(){

//$dbconfig = [
//    'username'=> 'root',
//    'password'=> '',
//    'host'=> 'localhost',
//    'database'=> 'csc'
//];


$dbconfig = [
    'username'=> 'm4303_fikki',
    'password'=> 'Bunmisegun"2016',
    'host'=> 'mysql6.serv00.com',
    'database'=> 'm4303_csc'
];

    $db = new mysqli($dbconfig['host'], $dbconfig['username'], $dbconfig['password'], $dbconfig['database']);

    if($db->connect_error){
        trigger_error('Unable to connect: ' . $db->connect_errno);
    }

    return $db;
}
