# JSON2Resume

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/d96205a06e2a45838b782cc23b07ea95)](https://app.codacy.com/gh/hxtree/JSON2Resume/)

## Overview
JSON2Resume is a powerful tool that converts a JSON array into a PDF resume.

## Key Features

* **Layers**: The tool excels at separating the presentation layer from the data, allowing for the seamless autogeneration of PDF resumes. You can provide your resume content in a structured JSON format, and JSON2Resume will handle the formatting and layout to produce a professional-looking PDF resume. This format not only simplifies the resume creation process but also ensures that your qualifications and experiences are presented in a compelling manner, increasing your chances of making a strong impression on potential employers.

* **Effortless Data Edits**: With JSON2Resume, you can effortlessly customize and update your resumes, tailoring them to different job opportunities while maintaining the successful format. This approach streamlines the entire resume-building process, giving you the confidence that your application stands out and effectively showcases your skills and achievements to prospective employers.

* **Fixed Top-notch PDF Format**: A unique feature of this tool is only one format is supported which was inspired by Barack Obama highly successful resume from when he was a U.S. Senator. By leveraging this proven format, JSON2Resume ensures that your resume follows a well-structured and effective layout that has been recognized for its impact.

## Best Practices 

### Master Resume

You are advised to prepare a Master Resume, which should be kept private and contain all your achievements, skills, work history, education, and other relevant details. This document serves as a comprehensive record of your professional background. To ensure its safety, store this file with redundancy to account for data failures, as it is a dynamic and constantly updated document.

The Master Resume typically spans 4 to 6 pages. Creating and maintaining this file will prove beneficial, as it will significantly save you time when generating your Targeted/Customized Resume tailored for specific job applications.

### Targeted/Customized Resume

The Master Resume serves as your reference for creating a Targeted/Customized resume. When applying for a potential job posting, you will use the Targeted/Customized resume. This version is specifically tailored to highlight the most relevant skills, experiences, and achievements that match the requirements of the job you are applying for. By copying and pasting relevant information from the Master Resume, you can ensure that your application aligns closely with the specific job opportunity, increasing your chances of landing the position.

![Resume Example](https://github.com/hxtree/JSON2Resume/raw/master/docs/example.png "Screenshot")

## Usage

Prerequisite: install [Docker](https://docs.docker.com/get-docker/) and Docker Compose.

1. Clone this repo using [Git](https://git-scm.com/downloads).
    ```bash
    git clone git@github.com:hxtree/JSON2Resume.git
    ```

2. Create a resume file:

    ```bash
    cp resume.json.example resume.json
    ```

3. Start the service and view service in browser [http://localhost](http://localhost):

    ```bash
    docker-compose up
    docker exec --user root json2resume-php-fpm composer update -d .
    ```

## Contributing

JSON2Resume warmly welcomes contributions from the community. Whether you're interested in fixing bugs, adding new features, or improving documentation, your contributions are valuable. To contribute, follow our guidelines outlined in CONTRIBUTING.md.

## License

JSON2Resume is licensed under the MIT License. Feel free to use, modify, and distribute the tool as per the terms of the license.

## Contact

If you have any questions, feedback, or need support, please feel free to reach out via GitHub issues.

Thank you for using JSON2Resume, and happy resume building!

<!-- [resume.json](https://gist.github.com/hxtree/6a0990af34040740ae7f5bd290814dd6) -->
