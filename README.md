# School App

Simple Laravel school management application with two services
1. Student Service
2. Teacher Service

## Student Service Client Endpoints
| Url                   | Method |  Inputs             | Description                   | 
|-----------------------|--------|---------------------|-------------------------------|
| /api/login            | POST   | email<br>password   | Student Login                 |
| /api/homework/get     | GET    |                     | Get student's homework        |
| /api/homework/submit  | POST   | homework_id<br>link | Submit student homework       |

## Teacher Service Client Endpoints
| Url                   | Method |  Inputs             | Description                   | 
|-----------------------|--------|---------------------|-------------------------------|
| /api/login            | POST   | email<br>password   | Teacher Login                 |
| /api/homework/create  | POST    | title<br>description<br>assignees (optional) | Create homework with optional assginees     |
| /api/homework/assign  | POST   | homework_id<br>assignees | Assign homework to students       |

## Project Setup
Docker compose is used to build and start the project. upon starting the project docker compose will spin up below containers.
- Student service `student-svc`
- Teacher service `teacher-svc`
- Mysql server `school-app_mysql`
- Phpmyadmin `school-app_phpmyadmin` 

Student service and Teacher service uses `entrypont.sh` to create database, run migration and seed the database. Application containers will be paused for 12 seconds upon start to wait until mysql container is ready to accept connections. Incoming request will not be accepted within this period.

###  Installation
```
# Clone the repositroy
$ git clone https://github.com/sharaf-dev/school-app.git

# Go into the repository
$ cd school-app'

# Build the application
$ docker-compose build

# Run the application
$ docker-compose up
```
> :warning:  Upon starting application containers will take 12 seconds to serve incoming requests

## Testing Application
Import `postman` collection files included in the project root to send requests to the application. scripts are included to extract/assign user token and retrieve/assign service tokens.

1. Student SVC.postman_collection.json
2. Teacher SVC.postman_collection.json

## Running Tests
Sqlite database is being used to run the integration tests. project composer files are generated using `php8`, to install package composer should be php8 compatible. To avoid updating composer version tests can be run inside the docker container.

#### Running tests in project directory
```
# Install application dependencies
$ composer install

# Run test using artisan command
$ composer install
```

#### Running tests in docker container
```
# Build application using docker compose
$ docker-compose build

# Run project using docker compose
$ docker-compose build

# Run test using artisan command
$ docker exec student-svc php artisan test
$ docker exec teacher-svc php artisan test
```

## Design Patterns used in the application
#### Repository Pattern
Repository pattern is used to create a separation between business logic and data persistent layer

#### Services Pattern
Service pattern is used to breakdown business logic into small tasks to improve the re-usability and maintainability
