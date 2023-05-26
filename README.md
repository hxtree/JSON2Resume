# JSON2Resume

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/d96205a06e2a45838b782cc23b07ea95)](https://app.codacy.com/gh/hxtree/JSON2Resume/)

JSON2Resume converts a JSON array into a PDF resume. This separates the presentation layer from data allowing for autogenerate PDF resumes.

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

## Formats

Currently only one format is supported which was inspired by Barack Obama resume from when he was a U.S. Senator.

## References

- [resume.json](https://gist.github.com/hxtree/6a0990af34040740ae7f5bd290814dd6)