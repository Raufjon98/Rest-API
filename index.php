<?php

/**
 * @OA\Info(title="NoteBook API", version="1.0.0")
 */

header('Content-type: json/application');
require 'config/connect.php';
require 'functions.php';
$method = $_SERVER['REQUEST_METHOD'];
$q = $_GET['q'];
$param = explode('/', $q);
$type = $param[0];
$id = $param[1];

if ($method === 'GET') {

    if ($type === 'records') {
        if (isset($id)) {
            getRecord($conn, $id);
        } else {
            getRecords($conn);
        }
    }

    if ($type === 'users') {
        if (isset($id)) {
            getUser($conn, $id);
        } else {
            getUsers($conn);
        }
    }

    /**
     * @OA\Get (
     *     path="/records",
     *     summary="Returns all records",
     *     description=" returns all records",
     *     @OA\RequestBody(
     *         description="Client side choosing",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         @OA\Schema(ref="#/notebook/records")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *     @OA\Schema(ref="#/notebook/records)
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Could Not Find Resource"
     *     )
     * )
     */
} elseif ($method === 'POST') {
    if ($type === 'records') {
        if (isset($id)) {
            updateRecord($conn, $id, $_POST);
        } else {
            addRecord($conn, $_POST);
        }
    }
    if ($type === 'users') {
        if (isset($id)){
            updateUser($conn,$id, $_POST);
        }else{
            addUser($conn, $_POST);
        }

    }
} elseif ($method === 'DELETE') {
    if ($type === 'records') {
        if (isset($id)) {
            deleteRecord($conn, $id);
        } else {
            $res = [
                "status" => false,
                "message" => 'Choose id for deleting'
            ];
            echo json_encode($res);
        }
    } elseif ($type === 'users') {
        if (isset($id)) {
            deleteUser($conn, $id);
        } else {
            $res = [
                "status" => false,
                "message" => 'Choose id for deleting'
            ];
            echo json_encode($res);
        }
    }
}

?>
