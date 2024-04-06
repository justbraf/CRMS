# Car Rental Management System

## Setup Guide
1. Copy the ***src*** folder to the root of the PHP server
2. Rename the ***src*** folder to ***api***
3. Import the SQL dump into your MySQL
4. Backend setup complete

---
### Here is the list of API routes currently operational:
- Get all customers
    - GET Method
    - http://localhost/api/customers/all.php
- Add a new customer
    - POST Method
    - http://localhost/api/customers/addNew.php
    - Required POST fields with exact spelling
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
- Get a specific customer
    - GET Method
    - one parameter: id
    - http://localhost/api/customers/getCustomer.php?id=12345