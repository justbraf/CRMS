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

include_once '../config/database.php';
include_once '../objects/customer.php';

// instantiate database and customer object
$database = new Database();
$db = $database->getConnection();

$customer = new Customer($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if (
    !empty($data->Firstname) &&
    !empty($data->Lastname) &&
    !empty($data->Address) &&
    !empty($data->Email_Address) &&
    !empty($data->Phone_Number) &&
    !empty($data->Driver_License_Number) &&
    !empty($data->Province_Of_Issue) &&
    !empty($data->License_Expiration_Date) &&
    !empty($data->Card_Number) &&
    !empty($data->Billing_Address) &&
    !empty($data->Card_Expiration_Date)
) {

    // set product property values
    $customer->Firstname = $data->Firstname;
    $customer->Lastname = $data->Lastname;
    $customer->Address = $data->Address;
    $customer->Email_Address = $data->Email_Address;
    $customer->Phone_Number = $data->Phone_Number;
    $customer->Driver_License_Number = $data->Driver_License_Number;
    $customer->Province_Of_Issue = $data->Province_Of_Issue;
    $customer->License_Expiration_Date = $data->License_Expiration_Date;
    $customer->Card_Number = $data->Card_Number;
    $customer->Billing_Address = $data->Billing_Address;
    $customer->Card_Expiration_Date = $data->Card_Expiration_Date;
    if (!empty($data->Vehicle_Make))
        $customer->Vehicle_Make = $data->Vehicle_Make;
    if (!empty($data->Rental_Duration))
        $customer->Rental_Duration = $data->Rental_Duration;
    if (!empty($data->Pick_Up_Location))
        $customer->Pick_Up_Location = $data->Pick_Up_Location;
    if (!empty($data->Drop_Off_Location))
        $customer->Drop_Off_Location = $data->Drop_Off_Location;
    // $product->created = date('Y-m-d H:i:s');

    if ($customer->addCustomer()) {
        // set response code - 201 created
        http_response_code(201);
        echo json_encode(array("message" => "Customer was created."));
    } else {
        // set response code - 503 service unavailable
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create customer."));
    }
} else {
    // set response code - 400 bad request
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create customer. Data is incomplete."));
}
