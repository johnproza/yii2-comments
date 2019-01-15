Comments extension for items
============================
Comments extension for items

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist johnproza/yii2-comments "*"
```

or add

```
"johnproza/yii2-comments": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Before using you must prepare database
```php
php yii migrate --migrationPath=@vendor/johnproza/yii2-comments/migrations 
```

Module setup
------------

Insert info your config file
```php
'modules' => [
    'comments' => [
        'class' => 'oboom\comments\Module',
    ],
]
```
