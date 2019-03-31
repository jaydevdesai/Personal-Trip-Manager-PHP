<?php
    function add_shopping_item($request) {
        if (!(isset($request['post']['trip_id']) && isset($request['post']['item_name'])
            && isset($request['post']['bought']))) {
            return response(array("message" => "Please pass all parameters"), 400);
        }

        $trip_id = $request['post']['trip_id'];
		$item_name = $request['post']['item_name'];
        $bought = $request['post']['bought'];
        $bought = filter_var($bought, FILTER_VALIDATE_BOOLEAN);
        
        $sql = "INSERT INTO user_shopping (trip_id, item_name, bought) VALUES (?, ?, ?)";
        $res = execute_sql($sql, $trip_id, $item_name, $bought);

		if ($res->errno != 0) {
			return response(array(
				"message" => "error while executing sql",
				"description" => $res->error
			), 500);
		}

        return response(array(
            "message" => "Item added"
        ));
    }

    function get_shopping_list($request) {
        if (!isset($request['post']['trip_id'])) {
            return response(array("message" => "Please pass all parameters"), 400);
        }
		$trip_id = $request['post']['trip_id'];
		$res = execute_sql('SELECT * FROM user_shopping WHERE trip_id=?', $trip_id);
        if ($res->errno != 0) {
            return response(array(
                "message" => "error while executing sql",
                "description" => $res->error
            ), 500);
        }
        $res = $res->get_result();
        $shopping_list = array();
		while($row = mysqli_fetch_assoc($res)) {
            unset($row['trip_id']);
            $row['bought'] = filter_var($row['bought'], FILTER_VALIDATE_BOOLEAN);
            array_push($shopping_list, $row);
        }
        return response(array(
            "message" => "Shopping list fetch successfully",
            "shopping_list" => $shopping_list
        ));
    }

    function delete_shopping_item($request) {
        if (!isset($request['post']['item_id'])) {
            return response(array("message" => "Please pass all parameters"), 400);
        }

        $item_id = $request['post']['item_id'];
        
        $sql = "DELETE FROM user_shopping WHERE id=?";
        $res = execute_sql($sql, $item_id);

		if ($res->errno != 0) {
			return response(array(
				"message" => "error while executing sql",
				"description" => $res->error
			), 500);
		}

        return response(array(
            "message" => "Item deleted"
        ));
    }

?>