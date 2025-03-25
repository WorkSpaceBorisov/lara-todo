# Laravel Application Setup

## Steps to Set Up the Project

### 1. Clone the repository

Clone the repository to your local machine:

git clone git@github.com:WorkSpaceBorisov/lara-todo.git

cd lara-todo

### 2. Install PHP dependencies

composer install

### 3. Set up the environment file

cp .env.example .env

### 4. Generate the application key

php artisan key:generate

### 5. Run migrations

php artisan migrate
