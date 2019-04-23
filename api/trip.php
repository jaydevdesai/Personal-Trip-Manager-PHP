<?php

function get_trips($request) {
    $res = execute_sql('SELECT * FROM trip_details WHERE user_id=? ORDER BY `start_date` DESC', $request['user_id'])->get_result();
    if (!$res) {
        return response(array(
            "message" => "Error executing database operation"
        ), 500);
    }
    $trips = array();
    while($row = mysqli_fetch_assoc($res)) {
        unset($row['user_id']);
        array_push($trips, $row);
    }
    return response(array(
        "message" => "Trips fetch successfully",
        "trips" => $trips
    ));
}

function create_trip($request) {
    if (!(isset($request['post']['tripName'])
    && isset($request['post']['placeName'])
    && isset($request['post']['startDate'])
    && isset($request['post']['endDate']))) {
        return response(array(
            "message" => "Please pass all parameters"
        ), 400);
    }
    $tripName = $request['post']["tripName"];
    $placeName = $request['post']["placeName"];
    $startDate = $request['post']["startDate"];
    $endDate = $request['post']["endDate"];

    $res = execute_sql("INSERT INTO trip_details (user_id, trip_name, place_name, start_date, end_date) VALUES (?, ?, ?, ?, ?)",
        $request['user_id'],
        $tripName,
        $placeName,
        $startDate,
        $endDate);
    if ($res->errno != 0) {
        return response(array(
            "message" => "error while executing sql",
            "description" => $res->error
        ), 500);
    }
    
    //TODO: create models
    $res = execute_sql('SELECT * FROM trip_details WHERE user_id=? ORDER BY `start_date` DESC', $request['user_id'])->get_result();
    if (!$res) {
        return response(array(
            "message" => "Error executing database operation"
        ), 500);
    }
    $trips = array();
    while($row = mysqli_fetch_assoc($res)) {
        unset($row['user_id']);
        array_push($trips, $row);
    }
    return response(array(
        "message" => "Trips created successfully",
        "trips" => $trips
    ));
}

function edit_trip($request) {
    if (!(isset($request['post']['tripName'])
    && isset($request['post']['tripId'])
    && isset($request['post']['placeName'])
    && isset($request['post']['startDate'])
    && isset($request['post']['endDate']))) {
        return response(array(
            "message" => "Please pass all parameters"
        ), 400);
    }
    $tripName = $request['post']["tripName"];
    $tripId = $request['post']["tripId"];
    $placeName = $request['post']["placeName"];
    $startDate = $request['post']["startDate"];
    $endDate = $request['post']["endDate"];

    $res = execute_sql("UPDATE trip_details SET trip_name = ?, place_name = ?, start_date = ?, end_date = ? where id = ? and user_id = ?",
        $tripName,
        $placeName,
        $startDate,
        $endDate,
        $tripId,
		$request['user_id']);
		
    if ($res->errno != 0) {
        return response(array(
            "message" => "error while executing sql",
            "description" => $res->error
        ), 500);
    }
    
    $res = execute_sql('SELECT * FROM trip_details WHERE user_id=? ORDER BY `start_date` DESC', $request['user_id'])->get_result();
    if (!$res) {
        return response(array(
            "message" => "Error executing database operation"
        ), 500);
    }
    $trips = array();
    while($row = mysqli_fetch_assoc($res)) {
        unset($row['user_id']);
        array_push($trips, $row);
    }
    return response(array(
        "message" => "Trips updated successfully",
        "trips" => $trips
    ));
}

function delete_trip($request){
	if (!isset($request['post']['tripId'])) {
        return response(array(
            "message" => "Please pass all parameters"
        ), 400);
    }
	$tripId = $request['post']['tripId'];
	
	$res = execute_sql("DELETE FROM trip_details WHERE id =? and user_id =?", $tripId, $request['user_id']);

    if ($res->errno != 0) {
        return response(array(
            "message" => "error while executing sql",
            "description" => $res->error
        ), 500);
    }

    return response(array(
        "message" => "Trip Deleted."
    ));
}

?>