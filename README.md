# Job Portal Laravel Application

This document outlines the conceptual and technical plan for building a Job Portal application using the Laravel framework.

## Setup and Installation

To run this application on your local machine, please follow these steps.

**Prerequisites:**
- PHP >= 8.2
- Composer
- A database server (e.g., MySQL, PostgreSQL)

**Steps:**

1.  **Clone the repository:**
    ```bash
    git clone <repository-url>
    cd <repository-directory>
    ```

2.  **Install PHP dependencies:**
    ```bash
    composer install
    ```

3.  **Create your environment file:**
    ```bash
    cp .env.example .env
    ```

4.  **Generate an application key:**
    ```bash
    php artisan key:generate
    ```

5.  **Configure your database:**
    Open the `.env` file and update the `DB_*` variables with your database credentials.
    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=job_portal
    DB_USERNAME=root
    DB_PASSWORD=
    ```

6.  **Run the database migrations:**
    This will create all the necessary tables in your database.
    ```bash
    php artisan migrate
    ```

7.  **Create the storage link:**
    This is necessary for the company logos to be publicly accessible.
    ```bash
    php artisan storage:link
    ```

8.  **Serve the application:**
    ```bash
    php artisan serve
    ```
    The application will now be running on `http://127.0.0.1:8000`.

## Task 1: Concept

### Sitemap

- `/` - Homepage (List of recent jobs)
- `/jobs` - List of all jobs (index)
- `/jobs/{id}` - Details of a single job (show)
- `/jobs/create` - Form to create a new job (create)
- `/jobs/{id}/edit` - Form to edit a job (edit)
- `/companies` - List of all companies (index)
- `/companies/{id}` - Details of a single company (show)
- `/companies/create` - Form to create a new company (create)
- `/companies/{id}/edit` - Form to edit a company (edit)
- `/categories` - List of all categories (index)
- `/categories/{id}` - Details of a single category (show)
- `/categories/create` - Form to create a new category (create)
- `/categories/{id}/edit` - Form to edit a category (edit)
- `/login` - User login page
- `/register` - User registration page
- `/dashboard` - User dashboard

### Models, Attributes, and Relationships

#### User
- `id` (PK)
- `name` (string)
- `email` (string, unique)
- `password` (string)
- `role` (enum: 'admin', 'user')
- `remember_token`
- `timestamps`
- **Relationships:**
  - A User (admin) can post many Jobs.
  - A User can own one Company.

#### Company
- `id` (PK)
- `name` (string)
- `description` (text)
- `website` (string, nullable)
- `logo` (string, nullable) - *Image Upload*
- `user_id` (FK to User)
- `timestamps`
- **Relationships:**
  - Has many Jobs.
  - Belongs to a User.

#### Category
- `id` (PK)
- `name` (string)
- `slug` (string, unique)
- `timestamps`
- **Relationships:**
  - Has many Jobs.

#### Job
- `id` (PK)
- `title` (string)
- `description` (text)
- `location` (string)
- `type` (enum: 'full-time', 'part-time', 'contract')
- `salary` (string, nullable)
- `company_id` (FK to Company)
- `category_id` (FK to Category)
- `user_id` (FK to User, the poster)
- `timestamps`
- **Relationships:**
  - Belongs to a Company.
  - Belongs to a Category.
  - Belongs to a User.

### User Permissions (Policies)

- **Guests:**
  - Can view lists (jobs, companies, categories).
  - Can view detail pages.
  - Cannot create, edit, or delete.
- **Authenticated Users ('user' role):**
  - Can manage their own company profile.
- **Admin Users ('admin' role):**
  - Full CRUD permissions on Jobs, Companies, and Categories.
  - Can manage users.
