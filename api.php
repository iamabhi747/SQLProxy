<?php

if ($_SERVER["REQUEST_METHOD"] != 'POST')
{
    http_response_code(405);
    exit();
}
// Contentent type == application/json

$data = json_decode(file_get_contents('php://input'));
if (!isset($data->query))
{
    // Query required
    echo '{"error":"Query Required"}';
    // http_response_code(400);
    exit();
}

if (!isset($data->token))
{
    echo '{"error":"Auth token Required"}';
    exit();
}


// Collect Parameters
$parameters = [];
$i = 1;
$parm_name = 'parm' . $i;
while (isset($data->$parm_name))
{
    $parameters[] = $data->$parm_name;

    $i++;
    $parm_name = 'parm' . $i;
}


// Connect
include 'auth.php';
$db = auth_database($data->token);

if (!$db->connected)
{
    echo '{"error":"Failed to connect database"}';
    // http_response_code(500);
    exit();
}

// Excute
try {
    $result = $db->excute($data->query, $parameters);

} catch (Throwable $th) {

    echo '{"error":"Failed to excute"}';
    // http_response_code(400);
    exit();
}

// Send Results
echo '{"result":'. json_encode($result) . '}'

?>