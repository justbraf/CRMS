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

// include database and object files
include_once '../config/database.php';
include_once '../objects/payment.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare payment object
$payment = new Payment($db);

// set ID property of record to read
$payment->CID = isset($_GET['cid']) ? $_GET['cid'] : die();
$payment->RID = isset($_GET['rid']) ? $_GET['rid'] : die();

// read the details of payment to be fetched
$payment->getPayments();

if ($payment->CID != null) {
    // create array
    $payments_arr = array();
    $payments_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $paymentSingle = array(
            "CID" => $payment->CID,
            "RID" => $payment->RID,
            "Card_Type" => $payment->Card_Type,
            "Amount_Paid" => $payment->Amount_Paid
        );

        array_push($payments_arr["records"], $paymentSingle);
    }

    // set response code - 200 OK
    http_response_code(200);
    echo json_encode($payments_arr);
} else {
    // set response code - 404 Not found
    http_response_code(404);
    echo json_encode(array("message" => "payment does not exist."));
}
