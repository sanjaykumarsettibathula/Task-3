# PHP CRUD Application with User Authentication

![PHP](https://img.shields.io/badge/PHP-8.0%2B-blue)
![MySQL](https://img.shields.io/badge/MySQL-8.0-orange)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.2-purple)

A complete blog application with secure user authentication, admin dashboard, and full CRUD functionality.

## 🌟 Features

- **User Authentication**
  - Secure registration/login with password hashing
  - Session management
  - Role-based access (User/Editor/Admin)

- **Blog Management**
  - Create, Read, Update, Delete posts
  - Rich text content support
  - Post categorization

- **Admin Dashboard**
  - User management system
  - Role modification
  - Content moderation

- **Security**
  - CSRF protection
  - Input validation
  - Prepared statements against SQL injection

## 📦 Installation

1. **Prerequisites**
   - XAMPP/WAMP/MAMP
   - PHP 8.0+
   - MySQL 8.0+

2. **Setup**
   ```bash
   git clone https://github.com/sanjaykumarsettibathula/Task-3.git
   cd Task-3

Database Configuration

Import database.sql from phpMyAdmin

Configure includes/config.php:

php
$host = "localhost";
$user = "your_username";
$pass = "your_password";
$db = "task4_db";
Run Application

Place folder in htdocs

Access via http://localhost/Task-3

🛠️ Project Structure
text
Task-3/
├── admin/
│   ├── admin.php
│   ├── delete_user.php
│   └── update_role.php
├── includes/
│   ├── config.php
│   ├── header.php
│   ├── footer.php
│   └── validation.php
├── assets/
│   ├── css/
│   └── js/
├── screenshots/
├── database.sql
├── index.php
├── login.php
├── register.php
├── dashboard.php
└── README.md
🚀 Technologies Used
Frontend: HTML5, CSS3, JavaScript

Backend: PHP 8.0

Database: MySQL 8.0

Security: Password hashing, CSRF tokens

Styling: Custom CSS with Bootstrap components

📝 Usage
Regular User

Register account

Create/edit your posts

View other posts

Admin

Manage all users

Edit/delete any posts

Assign user roles

🤝 Contributing
Fork the project

Create your feature branch (git checkout -b feature/AmazingFeature)

Commit your changes (git commit -m 'Add some amazing feature')

Push to the branch (git push origin feature/AmazingFeature)

Open a Pull Request

**To add this to your repository:**

1. Save this as `README.md` in your project root
2. Run these commands:

```bash
git add README.md
git commit -m "docs: Add comprehensive README for Task4"
git push origin main

