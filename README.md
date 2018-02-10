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

Create the database with doctrine.

```
php bin/console doctrine:create
```

After you need to migrate the database with the last version. To do this use this command :

```
php bin/console doctrine:migrations:diff
```

And find the version number to execute the migration :

```
php bin/console doctrine:migrations:execute "version"
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

## Documentation

Coming soon ...

## License

[The MIT License (MIT)](https://opensource.org/licenses/MIT)