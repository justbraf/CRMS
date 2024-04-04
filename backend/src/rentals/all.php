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
$stmt = $rental->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if ($num > 0) {
    $rentals_arr = array();
    $rentals_arr["records"] = array();

    // fetch() is faster than fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $rentalSingle = array(
            "periodStart" => $periodStart,
            "periodEnd" => $periodEnd,
            "rate" => $rate,
            "additionalFees" => $additionalFees,
            "status" => $status,
            "condition" => html_entity_decode($condition),
            "cardType" => $cardType,
            "amountOwed" => $amountOwed,
            "amountPaid" => $amountPaid
        );

        array_push($rentals_arr["records"], $rentalSingle);
    }

    // set response code - 200 OK
    http_response_code(200);
    // show rentals data in json format
    echo json_encode($rentals_arr);
} else {
    // set response code - 404 Not found
    http_response_code(404);
    // tell the user no rentals found
    echo json_encode(
        array("message" => "No rentals found.")
    );
}