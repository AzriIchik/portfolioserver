<?php
$app->get('/skill', function ($request, $response) {

    global $db_conn;

    $query = "SELECT skill_id, skill_name, skill_proficiency, skill_category FROM skill";
    $stmt = mysqli_prepare($db_conn, $query);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $response->status(200);
    $response->send(json_encode($result), array('Content-type' => 'application/json'));

});

$app->get('/skill/[:id]', function ($request, $response) {

    global $db_conn;

    $query = "SELECT skill_id, skill_name, skill_proficiency, skill_category FROM project WHERE project_id=" . $request->params['id'];
    $stmt = mysqli_prepare($db_conn, $query);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $response->status(200);
    $response->send(json_encode($result), array("Content-type" => "application/json"));

});

$app->post('/skill', function ($request, $response) {

    global $db_conn;

    $name = $request->body['name'];
    $proficiency = $request->body['proficiency'];
    $category = $request->body['category'];

    $query = "INSERT INTO skill(skill_name, skill_proficiency, skill_category) VALUES (?,?,?)";

    $stmt = mysqli_prepare($db_conn, $query);
    mysqli_stmt_bind_param($stmt, 'sss', $name, $proficiency, $category);

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

$app->put('/skill/[:id]', function ($request, $response) {


    global $db_conn;
    file_get_contents("php://input"); // since put write from php input stream, we read this file
    parse_str(file_get_contents("php://input"),$put_data);

    $name = $put_data['name'];
    $proficiency = $put_data['proficiency'];
    $category = $put_data['category'];

    $query = "UPDATE skill SET skill_name=?, skill_proficiency=?, skill_category=? WHERE skill_id=" . $request->params['id'];
    $stmt = mysqli_prepare($db_conn, $query);
    mysqli_stmt_bind_param($stmt, 'sss', $name, $proficiency, $category);

    if (mysqli_stmt_execute($stmt)) {
        $response->status(200);
        $response->send(
            json_encode(array("message" =>  "approved")),
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

$app->delete('/skill/[:id]', function ($request, $response) {

    global $db_conn;

    $query = "DELETE FROM skill WHERE skill_id=" . $request->params['id'];
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

$app->options('/skill', function ($request, $response) {
    $response->set('Access-Control-Allow-Methods', 'POST');
    $response->set('Access-Control-Allow-Headers', 'Authorization');
    $response->status(200);
});

$app->options('/skill/[:id]', function ($request, $response) {
    
    $response->set('Access-Control-Allow-Methods', 'DELETE, PUT');
    $response->set('Access-Control-Allow-Headers', 'Authorization');
    $response->status(200);
    
});

?>