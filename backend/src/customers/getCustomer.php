<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/customer.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare customer object
$customer = new Customer($db);

// set ID property of record to read
$customer->CID = isset($_GET['id']) ? $_GET['id'] : die();

// read the details of customer to be fetched
$customer->getCustomer();

if ($customer->Firstname != null) {
    // create array
    $customer_arr = array(
        "id" => $customer->CID,
        "Firstname" => $customer->Firstname,
        "Lastname" => $customer->Lastname,
        "Address" => $customer->Address,
        "Email_Address" => $customer->Email_Address,
        "Phone_Number" => $customer->Phone_Number,
        "Driver_License_Number" => $customer->Driver_License_Number,
        "Province_Of_Issue" => $customer->Province_Of_Issue,
        "License_Expiration_Date" => $customer->License_Expiration_Date,
        "Card_Number" => $customer->Card_Number,
        "Billing_Address" => $customer->Billing_Address,
        "Card_Expiration_Date" => $customer->Card_Expiration_Date,
        "Vehicle_Make" => $customer->Vehicle_Make,
        "Rental_Duration" => $customer->Rental_Duration,
        "Pick_Up_Location" => $customer->Pick_Up_Location,
        "Drop_Off_Location" => $customer->Drop_Off_Location
    );

    // set response code - 200 OK
    http_response_code(200);
    echo json_encode($customer_arr);
} else {
    // set response code - 404 Not found
    http_response_code(404);
    echo json_encode(array("message" => "customer does not exist."));
}