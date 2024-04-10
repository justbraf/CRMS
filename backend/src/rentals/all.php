<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

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
            "Rental_Period_Start" => $Rental_Period_Start,
            "Rental_Period_End" => $Rental_Period_End,
            "Additional_Fees" => $Additional_Fees,
            "Status" => html_entity_decode($Status),
            "Condition" => html_entity_decode($Condition)
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