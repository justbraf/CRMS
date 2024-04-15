<?php
class Rental
{

    // database connection and table name
    private $conn;
    private $tableName = "rentalsandreturns";

    // object properties
    public $RID;
    public $CID;
    public $VID;
    public $Name;
    public $Num_Days;
    public $Rental_Cost;
    public $Make;
    public $Model;
    public $Color;
    public $License_Plate;
    public $Rental_Period_Start;
    public $Rental_Period_End;
    public $Additional_Fees;
    public $Status;
    public $Vehicle_Condition;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // read all rentals
    function getAll()
    {
        // $query = "SELECT * FROM " . $this->tableName;
        $query = "SELECT 
            rar.RID, 
            rar.CID, 
            rar.VID, 
            CONCAT(cust.Lastname, \", \", cust.Firstname) AS Name, 
            DATEDIFF(rar.Rental_Period_End, rar.Rental_Period_Start) As Num_Days, 
            (DATEDIFF(rar.Rental_Period_End, rar.Rental_Period_Start) * veh.Rate + rar.Additional_Fees) As Rental_Cost, 
            veh.Make, 
            veh.Model, 
            veh.Color, 
            veh.License_Plate, 
            rar.Rental_Period_Start, 
            rar.Rental_Period_End, 
            rar.Additional_Fees, 
            rar.Status, 
            rar.Vehicle_Condition
        FROM " . $this->tableName . " AS rar 
        LEFT JOIN customers AS cust 
            ON rar.CID = cust.CID
        LEFT JOIN vehicles As veh
            ON rar.VID = veh.VID
        ORDER BY Name";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // retrieve a single rental based on the rental id number
    function getRental()
    {
        // query to read single record
        // $query = "SELECT * FROM " . $this->tableName . "
        $query = "SELECT 
            rar.RID, 
            rar.CID, 
            rar.VID, 
            CONCAT(cust.Lastname, \", \", cust.Firstname) AS Name, 
            DATEDIFF(rar.Rental_Period_End, rar.Rental_Period_Start) As Num_Days, 
            (DATEDIFF(rar.Rental_Period_End, rar.Rental_Period_Start) * veh.Rate + rar.Additional_Fees) As Rental_Cost, 
            veh.Make, 
            veh.Model, 
            veh.Color, 
            veh.License_Plate, 
            rar.Rental_Period_Start, 
            rar.Rental_Period_End, 
            rar.Additional_Fees, 
            rar.Status, 
            rar.Vehicle_Condition
        FROM " . $this->tableName . " AS rar 
        LEFT JOIN customers AS cust 
            ON rar.CID = cust.CID
        LEFT JOIN vehicles As veh
            ON rar.VID = veh.VID
            WHERE
                RID = ?
            LIMIT
                0,1";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind id of product to be updated
        $stmt->bindParam(1, $this->RID);

        // execute query
        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            // set values to object properties
            // $this->RID = $row['RID'];
            $this->CID = $row['CID'];
            $this->VID = $row['VID'];
            $this->Name = $row['Name'];
            $this->Num_Days = $row['Num_Days'];
            $this->Rental_Cost = $row['Rental_Cost'];
            $this->Make = $row['Make'];
            $this->Model = $row['Model'];
            $this->Color = $row['Color'];
            $this->License_Plate = $row['License_Plate'];
            $this->Rental_Period_Start = $row['Rental_Period_Start'];
            $this->Rental_Period_End = $row['Rental_Period_End'];
            $this->Additional_Fees = $row['Additional_Fees'];
            $this->Status = $row['Status'];
            $this->Vehicle_Condition = $row['Vehicle_Condition'];
        }
    }

    // add a new rental
    function addrental()
    {
        $query = "INSERT INTO " . $this->tableName . "
            SET
                CID=:CID,
                VID=:VID,
                Rental_Period_Start=:Rental_Period_Start,
                Rental_Period_End=:Rental_Period_End,
                Additional_Fees=:Additional_Fees,
                Status=:Status,
                Vehicle_Condition=:Vehicle_Condition";

        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->CID = htmlspecialchars(strip_tags($this->CID));
        $this->VID = htmlspecialchars(strip_tags($this->VID));
        $this->Rental_Period_Start = htmlspecialchars(strip_tags($this->Rental_Period_Start));
        $this->Rental_Period_End = htmlspecialchars(strip_tags($this->Rental_Period_End));
        $this->Additional_Fees = htmlspecialchars(strip_tags($this->Additional_Fees));
        $this->Status = htmlspecialchars(strip_tags($this->Status));
        $this->Vehicle_Condition = htmlspecialchars(strip_tags($this->Vehicle_Condition));

        // bind values
        $stmt->bindParam(":CID", $this->CID);
        $stmt->bindParam(":VID", $this->VID);
        $stmt->bindParam(":Rental_Period_Start", $this->Rental_Period_Start);
        $stmt->bindParam(":Rental_Period_End", $this->Rental_Period_End);
        $stmt->bindParam(":Additional_Fees", $this->Additional_Fees);
        $stmt->bindParam(":Status", $this->Status);
        $stmt->bindParam(":Vehicle_Condition", $this->Vehicle_Condition);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // update a rental
    function update()
    {
        // update query
        $query = "UPDATE " . $this->tableName . "        
            SET
                CID=:CID, 
                VID=:VID, 
                Rental_Period_Start=:Rental_Period_Start, 
                Rental_Period_End=:Rental_Period_End, 
                Additional_Fees=:Additional_Fees, 
                Status=:Status, 
                Vehicle_Condition=:Vehicle_Condition
            WHERE
                RID=:id";

        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->CID = htmlspecialchars(strip_tags($this->CID));
        $this->VID = htmlspecialchars(strip_tags($this->VID));
        $this->Rental_Period_Start = htmlspecialchars(strip_tags($this->Rental_Period_Start));
        $this->Rental_Period_End = htmlspecialchars(strip_tags($this->Rental_Period_End));
        $this->Additional_Fees = htmlspecialchars(strip_tags($this->Additional_Fees));
        $this->Status = htmlspecialchars(strip_tags($this->Status));
        $this->Vehicle_Condition = htmlspecialchars(strip_tags($this->Vehicle_Condition));

        // bind values
        $stmt->bindParam(":CID", $this->CID);
        $stmt->bindParam(":VID", $this->VID);
        $stmt->bindParam(":Rental_Period_Start", $this->Rental_Period_Start);
        $stmt->bindParam(":Rental_Period_End", $this->Rental_Period_End);
        $stmt->bindParam(":Additional_Fees", $this->Additional_Fees);
        $stmt->bindParam(":Status", $this->Status);
        $stmt->bindParam(":Vehicle_Condition", $this->Vehicle_Condition);
        $stmt->bindParam(":id", $this->RID);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // delete the product
    function delete()
    {
        // delete query
        $query = "DELETE FROM " . $this->tableName . " WHERE RID = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->RID = htmlspecialchars(strip_tags($this->RID));

        // bind id of record to delete
        $stmt->bindParam(1, $this->RID);

        // execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
