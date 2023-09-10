<?php
include 'database.php';

function auth_database($token)
{
    $server_db = new Database('localhost', 'hw', 'root', '');
    if (!$server_db->connected)
    {
        echo '{"error":"Something Went Wrong on Server"}';
        http_response_code(500);
        exit();
    }

    $rows = $server_db->excute('SELECT `dbname`,`username`,`password` FROM `TOKENS` WHERE `token`=?', [$token]);
    if (sizeof($rows) == 0)
    {
        echo '{"error":"Invalid Auth token"}';
        exit();
    }

    $dbname   = $rows[0]["dbname"];
    $username = $rows[0]["username"];
    $password = $rows[0]["password"];

    $db = new Database('localhost', $dbname, $username, $password);
    return $db;
}

?>