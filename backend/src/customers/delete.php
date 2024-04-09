<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object file
include_once '../config/database.php';
include_once '../objects/customer.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare customer object
$customer = new Customer($db);

// get customer id
$data = json_decode(file_get_contents("php://input"));

// set customer id to be deleted
$customer->CID = $data->id;

// delete the customer
if ($customer->delete()) {
    // set response code - 200 ok
    http_response_code(200);
    echo json_encode(array("message" => "customer was deleted."));
}
else {
    // set response code - 503 service unavailable
    http_response_code(503);
    echo json_encode(array("message" => "Unable to delete customer."));
}
