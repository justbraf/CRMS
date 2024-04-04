<?php
class Customer
{

    // database connection and table name
    private $conn;
    private $tableName = "customers";

    // object properties
    public $firstName;
    public $lastName;
    public $address;
    public $emailAddress;
    public $phoneNumber;
    // public $driversLicense;
    // public $placeOfIssue;

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
            //      . " p
            //     LEFT JOIN
            //         categories c
            //             ON p.category_id = c.id
            // ORDER BY
            //     p.created DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}
?>