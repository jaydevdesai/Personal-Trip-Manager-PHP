<?php
$routes = array(
    "/login" => "user.login",
    "/sign_up" => "user.sign_up"
);

$auth_routes = array(
    "/get_trips" => "trip.get_trips",
    "/create_trip" => "trip.create_trip",

    "/post_query" => "query.post_query",
    "/post_reply" => "query.post_reply",
    "/get_queries" => "query.get_queries",
    "/get_replies" => "query.get_replies"
);
?>