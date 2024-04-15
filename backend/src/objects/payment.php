<?php
class Payment
{

    // database connection and table name
    private $conn;
    private $tableName = "payments";

    // object properties
    public $PID;
    public $CID;
    public $RID;
    public $Name;
    public $Card_Type;
    public $Amount_Paid;

    // public $RID;
    // public $CID;
    // public $Name;
    // public $Num_Days;
    // public $Rental_Cost;
    // public $Make;
    // public $Model;
    // public $Color;
    // public $License_Plate;
    // public $Rental_Period_Start;
    // public $Rental_Period_End;
    // public $Additional_Fees;
    // public $Status;
    // public $Vehicle_Condition;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // read all rentals
    // function getAll()
    // {
    //     // $query = "SELECT * FROM " . $this->tableName;
    //         // PID, 
    //         // CID, 
    //         // RID,
    //     $query = "SELECT 
    //         Card_Type,
    //         Amount_Paid
    //     FROM " . $this->tableName . " 
    //     LEFT JOIN customers AS cust 
    //         ON rar.CID = cust.CID
    //     LEFT JOIN vehicles As veh
    //         ON rar.RID = veh.RID";

    //     $stmt = $this->conn->prepare($query);
    //     $stmt->execute();

    //     return $stmt;
    // }

    // retrieve a single rental based on the rental id number
    function getPayments()
    {
        // query to read single record
        // $query = "SELECT * FROM " . $this->tableName . "
        $query = "SELECT 
            pay.PID, 
            pay.CID, 
            pay.RID, 
            CONCAT(cust.Lastname, \", \", cust.Firstname) AS Name, 
            pay.Card_Type, 
            pay.Amount_Paid
        FROM " . $this->tableName . " AS pay 
        LEFT JOIN customers AS cust 
            ON pay.CID = cust.CID
            WHERE
                pay.RID = ? AND pay.CID = ?
            LIMIT
                0,1";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind id of product to be updated
        $stmt->bindParam(1, $this->RID);
        $stmt->bindParam(2, $this->CID);
        // $stmt->bindParam(":CID", $this->CID);
        // $stmt->bindParam(":RID", $this->RID);

        // execute query
        $stmt->execute();

        return $stmt;

        // get retrieved row
        // $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // if ($row) {
            // set values to object properties
            // $this->RID = $row['RID'];
        //     $this->PID = $row['PID'];
        //     $this->CID = $row['CID'];
        //     $this->RID = $row['RID'];
        //     $this->Name = $row['Name'];
        //     $this->Card_Type = $row['Card_Type'];
        //     $this->Amount_Paid = $row['Amount_Paid'];
        // }
    }

    // add a new rental
    function addPayment()
    {
        $query = "INSERT INTO " . $this->tableName . "
            SET
                CID=:CID,
                RID=:RID,
                Card_Type=:Card_Type,
                Amount_Paid=:Amount_Paid";

        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->CID = htmlspecialchars(strip_tags($this->CID));
        $this->RID = htmlspecialchars(strip_tags($this->RID));
        $this->Card_Type = htmlspecialchars(strip_tags($this->Card_Type));
        $this->Amount_Paid = htmlspecialchars(strip_tags($this->Amount_Paid));

        // bind values
        $stmt->bindParam(":CID", $this->CID);
        $stmt->bindParam(":RID", $this->RID);
        $stmt->bindParam(":Card_Type", $this->Card_Type);
        $stmt->bindParam(":Amount_Paid", $this->Amount_Paid);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // update a rental
    // function update()
    // {
        // update query
        // $query = "UPDATE " . $this->tableName . "        
        //     SET
        //         CID=:CID, 
        //         RID=:RID, 
        //         Rental_Period_Start=:Rental_Period_Start, 
        //         Rental_Period_End=:Rental_Period_End, 
        //         Additional_Fees=:Additional_Fees, 
        //         Status=:Status, 
        //         Vehicle_Condition=:Vehicle_Condition
        //     WHERE
        //         RID=:id";

        // $stmt = $this->conn->prepare($query);

        // // sanitize
        // $this->CID = htmlspecialchars(strip_tags($this->CID));
        // $this->RID = htmlspecialchars(strip_tags($this->RID));
        // $this->Rental_Period_Start = htmlspecialchars(strip_tags($this->Rental_Period_Start));
        // $this->Rental_Period_End = htmlspecialchars(strip_tags($this->Rental_Period_End));
        // $this->Additional_Fees = htmlspecialchars(strip_tags($this->Additional_Fees));
        // $this->Status = htmlspecialchars(strip_tags($this->Status));
        // $this->Vehicle_Condition = htmlspecialchars(strip_tags($this->Vehicle_Condition));

        // // bind values
        // $stmt->bindParam(":CID", $this->CID);
        // $stmt->bindParam(":RID", $this->RID);
        // $stmt->bindParam(":Rental_Period_Start", $this->Rental_Period_Start);
        // $stmt->bindParam(":Rental_Period_End", $this->Rental_Period_End);
        // $stmt->bindParam(":Additional_Fees", $this->Additional_Fees);
        // $stmt->bindParam(":Status", $this->Status);
        // $stmt->bindParam(":Vehicle_Condition", $this->Vehicle_Condition);
        // $stmt->bindParam(":id", $this->RID);

        // if ($stmt->execute()) {
        //     return true;
        // }
        // return false;
    // }

    // delete the product
    // function delete()
    // {
    //     // delete query
    //     $query = "DELETE FROM " . $this->tableName . " WHERE RID = ?";

    //     // prepare query
    //     $stmt = $this->conn->prepare($query);

    //     // sanitize
    //     $this->RID = htmlspecialchars(strip_tags($this->RID));

    //     // bind id of record to delete
    //     $stmt->bindParam(1, $this->RID);

    //     // execute query
    //     if ($stmt->execute()) {
    //         return true;
    //     }
    //     return false;
    // }
}
