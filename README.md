## Purpose & requirements
The application must expose an endpoint that accepts two timestamps and a
list of time expressions, and returns a breakdown of the duration between the two timestamps
using the given time expressions. The application should keep track of all the breakdowns
executed in some persistence layer. Another endpoint should be exposed to search these
stored breakdowns by the input timestamps.
A time expression is a string like “[integer]time_unit”. The time unit can be any of: “s” (seconds),
“i” (minutes), “h” (hours), “d” (day), and “m” (months). The optional integer indicates how many
units of the time unit the expression includes, defaulting to 1. You can assume that a month is
always 30 days, instead of using calendar months.

### Technologies

- Docker app
- PHP 8.2.10 (cli) (built: Aug 31 2023 18:52:55) (NTS)
- Laravel Framework 10.23.1
- Composer version 2.6.3 2023-09-15 09:38:21
- sqlite database

### Local

- Navigate to project root directory
- Run "composer install"
- Run "cp .env.example .env"
- Replace DB_DATABASE with absolute path of your sqlite db in .env file i.e. (/var/www/html/database/database.sqlite)
- Run "php artisan key:generate"
- Run "php artisan migrate"
- Run "php artisan serve --port=3000"


### Docker
Prerequisite to run docker app
- Have docker installed
- Navigate to project root directory
- Execute `docker-compose up --build --force-recreate`

## APIs
- **First API**: `http://localhost:3000/api/timestamp-duration-breakdown`
- **Method**: POST
- **Request body**:
The API expects a JSON request body with the following format:
`  {
  "first_timestamp": "2020-03-12 00:10:22",
  "second_timestamp": "2020-03-16 00:11:10",
  "expressions":["3s","1d", "2h", "1m"]
  }`
- **Response**
`  {
  "message": "Difference in times breakdown",
  "data": {
  "1m": 0,
  "1d": "4.00",
  "2h": 0,
  "3s": "16.00"
  }
  }`




- **Second API**: `localhost:3000/api/search-timestamps?first_timestamp=2020-03-12 00:10:22&second_timestamp=2020-03-16 00:11:10`
- **Method**: GET
- **Response**
  `{
  "message": "Time breakdown history",
  "data": {
  "id": 1,
  "first_timestamp": "2020-03-12 00:10:22",
  "second_timestamp": "2020-03-16 00:11:10",
  "expressions": [
  "3s",
  "1d",
  "2h",
  "1m"
  ],
  "time_breakdown": {
  "1m": 0,
  "1d": "4.00",
  "2h": 0,
  "3s": "16.00"
  },
  "created_at": "2023-09-17T18:32:29.000000Z",
  "updated_at": "2023-09-17T18:32:29.000000Z"
  }
  }`

## Journal
Please go through JOURNAL.md for more details around the project.
