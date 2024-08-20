# Smart Leading Test Project

This project is a full-stack application built with Symfony for the backend and Nuxt 3 for the frontend. It utilizes PostgreSQL for data management and provides RESTful API endpoints for managing products, categories, and types. The frontend is styled using Bootstrap and features dynamic routing for product management.

## Assumptions

- The project is set up locally using Laragon for ease of development.
- PostgreSQL is installed and running on the default port (5432).
- The user has access to a terminal with Composer, Node.js, and npm installed.


## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/smart-leading-test-php.git
   cd smart-leading-test-php

composer install

cd frontend
npm install


## Configuration

Update the `.env` file in the Symfony project:
```bash
DATABASE_URL="postgresql://symfony_user:your_password@127.0.0.1:5432/symfony_db?serverVersion=13&charset=utf8"


## Database Setup

1. Create the PostgreSQL database and user.
2. Run migrations:
   ```bash
   php bin/console doctrine:migrations:migrate


## API Endpoints

- **List Types**
  - Method: `GET`
  - URL: `/api/type`
  - Description: Fetch all types.

- **Create Type**
  - Method: `POST`
  - URL: `/api/type/new`
  - Description: Create a new type.
  - Headers: `Content-Type: application/json`


## Frontend Setup (Nuxt 3)

1. Navigate to the frontend directory:
   ```bash
   cd nuxt-product-management


npm run dev


## Conclusion

This project is intended as a test bed for integrating Symfony with PostgreSQL and Nuxt 3. Feel free to contribute or modify the code as needed.

