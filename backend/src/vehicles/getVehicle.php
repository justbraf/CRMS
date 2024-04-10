<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/vehicle.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare vehicle object
$vehicle = new Vehicle($db);

// set ID property of record to read
$vehicle->VID = isset($_GET['id']) ? $_GET['id'] : die();

// read the details of vehicle to be fetched
$vehicle->getvehicle();

if ($vehicle->Make != null) {
    // create array
    $vehicle_arr = array(
        "Make" => $vehicle->Make,
        "Model" => $vehicle->Model,
        "id" => $vehicle->VID,
        "Color" => $vehicle->Color,
        "License_Plate" => $vehicle->License_Plate,
        "Odometer_Reading" => $vehicle->Odometer_Reading,
        "Rate" => $vehicle->Rate,
        "Availability" => $vehicle->Availability
    );

    // set response code - 200 OK
    http_response_code(200);
    echo json_encode($vehicle_arr);
} else {
    // set response code - 404 Not found
    http_response_code(404);
    echo json_encode(array("message" => "vehicle does not exist."));
}
