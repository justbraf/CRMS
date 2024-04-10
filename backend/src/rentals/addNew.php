<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/rental.php';

// instantiate database and rental object
$database = new Database();
$db = $database->getConnection();

$rental = new Rental($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// RID sure data is not empty
if (
    !empty($data->RID) &&
    !empty($data->CID) &&
    !empty($data->VID) &&
    !empty($data->Rental_Period_Start) &&
    !empty($data->Rental_Period_End) &&
    !empty($data->Additional_Fees) &&
    !empty($data->Status) &&
    !empty($data->Condition)
) {

    // set product property values
    $rental->RID = $data->RID;
    $rental->CID = $data->CID;
    $rental->VID = $data->VID;
    $rental->Rental_Period_Start = $data->Rental_Period_Start;
    $rental->Rental_Period_End = $data->Rental_Period_End;
    $rental->Additional_Fees = $data->Additional_Fees;
    $rental->Status = $data->Status;
    $rental->Condition = $data->Condition;

    if ($rental->addrental()) {
        // set response code - 201 created
        http_response_code(201);
        echo json_encode(array("message" => "rental was created."));
    } else {
        // set response code - 503 service unavailable
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create rental."));
    }
} else {
    // set response code - 400 bad request
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create rental. Data is incomplete."));
}
