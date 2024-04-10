# Car Rental Management System

## Rental Routes

[Back to home](README.md)

- Get all rentals
    - GET Method
    - http://localhost/api/rentals/all.php
    - Returned fields
        - RID
        - CID
        - VID
        - Rental_Period_Start
        - Rental_Period_End
        - Additional_Fees
        - Status
        - Condition

- Add a new rental
    - POST Method
    - http://localhost/api/rentals/addNew.php
    - Required POST fields - exact spelling
        - CID
        - VID
        - Rental_Period_Start
        - Rental_Period_End
        - Additional_Fees
        - Status
        - Condition
        
- Get a specific rental
    - GET Method
    - one parameter: id
    - http://localhost/api/rentals/getrental.php?id=12345

- Update a specific rental
    - Suggest calling a get rental API
        - to verify the rental exist
        - to populate the form
        - and then send the existing data with any updates
    - POST Method
    - Required field: id
    - Optional POST fields - exact spelling
        - CID
        - VID
        - Rental_Period_Start
        - Rental_Period_End
        - Additional_Fees
        - Status
        - Condition
    - http://localhost/api/rentals/update.php
    
- Delete a specific rental
    - POST Method
    - Required field: id
    - http://localhost/api/rentals/delete.php

    [Back to home](README.md)