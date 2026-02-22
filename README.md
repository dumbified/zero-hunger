# Zero Hunger

A web-based application designed to bridge the gap between food donors (restaurants, supermarkets, individuals) and those in need. By streamlining the process of collecting, managing, and distributing surplus food, we aim to reduce food waste and combat hunger in our community.

## Features

### For Community
*   **Donation Portal:** Easy-to-use form for donors to schedule food pickups.
*   **Request Help:** Simple interface for individuals or organizations to request food assistance.

### For Admin
*   **Dashboard Analytics:** Overview of total donations, pending requests, and inventory status.
*   **Donation Management:** Track donations from "Pending" to "Completed". Assign drivers and schedule pickups.
*   **Inventory System:** Manage food stock with expiration dates and storage locations.
*   **Distribution Tracking:** Log food deliveries to beneficiaries (orphanages, shelters, families).
*   **User Management:** Role-based access control (Super Admin, Driver, Viewer).

## Tech Stack

*   **Framework:** [CodeIgniter 4](https://codeigniter.com/) (PHP MVC Framework)
*   **Database:** MySQL
*   **Frontend:** HTML5, Tailwind CSS (via CDN/local), JavaScript
*   **Server:** Apache (via XAMPP)

## Prerequisites

You should have the following installed:
*   [XAMPP](https://www.apachefriends.org/) (PHP 8.1+ and MySQL)
*   [Composer](https://getcomposer.org/)

## Installation

1.  **Clone the Repository**
    ```bash
    git clone https://github.com/yourusername/zero-hunger.git
    cd zero-hunger
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    ```

3.  **Configure Environment**

    *   Open `.env` and set your database credentials:


4.  **Setup Database**
    *   Start **Apache** and **MySQL** in XAMPP.
    *   Create the database named `zero_hunger`

    *   Run migrations to create tables:
        ```bash
        php spark migrate
        ```

5.  **Run the Application**
    ```bash
    php spark serve
    ```
        and run at: `http://localhost:8080`

## Default Credentials

Use these accounts to log in to the Admin Dashboard (`/admin/login`):

| Role | Username | Password |
| :--- | :--- | :--- |
| **Super Admin** | `admin` | `password` |
| **Driver** | `driver1` | `password` |
