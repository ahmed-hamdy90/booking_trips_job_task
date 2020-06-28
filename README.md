### Simple Booking trips system Using Laravel 7+

Booking trips system include check for available trips into one day, plus booking any available seat under trip.
any trip can be direct trip (like Cairo to Alexandria trip) or trip include more than one stop stations between pickup station and final station
(like Cairo, tanta, alexandria trip) So user can booking any internal trip only not the full one.

To access application's source code under `src` folder 

project's technologies stack: `PHP`, `MySql`, `Laravel 7+`, `Eloquent` 

project depend on Laravel migrations to setup MySql Database schema (see src/database/migrations), also setting dummy data using Laravel Seeder (see src/database/seeds),
here simple schema 
```
db:
 
 - Cities table -> id, name, code
 
 - Trips table -> id, departure_city_id, destination_city_id, date, departure_time, expected_trip_hours, expected_trip_minutes, expected_trip_seconds, total_seats_number, parent_trip_id, available_seats_number

 - Trips_booking_seats table -> trip_id, seat_number, booking_user_name, booking_user_email
```

project Can Run using Vagrant box, To install vagrant [See official Doc](https://www.vagrantup.com/downloads.html) you must install virtualBox first [See official Doc](https://www.virtualbox.org/wiki/Downloads)

#### How To Run Simple

- create your own `.env` file, to setting `Mysql` Database, 
(configuration for vagrant box only)
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rubosta_task_db -> change with your db_name
DB_USERNAME=vagrant -> change with your admin username
DB_PASSWORD=vagrant -> change with your admin passord
```

- Run Vagrant box
```shell script
vagant up
``` 

- using Postman
```
http://localhost:8686/api/trips
```

##### Possible Routes

- [GET] Retrieve the available trips for day,
Take three mandatory query string:
  - form: represent city's code which user will be pickup (first station)
  - to: represent city's code which user will land into (final station)
  - date: represent day which need to check available trips, take format `YYYY-mm-dd`
```
http://localhost:8686/api/trips
```
**Example:**
```
http://localhost:8686/api/trips?from=CA&to=FA&date=2020-06-27
```

- [POST] Booking any available seat into exists trip,
post Data as Json consist of:
  - tripId: represent trip id value
  - user object: represent user information, name and email
```
http://localhost:8686/api/booking-trip
```
**Example:** Here POST data and the same above url
```json
{
	"tripId": 1,
	"user": {
		"name": "ahmed",
		"email": "ahmed@test.com"
	}
}
``` 
 
#### Notices:

 - To access code under Vagrant box
 ```shell script
vagrant ssh

cd /var/www/src
``` 

#### TODO:

 - Fix bug of determine new booking Seat number
 
 - create unit test for exists the domain services classes
 
 - using .travis CI 
 
 - Using Docker to Run project beside Vagrant box