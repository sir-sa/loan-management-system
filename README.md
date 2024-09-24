Loan Management API Documentation

This API allows users to manage loans, including creating, retrieving, updating, deleting loans, Loan Calculation and update status. It also supports user registration and authentication with JWT.

Steps to run the application
After cloning the code run the following commands.
composer install/composer update
cp .env.example .env
php artisan key:generate
Create Database on mysql phpadmin.
php artisan migrate
php artisan serve.


Base URL
http://127.0.0.1:8000/api/


Endpoints
1. User Registration
Method: POST
Endpoint: /register
Description: Register a new user.
Request Body:
{
    "name":"John Doe",
    "email":"admin@demo.com",
    "password":"12345678",
    "password_confirmation":"12345678"
}

Responses:
{
    "message": "User registered successfully",
    "user": {
        "name": "John Doe",
        "email": "admin@demo.com",
        "role": "user",
        "updated_at": "2024-09-24T09:03:01.000000Z",
        "created_at": "2024-09-24T09:03:01.000000Z",
        "id": 2
    },
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL3JlZ2lzdGVyIiwiaWF0IjoxNzI3MTY4NTgxLCJleHAiOjE3MjcxNzIxODEsIm5iZiI6MTcyNzE2ODU4MSwianRpIjoieDV3VUhPWEVrZlE5T3ZUYyIsInN1YiI6IjIiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.gPhv6RO_o0DXdWtlMNjcQKDGCVsNc2ByD2GTvka5vjc"
}

2. User Login
Method: POST
Endpoint: /login
Description: Authenticate a user and receive a JWT token.

Request Body:
{
    "email":"admin@demo.com",
    "password":"12345678"
}

Responses:

{
    "message": "Login successful",
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2xvZ2luIiwiaWF0IjoxNzI3MTY4NzMxLCJleHAiOjE3MjcxNzIzMzEsIm5iZiI6MTcyNzE2ODczMSwianRpIjoibUYyNVhGNGpyNTV0SmhJayIsInN1YiI6IjIiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.ecRnQl4CPqARLtEOGPhOgIwhYvsRdZDyUfEOEVdORQ4",
    "user": {
        "id": 2,
        "name": "John Doe",
        "email": "admin@demo.com",
        "email_verified_at": null,
        "role": "user",
        "created_at": "2024-09-24T09:03:01.000000Z",
        "updated_at": "2024-09-24T09:03:01.000000Z"
    }
}


Protected Routes (Requires JWT)
3. Create Loan
Method: POST
Endpoint: /loans
Description: Create a new loan.
Request Body:

{
    "user_id": 1,
    "name": "John Doe",
    "loan_amount": 5000,
    "interest_rate": 5,
    "loan_term_months": 12,
    "status": "Pending",
    "payment_due_date": "2024-12-01"
}
Responses:
{
    "user_id": 1,
    "name": "John Doe",
    "loan_amount": 5000,
    "interest_rate": 5,
    "loan_term_months": 12,
    "status": "Pending",
    "payment_due_date": "2024-12-01",
    "updated_at": "2024-09-24T09:26:50.000000Z",
    "created_at": "2024-09-24T09:26:50.000000Z",
    "id": 5
}

4. Retrieve All Loans
Method: GET
Endpoint: /loans
Description: Retrieve all loans.
Responses:
200 OK: Returns an array of loans.

5. Retrieve a Specific Loan
Method: GET
Endpoint: /loans/{loanId}
Description: Retrieve a specific loan by ID.
Responses:
200 OK: Returns the loan details.
404 Not Found: Loan not found.

6. Update Loan
Method: PUT/PATCH
Endpoint: /loans/{loanId}
Description: Update an existing loan.
Request Body:

{
    "user_id": 1,
    "name": "John Doe",
    "loan_amount": 6000,
    "interest_rate": 4,
    "loan_term_months": 12,
    "status": "Approved",
    "payment_due_date": "2024-12-01"
}
Responses:
200 OK: Loan updated successfully.
404 Not Found: Loan not found.
400 Bad Request: Validation errors.

7. Delete Loan
Method: DELETE
Endpoint: /loans/{loanId}
Description: Delete a specific loan by ID.
Responses:
200 OK: Loan deleted successfully.
404 Not Found: Loan not found.


8. Calculate Loan Repayment
Method: POST
Endpoint: /loans/calculate
Description: Calculate the total repayment amount for a loan.
Request Body:

{
    "principal": 5000,
    "interest_rate": 5,
    "loan_term_months": 12
}
Responses:
{
    "total_repayment": "5,250.00",
    "monthly_repayment": "437.50"
}

9. Update Loan Status
Method: PATCH
Endpoint: /loans/status/{loanId}
Description: Update the status of a loan (Approved/Rejected).

Request Body:
{
    "status": "Approved"
}
Responses:
200 OK: Loan status updated successfully.
404 Not Found: Loan not found.
400 Bad Request: Validation errors.

10. User Logout
Method: POST
Endpoint: /logout
Description: Log out the user and invalidate the JWT token.
Responses:
200 OK: Successfully logged out.

Security
All protected routes require a valid JWT token in the Authorization header as a Bearer token.
Example:

Authorization: Bearer {eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2xvZ2luIiwiaWF0IjoxNzI3MTY4NzMxLCJleHAiOjE3MjcxNzIzMzEsIm5iZiI6MTcyNzE2ODczMSwianRpIjoibUYyNVhGNGpyNTV0SmhJayIsInN1YiI6IjIiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.ecRnQl4CPqARLtEOGPhOgIwhYvsRdZDyUfEOEVdORQ4}



Test cases,
I created the tests for these operations using PHPunit.
Run the this command. "php artisan test".






