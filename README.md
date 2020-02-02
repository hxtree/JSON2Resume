# JSON2Resume

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/d96205a06e2a45838b782cc23b07ea95)](https://app.codacy.com/manual/hxtree/JSON2Resume?utm_source=github.com&utm_medium=referral&utm_content=hxtree/JSON2Resume&utm_campaign=Badge_Grade_Dashboard)

JSON2Resume converts a JSON into a PDF Resume. It requires a valid PHP web server and makes use of the FPDF packaged, which is included.

## Installation
Clone the repository. Create a copy of the example file. Edit the file and add your resume information to it. It is important that the file remains a valid JSON file.
```BASH
$ git clone https://github.com/hxtree/JSON2Resume.git
$ cd JSON2Resume
$ cp resume.json.example resume.json
$ vim resume.json
```

Lastly, run the included index.php file on your PHP web server to produce a PDF version of the resume.json file.