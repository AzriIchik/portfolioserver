<?php

$app->get('/employment', function ($request, $response) {

    global $db_conn;

    $query = "SELECT employment_certurl, employment_desc, employment_id, employment_place, employment_position, employment_xtradesc, employment_startdate, employment_enddate FROM employment";

    if ($stmt = mysqli_prepare($db_conn, $query)) {
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $response->status(200);
        $response->send(json_encode($result), array('Content-type' => 'application/json'));
    } else {
        $response->status(200);
        $response->send(json_encode(array('message' => 'error')), array('Content-type' => 'application/json'));
    }

});


$app->get('/employment/[:id]', function ($request, $response) {

    global $db_conn;

    $query = "SELECT employment_certurl, employment_desc, employment_id, employment_place, employment_position, employment_xtradesc, employment_startdate, employment_enddate FROM employment WHERE employment_id=" . $request->params['id'];
    $stmt = mysqli_prepare($db_conn, $query);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $response->status(200);
    $response->send(json_encode($result), array("Content-type" => "application/json"));

});

$app->post('/employment', function ($request, $response) {

    global $db_conn;

    $certurl = $request->body['certurl'];
    $desc = $request->body['desc'];
    $place = $request->body['place'];
    $position = $request->body['position'];
    $xtradesc = $request->body['xtradesc'];
    $startdate = $request->body['startdate'];
    $enddate = $request->body['enddate'];

    $query = "INSERT INTO employment(employment_place, employment_position, employment_desc, employment_xtradesc, employment_certurl, employment_startdate, employment_enddate ) VALUES (?,?,?,?,?,?,?)";

    $stmt = mysqli_prepare($db_conn, $query);
    mysqli_stmt_bind_param($stmt, 'sssssss', $place, $position, $desc, $xtradesc, $certurl, $startdate, $enddate);

    if (mysqli_stmt_execute($stmt)) {
        $response->status(200);
        $response->send(
            json_encode(
                array(
                    'message' => "approved"
                )
            ),
            array("Content-type" => "application/json")
        );
    } else {
        $response->status(400);
        $response->send(
            json_encode(
                array(
                    'message' => "invalid",
                )
            ),
            array("Content-type" => "application/json")
        );
    }
});

$app->put('/employment/[:id]', function ($request, $response) {


    global $db_conn;
    file_get_contents("php://input"); // since put write from php input stream, we read this file
    parse_str(file_get_contents("php://input"), $put_data);

    $certurl = $put_data['certurl'];
    $desc = $put_data['desc'];
    $place = $put_data['place'];
    $position = $put_data['position'];
    $xtradesc = $put_data['xtradesc'];
    $startdate = $put_data['startdate'];
    $enddate = $put_data['enddate'];

    $query = "UPDATE employment SET employment_place=?, employment_position=?, employment_desc=?, employment_xtradesc=?, employment_certurl=?, employment_startdate=?, employment_enddate=? WHERE employment_id=" . $request->params['id'];
    $stmt = mysqli_prepare($db_conn, $query);
    mysqli_stmt_bind_param($stmt, 'sssssss', $place, $position, $desc, $xtradesc, $certurl, $startdate, $enddate);

    if (mysqli_stmt_execute($stmt)) {
        $response->status(200);
        $response->send(
            json_encode(array("message" => "approved")),
            array("Content-type" => "application/json")
        );

    } else {
        $response->status(400);
        $response->send(
            json_encode(
                array("message" => $request->body)
            ),
            array("Content-type" => "application/json")
        );
    }

});

$app->delete('/employment/[:id]', function ($request, $response) {

    global $db_conn;

    $query = "DELETE FROM employment WHERE employment_id=" . $request->params['id'];
    $stmt = mysqli_prepare($db_conn, $query);
    if (mysqli_stmt_execute($stmt)) {
        $response->status(200);
        $response->send(
            json_encode(array("message" => "approved")),
            array("Content-type" => "application/json")
        );

    } else {
        $response->status(400);
        $response->send(
            json_encode(
                array("message" => $stmt->error)
            ),
            array("Content-type" => "application/json")
        );
    }
});

$app->options('/employment', function ($request, $response) {
    $response->set('Access-Control-Allow-Methods', 'POST');
    $response->set('Access-Control-Allow-Headers', 'Authorization');
    $response->status(200);
});

$app->options('/employment/[:id]', function ($request, $response) {
    
    $response->set('Access-Control-Allow-Methods', 'DELETE, PUT');
    $response->set('Access-Control-Allow-Headers', 'Authorization');
    $response->status(200);
    
});

?>