# MRBS v1.12.2

This is the Docker environment for the Meeting Room Booking System (MRBS) **version 1.12.2**. The code and default configuration are already bundled inside the image.

The official Docker Hub image is available at: https://hub.docker.com/r/jirho/mrbs

You can run this setup either using the pre-built image or by using the `docker-compose.yml` and `Dockerfile` directly from the repository.

## Installation

1. Create a directory for your installation and navigate into it:
   ```bash
   mkdir mrbs-docker && cd mrbs-docker
   ```

   *If this is a fresh installation, download the database schema file to initialize the DB:*
   ```bash
   curl -sSLO https://raw.githubusercontent.com/meeting-room-booking-system/mrbs-code/master/tables.my.sql
   ```

2. Create a `docker-compose.yml` file with the following content:
   ```yaml
   services:
       mrbs:
           image: jirho/mrbs:v1.12.2
           container_name: mrbs
           ports:
               - "8080:80"
           restart: unless-stopped
       db:
           image: mysql:8.0
           container_name: mrbs_db
           ports:
               - "3306:3306"
           command: --default-authentication-plugin=mysql_native_password
           environment:
               MYSQL_DATABASE: mrbs
               MYSQL_USER: mrbs
               MYSQL_PASSWORD: mrbs
               MYSQL_ROOT_PASSWORD: mrbs
           volumes:
               # ONLY include the line below on a fresh installation. Remove/comment it out if upgrading/migrating:
               - ./tables.my.sql:/docker-entrypoint-initdb.d/010-tables.sql
               - persistent:/var/lib/mysql
           restart: unless-stopped
   volumes:
       persistent:
   ```

3. Start the services:
   ```bash
   docker compose up -d
   ```

4. **Done!** You can access the service at:
   * **MRBS Web:** http://localhost:8080
