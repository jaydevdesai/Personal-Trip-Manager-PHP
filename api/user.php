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

function set_profile($request){
	global $config;
	
	if (!(isset($request['post']['userName'])
        && isset($request['post']['birthDate']) 
	&& isset($request['files']['profile_image']))) {
        return response(array(
            "message" => "Please pass email and password"
        ), 400);
    }
	$imageFileType = strtolower(pathinfo($request['files']["profile_image"]["name"],PATHINFO_EXTENSION));
    $target_file_name = 'profile_' . time() . '.' . $imageFileType;
    $target_file_path = $config['profiles_dir'] . $target_file_name;

    if (!move_uploaded_file($request['files']['profile_image']['tmp_name'], $target_file_path)) {
        return response(array(
            "message" => "Error occured while uploading file"
        ), 500);
    }
	
	$userName = $request['post']['userName'];
	$birthDate = $request['post']['birthDate'];

    $query = 'INSERT INTO user_details (user_id, name, image, dob) VALUES (?, ?, ?, ?)';
    $res = execute_sql($query, $request['user_id'], $userName, $target_file_name, $birthDate);
    if ($res->errno != 0) {
        return response(array(
            "message" => "error while executing sql",
            "description" => $res->error
        ), 500);
    }
	
	return response(array(
        "message" => "Profile set successfully.",
    ));
}

function update_profile($request){
	if (!(isset($request['post']['userName']) && isset($request['post']['birthDate']))) {
        return response(array(
            "message" => "Please pass all parameters"
        ), 400);
    }
	
	$userName = $request['post']['userName'];
	$birthDate = $request['post']['birthDate'];

    $query = 'UPDATE user_details SET name= ?, dob = ? where user_id = ?';
    $res = execute_sql($query,$userName, $birthDate, $request['user_id']);
    if ($res->errno != 0) {
        return response(array(
            "message" => "error while executing sql",
            "description" => $res->error
        ), 500);
    }
	
	return response(array(
        "message" => "Profile updated successfully.",
    ));
}

function get_profile($request){
	global $config;
    $query = 'SELECT * FROM user_details WHERE user_id=?';
    $res = execute_sql($query, $request['user_id'])->get_result();
	
    if (!$res) {
			return response(array(
				"message" => "Error executing database operation"
			), 500);
		}
	
    $profile = mysqli_fetch_assoc($res);
	unset($profile['user_id']);
	$profile['profile_image'] = $config['base_url'] . $config['profiles_dir'] . $profile['image'];
	
    return response(array(
        "message" => "Profile fetched successfully.",
        "profile" => $profile
    ));
}

function change_password($request){
	if (!(isset($request['post']['oldPassword']) && isset($request['post']['newPassword']))) {
        return response(array(
            "message" => "Please pass all parameters"
        ), 400);
    }
	
	$oldPassword = $request['post']['oldPassword'];
	$md5_oldPass = md5($oldPassword);
	$newPassword = $request['post']['newPassword'];
	$md5_newPass = md5($newPassword);
	
	$res = execute_sql('SELECT password FROM user_login WHERE id= ? and password= ?', $request['user_id'], $md5_oldPass)->get_result();

    $n = mysqli_num_rows($res);
    if ($n != 1) {
        return response(array(
            "message" => "Incorrect Old Password."
        ), 400);
    }
	
	$query = 'UPDATE user_login SET password= ? where id = ? and password = ?';
    $res = execute_sql($query, $md5_newPass, $request['user_id'], $md5_oldPass);
    if ($res->errno != 0) {
        return response(array(
            "message" => "error while executing sql",
            "description" => $res->error
        ), 500);
    }
	return response(array(
        "message"=> "Password Changed Successfully."
    ));
}
?>