<?php
class Customer
{

    // database connection and table name
    private $conn;
    private $tableName = "customers";

    // object properties
    public $CID;
    public $Firstname;
    public $Lastname;
    public $Address;
    public $Email_Address;
    public $Phone_Number;
    public $Driver_License_Number;
    public $Province_Of_Issue;
    public $License_Expiration_Date;
    public $Card_Number;
    public $Billing_Address;
    public $Card_Expiration_Date;
    public $Vehicle_Make;
    public $Rental_Duration;
    public $Pick_Up_Location;
    public $Drop_Off_Location;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // read all customers
    function getAll()
    {
        $query = "SELECT * FROM " . $this->tableName;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // add new customer
    function addCustomer()
    {
        $query = "INSERT INTO " . $this->tableName . "
            SET
                Firstname=:Firstname, Lastname=:Lastname, Address=:Address, Email_Address=:Email_Address, Phone_Number=:Phone_Number, Driver_License_Number=:Driver_License_Number, Province_Of_Issue=:Province_Of_Issue, License_Expiration_Date=:License_Expiration_Date, Card_Number=:Card_Number, Billing_Address=:Billing_Address, Card_Expiration_Date=:Card_Expiration_Date";
        if (!empty($this->Vehicle_Make))
            $query .= ", Vehicle_Make=:Vehicle_Make";
        if (!empty($this->Rental_Duration))
            $query .= ", Rental_Duration=:Rental_Duration";
        if (!empty($this->Pick_Up_Location))
            $query .= ", Pick_Up_Location=:Pick_Up_Location";
        if (!empty($this->Drop_Off_Location))
            $query .= ", Drop_Off_Location=:Drop_Off_Location";

        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->Firstname = htmlspecialchars(strip_tags($this->Firstname));
        $this->Lastname = htmlspecialchars(strip_tags($this->Lastname));
        $this->Address = htmlspecialchars(strip_tags($this->Address));
        $this->Email_Address = htmlspecialchars(strip_tags($this->Email_Address));
        $this->Phone_Number = htmlspecialchars(strip_tags($this->Phone_Number));
        $this->Driver_License_Number = htmlspecialchars(strip_tags($this->Driver_License_Number));
        $this->Province_Of_Issue = htmlspecialchars(strip_tags($this->Province_Of_Issue));
        $this->License_Expiration_Date = htmlspecialchars(strip_tags($this->License_Expiration_Date));
        $this->Card_Number = htmlspecialchars(strip_tags($this->Card_Number));
        $this->Billing_Address = htmlspecialchars(strip_tags($this->Billing_Address));
        $this->Card_Expiration_Date = htmlspecialchars(strip_tags($this->Card_Expiration_Date));

        if (!empty($this->Vehicle_Make))
            $this->Vehicle_Make = htmlspecialchars(strip_tags($this->Vehicle_Make));
        if (!empty($this->Rental_Duration))
            $this->Rental_Duration = htmlspecialchars(strip_tags($this->Rental_Duration));
        if (!empty($this->Pick_Up_Location))
            $this->Pick_Up_Location = htmlspecialchars(strip_tags($this->Pick_Up_Location));
        if (!empty($this->Drop_Off_Location))
            $this->Drop_Off_Location = htmlspecialchars(strip_tags($this->Drop_Off_Location));

        // bind values
        $stmt->bindParam(":Firstname", $this->Firstname);
        $stmt->bindParam(":Lastname", $this->Lastname);
        $stmt->bindParam(":Address", $this->Address);
        $stmt->bindParam(":Email_Address", $this->Email_Address);
        $stmt->bindParam(":Phone_Number", $this->Phone_Number);
        $stmt->bindParam(":Driver_License_Number", $this->Driver_License_Number);
        $stmt->bindParam(":Province_Of_Issue", $this->Province_Of_Issue);
        $stmt->bindParam(":License_Expiration_Date", $this->License_Expiration_Date);
        $stmt->bindParam(":Card_Number", $this->Card_Number);
        $stmt->bindParam(":Billing_Address", $this->Billing_Address);
        $stmt->bindParam(":Card_Expiration_Date", $this->Card_Expiration_Date);

        if (!empty($this->Vehicle_Make))
            $stmt->bindParam(":Vehicle_Make", $this->Vehicle_Make);
        if (!empty($this->Rental_Duration))
            $stmt->bindParam(":Rental_Duration", $this->Rental_Duration);
        if (!empty($this->Pick_Up_Location))
            $stmt->bindParam(":Pick_Up_Location", $this->Pick_Up_Location);
        if (!empty($this->Drop_Off_Location))
            $stmt->bindParam(":Drop_Off_Location", $this->Drop_Off_Location);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}

// ====================================
// $query = "SELECT * 
//     FROM
//         " . $this->tableName;
//      . " p
//     LEFT JOIN
//         categories c
//             ON p.category_id = c.id
// ORDER BY
//     p.created DESC";
