<?php

$app->get('/project', function ($request, $response) {

    global $db_conn;

    $query = "SELECT project_desc,project_id,project_imgurl1,project_imgurl2,project_imgurl3,project_name,project_techstack,project_link FROM project";
    $stmt = mysqli_prepare($db_conn, $query);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $response->status(200);
    $response->send(
        json_encode($result),
        array(
            'Content-type' => 'application/json'
        )
    );

});

$app->get('/project/[:id]', function ($request, $response) {

    global $db_conn;

    $query = "SELECT project_desc,project_id,project_imgurl1,project_imgurl2,project_imgurl3,project_name,project_techstack,project_link FROM project WHERE project_id=" . $request->params['id'];
    $stmt = mysqli_prepare($db_conn, $query);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $response->status(200);
    $response->send(json_encode($result), array("Content-type" => "application/json"));

});

$app->post('/project', function ($request, $response) {

    global $db_conn;
    $name = $request->body['name'];
    $desc = $request->body['desc'];
    $techstack = $request->body['techstack'];
    $link = $request->body['link'];

    $query = "INSERT INTO project(project_name,project_techstack,project_link, project_desc) VALUES (?,?,?,?)";

    $stmt = mysqli_prepare($db_conn, $query);
    mysqli_stmt_bind_param($stmt, 'ssss', $name, $techstack, $link, $desc);

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

$app->put('/project/[:id]', function ($request, $response) {

    global $db_conn;
    parse_str(file_get_contents("php://input"), $put_data);

    $name = $put_data['name'];
    $desc = $put_data['desc'];
    $techstack = $put_data['techstack'];
    $link = $put_data['link'];

    $query = "UPDATE project SET project_name=?, project_techstack=?, project_link=?, project_desc=? WHERE project_id=" . $request->params['id'];
    $stmt = mysqli_prepare($db_conn, $query);
    mysqli_stmt_bind_param($stmt, 'ssss', $name, $techstack, $link, $desc);

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

$app->delete('/project/[:id]', function ($request, $response) {

    global $db_conn;

    $query = "DELETE FROM project WHERE project_id=" . $request->params['id'];
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

/* REFACTOR THIS CODE LATER */
$app->post('/projectimg/[:id]', function ($request, $response) {
    global $db_conn;

    $proj_id = $request->body['projid'];

    $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp', 'pdf', 'doc', 'ppt'); // valid extensions
    $path = $_SERVER['DOCUMENT_ROOT'] . '/upload/image/'; // upload directory

    if ($_FILES['imageFiles']) {
        $img = $_FILES['imageFiles']['name'];
        $tmp = $_FILES['imageFiles']['tmp_name'];

        // get uploaded file's extension
        $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));

        // can upload same image using rand function
        $final_image = rand(1000, 1000000) . $img;

        // check's valid format
        if (in_array($ext, $valid_extensions)) {
            $path = $path . strtolower($final_image);
            $refPath = $_SERVER['SERVER_NAME'] . '/upload/image/' . strtolower($final_image);

            if (move_uploaded_file($tmp, $path)) {

                //echo $insert?'ok':'err';
                $query = "UPDATE project SET project_imgurl" . $request->params['id'] . "=? WHERE project_id=?";
                $stmt = mysqli_prepare($db_conn, $query);
                mysqli_stmt_bind_param($stmt, 'ss', $refPath, $proj_id);
                mysqli_stmt_execute($stmt);

                $response->status(200);
                $response->send(json_encode(array("message" => "approved")), array("Content-type" => "application/json"));
            }
        } else {
            $response->status(200);
            $response->send(json_encode(array("message" => "fail")), array("Content-type" => "text/plain"));
        }
    }

});


$app->delete('/projectimg/[:id]/[:imgid]', function ($request, $response) {

    global $db_conn;

    $imgcol = "project_imgurl" . $request->params['imgid'];
    $id = $request->params['id'];

    $query = "SELECT $imgcol FROM project WHERE project_id=?";
    $stmt = mysqli_prepare($db_conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $id);

    if (mysqli_stmt_execute($stmt)) {

        $res = mysqli_stmt_get_result($stmt);
        $res = mysqli_fetch_all($res, MYSQLI_ASSOC);
        $imgfilename = basename($res[0][$imgcol]);

        if (unlink($_SERVER['DOCUMENT_ROOT'] . '/upload/image/' . $imgfilename)) {

            $query = "UPDATE project SET $imgcol=NULL WHERE project_id=?";
            $stmt = mysqli_prepare($db_conn, $query);
            mysqli_stmt_bind_param($stmt, 's', $id);
            if (mysqli_stmt_execute($stmt)) {
                $response->status(200);
                $response->send(
                    json_encode(array("message" => "approved")),
                    array("Content-type" => "text/plain")
                );
                return;
            }
        }
    }

    $response->status(400);
    $response->send(
        json_encode(
            array("message" => $stmt->error)
        ),
        array("Content-type" => "application/json")
    );

});

$app->options('/project', function ($request, $response) {
    $response->set('Access-Control-Allow-Methods', 'POST, PUT');
    $response->set('Access-Control-Allow-Headers', 'Authorization');
    $response->status(200);
});

$app->options('/project/[:id]', function ($request, $response) {
    $response->set('Access-Control-Allow-Methods', 'DELETE, PUT, POST');
    $response->set('Access-Control-Allow-Headers', 'Authorization');
    $response->status(200);
});

$app->options('/projectimg/[:id]', function ($request, $response) {
    $response->set('Access-Control-Allow-Methods', 'DELETE, PUT, POST');
    $response->set('Access-Control-Allow-Headers', 'Authorization');
    $response->status(200);
});

$app->options('/projectimg/[:id]/[:imgid]', function ($request, $response) {
    $response->set('Access-Control-Allow-Methods', 'DELETE');
    $response->set('Access-Control-Allow-Headers', 'Authorization');
    $response->status(200);
});

?>