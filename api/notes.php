<?php
	function get_note($request) {
		if (!(isset($request['post']['tripId']))) {
			return response(array("message" => "Please pass all parameters"), 400);
		}
		$tripId = $request['post']['tripId'];
		$res = execute_sql('SELECT * FROM user_notes WHERE trip_id=?', $tripId)->get_result();
		if (!$res) {
			return response(array(
				"message" => "Error executing database operation"
			), 500);
		}
		
		while($row = mysqli_fetch_assoc($res)) {
			unset($row['user_id']);
			return response(array(
				"message" => "Note fetch successfully",
				"note" => $row
			));
		}
		return response(array(
			"message" => "No notes"
		));
	}
	
	function update_note($request){
		if (!(isset($request['post']['tripId']) && isset($request['post']['noteId'])
			&& isset($request['post']['noteText']))) {
			return response(array("message" => "Please pass all parameters"), 400);
		}
		
		$tripId = $request['post']['tripId'];
		$noteId = $request['post']['noteId'];
		$noteText = $request['post']['noteText'];
		
		$res = execute_sql('INSERT INTO user_notes (trip_id, note_text) VALUES (?, ?) ON DUPLICATE KEY UPDATE note_text=?', $tripId, $noteText, $noteText);
		
		if ($res->errno != 0) {
			return response(array(
				"message" => "error while executing sql",
				"description" => $res->error
			), 500);
		}
		
		return response(array(
        "message" => "Note Saved"
		));
	}
	
?>