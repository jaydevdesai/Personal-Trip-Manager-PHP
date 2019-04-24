<?php

function post_query($request) {
    if (!isset($request['post']['query_text'])) {
        return response(array(
            "message" => "Please pass all parameters"
        ), 400);
    }
    $query_text = $request['post']['query_text'];
    $res = execute_sql("INSERT INTO user_query (user_id, query_text) VALUES (?, ?)", $request['user_id'], $query_text);

    if ($res->errno != 0) {
        return response(array(
            "message" => "error while executing sql",
            "description" => $res->error
        ), 500);
    }

    return response(array(
        "message" => "Query posted"
    ));
}

function post_query_reply($request) {
    if (!(isset($request['post']['query_id']) && isset($request['post']['reply_text']))) {
        return response(array(
            "message" => "Please pass all parameters"
        ), 400);
    }
    $query_id = $request['post']['query_id'];
    $reply_text = $request['post']['reply_text'];
    $res = execute_sql("INSERT INTO query_replies (query_id, replier_id, reply_text) VALUES (?, ?, ?)", $query_id, $request['user_id'], $reply_text);

    if ($res->errno != 0) {
        return response(array(
            "message" => "error while executing sql",
            "description" => $res->error
        ), 500);
    }

    return response(array(
        "message" => "Reply posted"
    ));
}

function get_queries($request) {
    $res = execute_sql("SELECT query_id, query_text, email, user_details.name, user_query.creation_time FROM user_query
    INNER JOIN user_login ON user_query.user_id = user_login.id
    LEFT JOIN user_details ON user_query.user_id = user_details.user_id
    ORDER BY user_query.creation_time DESC");

    if ($res->errno != 0) {
        return response(array(
            "message" => "error while executing sql",
            "description" => $res->error
        ), 500);
    }

    $res = $res->get_result();

    $queries = mysqli_get_array($res);

    return response(array(
        "message" => "Queries fetch successfully",
        "queries" => $queries
    ));
}

function get_user_queries($request) {
	
    $res = execute_sql("SELECT query_id, query_text, email, user_details.name, user_query.creation_time FROM user_query
	INNER JOIN user_login ON user_query.user_id = user_login.id
    LEFT JOIN user_details ON user_query.user_id = user_details.user_id where user_query.user_id = ?
    ORDER BY user_query.creation_time DESC",$request['user_id']);

    if ($res->errno != 0) {
        return response(array(
            "message" => "error while executing sql",
            "description" => $res->error
        ), 500);
    }

    $res = $res->get_result();

    $queries = mysqli_get_array($res);

    return response(array(
        "message" => "Queries fetch successfully",
        "queries" => $queries
    ));
}

function delete_query($request){
	if (!isset($request['post']['queryId'])) {
        return response(array(
            "message" => "Please pass all parameters"
        ), 400);
    }
	$queryId = $request['post']['queryId'];
	
	$res = execute_sql("DELETE FROM user_query WHERE query_id =? and user_id =?", $queryId, $request['user_id']);

    if ($res->errno != 0) {
        return response(array(
            "message" => "error while executing sql",
            "description" => $res->error
        ), 500);
    }

    return response(array(
        "message" => "Query Deleted."
    ));
}

function delete_query_reply($request){
	if (!isset($request['post']['queryReplyId'])) {
        return response(array(
            "message" => "Please pass all parameters"
        ), 400);
    }
	$queryReplyId = $request['post']['queryReplyId'];
	
	$res = execute_sql("DELETE FROM query_replies WHERE id =? and replier_id =?", $queryReplyId, $request['user_id']);

    if ($res->errno != 0) {
        return response(array(
            "message" => "error while executing sql",
            "description" => $res->error
        ), 500);
    }

    return response(array(
        "message" => "Query Reply Deleted."
    ));
}

function get_query_replies($request) {
    if (!isset($request['post']['query_id'])) {
        return response(array(
            "message" => "Please pass all parameters"
        ), 400);
    }
    $query_id = $request['post']['query_id'];
    $res = execute_sql("SELECT query_replies.id, reply_text, email, name, query_replies.creation_time FROM query_replies
    INNER JOIN user_login ON query_replies.replier_id = user_login.id
    LEFT JOIN user_details ON query_replies.replier_id = user_details.user_id
    WHERE query_id = ?", $query_id);

    if ($res->errno != 0) {
        return response(array(
            "message" => "error while executing sql",
            "description" => $res->error
        ), 500);
    }

    $res = $res->get_result();

    $replies = mysqli_get_array($res);

    return response(array(
        "message" => "Reply fetch successfully",
        "replies" => $replies
    ));
}

?>