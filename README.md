# Petstore API Server

API Server framework is [BulletPHP](http://bulletphp.com), chosen because it's
lightweight and easy to pull something together. I haven't used it prior to this
test. Not sure I would again, either.


**Notes**

- For ease of testing, a docker-compose stack is pre-configured:
  - PHP 7.2
  - MariaDB
- Only `user` and `pet` endpoints are implemented and partial tests written
- No authentication mechanisms in place


## Running the API Server

```bash
composer install
docker-compose up
```


## Curl'ing

```bash
curl -X POST "http://127.0.0.1:8989/user" \
  -H "accept: application/json" \
  -H "Content-Type: application/json" \
  -d "{ \"username\": \"jcurnow\", \"firstName\": \"Jamie\", \"lastName\": \"Curnow\", \"email\": \"jc@jc21.com\", \"password\": \"changeme\", \"phone\": \"04329865564\", \"userStatus\": 0}"

curl -X DELETE "http://127.0.0.1:8989/user/jcurnow" \
  -H "accept: application/json" \
  -H "Content-Type: application/json"
```


## Running unit tests

API Tests were written in [Codeception](https://codeception.com).

```bash
docker-compose exec api /app/testing/run
```
