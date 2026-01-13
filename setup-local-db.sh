#!/bin/bash

# Script to set up the vulnerable web application database in local MySQL

echo "Setting up vulnerable web application database in local MySQL..."

# Check if MySQL is running
if ! mysql -u root -p'rootpassword' -e "SELECT 1;" >/dev/null 2>&1; then
    echo "Attempting to start MySQL service..."
    sudo service mysql start 2>/dev/null || sudo systemctl start mysql 2>/dev/null

    # Wait a moment for MySQL to start
    sleep 3
fi

# Check again if MySQL is accessible
if mysql -u root -p'rootpassword' -e "SELECT 1;" >/dev/null 2>&1; then
    echo "MySQL is accessible."
else
    echo "ERROR: Cannot access MySQL. Please ensure MySQL is running and accessible with 'mysql -u root -p'rootpassword''"
    echo "Make sure your MySQL root password is 'rootpassword'."
    exit 1
fi

# Create database and import schema
echo "Creating database 'vulnerable_app'..."
mysql -u root -p'rootpassword' -e "CREATE DATABASE IF NOT EXISTS vulnerable_app;"

echo "Importing database schema and sample data..."
mysql -u root -p'rootpassword' vulnerable_app < database.sql

if [ $? -eq 0 ]; then
    echo "Database setup completed successfully!"
    echo ""
    echo "To run the application with local MySQL:"
    echo "1. Make sure MySQL is running"
    echo "2. Access the application via your local web server (Apache/Nginx)"
    echo "3. The application will connect to your local MySQL installation"
    echo ""
    echo "Default credentials for testing:"
    echo "  Username: admin"
    echo "  Password: admin123"
    echo ""
    echo "SQL Injection test examples:"
    echo "  Username: ' OR '1'='1"
    echo "  Password: anything"
else
    echo "ERROR: Failed to import database schema."
    exit 1
fi