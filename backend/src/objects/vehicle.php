<?php
class Vehicle
{

    // database connection and table name
    private $conn;
    private $tableName = "vehicles";

    // object properties
    public $make;
    public $model;
    public $colour;
    public $plateNumber;
    public $rating;
    public $availability;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // read customers
    function read()
    {
        // modify select clause
        $query = "SELECT * 
            FROM
                " . $this->tableName;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}
?>