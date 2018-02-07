Symfony School Project
========

## Synopsys

My first project with symfony 3.4 for the school. It's a simple CRUD using Doctrine, Twig, and Mysql.

## Getting Started

### Prerequisites

Before install the project you need to have :


* PHP 7
* Composer
* Mysql


### Installing

To install the project you need to use this command.

In first install the project. Answer to the question with your database address, port and password.

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

After do this you can run the project with this command :

```
php bin/console server:run
```

Now you can connect to the project with this address :


```
http://127.0.0.1:8000
```

or

```
http://localhost:8000
```

