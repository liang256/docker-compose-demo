# docker-compose-demo
A 5 minutes tutorial shows how to use docker compose

## Why Docker Compose

- Can have different apps require different enviroments on local machine. For example, one app use php5, the other use php7.
- Portible enviroment setup of yout app
- Keep local machine clean. For example, install Composer in container instead of local machine 

## Implement
clone thise [repo](https://github.com/n795113/docker-compose-demo)
```shell
git clone https://github.com/n795113/docker-compose-demo.git
```

### Run A Database
Let's run a MySQL database with phpMyAdmin

```shell=
cd db
docker-compose up -d
```
go to [localhost:8888](http://localhost:8888/) check if the database is up

### Run A Web Server
```shell=
cd php_app
docker-compose up -d
```
go to [localhost:4444](http://localhost:4444/) check if the website served

### Run a Laravel App

```sh
docker exec -ti example-app sh
```

```sh
composer create-project laravel/laravel example-app

# it will panic without this
cp supervisord.conf example-app
cp Envoy.blade.php example-app

exit
```

Remap Nginx serve path to `example-app`. Edit `docker-compose.yml`

```yml
# ...
volumes:
    - ./example-app:/var/www
# ...
```

Recreate the container
```shell=
docker-compose down
docker-compose up -d
```

go to [localhost:4444](http://localhost:4444/) check if the Laravel app served

### Laravel App Connect To DB

1. Create a database. (we can use [phpMyAdmin](http://localhost:8888/) or go into container use CLI)

2. edit `.env` of the Laravel app

    ```
    DB_HOST=172.17.0.1
    DB_PASSWORD=root
    ```

3. go into the container to build tables

    ```sh
    docker exec -ti example-app sh
    ```

    Run this command to check if the app can connect to DB.
    ```sh
    php artisan migrate
    ```

## Recap
- docker volume (mapping local dir to container dir)
- how to manage containers
- container interact with container (172.17.0.1)

## Command cheat sheet

```bash=
# There are 2 ways to go into the container
# 1. by name
# 2. by id

# list all container
docker ps

# go into a container
docker exec -ti <container name or id>

# remove a container
docker rm -f <container name or id>

# build and run a docker compose
docker-compose up

# up in detach mode
docker-compose up -d

# force rebuild
docker-compose up --build

# shot down & remove docker compose
docker-compose down
```
