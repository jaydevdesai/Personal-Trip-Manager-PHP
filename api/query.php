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

function post_reply($request) {
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

?>