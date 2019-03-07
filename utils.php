<?php

$dbConnection = NULL;

function response($data, $status = 200) {
    return array(
        "status" => $status,
        "data" => $data
    );
}

function execute_sql($sql, ...$args) {
    global $config;
    global $dbConnection;
    if (!isset($dbConnection)) {
        $dbConnection = mysqli_connect($config['host'], $config['username'], $config['password'], $config['database']);
        if (!$dbConnection) {
            throw new Exception("Connection failed: " . mysqli_connect_error());
        }
    }
    $stmt = $dbConnection->prepare($sql);
    $s = '';
    foreach ($args as $arg) {
        $s .= 's';
    }
    if (count($args) > 0) {
        $stmt->bind_param($s, ...$args);
    }

    $stmt->execute();

    return $stmt;
}

function render_response_and_exit($response, $status = 200) {
    http_response_code($status);
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

function get_authorization_header() {
    $headers = apache_request_headers();
    if (!isset($headers['Authorization'])) {
        return false;
    }
    return $headers['Authorization'];
}

function mysqli_get_array($res) {
    $arr = array();
    while ($row = mysqli_fetch_assoc($res)) {
        array_push($arr, $row);
    }
    return $arr;
}

?>