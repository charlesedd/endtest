# Endtest
A work in progress solution for End programming test to create a micro services API.
-- This is unfinished

# Installation
This project is designed to be run inside the laveral homestead vagrant container
For details on how to set that up see the documentation at https://laravel.com/docs/5.8/homestead 
composer install
run migrations 

# Usage
http://homestead.test/shipping_rate/ should be used as the crud API endpoint with http://homestead.test/shipping_rate/calculate/ being used as the endpoint to calculate the shippingg rates and update the order totals.

# To Do
Add unit test
Finish all the crud end points, can add records currently but not update delete etc.
