# Firebase ML Kit demo for Google I/O Extended Georgetown 2019

###  yinsee@3b.my

Presentation slide here

https://docs.google.com/presentation/d/1l49KQE6Rdnvc6eqTozOCO1iquMR8UNxA5bfzz8UhHyk/edit?usp=sharing

# Setting up Google

Setup your Firebase credential file in Google Console

https://cloud.google.com/vision/docs/quickstart-client-libraries

drop the JSON file in the project folder, configure ```.env``` file to incliude the file

for example:
```
GOOGLE_APPLICATION_CREDENTIALS=./mykey-1233456.json
```

# Setting up Laravel
## Install php packages

```
composer install
```

## Run webserver
```
php artisan serve
```

Done! Open http://localhost:8000 in browser
