# Vulnerable Web Application - SQL Injection Project Report

## 📋 Project Overview

This project demonstrates a simple web application with intentional SQL injection vulnerabilities for educational purposes. The application is built with PHP and MySQL, and can be deployed using Docker or traditional methods.

## 🎯 Project Objectives

1. Create a vulnerable web application with SQL injection vulnerabilities
2. Demonstrate common SQL injection attack vectors
3. Provide both vulnerable and secure versions for comparison
4. Document the development and deployment process
5. Show proper git workflow for security-focused development

## 🛠️ Technology Stack

- **Backend**: PHP 8.1
- **Database**: MySQL 8.0
- **Web Server**: Apache 2.4 (in Docker container)
- **Containerization**: Docker & Docker Compose
- **Version Control**: Git

## 📁 Project Structure

```
vulnerable-webapp/
├── index.php              # Main vulnerable application
├── database.sql           # Database schema and sample data
├── Dockerfile             # Docker configuration
├── docker-compose.yml     # Multi-container orchestration
├── apache-config.conf     # Apache virtual host configuration
├── nginx-config.conf      # Nginx server block configuration
├── README.md              # This file
├── PROJECT_SUMMARY.md     # Project summary document
├── setup-local-db.sh      # Script to set up local MySQL database
└── .gitignore            # Git ignore rules
```

## 🚀 Deployment Methods

### Docker Deployment (Recommended)

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd vulnerable-webapp
   ```

2. **Start the application stack**
   ```bash
   docker compose up -d
   ```

3. **Access the application**
   - Web Application: `http://localhost:8082`
   - Database: `localhost:3307` (to avoid conflict with local MySQL)

4. **Stop the application**
   ```bash
   docker compose down
   ```

### Local Installation with System MySQL

1. **Set up the database using the provided script**
   ```bash
   ./setup-local-db.sh
   ```

2. **Configure your local web server** (Apache or Nginx) to serve the application

3. **Access the application** via your local web server

## 🔍 Vulnerability Details

### SQL Injection in Login Form

The login form contains a critical SQL injection vulnerability:

```php
// VULNERABLE CODE
$sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
```

### Exploitation Examples

1. **Basic Bypass**: `' OR '1'='1`
2. **Comment-based Bypass**: `' OR 'x'='x' -- `
3. **Union-based Attack**: `' UNION SELECT username, password, 'admin' FROM users -- `

## 🧪 Testing Results

### Successful SQL Injection Tests

1. **Comment-based bypass**:
   - **Payload**: `username=admin' -- &password=anything`
   - **Result**: Successfully logged in as "admin"

2. **OR condition bypass**:
   - **Payload**: `username=' OR '1'='1&password=' OR '1'='1`
   - **Result**: Successfully logged in as "admin"

### Sample Users

The application includes these sample users for testing:
- Username: `admin`, Password: `admin123`
- Username: `user1`, Password: `password1`
- Username: `test`, Password: `test123`
- Username: `guest`, Password: `guest123`

## 🛡️ Secure Version

The secure version is available in the `sql-injection-fix` branch with the following improvements:

- **Prepared Statements**: Using parameterized queries
- **Input Validation**: Proper sanitization of user input
- **Password Hashing**: Using `password_hash()` instead of plain text
- **Error Handling**: Secure error messages without information disclosure
- **Session Security**: Protection against session fixation attacks

## 📊 Git Workflow

This project demonstrates proper git workflow for security development:

- **Main branch**: Contains the vulnerable version for educational purposes
- **sql-injection-fix branch**: Contains the secure version with fixes
- **Descriptive commit messages**: Each commit explains the changes made
- **Progress tracking**: Commits show the evolution of the project

## 📈 Development Process

### Initial Setup
1. Created basic PHP login application with SQL injection vulnerability
2. Designed database schema with users and sensitive data tables
3. Implemented basic UI for login functionality

### Docker Integration
1. Created Dockerfile for PHP/Apache container
2. Created docker-compose.yml for full stack deployment
3. Configured proper startup sequence with health checks
4. Resolved port conflicts with local MySQL installation

### Database Configuration
1. Set up MySQL with proper authentication plugin
2. Implemented database initialization script
3. Added retry mechanism for connection stability
4. Created sample users for testing

### Security Testing
1. Verified SQL injection vulnerabilities work as intended
2. Tested various attack vectors
3. Confirmed successful authentication bypasses

## ⚠️ Security Notice

This application contains **intentional security vulnerabilities** for educational purposes. **DO NOT** use this code in production environments.

Users must:
- Only test on systems they own or have explicit permission to test
- Follow all applicable laws and regulations
- Use this knowledge for ethical security testing only
- Not use these techniques for malicious activities

## 📚 Educational Objectives

After studying this application, you should understand:

1. **How SQL injection works**
2. **Why user input validation is critical**
3. **The dangers of string interpolation in SQL queries**
4. **How to implement secure database access**
5. **Security testing methodologies**
6. **Git workflow for tracking security fixes**

## 🛠️ Security Best Practices (For Production)

1. **Always use prepared statements**
2. **Validate and sanitize all user input**
3. **Implement proper authentication and authorization**
4. **Use password hashing (bcrypt/argon2)**
5. **Enable error logging and monitoring**
6. **Keep software updated**
7. **Implement Web Application Firewall (WAF)**
8. **Regular security testing and code reviews**
9. **Principle of least privilege**
10. **Defense in depth**

## 📝 Conclusion

This project successfully demonstrates:
- A realistic SQL injection vulnerability in a web application
- Proper Docker deployment with health checks and initialization
- Clear documentation of security vulnerabilities for educational purposes
- Git workflow for tracking security-related changes
- Both vulnerable and secure implementations for comparison

The application serves as an excellent learning tool for understanding SQL injection vulnerabilities and how to prevent them in real-world applications.