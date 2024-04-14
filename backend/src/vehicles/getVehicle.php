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
        header("Access-Control-Allow-Methods: GET"); //Make sure you remove those you do not want to support

    if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_HEADERS"]))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    //Just exit with 200 OK with the above headers for OPTIONS method
    exit(0);
}

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
