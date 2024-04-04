<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/vehicle.php';

// instantiate database and vehicle object
$database = new Database();
$db = $database->getConnection();

$vehicle = new Vehicle($db);

// query vehicles
$stmt = $vehicle->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if ($num > 0) {
    $vehicles_arr = array();
    $vehicles_arr["records"] = array();

    // fetch() is faster than fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $vehicleSingle = array(
            "make" => $make,
            "model" => $model,
            "colour" => $colour,
            "plateNumber" => $plateNumber,
            "rating" => $rating,
            "availability" => $availability
        );

        array_push($vehicles_arr["records"], $vehicleSingle);
    }

    // set response code - 200 OK
    http_response_code(200);
    // show vehicles data in json format
    echo json_encode($vehicles_arr);
} else {
    // set response code - 404 Not found
    http_response_code(404);
    // tell the user no vehicles found
    echo json_encode(
        array("message" => "No vehicles found.")
    );
}