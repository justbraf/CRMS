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
include_once '../objects/customer.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare customer object
$customer = new Customer($db);

// get id of customer to be edited
$data = json_decode(file_get_contents("php://input"));

// set ID property of customer to be edited
$customer->CID = $data->id;

// read the details of customer to be updated
$customer->getCustomer();

// Update any customer property values that have changed
if (!empty($data->Firstname)) {
    if ($customer->Firstname != $data->Firstname)
        $customer->Firstname = $data->Firstname;
}
if (!empty($data->Lastname)) {
    if ($customer->Lastname != $data->Lastname)
        $customer->Lastname = $data->Lastname;
}
if (!empty($data->Address)) {
    if ($customer->Address != $data->Address)
        $customer->Address = $data->Address;
}
if (!empty($data->Email_Address)) {
    if ($customer->Email_Address != $data->Email_Address)
        $customer->Email_Address = $data->Email_Address;
}
if (!empty($data->Phone_Number)) {
    if ($customer->Phone_Number != $data->Phone_Number)
        $customer->Phone_Number = $data->Phone_Number;
}
if (!empty($data->Driver_License_Number)) {
    if ($customer->Driver_License_Number != $data->Driver_License_Number)
        $customer->Driver_License_Number = $data->Driver_License_Number;
}
if (!empty($data->Province_Of_Issue)) {
    if ($customer->Province_Of_Issue != $data->Province_Of_Issue)
        $customer->Province_Of_Issue = $data->Province_Of_Issue;
}
if (!empty($data->License_Expiration_Date)) {
    if ($customer->License_Expiration_Date != $data->License_Expiration_Date)
        $customer->License_Expiration_Date = $data->License_Expiration_Date;
}
if (!empty($data->Card_Number)) {
    if ($customer->Card_Number != $data->Card_Number)
        $customer->Card_Number = $data->Card_Number;
}
if (!empty($data->Billing_Address)) {
    if ($customer->Billing_Address != $data->Billing_Address)
        $customer->Billing_Address = $data->Billing_Address;
}
if (!empty($data->Card_Expiration_Date)) {
    if ($customer->Card_Expiration_Date != $data->Card_Expiration_Date)
        $customer->Card_Expiration_Date = $data->Card_Expiration_Date;
}
if (!empty($data->Vehicle_Make)) {
    if ($customer->Vehicle_Make != $data->Vehicle_Make)
        $customer->Vehicle_Make = $data->Vehicle_Make;
}
if (!empty($data->Rental_Duration)) {
    if ($customer->Rental_Duration != $data->Rental_Duration)
        $customer->Rental_Duration = $data->Rental_Duration;
}
if (!empty($data->Pick_Up_Location)) {
    if ($customer->Pick_Up_Location != $data->Pick_Up_Location)
        $customer->Pick_Up_Location = $data->Pick_Up_Location;
}
if (!empty($data->Drop_Off_Location)) {
    if ($customer->Drop_Off_Location != $data->Drop_Off_Location)
        $customer->Drop_Off_Location = $data->Drop_Off_Location;
}

// update the customer
if ($customer->update()) {
    // set response code - 200 ok
    http_response_code(200);
    echo json_encode(array("message" => "customer was updated."));
} else {
    // set response code - 503 service unavailable
    http_response_code(503);
    echo json_encode(array("message" => "Unable to update customer."));
}
