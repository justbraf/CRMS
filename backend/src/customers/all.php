<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/customer.php';

// instantiate database and customer object
$database = new Database();
$db = $database->getConnection();

$customer = new Customer($db);

// query customers
$stmt = $customer->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if ($num > 0) {
    $customers_arr = array();
    $customers_arr["records"] = array();

    // fetch() is faster than fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $customerSingle = array(
            "firstName" => $firstName,
            "lastName" => $lastName,
            "address" => html_entity_decode($address),
            "emailAddress" => $emailAddress,
            "phoneNumber" => $phoneNumber
        );

        array_push($customers_arr["records"], $customerSingle);
    }

    // set response code - 200 OK
    http_response_code(200);
    // show customers data in json format
    echo json_encode($customers_arr);
} else {
    // set response code - 404 Not found
    http_response_code(404);
    // tell the user no customers found
    echo json_encode(
        array("message" => "No customers found.")
    );
}