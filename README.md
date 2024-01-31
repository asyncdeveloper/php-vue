# PHP/Vue Subscription App

## Description

This project was built with PHP and Vue.

## Running the Application

### With Docker

To run the Application, you must install:

- **Docker** (https://www.docker.com/products/docker-desktop)

Then run this command in project root - This will install dependencies for both client and server (might take some time)

```console
$ make up
```

You should be able to visit your client (frontend)  at http://localhost:5173

You should be able to visit your server (backend) at http://localhost:8080

### Environment (Server)

An `.env` is auto created from `.env.example` on project install you can change any of the values as needed.

### Design Doc

[see here for design document](design.md)

# API documentation:

API End points and documentation can be found at:
[Postman Documentation](https://documenter.getpostman.com/view/5928045/2s9Yyth1mF)

List of all API endpoints:

> POST /api/subscribers

> GET /api/subscribers

> GET /api/subscribers{id}

### TODO (could not complete due to time constraint)

- Document API using swagger UI
- Add automated tests on client and server side
- Implement a cache layer(redis)
- configure error pages on nginx
