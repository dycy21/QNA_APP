# 🚀 Guest Check-in Automation System

This application, built entirely on **Laravel (PHP/MySQL)**, provides a unified, secure, and streamlined process for property administrators to manage guest bookings, collect compliance details (ID verification), and deliver custom, conditional check-in instructions.

## 1. ⚙️ Local Installation Guide

Follow these steps to get a functional copy of the application running on your local machine using a standard MySQL setup.

### Prerequisites

* **PHP:** Version 8.2 or higher.
* **Composer:** Installed globally.
* **MySQL:** Database server installed and running locally.
* **Git:** For cloning the repository.

### Setup Instructions

1.  **Clone the Repository:**
    ```bash
    git clone [YOUR_REPOSITORY_URL] qna_app
    cd qna_app
    ```

2.  **Install Dependencies:**
    ```bash
    composer install
    ```

3.  **Configure Environment:**
    ```bash
    cp .env.example .env
    ```

4.  **Update `.env`:** Edit the `.env` file and set the following variables for your **local MySQL database**:
    * `APP_KEY`: Must be set using the command below.
    * `DB_DATABASE`: Your local MySQL database name (e.g., `qna_db`).
    * `DB_USERNAME`: Your local database username (e.g., `root`).
    * `DB_PASSWORD`: Your local database password.

5.  **Generate Key and Link Storage:**
    ```bash
    php artisan key:generate
    php artisan storage:link
    ```

6.  **Run Migrations and Seed Admin:**
    This command clears the database, rebuilds the schema, and creates the default administrator account.
    ```bash
    php artisan migrate:fresh --seed --class=AdminUserSeeder
    ```

7.  **Serve Application:**
    ```bash
    php artisan serve
    ```
    Access the application locally (e.g., at `http://127.0.0.1:8000/`).

***

## 2. 🗺️ Application Workflow and Features

The application operates in two critical phases, ensuring security, compliance, and personalized delivery.

### Admin Setup Phase (Protected)

1.  **Content Creation:** Admin creates **Instruction Pages** and **Properties**.
2.  **Unified Editor:** The interface for creating and managing Instruction Pages and Steps is unified on a single page, featuring **drag-and-drop ordering** and an **instant image preview**.
3.  **Logic Linking:** Admin sets a primary check-in **Question** for a Property, mapping each potential **Answer** to a specific Instruction Page.
4.  **Booking:** Admin creates a **Guest Booking**, which generates a secure **Magic Link**.

### Guest Execution Flow (Dynamic)

1.  **Link Access:** Guest clicks the Magic Link.
2.  **Date Check:** System verifies the guest token and checks the current date.
3.  **Compliance Gate:** Guest is required to confirm contact details and **upload a Government ID photo**.
4.  **Conditional Routing:** After compliance, the **Check-in Question** is presented.
5.  **Instruction Delivery:** Based on the guest's **Answer**, they are instantly routed to the correct, step-by-step **Instruction Page**.

***

## 3. ☁️ Deployment Guide: Railway

Railway is recommended for its stability and automated database setup.

### A. Pre-Deployment Checks

1.  **Code Ready:** Ensure your local code is committed and pushed to GitHub/GitLab.
2.  **Build Scripts:** Verify that **`Procfile`** and **`build.sh`** are committed to the root of your repository.

### B. Railway Configuration (Dashboard Actions)

1.  **Project Setup:** Create a new Railway project linked to your repository.
2.  **Add Database:** Add a **MySQL** service.
3.  **Set Environment Variables:** In the **Variables** tab of your Application Service, set the following critical variables using the values injected by the MySQL service (e.g., `MYSQLHOST`):
    * `DB_CONNECTION`: `mysql`
    * `DB_HOST`: `${{MYSQL.HOST}}`
    * `DB_USERNAME`: `${{MYSQL.USERNAME}}`
    * `DB_PASSWORD`: `${{MYSQL.PASSWORD}}`
    * `APP_KEY`: (Manually generated key)

### C. Final Launch (Railway Terminal/CLI)

After the build completes, access the **Railway Web Terminal** to finalize the database setup on the live MySQL server:

1.  **Run Migrations:** (Creates all tables in the live database)
    ```bash
    php artisan migrate --force
    ```

2.  **Seed Admin User:** (Creates your login credentials)
    ```bash
    php artisan db:seed --class=AdminUserSeeder
    ```
    Your site will be live and fully functional at the generated Railway URL.
