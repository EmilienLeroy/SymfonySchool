Symfony School Project
========

## Synopsys

My first project with symfony 3.4 for the school. It's a simple CRUD using Doctrine, Twig, and Mysql.

## Getting Started

### Prerequisites

Before install the project you need to have :


* [PHP 7](http://php.net/)
* [Composer](https://getcomposer.org/download/)
* [Mysql](https://www.mysql.com/)


### Installing

In first clone the project.
```
git clone https://github.com/EmilienLeroy/SymphonySchool.git
```

Install the project. Answer to the question with your database address, port and password.

```
composer install
```

### Database

Create the database with doctrine.

```
php bin/console doctrine:database:create
```

After you need to migrate the database with the last version. To do this use this command :

```
php bin/console doctrine:migrations:migrate
```

When you update the database you need to migrate the database:

```
php bin/console doctrine:migrations:diff
```

And find the version number to execute the migration :

```
php bin/console doctrine:migrations:execute "version"
```

for drop the database :
```
php bin/console doctrine:database:drop --force
```


### Start the project

After do the installation you can run the project with this command :

```
php bin/console server:run
```

Now you can connect to the project with this address :

```
http://localhost:8000
```

### OMDB

For use the OMDB api you need to have a [KEY](http://www.omdbapi.com/).
When you have this key paste it into the **config/parameter.yml** and replace this :

```
OMDB.key: YOUR_OMDB_KEY
```

## Documentation

You can read the doc for the api at this address :

```
http://localhost:8000/api/doc
```

Debug service :

```
bin/console debug:container ShowFinder
```

## License

[The MIT License (MIT)](https://opensource.org/licenses/MIT)