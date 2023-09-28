<?php

$app->get('/profile', function ($request, $response) {

    global $db_conn;
    $query = "SELECT myprofile_aboutme, myprofile_aboutresume, myprofile_address, myprofile_age, myprofile_email, myprofile_imgurl, myprofile_name, myprofile_phoneno, myprofile_title, myprofile_resumeurl FROM myprofile";

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

$app->put('/profile', function ($request, $response) {

    global $db_conn;

    parse_str(file_get_contents("php://input"), $put_data);

    $name = $put_data['name'];
    $aboutme = $put_data['aboutme'];
    $aboutresume = $put_data['aboutresume'];
    $address = $put_data['address'];
    $age = $put_data['age'];
    $email = $put_data['email'];
    $phoneno = $put_data['phoneno'];
    $title = $put_data['title'];
    $resumeurl = $put_data['resumeurl'];
    $authtoken = $put_data['authtoken'];

    $query = "UPDATE myprofile SET myprofile_name=?, myprofile_title=?, myprofile_age=?, myprofile_phoneno=?, myprofile_email=?, myprofile_address=?, myprofile_aboutme=?, myprofile_aboutresume=?,myprofile_resumeurl=? WHERE myprofile_authkey=?";
    $stmt = mysqli_prepare($db_conn, $query);
    mysqli_stmt_bind_param($stmt, 'ssisssssss', $name, $title, $age, $phoneno, $email, $address, $aboutme, $aboutresume, $resumeurl, $authtoken);

    if (mysqli_stmt_execute($stmt)) {
        $response->send(
            json_encode(
                array(
                    'message' => "approved"
                )
            ),
            array("Content-type" => "application/json")
        );
    } else {
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


/* REFACTOR THIS CODE LATER */
$app->post('/profileimg', function ($request, $response) {
    global $db_conn;

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

                //remove file
                $query = "SELECT myprofile_imgurl FROM myprofile";
                $stmt = mysqli_prepare($db_conn, $query);
                mysqli_stmt_execute($stmt);

                try {
                    $res = mysqli_stmt_get_result($stmt);
                    $res = mysqli_fetch_all($res, MYSQLI_ASSOC);
                    $imgfilename = basename($res[0]['myprofile_imgurl']);
                    unlink($_SERVER['DOCUMENT_ROOT'] . '/upload/image/' . $imgfilename);
                } catch (\Throwable $th) {
                    
                }

                $query = "UPDATE myprofile SET myprofile_imgurl=?";
                $stmt = mysqli_prepare($db_conn, $query);
                mysqli_stmt_bind_param($stmt, 's', $refPath);
                mysqli_stmt_execute($stmt);

                $response->status(200);
                $response->send(json_encode(array("message" => "approved")), array("Content-type" => "application/json"));
                return;
            }
        }
    }

    $response->status(400);
    $response->send(json_encode(array("message" => $refPath)), array("Content-type" => "text/plain"));

});

$app->options('/profile', function ($request, $response) {
    
    $response->set('Access-Control-Allow-Methods', 'DELETE, PUT', 'POST');
    $response->set('Access-Control-Allow-Headers', 'Authorization');
    $response->status(200);
    
});

?>