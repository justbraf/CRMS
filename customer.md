# Car Rental Management System

## Customer Routes

[Back to home](README.md)

- Get all customers
    - GET Method
    - http://localhost/api/customers/all.php
    - Returned fields
        - CID
        - Firstname
        - Lastname
        - Email_Address
        - Phone_Number
        - Driver_License_Number

- Add a new customer
    - POST Method
    - http://localhost/api/customers/addNew.php
    - Required POST fields - exact spelling
        - Firstname
        - Lastname
        - Address
        - Email_Address
        - Phone_Number
        - Driver_License_Number
        - Province_Of_Issue
        - License_Expiration_Date
        - Card_Number
        - Billing_Address
        - Card_Expiration_Date
    - Optional POST fields - exact spelling
        - Vehicle_Make
        - Rental_Duration
        - Pick_Up_Location
        - Drop_Off_Location

- Get a specific customer
    - GET Method
    - one parameter: id
    - http://localhost/api/customers/getCustomer.php?id=12345

- Update a specific customer
    - Suggest calling a get customer API
        - to verify the customer exist
        - to populate the form
        - and then send the existing data with any updates
    - POST Method
    - Required field: id
    - Optional POST fields - exact spelling
        - Firstname
        - Lastname
        - Address
        - Email_Address
        - Phone_Number
        - Driver_License_Number
        - Province_Of_Issue
        - License_Expiration_Date
        - Card_Number
        - Billing_Address
        - Card_Expiration_Date
        - Vehicle_Make
        - Rental_Duration
        - Pick_Up_Location
        - Drop_Off_Location
    - http://localhost/api/customers/update.php
    
- Delete a specific customer
    - POST Method
    - Required field: id
    - http://localhost/api/customers/delete.php

    [Back to home](README.md)