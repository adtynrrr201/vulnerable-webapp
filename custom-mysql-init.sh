#!/bin/bash
set -e

# Run the original entrypoint to initialize MySQL
docker-entrypoint.sh mysqld &
MYSQL_PID=$!

# Wait for MySQL to be ready
until mysqladmin ping -h localhost --silent; do
  sleep 1
done

# Create the database and import schema
mysql -u root -proot -e "CREATE DATABASE IF NOT EXISTS vulnerable_app;"
mysql -u root -proot vulnerable_app < /docker-entrypoint-initdb.d/init.sql

# Kill the temporary MySQL process
kill $MYSQL_PID

# Now run the original entrypoint again normally
exec docker-entrypoint.sh mysqld