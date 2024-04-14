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

// include database and object files
include_once '../config/database.php';
include_once '../objects/rental.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare rental object
$rental = new Rental($db);

// get id of rental to be edited
$data = json_decode(file_get_contents("php://input"));

// set ID property of rental to be edited
$rental->RID = $data->id;

// read the details of rental to be updated
$rental->getRental();

// Update any rental property values that have changed
if (!empty($data->CID)) {
    if ($rental->CID != $data->CID)
        $rental->CID = $data->CID;
}
if (!empty($data->VID)) {
    if ($rental->VID != $data->id)
        $rental->VID = $data->id;
}
if (!empty($data->Rental_Period_Start)) {
    if ($rental->Rental_Period_Start != $data->Rental_Period_Start)
        $rental->Rental_Period_Start = $data->Rental_Period_Start;
}
if (!empty($data->Rental_Period_End)) {
    if ($rental->Rental_Period_End != $data->Rental_Period_End)
        $rental->Rental_Period_End = $data->Rental_Period_End;
}
if (!empty($data->Additional_Fees)) {
    if ($rental->Additional_Fees != $data->Additional_Fees)
        $rental->Additional_Fees = $data->Additional_Fees;
}
if (!empty($data->Status)) {
    if ($rental->Status != $data->Status)
        $rental->Status = $data->Status;
}
if (!empty($data->Vehicle_Condition)) {
    if ($rental->Vehicle_Condition != $data->Vehicle_Condition)
        $rental->Vehicle_Condition = $data->Vehicle_Condition;
}

// update the rental
if ($rental->update()) {
    // set response code - 200 ok
    http_response_code(200);
    echo json_encode(array("message" => "rental was updated."));
} else {
    // set response code - 503 service unavailable
    http_response_code(503);
    echo json_encode(array("message" => "Unable to update rental."));
}
