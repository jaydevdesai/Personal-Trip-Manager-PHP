<?php

function upload_reservation($request) {
    global $config;
    if (!(isset($request['post']['reservation_name'])
    && isset($request['files']['reservation_image'])
    && isset($request['post']['trip_id']))) {
        return response(array(
            "message" => "Please pass all parameters"
        ), 400);
    }

    $imageFileType = strtolower(pathinfo($request['files']["reservation_image"]["name"],PATHINFO_EXTENSION));
    $target_file_name = 'reservation_' . time() . '.' . $imageFileType;
    $target_file_path = $config['reservations_dir'] . $target_file_name;

    if (!move_uploaded_file($request['files']['reservation_image']['tmp_name'], $target_file_path)) {
        return response(array(
            "message" => "Error occured while uploading file"
        ), 500);
    }
    $reservation_name = $request['post']['reservation_name'];

    $query = 'INSERT INTO user_reservations (trip_id, reservation_name, reservation_image) VALUES (?, ?, ?)';
    $res = execute_sql($query, $request['post']['trip_id'], $reservation_name, $target_file_name);
    if ($res->errno != 0) {
        return response(array(
            "message" => "error while executing sql",
            "description" => $res->error
        ), 500);
    }

    return response(array(
        "message" => "Reservation uploaded successfully",
    ));
}

function get_reservations($request) {
    global $config;
    if (!isset($request['post']['trip_id'])) {
        return response(array(
            "message" => "Please pass all parameters"
        ), 400);
    }
    $query = 'SELECT * FROM user_reservations WHERE trip_id=?';
    $res = execute_sql($query, $request['post']['trip_id']);
    if ($res->errno != 0) {
        return response(array(
            "message" => "error while executing sql",
            "description" => $res->error
        ), 500);
    }
    $res = $res->get_result();

    $reservations = mysqli_get_array($res);
    for($i = 0; $i < count($reservations); $i++) {
        unset($reservations[$i]['user_id']);
        $reservations[$i]['reservation_image'] = $config['base_url'] . $config['reservations_dir'] . $reservations[$i]['reservation_image'];
    }
    return response(array(
        "message" => "Reservations fetch successfully",
        "reservations" => $reservations
    ));
}

?>