# Vulnerable Web Application - SQL Injection Demo

## ⚠️ Educational Purpose Only

This application contains **intentional security vulnerabilities** for educational purposes. **DO NOT** use this code in production environments.

## Overview

A simple PHP login system with MySQL backend that demonstrates SQL injection vulnerabilities. The application allows users to bypass authentication using malicious SQL queries.

## Progress Tracking

Throughout the development of this project, I've made several commits to track the progress:

1. **Initial commit**: Basic vulnerable application
2. **Fix SQL injection vulnerability**: Implemented prepared statements and security best practices
3. **Add comprehensive README**: Detailed deployment instructions
4. **Initial project setup**: CLI tool and templates

## Vulnerability Details

### SQL Injection in Login Form

The login form (`index.php:25`) contains a critical SQL injection vulnerability:

```php
// VULNERABLE CODE
$sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
```

### Exploitation Examples

1. **Basic Bypass**: `' OR '1'='1`
2. **Comment-based Bypass**: `' OR 'x'='x' -- `
3. **Union-based Attack**: `' UNION SELECT username, password, 'admin' FROM users -- `

## System Requirements

- PHP 7.4+ or 8.x
- MySQL 5.7+ or MariaDB 10.2+
- Apache 2.4+ or Nginx 1.18+
- Linux/Unix environment (recommended)

## Installation & Deployment

### Option 1: Docker Deployment (Recommended for Development)

1. Make sure you have Docker and Docker Compose installed
2. Run the application stack:
```bash
docker-compose up -d
```
3. The application will be available at: `http://localhost:8080`
4. MySQL database will be available at: `localhost:3306`

### Option 2: Traditional Deployment

#### Step 1: Database Setup

```bash
# Login to MySQL
mysql -u root -p

# Create database and tables
mysql> source /path/to/vulnerable-webapp/database.sql;
```

Or using command line:
```bash
mysql -u root -p < database.sql
```

#### Step 2: Web Server Configuration

##### Apache Deployment

1. Install Apache and PHP:
```bash
sudo apt update
sudo apt install apache2 php php-mysql libapache2-mod-php
```

2. Enable required modules:
```bash
sudo a2enmod php8.1
sudo a2enmod rewrite
```

3. Copy configuration:
```bash
sudo cp apache-config.conf /etc/apache2/sites-available/vulnerable-webapp.conf
sudo a2ensite vulnerable-webapp.conf
sudo systemctl reload apache2
```

4. Set permissions:
```bash
sudo chown -R www-data:www-data /home/adityanur/vulnerable-webapp
sudo chmod -R 755 /home/adityanur/vulnerable-webapp
```

##### Nginx Deployment

1. Install Nginx and PHP-FPM:
```bash
sudo apt install nginx php-fpm php-mysql
```

2. Copy configuration:
```bash
sudo cp nginx-config.conf /etc/nginx/sites-available/vulnerable-webapp
sudo ln -s /etc/nginx/sites-available/vulnerable-webapp /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

3. Configure PHP-FPM:
```bash
sudo systemctl enable php8.1-fpm
sudo systemctl start php8.1-fpm
```

### Step 3: Host Configuration

Add to `/etc/hosts`:
```bash
127.0.0.1 vulnerable-webapp.local
```

### Step 4: Test Deployment

1. Open browser: `http://vulnerable-webapp.local`
2. Test with valid credentials:
   - Username: `admin`
   - Password: `admin123`
3. Test SQL injection with: `' OR '1'='1`

## Project Structure

```
vulnerable-webapp/
├── index.php              # Main vulnerable application
├── database.sql           # Database schema and sample data
├── apache-config.conf     # Apache virtual host configuration
├── nginx-config.conf      # Nginx server block configuration
└── README.md              # This file
```

## Security Fix

The secure version is available in the `sql-injection-fix` branch. Key improvements:

- **Prepared Statements**: Using parameterized queries
- **Input Validation**: Proper sanitization of user input
- **Password Hashing**: Using `password_hash()` instead of plain text
- **Error Handling**: Secure error messages without information disclosure
- **Session Security**: Protection against session fixation attacks
- **Audit Logging**: Security event logging capabilities

Switch to the secure version:
```bash
git checkout sql-injection-fix
```

## Testing the Vulnerability

### Using Browser

1. Navigate to the login page
2. Enter `' OR '1'='1` as username
3. Enter any password
4. Observe successful login bypass

### Using curl

```bash
# Test SQL injection
curl -X POST -d "username=' OR '1'='1&password=anything" \
     http://vulnerable-webapp.local/
```

### Using SQLMap

```bash
sqlmap -u "http://vulnerable-webapp.local/" \
       --data="username=test&password=test" \
       --dbs
```

## Educational Objectives

After studying this application, you should understand:

1. **How SQL injection works**
2. **Why user input validation is critical**
3. **The dangers of string interpolation in SQL queries**
4. **How to implement secure database access**
5. **Security testing methodologies**
6. **Git workflow for tracking security fixes**

## Security Best Practices (For Production)

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

## Git Workflow

This project demonstrates proper git workflow for security development:

- **Main branch**: Contains the vulnerable version for educational purposes
- **sql-injection-fix branch**: Contains the secure version with fixes
- **Descriptive commit messages**: Each commit explains the changes made
- **Progress tracking**: Commits show the evolution of the project

To see the differences between branches:
```bash
git diff main sql-injection-fix
```

## Legal & Ethical Notice

This code is provided for **educational purposes only**. The author assumes no responsibility for misuse of this code. Users must:

- Only test on systems they own or have explicit permission to test
- Follow all applicable laws and regulations
- Use this knowledge for ethical security testing only
- Not use these techniques for malicious activities

## Support

For questions about deployment or security concepts, please refer to:
- OWASP SQL Injection Prevention Guide
- PHP Security Manual
- MySQL Security Documentation

---

**Remember**: Security is not an afterthought - it's a fundamental requirement.