**Test Project**
In this repository contains test Symfony 5.4 project. It hase some very basic booking system related entities like guests, tables and bookings.

In the root directory you will find sample_data.csv file for this project.

**Settings up**  

 1. Clone from repository.
 2. Install all dependencies with "composer install" command
 3. Setup DB connection by adding your MySQL connection details in .env.local file
 4. Create DB schema with "doctrine:schema:create"

 **Objective**
 
The objective of this task is to create Symfony CLI command which will import content of "sample_data.csv" into project's DB.

Pleas note that on the first import there will be no records of Table entity. You will need to add them to the DB af system "finds out" about the new tables. You can identify booked tables by the "table" column in cvs and Table->number property. 
There is maxGuests property in the Table entity too. Your code has to update for each table as it finds out new maximum values from the bookings in csv.
Total amount in Booking entity is stored in 1/100s of currency unit, i.e. $10.25 will be 1025 in DB. 
  
**Deliverables**

Create you code and make pull request to this repo