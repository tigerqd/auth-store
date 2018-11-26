## Getting Started

Prerequisites:
    - there is installed Docker CE (https://docs.docker.com/engine/installation/)
    - there is installed docker-compose utility (https://docs.docker.com/compose/install/)

1. Open terminal in project directory.
    
    Check if your user is in docker group. If it's not - then run this command and relogin 
    ```bash
     sudo usermod -aG docker $USER
    ```
2. Run containers.
    Linux/Ubuntu:
    ```bash
        docker-compose build
        docker-compose up -d 
    ```
    
    MacOS:
    ```bash
        docker-compose -f docker-compose.yml -f docker-compose.osx.yml build
        docker-compose -f docker-compose.yml -f docker-compose.osx.yml up -d
    ```
    
    Or for All Platforms
    ```bash
        make
    ```
    
    In order to assign container`s shell:
        ```bash
            make php
        ```
3. Install composer dependencies:
    ```bash
        docker-compose exec auth-backend composer install
    ```

4. Setup .env file for your needs example in .env.dist

5. Open in browser:
    - http://127.0.0.1:8001

6. Run consumer
    ```bash
        docker-compose exec auth-backend  bin/console messenger:consume-messages amqp
    ```
7. Project api methods
   
   1. ### POST /api/v1/register
      required body
      [
           "password": "test",
           "firstname": "firstname",
           "lastname": "lastname",
           "age": "23",
           "nickname": "test"
      ]
      
   2. ### POST /api/v1/login
      required body
      [
           "password": "test",
           "nickname": "test"
      ]
      
   3. ### GET /api/v1/track?source_label=pageHitEvent


## Docker for Mac Troubleshooting
https://medium.com/@TomKeur/how-get-better-disk-performance-in-docker-for-mac-2ba1244b5b70


```bash
make && make up

make php

composer install --no-scripts
mkdir var/cache
chmod -R 777 var/cache/ var/logs/ var/sessions
```

##Troubleshooting
* Sometimes **docker-compose** command cannot obtain some packages during container build process and fails with error like 
`E: Failed to fetch some package`. Try to turn off VPN.