<?php
class Vehicle
{

    // database connection and table name
    private $conn;
    private $tableName = "vehicles";

    // object properties
    public $Make;
    public $Model;
    public $VID;
    public $Color;
    public $License_Plate;
    public $Odometer_Reading;
    public $Rate;
    public $Availability;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // read all vehicles
    function getAll()
    {
        $query = "SELECT * FROM " . $this->tableName;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // retrieve a single vehicle based on the vehicle id number
    function getVehicle()
    {
        // query to read single record
        $query = "SELECT * FROM " . $this->tableName . "                
            WHERE
                VID = ?
            LIMIT
                0,1";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind id of product to be updated
        $stmt->bindParam(1, $this->VID);

        // execute query
        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            // set values to object properties
            $this->Make = $row['Make'];
            $this->Model = $row['Model'];
            // $this->VID = $row['VID'];
            $this->Color = $row['Color'];
            $this->License_Plate = $row['License_Plate'];
            $this->Odometer_Reading = $row['Odometer_Reading'];
            $this->Rate = $row['Rate'];
            $this->Availability = $row['Availability'];
        }
    }

    // add a new vehicle
    function addVehicle()
    {
        $query = "INSERT INTO " . $this->tableName . "
            SET
                Make=:Make,
                Model=:Model,
                VID=:VID,
                Color=:Color,
                License_Plate=:License_Plate,
                Odometer_Reading=:Odometer_Reading,
                Rate=:Rate,
                Availability=:Availability";

        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->Make = htmlspecialchars(strip_tags($this->Make));
        $this->Model = htmlspecialchars(strip_tags($this->Model));
        $this->VID = htmlspecialchars(strip_tags($this->VID));
        $this->Color = htmlspecialchars(strip_tags($this->Color));
        $this->License_Plate = htmlspecialchars(strip_tags($this->License_Plate));
        $this->Odometer_Reading = htmlspecialchars(strip_tags($this->Odometer_Reading));
        $this->Rate = htmlspecialchars(strip_tags($this->Rate));
        $this->Availability = htmlspecialchars(strip_tags($this->Availability));

        // bind values
        $stmt->bindParam(":Make", $this->Make);
        $stmt->bindParam(":Model", $this->Model);
        $stmt->bindParam(":VID", $this->VID);
        $stmt->bindParam(":Color", $this->Color);
        $stmt->bindParam(":License_Plate", $this->License_Plate);
        $stmt->bindParam(":Odometer_Reading", $this->Odometer_Reading);
        $stmt->bindParam(":Rate", $this->Rate);
        $stmt->bindParam(":Availability", $this->Availability);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // update a vehicle
    function update()
    {
        // update query
        $query = "UPDATE " . $this->tableName . "        
        SET
            Make=:Make, 
            Model=:Model, 
            VID=:VID, 
            Color=:Color, 
            License_Plate=:License_Plate, 
            Odometer_Reading=:Odometer_Reading, 
            Rate=:Rate, 
            Availability=:Availability
        WHERE
            VID = :id";

        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->Make = htmlspecialchars(strip_tags($this->Make));
        $this->Model = htmlspecialchars(strip_tags($this->Model));
        $this->VID = htmlspecialchars(strip_tags($this->VID));
        $this->Color = htmlspecialchars(strip_tags($this->Color));
        $this->License_Plate = htmlspecialchars(strip_tags($this->License_Plate));
        $this->Odometer_Reading = htmlspecialchars(strip_tags($this->Odometer_Reading));
        $this->Rate = htmlspecialchars(strip_tags($this->Rate));
        $this->Availability = htmlspecialchars(strip_tags($this->Availability));

        // bind values
        $stmt->bindParam(":Make", $this->Make);
        $stmt->bindParam(":Model", $this->Model);
        $stmt->bindParam(":VID", $this->VID);
        $stmt->bindParam(":Color", $this->Color);
        $stmt->bindParam(":License_Plate", $this->License_Plate);
        $stmt->bindParam(":Odometer_Reading", $this->Odometer_Reading);
        $stmt->bindParam(":Rate", $this->Rate);
        $stmt->bindParam(":Availability", $this->Availability);
        $stmt->bindParam(":id", $this->VID);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // delete the product
    function delete()
    {
        // delete query
        $query = "DELETE FROM " . $this->tableName . " WHERE VID = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->VID = htmlspecialchars(strip_tags($this->VID));

        // bind id of record to delete
        $stmt->bindParam(1, $this->VID);

        // execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}