# To install project
    1.install docker 
    2.install docker-composer

#Go to /bin/php8/DockerFile
change var $user to your pc user 
or comment this line container work with root user 

    RUN chown $user /var/www/html
    USER $user

# Repair your env
    rename .env-sample to .env
    rename docker-compose-sample.yml to docker-compose.yml

# Rebuild docker images
    docker-compose up -d --no-deps --build

# Down docker images
    docker-compose down

# List docker Containers
    docker container ls -a
    docker ps -a 

# List docker images
    docker images -q

# Execute docker images
    sudo docker exec -it $container_name bash

# Remove All Containers
    docker -rm -f $(docker ps -a -q)

# Remove All images
    docker -rmi -f $(docker images -a -q)

# Show Logs 
     docker-compose logs
