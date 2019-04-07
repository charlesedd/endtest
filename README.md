# Endtest
A work in progress solution for End programming test to create a micro services API.

# Installation
This project is designed to be run inside the laveral homestead vagrant container
For details on how to set that up see the documentation at https://laravel.com/docs/5.8/homestead 

composer install
```composer global require "laravel/installer"```

run migrations 
```php artisan migrate```

Add the data via the shipping data via the end points

Run the unit tests
```phpunit```
These should fail without the data in the DB

# Usage
http://homestead.test/shipping_rate/ should be used as the crud API endpoint with http://homestead.test/shipping_rate/calculate/ being used as the endpoint to calculate the shipping rates and update the order totals.


