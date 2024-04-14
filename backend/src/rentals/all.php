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
include_once '../objects/rental.php';

// instantiate database and rental object
$database = new Database();
$db = $database->getConnection();

$rental = new Rental($db);

// query rentals
$stmt = $rental->getAll();
$num = $stmt->rowCount();

// check if more than 0 record found
if ($num > 0) {
    $rentals_arr = array();
    $rentals_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $rentalSingle = array(
            "RID" => $RID,
            "CID" => $CID,
            "VID" => $VID,
            "Name"=> $Name,
            "Num_Days" => $Num_Days,
            "Rental_Cost" => $Rental_Cost,
            "Make" => $Make,
            "Model" => $Model,
            "Color" => $Color,
            "License_Plate" => $License_Plate,
            "Rental_Period_Start" => $Rental_Period_Start,
            "Rental_Period_End" => $Rental_Period_End,
            "Additional_Fees" => $Additional_Fees,
            "Status" => html_entity_decode($Status),
            "Vehicle_Condition" => html_entity_decode($Vehicle_Condition)
        );

        array_push($rentals_arr["records"], $rentalSingle);
    }

    // set response code - 200 OK
    http_response_code(200);
    echo json_encode($rentals_arr);
} else {
    // set response code - 404 Not found
    http_response_code(404);
    echo json_encode(
        array("message" => "No rentals found.")
    );
}