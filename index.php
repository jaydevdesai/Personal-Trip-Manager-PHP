<?php

error_reporting(-1);
ini_set('display_errors', 'On');

require('route.php');
require('config.php');
require('utils.php');

$full_url = $_SERVER['REQUEST_URI'];
$folder_name = basename(__DIR__);
$full_url = str_replace('/' . $folder_name, '', $full_url);
$route_of_url = str_replace('/index.php', '', $full_url);

if (array_key_exists($route_of_url, $routes)) {
    $route_path = $routes[$route_of_url];
    $is_auth = false;
} else if (array_key_exists($route_of_url, $auth_routes)) {
    $route_path = $auth_routes[$route_of_url];
    $is_auth = true;
} else {
    render_response_and_exit(array("error"=>"API not found"), 404);
}

$exploded_path = explode(".", $route_path);
if (count($exploded_path) < 2) {
    render_response_and_exit(array("error"=>"Route error"), 500);
}
$filename = $exploded_path[0];
$fun_name = $exploded_path[1];
require('api/'. $filename . '.php');
$request = array(
    "method"=> $_SERVER['REQUEST_METHOD'],
    "post" => $_POST
);
if ($is_auth) {
    $token = get_authorization_header();
    if (!$token) {
        render_response_and_exit(array("message"=>"authorizaion token is missing"), 401);
    }
    $res = execute_sql('SELECT * from user_login WHERE access_token = ?', $token)->get_result();
    $n = mysqli_num_rows($res);
    if ($n != 1) {
        render_response_and_exit(array("message"=>"invalid token"), 401);
    }
    $user = mysqli_fetch_assoc($res);
    $request['user_id'] = $user['id'];
}
$response = $fun_name($request);
render_response_and_exit($response['data'], $response['status']);

?>