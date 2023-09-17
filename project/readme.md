Setup:

1. `composer install` in project folder. 
2. get into eco-finance-docker folder & run: `docker-compose up -d`
3. exec in cmd `docker exec -it eco-finance bash`, in container `php public/index.php` it will create database.
4. Works only two routes: `localhost:806/api/push` & `localhost:806/api/sensor/read/172.23.0.1`

P.S. Added postman requests.
