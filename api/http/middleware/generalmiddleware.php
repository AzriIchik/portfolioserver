<?php

$checkIfLogin = function ($request, $response) {

    global $app;
    $authorizationToken = " ";
    $checkMethod = array('POST', 'PUT', 'DELETE');

    if (in_array($_SERVER['REQUEST_METHOD'], $checkMethod)) {

        global $db_conn;

        $get_route = str_replace($app->basePath, '', $_SERVER['REQUEST_URI']);
        if (str_contains($get_route, '/login'))
            return;

        $reqheader = getallheaders();
        if (isset($reqheader['Authorization'])) {
            $authorization = $reqheader['Authorization'];
            $authorization = explode(' ', $authorization);
            $authorizationToken = $authorization[1];
        }

        //AUTO LOGIN
        $query = "SELECT * FROM myprofile WHERE myprofile_authkey=?";
        $stmt = mysqli_prepare($db_conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $authorizationToken);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result->num_rows != 1) {
            $response->status(400);
            $response->send(
                json_encode(
                    array(
                        'message' => "invalid credentials"
                    )
                ),
                array("Content-type" => "application/json")
            );
            die();
        }

    }
}
    ?>