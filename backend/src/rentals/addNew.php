<?php
// Allow from any origin
if (isset($_SERVER["HTTP_ORIGIN"])) {
    // You can decide if the origin in $_SERVER['HTTP_ORIGIN'] is something you want to allow, or as we do here, just allow all
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
} else {
    //No HTTP_ORIGIN set, so we allow any. You can disallow if needed here
    header("Access-Control-Allow-Origin: *");
}

header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 600");    // cache for 10 minutes

if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
    if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_METHOD"]))
        header("Access-Control-Allow-Methods: POST"); //Make sure you remove those you do not want to support

    if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_HEADERS"]))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    //Just exit with 200 OK with the above headers for OPTIONS method
    exit(0);
}

include_once '../config/database.php';
include_once '../objects/rental.php';

// instantiate database and rental object
$database = new Database();
$db = $database->getConnection();

$rental = new Rental($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if (
    !empty($data->CID) &&
    !empty($data->VID) &&
    !empty($data->Rental_Period_Start) &&
    !empty($data->Rental_Period_End) &&
    // !empty($data->Additional_Fees) &&
    !empty($data->Status) &&
    !empty($data->Vehicle_Condition)
) {

    // set product property values
    $rental->CID = $data->CID;
    $rental->VID = $data->VID;
    $rental->Rental_Period_Start = $data->Rental_Period_Start;
    $rental->Rental_Period_End = $data->Rental_Period_End;
    $rental->Additional_Fees = !empty($data->Additional_Fees) ? $data->Additional_Fees : 0;
    $rental->Status = $data->Status;
    $rental->Vehicle_Condition = $data->Vehicle_Condition;

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
