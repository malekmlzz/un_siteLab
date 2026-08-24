### un-sit

un_siteLab

A healthcare-oriented web application built with Laravel/PHP for managing information and workflows related to doctors, laboratories, ultrasound services, and patients.

The project focuses on building a structured backend application with authentication, database management, role-based workflows, RESTful APIs, testing, and containerized development.

Overview

"un_siteLab" is a backend-focused healthcare management project designed to organize interactions between different healthcare-related entities.

The application provides a foundation for managing:

- Doctors
- Laboratories
- Ultrasound services
- Patient-related information
- User registration and authentication
- API-based communication
- Database records and relationships

The project was developed as a practical software engineering project with an emphasis on backend architecture, maintainability, and structured API development.

Key Features

Authentication & User Management

- User registration and authentication
- Structured user-related workflows
- Protected application routes
- Role-oriented access patterns

Healthcare Management

The application includes backend functionality related to:

- Doctor registration and management
- Laboratory registration
- Ultrasound service management
- Patient information
- Relationships between healthcare entities

API Development

The project provides API endpoints for interacting with application resources.

The API-oriented architecture makes it possible for different clients or frontend applications to communicate with the backend.

Database Management

The application uses a relational database structure with:

- Migrations
- Models
- Relationships
- Seeders
- Structured database queries

This approach makes the application easier to maintain and reproduce in different environments.

Testing

The repository includes a testing structure to help validate application functionality and reduce regressions during development.

Containerized Development

Docker-related configuration is included to simplify environment setup and provide a more consistent development environment.

Technology Stack

Technology| Purpose
PHP| Backend development
Laravel| Web application framework
MySQL / Relational Database| Data persistence
JavaScript| Frontend/client-side functionality
Docker| Development environment
REST API| Backend communication
PHPUnit / Laravel Testing| Application testing

Project Structure

The project follows a structured Laravel architecture.

un_siteLab/
├── app/
│   ├── Http/
│   ├── Models/
│   └── ...
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── ...
├── routes/
│   ├── api.php
│   ├── web.php
│   └── ...
├── tests/
├── public/
├── resources/
├── Dockerfile
├── docker-compose.yml
└── README.md

Architecture

The application follows Laravel's MVC-oriented architecture:

Client
   │
   ▼
Routes / API
   │
   ▼
Controllers
   │
   ▼
Services / Application Logic
   │
   ▼
Models / Eloquent ORM
   │
   ▼
Relational Database

This structure separates routing, business logic, data models, and persistence concerns.

API-Oriented Design

One of the main goals of the project is to provide a structured backend that can communicate with clients through APIs.

Example resource categories include:

Users
Doctors
Laboratories
Ultrasound Services
Patients

The API structure can be extended as new healthcare workflows are introduced.

Installation

Requirements

Before running the project, make sure you have:

- PHP
- Composer
- Laravel-compatible database
- Node.js and npm
- Docker / Docker Compose (optional)

Clone the repository

git clone https://github.com/malekmlzz/un_siteLab.git
cd un_siteLab

Install PHP dependencies

composer install

Configure environment

Create your environment configuration:

cp .env.example .env

Then configure the database and application settings inside ".env".

Generate application key

php artisan key:generate

Run migrations

php artisan migrate

If the project requires seed data:

php artisan db:seed

Install frontend dependencies

npm install

Start the development server

php artisan serve

The application should then be available through the local Laravel development server.

Docker

Docker configuration is also included in the repository.

A containerized environment can be started using:

docker compose up -d

Use the Docker configuration provided in the repository for environment-specific settings.

Testing

Run the Laravel test suite with:

php artisan test

Testing is used to verify application behavior and help identify regressions during development.

Development Focus

This project demonstrates practical experience with:

- Backend web development
- Laravel/PHP development
- REST API design
- Relational databases
- Authentication
- Data modeling
- MVC architecture
- Docker-based development
- Automated testing
- Healthcare-oriented application workflows

Security Considerations

Because the project handles healthcare-related concepts, security and privacy are important considerations.

Potential production deployments should include additional security measures such as:

- Strong authentication policies
- Authorization and role-based access control
- Input validation
- Secure password storage
- HTTPS
- Rate limiting
- Secure API authentication
- Database access controls
- Logging and monitoring
- Protection of sensitive patient information

