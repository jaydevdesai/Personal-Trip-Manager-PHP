<?php
function add_cash($request){
	if (!(isset($request['post']['cashBalance']) && isset($request['post']['tripId']))) {
        return response(array(
            "message" => "Please pass all parameters"
        ), 400);
    }
    $cashBalance = $request['post']['cashBalance'];
    $tripId = $request['post']['tripId'];
    $res = execute_sql("INSERT INTO expense_details (trip_id, cash_balance) VALUES (?, ?)", $tripId, $cashBalance);

    if ($res->errno != 0) {
        return response(array(
            "message" => "error while executing sql",
            "description" => $res->error
        ), 500);
    }

    return response(array(
        "message" => "Cash added."
    ));
}

function add_expense($request){
	if(!(isset($request['post']['name']) && isset($request['post']['tripId']) 
		&& isset($request['post']['price']) && isset($request['post']['cash']) 
	&& isset($request['post']['purchaseDate']))) {
        return response(array(
            "message" => "Please pass all parameters"
        ), 400);
    }
    $name = $request['post']['name'];
    $tripId = $request['post']['tripId'];
    $price = $request['post']['price'];
    $cash = $request['post']['cash'];
    $purchaseDate = $request['post']['purchaseDate'];
	
    $res = execute_sql("INSERT INTO user_expenses (trip_id, name, price, cash, purchase_date) VALUES (?, ?, ?, ?, ?)", $tripId, $name, $price, $cash, $purchaseDate);

    if ($res->errno != 0) {
        return response(array(
            "message" => "error while executing sql",
            "description" => $res->error
        ), 500);
    }

    return response(array(
        "message" => "Expense added."
    ));
}

function get_expense($request){
	if (!isset($request['post']['tripId'])) {
        return response(array(
            "message" => "Please pass all parameters"
        ), 400);
    }
    $tripId = $request['post']['tripId'];
    $res = execute_sql("SELECT cash_balance FROM expense_details WHERE trip_id = ?", $tripId)->get_result();

    if (!$res) {
        return response(array(
            "message" => "Error while executing sql",
        ), 500);
    }
	
	$n = mysqli_num_rows($res);
    if ($n != 1) {
        return response(array(
            "cash_balance" => -1
		));
    }

	$res1 = $res->fetch_assoc()['cash_balance'];
	$res = execute_sql("SELECT id, name, price, cash, purchase_date FROM user_expenses WHERE trip_id = ?", $tripId);

    if ($res->errno != 0) {
        return response(array(
            "message" => "error while executing sql",
            "description" => $res->error
        ), 500);
    }
    $res = $res->get_result();
    $expenses = mysqli_get_array($res);

    return response(array(
        "message" => "Reply fetch successfully",
        "cash_balance" => $res1,
        "expenses" => $expenses
    ));
}


?>