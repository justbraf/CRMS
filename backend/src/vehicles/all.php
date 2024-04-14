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

include_once '../config/database.php';
include_once '../objects/vehicle.php';

// instantiate database and vehicle object
$database = new Database();
$db = $database->getConnection();

$vehicle = new Vehicle($db);

// query vehicles
$stmt = $vehicle->getAll();
$num = $stmt->rowCount();

// check if more than 0 record found
if ($num > 0) {
    $vehicles_arr = array();
    $vehicles_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $vehicleSingle = array(
            "Make" => $Make,
            "Model" => $Model,
            "VID" => $VID,
            "Color" => $Color,
            "License_Plate" => $License_Plate,
            "Odometer_Reading" => $Odometer_Reading,
            "Rate" => $Rate,
            "Availability" => $Availability
        );

        array_push($vehicles_arr["records"], $vehicleSingle);
    }

    // set response code - 200 OK
    http_response_code(200);
    echo json_encode($vehicles_arr);
} else {
    // set response code - 404 Not found
    http_response_code(404);
    echo json_encode(
        array("message" => "No vehicles found.")
    );
}
