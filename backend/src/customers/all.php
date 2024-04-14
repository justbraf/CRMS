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
include_once '../objects/customer.php';

// instantiate database and customer object
$database = new Database();
$db = $database->getConnection();

$customer = new Customer($db);

// query customers
$stmt = $customer->getAll();
$num = $stmt->rowCount();

// check if more than 0 records found
if ($num > 0) {
    $customers_arr = array();
    $customers_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        // return only select fields for searching
        $customerSingle = array(
            "CID" => $CID,
            "Firstname" => $Firstname,
            "Lastname" => $Lastname,
            // "Address" => html_entity_decode($Address),
            "Email_Address" => $Email_Address,
            "Phone_Number" => $Phone_Number,
            "Driver_License_Number" => $Driver_License_Number,
            // "Province_Of_Issue" => $Province_Of_Issue,
            // "License_Expiration_Date" => $License_Expiration_Date,
            // "Card_Number" => $Card_Number,
            // "Billing_Address" => $Billing_Address,
            // "Card_Expiration_Date" => $Card_Expiration_Date,
            // "Vehicle_Make" => $Vehicle_Make,
            // "Rental_Duration" => $Rental_Duration,
            // "Pick_Up_Location" => $Pick_Up_Location,
            // "Drop_Off_Location" => $Drop_Off_Location
        );

        array_push($customers_arr["records"], $customerSingle);
    }
    // set response code - 200 OK
    http_response_code(200);
    echo json_encode($customers_arr);
} else {
    // set response code - 404 Not found
    http_response_code(404);
    echo json_encode(
        array("message" => "No customers found.")
    );
}
