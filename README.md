# Hasta La Vista Backend API

Hasta La Vista Backend API is a Laravel-based back-end dashboard system designed to manage various entities such as bookings, orders, products, services, and more. It provides a robust set of APIs for seamless integration with front-end platforms, supporting data exchange through JSON responses. This dashboard is highly scalable, with additional features like managing categories, banners, testimonials, locations, and other customizable settings.

## Features

- **Dashboard Overview**: View all key metrics in one place.
- **Manage Orders & Bookings**: Create, edit, and view bookings and orders.
- **Products & Services Management**: Manage products, services, and their associated packages.
- **Category System**: Supports multiple levels like category, subcategory, and sub-subcategory.
- **Additional Modules**: Manage celebrities, festivals, testimonials, banners, locations, and more.
- **API-Driven**: Easily connect with front-end frameworks like React to get data via JSON responses.

## Prerequisites

- **PHP** >= 8.0
- **Composer**
- **MySQL** 
- **Laravel** 11

## Installation

1. Clone the repository:

    ```bash
    git clone https://github.com/girish104/laravel-backend-api.git
    ```

2. Navigate into the project directory:

    ```bash
    cd laravel-backend-api
    ```

3. Install PHP dependencies using Composer:

    ```bash
    composer install
    ```

4. Create a copy of the `.env` file:

    ```bash
    cp .env.example .env
    ```

5. Generate an application key:

    ```bash
    php artisan key:generate
    ```

6. Set up your database configuration in the `.env` file:

    ```bash
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_username
    DB_PASSWORD=your_database_password
    ```

7. Run database migrations:

    ```bash
    php artisan migrate
    ```

8. Seed the database with initial data (optional):

    ```bash
    php artisan db:seed
    ```

9. Start the Laravel development server:

    ```bash
    php artisan serve
    ```

## API Documentation

The platform exposes several APIs for managing orders, products, services, and more, which can be accessed by integrating with any front-end stack like React, Vue.js, etc. All APIs return data in JSON format for easy handling on the client side.

