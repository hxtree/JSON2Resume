# JSON2Resume

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/d96205a06e2a45838b782cc23b07ea95)](https://app.codacy.com/gh/hxtree/JSON2Resume/)

JSON2Resume converts a JSON into a PDF Resume.

![Resume Example](https://github.com/hxtree/JSON2Resume/raw/master/docs/example.png "Screenshot")

## Installation

A valid PHP web server is required. Clone the repository. Create a copy of the example file. Edit the file and add your resume information to it. It is important that the file remains a valid JSON file.


1. Clone this repo using [Git](https://git-scm.com/downloads).
    ```
    git clone git@github.com:hxtree/JSON2Resume.git
    ```

2. Install [Docker](https://docs.docker.com/get-docker/), [VSCode](https://code.visualstudio.com/), and the [Remote - Containers](https://code.visualstudio.com/docs/remote/containers-tutorial) extension.

3. Open repo Project Folder using VSCode and build and connect to remote container.

4. Create a resume file.
    ```bash
    cp resume.json.example resume.json
    ```

5. View service in browser [http://localhost](http://localhost)
