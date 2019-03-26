<?php

function upload_document($request) {
    global $config;
    if (!(isset($request['post']['document_name'])
        && isset($request['files']['document_image']))) {
        return response(array(
            "message" => "Please pass all parameters"
        ), 400);
    }

    $imageFileType = strtolower(pathinfo($request['files']["document_image"]["name"],PATHINFO_EXTENSION));
    $target_file_name = 'document_' . time() . '.' . $imageFileType;
    $target_file_path = $config['documents_dir'] . $target_file_name;

    if (!move_uploaded_file($request['files']['document_image']['tmp_name'], $target_file_path)) {
        return response(array(
            "message" => "Error occured while uploading file"
        ), 500);
    }
    $document_name = $request['post']['document_name'];

    $query = 'INSERT INTO user_documents (user_id, document_name, document_image) VALUES (?, ?, ?)';
    $res = execute_sql($query, $request['user_id'], $document_name, $target_file_name);
    if ($res->errno != 0) {
        return response(array(
            "message" => "error while executing sql",
            "description" => $res->error
        ), 500);
    }

    return response(array(
        "message" => "Document uploaded successfully",
    ));
}

function get_documents($request) {
    global $config;
    $query = 'SELECT * FROM user_documents WHERE user_id=?';
    $res = execute_sql($query, $request['user_id']);
    if ($res->errno != 0) {
        return response(array(
            "message" => "error while executing sql",
            "description" => $res->error
        ), 500);
    }
    $res = $res->get_result();

    $documents = mysqli_get_array($res);
    for($i = 0; $i < count($documents); $i++) {
        unset($documents[$i]['user_id']);
        $documents[$i]['document_image'] = $config['base_url'] . $config['documents_dir'] . $documents[$i]['document_image'];
    }
    return response(array(
        "message" => "Documents fetch successfully",
        "documents" => $documents
    ));
}

?>