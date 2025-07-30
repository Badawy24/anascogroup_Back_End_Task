AnascoGroup Backend Task - Laravel 11 API

✅ Features

🔐 Authentication

Register, login, logout with Laravel Sanctum tokens.

📦 Subscription Plans

View available plans (from database seed).

💳 Stripe Checkout

Initiate Stripe payment session

Webhook to confirm successful payments

Log transactions in the database

📟 Transactions

View user's payment history

🛡️ Clean Architecture

Form Requests

Services

Repositories

Route Versioning: api/v1

🔪 API Endpoints

🔑 Authentication

POST /api/v1/register

POST /api/v1/login

POST /api/v1/logout

📦 Plans

GET /api/v1/plans

💳 Stripe Payments

POST /api/v1/checkout/stripe

POST /api/v1/checkout/paypal -- Not completed

📟 Transactions

GET /api/v1/my-transactions

🛠️ Setup Instructions

Clone the repository:

git clone https://github.com/Badawy24/anascogroup_Back_End_Task.git
cd anascogroup_Back_End_Task

Install dependencies:

composer install

Copy .env and generate app key:

cp .env.example .env
php artisan key:generate

Configure .env:

Set DB_CONNECTION=sqlite

Set STRIPE_SECRET= and STRIPE_KEY= from Stripe dashboard

Run migrations and seed plans:

php artisan migrate --seed

Serve the application:

php artisan serve

🔪 Sample API Requests

Register

POST /api/v1/register
{
  "name": "Badawy",
  "email": "badawyy@gmail.com",
  "password": "P@ssw0rd",
  "password_confirmation": "P@ssw0rd"
}

Login

POST /api/v1/login
{
  "email": "badawyy@gmail.com",
  "password": "P@ssw0rd"
}

Logout

POST /api/v1/logout

View Plans

GET /api/v1/plans

Checkout (Stripe)

POST /api/v1/checkout/stripe
{
  "plan_id": 1
}

View Transactions

GET /api/v1/my-transactions

📟 Notes

Stripe integration is fully implemented.

PayPal integration is not completed, and is excluded from this version.

Testing is done using Postman.
