# JSON2Resume

JSON2Resume converts a JSON into a PDF Resume. It requires a valid PHP webserver and makes use of the FPDF packaged, which is included.

## Installation
Create a copy of the example file. Edit the file and add your resume information to it. It is important that the file remains a valid JSON file.
```BASH
$ cp resume.json.example resume.json
$ vim resume.json
```

Lastly, run the included index.php file on your PHP web server to produce a PDF version of the resume.json file.