This repository should not be considered a production-ready healthcare system without a complete security, privacy, compliance, and deployment review.

Project Status

This project is maintained as a software development project and can be extended with additional healthcare workflows, security improvements, automated tests, and frontend functionality.

Author

Malek

Python Developer | Backend Developer | Cybersecurity Enthusiast

GitHub:
https://github.com/malekmlzz

Disclaimer

This project is intended for educational, development, and demonstration purposes.

Any deployment involving real patient or medical information requires appropriate security controls, privacy protections, legal compliance, and professional review.

#### Api for register laboratory and sonography
##### POST:Send (full_name)(center_number)(phon_number)(role)(password)(password_confirmation)
[http://127.0.0.1:8000/api/v1/register/users]


#### Api for register docter
##### POST:Send (full_name)(national_code)(docter_code)(phon_number)(role)(password)(password_confirmation) 
[http://127.0.0.1:8000/api/v1/register/users]


#### For laboratory and sonography login 
##### POST : send (center_number) (password)
[http://127.0.0.1:8000/api/v1/login/users]

#### For docter login
##### POST : send (national_code) (password)
[http://127.0.0.1:8000/api/v1/login/users]

#### For admin login
##### POST : send(email)(password)
[http://127.0.0.1:8000/api/v1/login/admin]

#### For logOut
[http://127.0.0.1:8000/api/v1/logout]

#### Api panel admin
#### Add docter whit admin
##### POST: send (full_name)(national_code)(docter_code)(phone_number)(role)(password)
[http://127.0.0.1:8000/api/v1/admin/docter/store]

#### Add laboratory 
##### POST:send(full_name)(center_number)(phone_number)(role)(password)
[http://127.0.0.1:8000/api/v1/admin/laboratory/store]

#### Add sonography
##### POST:send(full_name)(center_number)(phone_number)(role)(password)
[http://127.0.0.1:8000/api/v1/admin/sonography/store]

#### Add admin 
##### POST : send(full_name)(email)(role)(password)
[http://127.0.0.1:8000/api/v1/admin/store]

#### api delete users
##### GET: send user_id
[http://127.0.0.1:8000/api/v1/admin/delete/{user_id}]

#### Api show all docter
##### GET : don’t need to any data
[http://127.0.0.1:8000/api/v1/admin/docter]

#### Show all laboratory
[http://127.0.0.1:8000/api/v1/admin/laboratory]

#### Api show all sonography
[http://127.0.0.1:8000/api/v1/admin/sonography]

#### Api show all patient
[http://127.0.0.1:8000/api/v1/admin/patient]

#### Show all admin
[http://127.0.0.1:8000/api/v1/admin]

#### Api dashboard panel admin
[http://127.0.0.1:8000/api/v1/admin/dashborad]

#### Api verify users
##### GET:send user id
[http://127.0.0.1:8000/api/v1/admin/verifyUser/{user_id}]

#### Api insert Experiment patient by laboratory and sonograph
##### POST : send(experiment_name)(national_code)(phon_number)(experiment_file)
[http://127.0.0.1:8000/api/v1/laboratory/dashborad/store]

#### Api serach Experiment patient by Docter
##### POST : send(national_code)(start_data)(end_data)
[http://127.0.0.1:8000/api/v1/docter/dashborad/serach]

#### Api change password into panel users by users (laboratory , sonograph , docter)
##### POST : send(old_password)(new_password)
[http://127.0.0.1:8000/api/v1/changePassword]

#### api download experiment
##### GET:send user id
[http://127.0.0.1:8000/api/v1/download/experiment/{user_id}]

#### Api rest password 
 ##### POST :for lab and sono send(center_number)
 ##### POST : for docter send(national_code)
 [http://127.0.0.1:8000/api/v1/restPassword/sendCode]


 #### Receive code
 ##### POST : send(code)(national_code)(password)
##### POST : send(code)(center_unmber)(password)
[http://127.0.0.1:8000/api/v1/restPassword/vrifyCode]

#### Api show Experiment patient into panel laboratory and sonograph
##### GET :don’t need to any data
[http://127.0.0.1:8000/api/v1/laboratory/dashborad/show]

#### Api show all center
##### GET :don’t need to any data
[http://127.0.0.1:8000/api/v1/all/center]

#### Api user info(profile)
##### GET :don’t need to any data
[http://127.0.0.1:8000/api/v1/user/info]





