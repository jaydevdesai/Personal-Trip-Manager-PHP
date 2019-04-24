<?php
$routes = array(
    "/login" => "user.login",
    "/sign_up" => "user.sign_up"
);

$auth_routes = array(
    "/get_trips" => "trip.get_trips",
    "/create_trip" => "trip.create_trip",
    "/edit_trip" => "trip.edit_trip",
    "/delete_trip" => "trip.delete_trip",

    "/post_query" => "query.post_query",
    "/get_queries" => "query.get_queries",
    "/get_user_queries" => "query.get_user_queries",
    "/delete_query" => "query.delete_query",

    "/post_query_reply" => "query.post_query_reply",
    "/get_query_replies" => "query.get_query_replies",
    "/delete_query_reply" => "query.delete_query_reply",
    
    "/get_note" => "notes.get_note",
    "/update_note" => "notes.update_note",

    "/get_documents" => "document.get_documents",
    "/upload_document" => "document.upload_document",

    "/get_reservations" => "reservation.get_reservations",
    "/upload_reservation" => "reservation.upload_reservation",
	
    "/get_profile" => "user.get_profile",
    "/set_profile" => "user.set_profile",
    "/update_profile" => "user.update_profile",
    "/change_password" => "user.change_password",
	
    "/add_cash" => "expense.add_cash",
    "/add_expense" => "expense.add_expense",
    "/get_expense" => "expense.get_expense",

    "/add_shopping_item" => "shopping.add_shopping_item",
    "/get_shopping_list" => "shopping.get_shopping_list",
    "/delete_shopping_item" => "shopping.delete_shopping_item",

    "/get_explore_trips" => "explore.get_explore_trips"
);
?>