<?php
function login($request)
{
    if (!(isset($request['post']['email'])
        && isset($request['post']['password']))) {
        return response(array(
            "message" => "Please pass email and password"
        ), 400);
    }
    $email = $request['post']['email'];
    $password = $request['post']['password'];

    $md5_pass = md5($password);

    $res = execute_sql('SELECT * FROM user_login WHERE email= ? and password= ?', $email, $md5_pass)->get_result();

    $n = mysqli_num_rows($res);
    if ($n != 1) {
        return response(array(
            "message" => "incorrect email or password"
        ), 400);
    }
    
    $user = mysqli_fetch_assoc($res);
    $token = bin2hex(random_bytes(16));
    execute_sql("update user_login set access_token=? where id = ?", $token, $user['id']);

    return response(array(
        "email"=> $user['email'],
        "access_token" => $token
    ));
}

function sign_up($request) {
    if (!(isset($request['post']['email'])
        && isset($request['post']['password']))) {
        return response(array(
            "message" => "Please pass email and password"
        ), 400);
    }
    $email = $request['post']['email'];
    $password = $request['post']['password'];
    $md5_pass = md5($password);
    $res = execute_sql('INSERT INTO user_login (email, password) VALUES (?, ?)', $email, $md5_pass);
    if ($res->errno != 0) {
        if ($res->errno == 1062) {
            return response(array(
                "message" => "email already exists"
            ), 400);
        } else {
            return response(array(
                "message" => "error while executing sql",
                "description" => $res->error
            ), 500);
        }
    }
    $token = bin2hex(random_bytes(16));
    execute_sql("UPDATE user_login SET access_token=? WHERE id = ?", $token, $res->insert_id);
    return response(array(
        "email"=> $email,
        "access_token" => $token
    ));
}
?>