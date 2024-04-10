<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/rental.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare rental object
$rental = new Rental($db);

// set ID property of record to read
$rental->VID = isset($_GET['id']) ? $_GET['id'] : die();

// read the details of rental to be fetched
$rental->getRental();

if ($rental->CID != null) {
    // create array
    $rental_arr = array(
        "RID" => $rental->RID,
        "CID" => $rental->CID,
        "id" => $rental->VID,
        "Rental_Period_Start" => $rental->Rental_Period_Start,
        "Rental_Period_End" => $rental->Rental_Period_End,
        "Additional_Fees" => $rental->Additional_Fees,
        "Status" => $rental->Status,
        "Condition" => $rental->Condition
    );

    // set response code - 200 OK
    http_response_code(200);
    echo json_encode($rental_arr);
} else {
    // set response code - 404 Not found
    http_response_code(404);
    echo json_encode(array("message" => "rental does not exist."));
}
