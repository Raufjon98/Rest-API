<?php
function getRecords($conn)
{
    $records = [];
    $query = "select * from record";
    $result = $conn->query($query);
    while ($row = mysqli_fetch_assoc($result)) {
        $records[] = $row;
    }
    echo json_encode($records);
}

function getRecord($conn, $id)
{
    $records = [];
    $query = "select * from record where id='" . $id . "'";
    $result = $conn->query($query);
    $row = mysqli_fetch_assoc($result);
    if ($row > 0) {
        echo json_encode($row);
    } else {
        http_response_code('404');
        $res = [
            "status" => false,
            "message" => "Record not found"
        ];
        echo json_encode($res);

    }
}

function addRecord($conn, $data){
    $title = $data['title'];
    $body = $data['body'];
    $query = "INSERT INTO  record (id, title, body) VALUES (default, '$title', '$body')";
    $result = $conn->query($query);
    http_response_code('201');
    $res = [
        "status" => true,
       "record_id" =>mysqli_insert_id($conn)
    ];
    echo json_encode($res);
 }

function updateRecord($conn, $id, $data){
    $title = $data['title'];
    $body = $data['body'];
    $query = "update  record set title = '$title', body = '$body' where record.id = '$id'";
    $result = $conn->query($query);
    http_response_code('200');
    $res = [
        "status" => true,
        "message" => 'Record is updated'
    ];
    echo json_encode($res);
}

function deleteRecord($conn,$id){
    $query = "delete from record where record.id = '$id'";
    $result = $conn->query($query);
    http_response_code('200');
    $res = [
        "status" => true,
        "message" => 'Record was deleted!'
    ];
    echo json_encode($res);
}

function getUsers($conn)
{
    $records = [];
    $query = "select * from user";
    $result = $conn->query($query);
    while ($row = mysqli_fetch_assoc($result)) {
        $records[] = $row;
    }
    echo json_encode($records);
}

function getUser($conn, $id)
{
    $users = [];
    $query = "select * from user where uid='" . $id . "'";
    $result = $conn->query($query);
    $row = mysqli_fetch_assoc($result);
    if ($row > 0) {
        echo json_encode($row);
    } else {
        http_response_code('404');
        $res = [
            "status" => false,
            "message" => "Record not found"
        ];
        echo json_encode($res);

    }
}

function addUser($conn, $data){
    $fio = $data['fio'];
    if ($fio == ''){
        http_response_code('400');
        $res = [
            "status" => false,
            "message" =>'fio is required field'
        ];
        echo json_encode($res);
        exit();
    }
    $company = $data['company'];
    $telephone = $data['telephone'];
    if ($telephone == ''){
        http_response_code('400');
        $res = [
            "status" => false,
            "message" =>'telephone is required field'
        ];
        echo json_encode($res);
        exit();
    }
    $email = $data['email'];
    if ($email == ''){
        http_response_code('400');
        $res = [
            "status" => false,
            "message" =>'email is required field'
        ];
        echo json_encode($res);
        exit();
    }
    $dateOfBirth = $data['dateOfBirth'];
    $postedPhoto = $data['photo'];
    $photo = saveImage($postedPhoto,$email);
    $query = "INSERT INTO  user (uid, fio, company, telephone, email, dateOfBirth, photo) VALUES (default, '$fio', '$company', '$telephone', '$email', '$dateOfBirth', '$photo')";
    $result = $conn->query($query);
    http_response_code('201');
    $res = [
        "status" => true,
        "message" => 'User was added!'
    ];
    echo json_encode($res);
}

function updateUser($conn,$id, $data){
    $fio = $data['fio'];
    if ($fio == ''){
        http_response_code('400');
        $res = [
            "status" => false,
            "message" =>'fio is required field'
        ];
        echo json_encode($res);
        exit();
    }
    $company = $data['company'];
    $telephone = $data['telephone'];
    if ($telephone == ''){
        http_response_code('400');
        $res = [
            "status" => false,
            "message" =>'telephone is required field'
        ];
        echo json_encode($res);
        exit();
    }
    $email = $data['email'];
    if ($email == ''){
        http_response_code('400');
        $res = [
            "status" => false,
            "message" =>'email is required field'
        ];
        echo json_encode($res);
        exit();
    }
    $dateOfBirth = $data['dateOfBirth'];
    $postedPhoto = $data['photo'];
    $photo = saveImage($postedPhoto,'photo.jpg');
    $query = "UPDATE `user` SET `fio`='$fio',`company`='$company',`telephone`='$telephone',`email`='$email',`dateOfBirth`='$dateOfBirth',`photo`='$photo' WHERE user.uid = '$id'";
    $result = $conn->query($query);
    http_response_code('200');
    $res = [
        "status" => true,
        "message" => 'User was updated'
    ];
    echo json_encode($res);
}

function deleteUser($conn,$id){
    $query = "delete from user where user.uid = '$id'";
    $result = $conn->query($query);
    http_response_code('200');
    $res = [
        "status" => true,
        "message" => 'User was deleted!'
    ];
    echo json_encode($res);
}


function saveImage($data, $filename) {

    $base64_img_array = explode(':', $data);

    $img_info = explode(',', end($base64_img_array));
    $img_file_extension = '';
    if (!empty($img_info)) {
        switch ($img_info[0]) {
            case 'image/jpeg;base64':
                $img_file_extension = 'jpeg';
                break;
            case 'image/jpg;base64':
                $img_file_extension = 'jpg';
                break;
            case 'image/gif;base64':
                $img_file_extension = 'gif';
                break;
            case 'image/png;base64':
                $img_file_extension = 'png';
                break;
        }
    }
    $img_file_name = 'img/' . $filename . '.' . $img_file_extension;
    $img_file = file_put_contents($img_file_name, base64_decode($img_info[1]));

    if ($img_file) {
        return $img_file_name;
    } else {
        return false;
    }
}

?>

