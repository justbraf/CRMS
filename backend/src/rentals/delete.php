<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object file
include_once '../config/database.php';
include_once '../objects/rental.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare rental object
$rental = new Rental($db);

// get rental id
$data = json_decode(file_get_contents("php://input"));

// set rental id to be deleted
$rental->RID = $data->id;

// delete the rental
if ($rental->delete()) {
    // set response code - 200 ok
    http_response_code(200);
    echo json_encode(array("message" => "rental was deleted."));
}
else {
    // set response code - 503 service unavailable
    http_response_code(503);
    echo json_encode(array("message" => "Unable to delete rental."));
}
