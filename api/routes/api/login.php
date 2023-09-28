<?php 
$app->post('/login', function ($request, $response) {

    global $db_conn;

    $loginCredentials = json_decode($request->body['data']);

    //AUTO LOGIN
    $query = "SELECT * FROM myprofile WHERE myprofile_authkey=?";
    $stmt = mysqli_prepare($db_conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $loginCredentials->authtoken);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result->num_rows == 1) {
        $response->status(200);
        $response->send(json_encode(array("message" => "valid token")), array("Content-type" => "application/json"));
        return;
    }

    //MANUAL LOGIN
    $query = "SELECT * FROM myprofile WHERE myprofile_email=? AND myprofile_password=? LIMIT 1";
    $stmt = mysqli_prepare($db_conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $loginCredentials->myprofile_email, $loginCredentials->myprofile_password);

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result->num_rows > 0) {

        $authToken = bin2hex(random_bytes(16));
        $query = "UPDATE myprofile SET myprofile_authkey=? WHERE myprofile_email=?";
        $stmt = mysqli_prepare($db_conn, $query);
        mysqli_stmt_bind_param($stmt, "ss", $authToken, $loginCredentials->myprofile_email);
        mysqli_stmt_execute($stmt);

        $response->status(200);
        $response->send(
            json_encode(
                array(
                    'message' => "approved",
                    'authtoken' => $authToken
                )
            ),
            array(
                'Content-type' => 'application/json'
            )
        );
    } else {
        $response->status(200);
        $response->send(
            "Fail",
            array(
                'Content-type' => 'text/plain'
            )
        );
    }
});
?>