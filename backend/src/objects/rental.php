<?php
class Rental
{

    // database connection and table name
    private $conn;
    private $tableName = "rentals";

    // object properties
    public $periodStart;
    public $periodEnd;
    public $rate;
    public $additionalFees;
    public $status;
    public $condition;
    public $cardType;
    public $amountOwed;
    public $amountPaid;

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