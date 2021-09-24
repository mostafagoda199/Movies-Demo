# Import postman collection link
    https://www.getpostman.com/collections/2c866e2fcaf80b46d09a

# Set database config
    DB_CONNECTION=mysql
    DB_HOST=database
    DB_PORT=3306
    DB_DATABASE=moviesdb
    DB_USERNAME=root
    DB_PASSWORD=admin

# Run test
    php artisan test

# Run schedule task
    php artisan schedule:run

# Run queue worker
    php artisan queue:work --timeout=9999

# Run if any job fail 
    php artisan queue:retry all 

