<?php
    function get_explore_trips($request) {
        if (!isset($request['post']['last_created_at'])) {
            return response(array("message" => "Please pass all parameters"), 400);
        }
        $limit = 3;
        $created_at_query = '';
        $last_created_at = $request['post']['last_created_at'];
        $created_at_exists = $last_created_at != NULL;
        if ($created_at_exists) {
            $created_at_query = "AND created_at < ?";
        }
        $query = "SELECT * FROM trip_details WHERE user_id != ? $created_at_query ORDER BY `created_at` DESC LIMIT $limit";
        if ($created_at_exists) {
            $res = execute_sql($query, $request['user_id'], $last_created_at)->get_result();
        } else {
            $res = execute_sql($query, $request['user_id'])->get_result();
        }
        if (!$res) {
            return response(array(
                "message" => "Error executing database operation"
            ), 500);
        }
        $trips = array();
        while($row = mysqli_fetch_assoc($res)) {
            array_push($trips, $row);
        }
        return response(array(
            "message" => "Trips fetch successfully",
            "trips" => $trips
        ));
    }
?>