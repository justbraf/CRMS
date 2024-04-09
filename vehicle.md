# Car Rental Management System

## Vehicles Routes

[Back to home](README.md)

- Get all vehicles
    - GET Method
    - http://localhost/api/vehicles/all.php
    - Returned fields
        - Make
        - Model
        - VID
        - Color
        - License_Plate
        - Odometer_Reading
        - Rate
        - Availability

- Add a new vehicle
    - POST Method
    - http://localhost/api/vehicles/addNew.php
    - Required POST fields - exact spelling
        - Make
        - Model
        - VID
        - Color
        - License_Plate
        - Odometer_Reading
        - Rate
        - Availability

- Get a specific vehicle
    - GET Method
    - one parameter: id
    - http://localhost/api/vehicles/getVehicle.php?id=12345

- Update a specific vehicle
    - Suggest calling a get vehicle API
        - to verify the vehicle exist
        - to populate the form
        - and then send the existing data with any updates
    - POST Method
    - Required field: id
    - Optional POST fields - exact spelling
        - Make
        - Model
        - id (alias for VID)
        - Color
        - License_Plate
        - Odometer_Reading
        - Rate
        - Availability
    - http://localhost/api/vehicles/update.php
    
- Delete a specific vehicle
    - POST Method
    - Required field: id
    - http://localhost/api/vehicles/delete.php

    [Back to home](README.md)