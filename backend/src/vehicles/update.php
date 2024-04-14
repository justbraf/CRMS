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
include_once '../objects/vehicle.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare vehicle object
$vehicle = new Vehicle($db);

// get id of vehicle to be edited
$data = json_decode(file_get_contents("php://input"));

// set ID property of vehicle to be edited
$vehicle->VID = $data->id;

// read the details of vehicle to be updated
$vehicle->getvehicle();

// Update any vehicle property values that have changed
if (!empty($data->Make)) {
    if ($vehicle->Make != $data->Make)
        $vehicle->Make = $data->Make;
}
if (!empty($data->Model)) {
    if ($vehicle->Model != $data->Model)
        $vehicle->Model = $data->Model;
}
if (!empty($data->VID)) {
    if ($vehicle->VID != $data->id)
        $vehicle->VID = $data->id;
}
if (!empty($data->Color)) {
    if ($vehicle->Color != $data->Color)
        $vehicle->Color = $data->Color;
}
if (!empty($data->License_Plate)) {
    if ($vehicle->License_Plate != $data->License_Plate)
        $vehicle->License_Plate = $data->License_Plate;
}
if (!empty($data->Odometer_Reading)) {
    if ($vehicle->Odometer_Reading != $data->Odometer_Reading)
        $vehicle->Odometer_Reading = $data->Odometer_Reading;
}
if (!empty($data->Rate)) {
    if ($vehicle->Rate != $data->Rate)
        $vehicle->Rate = $data->Rate;
}
if (!empty($data->Availability)) {
    if ($vehicle->Availability != $data->Availability)
        $vehicle->Availability = $data->Availability;
}

// update the vehicle
if ($vehicle->update()) {
    // set response code - 200 ok
    http_response_code(200);
    echo json_encode(array("message" => "vehicle was updated."));
} else {
    // set response code - 503 service unavailable
    http_response_code(503);
    echo json_encode(array("message" => "Unable to update vehicle."));
}
