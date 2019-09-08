# repovel

Repovel is used to add an extra layer for services and abstract data access using repositories.

**The Service Layer** is a design pattern that will help you to abstract your logic when you need to use different front-end on your application, for your domain logic.
Actually, you delegate the application logic to a common service (the service layer) and have only one class to maintain when your application grows or needs an update. This is also a good way to clean up your controllers, and make them more readable. [[1](https://m.dotdev.co/design-pattern-service-layer-with-laravel-5-740ff0a7b65f)]

**The Repository Pattern** has gained quite a bit of popularity since it was first introduced as a part of Domain-Driven Design in 2004. Essentially, it provides an abstraction of data, so that your application can work with a simple abstraction that has an interface approximating that of a collection. Meaning, it adds another layer between your application logic and your data source either your database or any external API. [[2](https://deviq.com/repository-pattern/)],[[3](https://www.larashout.com/how-to-use-repository-pattern-in-laravel)]

## Installation

Run the following command from you terminal:

```
composer require imdhemy/repovel
```

## Usage
**Repovel** extends the awesome artisan commands to add two new commands `make:service` and `make:repository` as follows:

### Services
To create a service class, use the `make:service` Artisan CLI command:
```
php artisan make:service StoreBlogPost
```
If you want to create a Form Request class with the required service, add the option `-r`
```
php artisan make:service StoreBlogPost -r
```
This command creates two classes `App\Http\Services\StoreBlogPost` and `App\Http\Requests\StoreBlogPostRequest`

So how the created services are used? Within your controller method you can instantiate your service and return its `handle()` as a response

- `PostController.php`
```php
public function store(StoreBlogPostRequest $request)
{
    return new StoreBlogPost($request);
}
```

Instantiating a service class with a Form request is optional, you can discard the `$request` param:
```php
$service = new StoreBlogPost;
```

- `StoreBlogPost.php`
Write your service logic inside the `handle()` method:
```php
/**
 * Execute service
 *
 * @return mixed
 */
public function handle()
{
    // do some stuff
}
```

You can access the `Illuminate\Foundation\Http\FormRequest` methods inside the service:
```php
$name = $this->input('name');
$validated_name = $this->validated('name');
$all_input = $this->all();
```

### Repositories
To create a repository class, use the `make:repository` Artisan CLI command:

```
php artisan make:repository PostRepository
```

The created class is found in `app\Http\Repositories`, go and add your required methods to retrieve data.

**N.B.** I found that implementing Repository Criteria or forcing some repository methods like(all, get, find and etc ..) by an interface will limit the usage of the created repositories. It's up to you to use them.

### Full Example
```php
<?php

namespace App\Http\Services;

use Imdhemy\Repovel\Contracts\AbstractService as Service;
use App\Repositories\DummyRepository;

class DummyClass extends Service
{
    /**
     * Execute service
     *
     * @return mixed
     */
    public function handle()
    {
        $repository = new DummyRepository();
        $dummies = $repository->all();
        return $dummies;
    }
}
```

## Configuration
The config file `repovel.php` allows you to change the default namespace for services and repositories.
To publish the config files run the following Artisan CLI command
```
php artisan vendor:publish --tag=repovel-configs
```
This copies `[/imdhemy/repovel/src/config/repovel.php]` To `[/config/repovel.php]` where you can edit the default configuration:
```php
return [
    /**
     * ---------------------------------------------------
     * Services configuration
     * ---------------------------------------------------
     *
     */
    'services'  => [
        'namespace' => '\Http\Services' // Default namespace for the services
    ],

     /**
     * ---------------------------------------------------
     * Repositories configuration
     * ---------------------------------------------------
     *
     */
    'repositories' => [
        'namespace' => '\Repositories' // Default namespace for the repositories
    ]
];
```

## License
The contents of this repository is released under the [MIT license](./LICENSE).
