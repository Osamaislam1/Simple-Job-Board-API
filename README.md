**Simple Job Board API**
This is a RESTful API for a job board application built using Laravel. The API allows users to register, log in, create job listings, apply for jobs, and view applications.

**Features**
User Authentication: Register and log in using Laravel Sanctum for API token authentication.
Job Listings: CRUD operations for job listings with fields like title, description, company, location, and salary.
Job Applications: Apply to jobs and view applications. Each job is associated with the user who created it.
Search: Search job listings by title or location.
JSON Resources: Consistent and structured API responses using Laravel JSON Resources.
Basic Error Handling: Validation and error responses for invalid requests.

**Prerequisites**
PHP 8.2+
Composer
MySQL
Laravel 11.x
Git

**Installation**
1. Clone the repository:
2. git clone https://github.com/Osamaislam1/Simple-Job-Board-API.git
3. cd Simple-Job-Board-API
4. Install dependencies:
    composer install
5. Set up the environment:
6. Copy the .env.example file to .env:
8. Update the .env file with your database credentials:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=job_board
DB_USERNAME=root
DB_PASSWORD=your_password

8. Generate an application key:
     php artisan key:generate
   
10. Run the database migrations:
        php artisan migrate
    
12. Serve the application:
    php artisan serve
    
The API will be accessible at http://127.0.0.1:8000/api/

**API Endpoints**
1. User Authentication
Register: POST /api/register
Login: POST /api/login
Logout: POST /api/logout
2. Job Listings
Create Job: POST /api/jobs
List Jobs: GET /api/jobs
View Job: GET /api/jobs/{id}
Update Job: PUT /api/jobs/{id}
Delete Job: DELETE /api/jobs/{id}
Search Jobs: GET /api/jobs/search
3. Job Applications
Apply for Job: POST /api/applications
View Applications for Job: GET /api/jobs/{job}/applications
View Applications by User: GET /api/user/applications

**API Documentation**
This project uses the Scramble package to automatically generate detailed API documentation.

**Access the API Documentation Website:**

Visit http://127.0.0.1:8000/docs/api to view the full API documentation in your web browser.


**Example Requests**
Here are some example requests you can use to test the API with Postman or CURL.

**Register a new user:**

curl -X POST http://127.0.0.1:8000/api/register \
-H "Content-Type: application/json" \
-d '{"name": "John Doe", "email": "johndoe@example.com", "password": "password123"}'

**Create a new job listing:**
curl -X POST http://127.0.0.1:8000/api/jobs \
-H "Authorization: Bearer your_access_token_here" \
-H "Content-Type: application/json" \
-d '{"title": "Software Engineer", "description": "Develop and maintain web applications.", "company": "Tech Corp", "location": "San Francisco, CA", "salary": 120000}'
