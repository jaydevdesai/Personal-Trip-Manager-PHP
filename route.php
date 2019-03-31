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
    "/get_query_replies" => "query.get_query_replies",
    
    "/get_note" => "notes.get_note",
    "/update_note" => "notes.update_note",

    "/get_documents" => "document.get_documents",
    "/upload_document" => "document.upload_document",

    "/get_reservations" => "reservation.get_reservations",
    "/upload_reservation" => "reservation.upload_reservation",

    "/add_shopping_item" => "shopping.add_shopping_item",
    "/get_shopping_list" => "shopping.get_shopping_list",
    "/delete_shopping_item" => "shopping.delete_shopping_item"
);
?>