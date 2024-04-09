<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/vehicle.php';

// instantiate database and vehicle object
$database = new Database();
$db = $database->getConnection();

$vehicle = new Vehicle($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if (
    !empty($data->Make) &&
    !empty($data->Model) &&
    !empty($data->VID) &&
    !empty($data->Color) &&
    !empty($data->License_Plate) &&
    !empty($data->Odometer_Reading) &&
    !empty($data->Rate) &&
    !empty($data->Availability)
) {

    // set product property values
    $vehicle->Make = $data->Make;
    $vehicle->Model = $data->Model;
    $vehicle->VID = $data->VID;
    $vehicle->Color = $data->Color;
    $vehicle->License_Plate = $data->License_Plate;
    $vehicle->Odometer_Reading = $data->Odometer_Reading;
    $vehicle->Rate = $data->Rate;
    $vehicle->Availability = $data->Availability;

    if ($vehicle->addvehicle()) {
        // set response code - 201 created
        http_response_code(201);
        echo json_encode(array("message" => "vehicle was created."));
    } else {
        // set response code - 503 service unavailable
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create vehicle."));
    }
} else {
    // set response code - 400 bad request
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create vehicle. Data is incomplete."));
}
