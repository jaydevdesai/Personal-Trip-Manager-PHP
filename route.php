<?php
$routes = array(
    "/login" => "user.login",
    "/sign_up" => "user.sign_up"
);

$auth_routes = array(
    "/get_trips" => "trip.get_trips",
    "/create_trip" => "trip.create_trip",

    "/post_query" => "query.post_query",
    "/get_queries" => "query.get_queries",

    "/post_query_reply" => "query.post_query_reply",
    "/get_query_replies" => "query.get_query_replies"
);
?>