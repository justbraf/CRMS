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
    public $Rental_Period_Start;
    public $Rental_Period_End;
    public $Additional_Fees;
    public $Status;
    public $Condition;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // read all rentals
    function getAll()
    {
        $query = "SELECT * FROM " . $this->tableName;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // retrieve a single rental based on the rental id number
    function getRental()
    {
        // query to read single record
        $query = "SELECT * FROM " . $this->tableName . "                
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
            $this->Rental_Period_Start = $row['Rental_Period_Start'];
            $this->Rental_Period_End = $row['Rental_Period_End'];
            $this->Additional_Fees = $row['Additional_Fees'];
            $this->Status = $row['Status'];
            $this->Condition = $row['Condition'];
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
                Condition=:Condition";

        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->CID = htmlspecialchars(strip_tags($this->CID));
        $this->VID = htmlspecialchars(strip_tags($this->VID));
        $this->Rental_Period_Start = htmlspecialchars(strip_tags($this->Rental_Period_Start));
        $this->Rental_Period_End = htmlspecialchars(strip_tags($this->Rental_Period_End));
        $this->Additional_Fees = htmlspecialchars(strip_tags($this->Additional_Fees));
        $this->Status = htmlspecialchars(strip_tags($this->Status));
        $this->Condition = htmlspecialchars(strip_tags($this->Condition));

        // bind values
        $stmt->bindParam(":CID", $this->CID);
        $stmt->bindParam(":VID", $this->VID);
        $stmt->bindParam(":Rental_Period_Start", $this->Rental_Period_Start);
        $stmt->bindParam(":Rental_Period_End", $this->Rental_Period_End);
        $stmt->bindParam(":Additional_Fees", $this->Additional_Fees);
        $stmt->bindParam(":Status", $this->Status);
        $stmt->bindParam(":Condition", $this->Condition);

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
                Condition=:Condition
            WHERE
                RID = :id";

        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->CID = htmlspecialchars(strip_tags($this->CID));
        $this->VID = htmlspecialchars(strip_tags($this->VID));
        $this->Rental_Period_Start = htmlspecialchars(strip_tags($this->Rental_Period_Start));
        $this->Rental_Period_End = htmlspecialchars(strip_tags($this->Rental_Period_End));
        $this->Additional_Fees = htmlspecialchars(strip_tags($this->Additional_Fees));
        $this->Status = htmlspecialchars(strip_tags($this->Status));
        $this->Condition = htmlspecialchars(strip_tags($this->Condition));

        // bind values
        $stmt->bindParam(":CID", $this->CID);
        $stmt->bindParam(":VID", $this->VID);
        $stmt->bindParam(":Rental_Period_Start", $this->Rental_Period_Start);
        $stmt->bindParam(":Rental_Period_End", $this->Rental_Period_End);
        $stmt->bindParam(":Additional_Fees", $this->Additional_Fees);
        $stmt->bindParam(":Status", $this->Status);
        $stmt->bindParam(":Condition", $this->Condition);
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