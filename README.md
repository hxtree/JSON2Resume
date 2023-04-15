# JSON2Resume

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/d96205a06e2a45838b782cc23b07ea95)](https://app.codacy.com/gh/hxtree/JSON2Resume/)

JSON2Resume converts a JSON array into a PDF resume.

![Resume Example](https://github.com/hxtree/JSON2Resume/raw/master/docs/example.png "Screenshot")

## Usage

1. Clone this repo using [Git](https://git-scm.com/downloads).
    ```bash
    git clone git@github.com:hxtree/JSON2Resume.git
    ```

2. Install [Docker](https://docs.docker.com/get-docker/) and Docker Compose.

3. Create a resume file:

    ```bash
    cp resume.json.example resume.json
    ```

4. Start the service:

    ```bash
    docker-compose up
    docker exec --user root json2resume-php-fpm composer update -d .
    ```

5. View service in browser [http://localhost](http://localhost)
