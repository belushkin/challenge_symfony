# ecocode coding test

We have a small application that currently can only show the users a list of movies like IMDB does. 
The final product should contain the whole IMDB database and will give the users the opportunity
to mark their favorites. 




## Setup
If you want to set up the sample project, you can load the fixtures to get some sample data.


## Tasks
suggested time limit for the whole test is between 2-4 hours.

- review/refactor/debug the php files (templates can be ignored) according to your interpretation of clean code
  
  if you have improvements/suggestions that have not been implemented write them down under 
  [further improvements](#markdown-header-further-improvements) 
- Fill the User properties "last_login" and login_count" correctly
- Think about a concept how import over 6 million titles from im db und update them on a daily base



## Results submission
create a new repository with the current code base. commit your changes and send us a link to the repository


## Further improvements

- Adding pager to the list of the films
- Adding search field
- Adding RabbitMQ/Amazon SQS for asynchronous updating database on daily basis
- Add Elastic search for quick search of the films
- Add Nginx instead of built in Symfony Web Server
- Add recommendation system to help user mark their favorites
- Add tests (phpUnit, Behat)
- Add caching system like Redis/Memcache
- Possibly switch to no-sql solution to optimize highload with 6 million records
- It is reasonable to switch to Master/Slave database design and set more slaves to read data since reading will be the 
bottleneck in this configuration.
- Maintain indexes
- Possibly do day and night data processing

## Prerequisites

Docker.io and docker-compose must be installed in the system in order to be able to use the app. OS Linux

## How to setup the application:

```php
git clone https://github.com/belushkin/tmpr.git
cd tmpr; ./toolbox.sh up
./toolbox.sh exec php bin/console doctrine:schema:create
./toolbox.sh ssh
php bin/console doctrine:fixtures:load [Y]
```

## URL of the running app
http://localhost:8000

http://localhost:8080 (adminer)

## Basic script usage:

Application has toolbox.sh script. It is very easy run, stop, ssh, rebuild, run tests and stop the application.

```php
./toolbox.sh up # run the application
./toolbox.sh rebuild # rebuild the image
./toolbox.sh ssh # ssh to the container
./toolbox.sh exec # exec command inside the container
./toolbox.sh tests # run tests
./toolbox.sh down # stop the application
```

## Contributors
@belushkin

## License
MIT License
