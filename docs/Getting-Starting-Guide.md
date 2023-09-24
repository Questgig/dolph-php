# Getting Started with Dolph-PHP

# Intro
Dolph PHP is an advanced PHP framework designed to elevate the language and empower developers with modern tools and capabilities. It aims to save PHP by bringing cutting-edge features, performance optimizations, and a streamlined development experience to the ecosystem.

# Defining Routes
If you’re new to Dolph PHP, let’s get started by looking at an example of a basic GET route for an application that you can create using Dolph PHP. We'll be using a [Swoole server](https://github.com/swoole/swoole-src) in this example, but you should be able to extend it to any HTTP server.  

## Basic GET Route

```php
use DolphPHP\App;
use DolphPHP\Swoole\Request;
use DolphPHP\Swoole\Response;
use Swoole\Http\Server;
use Swoole\Http\Request as SwooleRequest;
use Swoole\Http\Response as SwooleResponse;

$http = new Server("0.0.0.0", 8080);
 
App::get('/')
   ->inject('request')
   ->inject('response')
   ->action(
       function($request, $response) {
           // Return raw HTML
           $response->send("<div> Hello World! </div>");
       }
/*
   Configure your HTTP server to respond with the Dolph PHP app.   
*/

$http->on('request', function (SwooleRequest $swooleRequest, SwooleResponse $swooleResponse) {
   $request = new Request($swooleRequest);
   $response = new Response($swooleResponse);
   $app = new App('America/Toronto');
   $app->run($request, $response);
});

$http->start();
```
 

Any route in Dolph PHP would require you to `inject` the dependencies ( `$request` and `$response` in this case ) and define the controller by passing a callback to the `action` function. As you might have already guessed, `$request` and `$response` refer to the objects of the HTTP server library you’re using, for example, Swoole in this case. `action` defines the callback function that would be called when the GET request is executed. In this case, raw HTML is returned as a `$response`.

## More Endpoints
You can perform basic CRUD operations like GET, POST, PUT and DELETE using Dolph PHP. Let’s assume there's a file `todos.json` that stores a list of todo objects with the following structure. In a real-world scenario, you would be fetching this information from a database.  

```json
[
    {
        "id": "123",
        "task": "Get groceries",
        "is_complete": false
    },
]
```

You can create a PUT request to update a todo by passing it’s reference `id` along with the values to be updated as follows:

```php
App::put('/todos/:id')
   ->param('id', "", new Wildcard(), 'id of the todo')
   ->param('task', "", new Wildcard(), 'name of the todo')
   ->param('is_complete', true, new Wildcard(), 'task complete or not')
   ->inject('response')
   ->action(
       function($id, $task, $is_complete, $response) {
           $path = \realpath('/app/app/todos.json');
           $data = json_decode(file_get_contents($path));
           foreach($data as $object){
               if($object->id == $id){
                   $object->task = $task;
                   $object->is_complete = $is_complete;
                   break;
               }
           }
           $jsonData = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
           file_put_contents($path, $jsonData);
           $response->json($data);
       }
   );
```

You might have noticed an additional property in the above example, i.e. `param`. Let's discuss about how you can add parameters to Dolph PHP.

### Parameters
All the parameters need to be defined using the `param` property which accepts the following - `$key`, `$default`, `$validator`, `$description`, `$optional` and `$injections`.

There are typically 3 types of parameters:
1. Path params ( eg: `/api/users/<userID>` ) 
2. Query Params ( eg: `/api/users?userId=<userID>`)
3. Body Params ( These are passed in the request body in POST and PUT requests. ) 

Let's take a look at how these three types of params are taken care of by Dolph PHP:

1. Path parameters are specified using `:<param_name>` in the route path and then adding them as a `->param('param_name', <default_value>, 'description')` in the route definition.

2. Query Parameters are specified simply using the `->param()` function.

3. Body Parameters are specified using the `->param()` function as well.

Each of these params then become available to the `->action()` callback function in the same order that they were declared in. 

### Returning a Response
Based on the type of the response you wish to return, multiple options can be used:

* #### Raw HTML
```php
$response->send("<div> Hello World! </div>");
```

`$response->send()` can be used to render raw HTML on the webpage.

* #### JSON Object
```php
$response->json(['Goodbye' => 'World']);
```

JSON objects can be returned by passing the JSON object inside `$response->json()`.


### Setting Response Status 

You can set a status code for your response using the `setStatusCode()` function of dolph's response object.

```php
$response
    ->setStatusCode(200)
    ->send('')
```

You can find the details of other status codes by visiting our [GitHub repository](https://github.com/questgig/dolph-php/blob/master/src/Response.php).


# Advanced Dolph PHP

Let's make the above example slightly advanced by adding more properties.

```php
use DolphPHP\App;
use DolphPHP\Swoole\Request;
use DolphPHP\Swoole\Response;
use Swoole\Http\Server;
use Swoole\Http\Request as SwooleRequest;
use Swoole\Http\Response as SwooleResponse;
use DolphPHP\Validator\Wildcard;

$http = new Server("0.0.0.0", 8080);

App::init(function($response) {
   /* 
      Example of global init method. Do stuff that is common to all your endpoints in all groups. 
      This can include things like authentication and authorisation checks, implementing rate limits and so on..
   */
}, ['response']);

App::init(function($response) {
   /* 
      Example of init method for group1. Do stuff that is common to all your endpoints in group1.
      This can include things like authentication and authorisation checks, implementing rate limits and so on..
   */
}, ['response'], 'group1');

App::init(function($response) {
   /* 
      Example of init method for group2. Do stuff that is common to all your endpoints in group2. 
      This can include things like authentication and authorisation checks, implementing rate limits and so on..
   */
}, ['response'], 'group2');

App::shutdown(function($request) {
   /* 
     Example of global shutdown method. Do stuff that needs to be performed at the end of each request for all groups.
     '*' (Wildcard validator) is optional.
     This can include cleanups, logging information, recording usage stats, closing database connections and so on..
   */

}, ['request'], '*');

App::shutdown(function($request) {
   /* 
     Example of shutdown method of group1. Do stuff that needs to be performed at the end of each request for all groups.
     This can include cleanups, logging information, recording usage stats, closing database connections and so on..
   */

}, ['request'], 'group1');

App::put('/todos/:id')
   ->desc('Update todo')
   ->groups(['group1', 'group2'])
   ->label('scope', 'public')
   ->label('abuse-limit', 50)
   ->param('id', "", new Wildcard(), 'id of the todo')
   ->param('task', "", new Wildcard(), 'name of the todo')
   ->param('is_complete', true, new Wildcard(), 'task complete or not')
   ->inject('response')
   ->action(
       function($id, $task, $is_complete, $response) {
           $path = \realpath('/app/app/todos.json');
           $data = json_decode(file_get_contents($path));
           foreach($data as $object){
               if($object->id == $id){
                   $object->task = $task;
                   $object->is_complete = $is_complete;
                   break;
               }
           }
           $jsonData = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
           file_put_contents($path, $jsonData);
           $response->json($data);
       }
   );
   
$http->start();
```

For each endpoint, you can add the following properties described below. Let’s talk about what each one of them represents.

* #### Description
`desc` is used for providing the general description and documenting the function of the given endpoint. It takes a string as an input, example, 'Create an account using an email and a password'.

* #### Groups
`groups` are used to define common functions that need to be executed. When you add a callback function to a group, the init hooks of the respective group are executed before the individual actions are executed.

* #### Labels
`label` can be used to store metadata that is related to your endpoint. It’s a key-value store. Some use-cases can be using label to generate the documentation or the swagger specifications. 

* #### Injections
Since each action in Dolph PHP depends on certain resources, `inject` is used to add the dependencies. `$response` and `$request` can be injected into the service. Dolph PHP provides the app static functions to make global resources available to all Dolph PHP endpoints.

* #### Action
`action` contains the callback function that needs to be executed when an endpoint is called. The `param` and `inject` variables need to be passed as parameters in the callback function in the same order. The callback function defines the logic and also returns the `$response` back.


# Lifecycle

Now that you’re familiar with routing in Dolph PHP, let’s dive into the lifecycle of a Dolph PHP request in detail and learn about some of the lifecycle methods.

## Init and Shutdown Methods
 
The Dolph PHP app goes through the following lifecycle whenever it receives any request:

![untitled@2x](https://user-images.githubusercontent.com/43381712/146966398-0f4af03b-213e-47d7-9002-01983053c5aa.png)

In case an error occurs anywhere during the execution, the workflow executes the error callbacks of the concerned groups before calling the global error handler.

The init and shutdown methods take three params:

    1. Callback function
    2. Array of resources required by the callback 
    3. The endpoint group for which the callback is intended to run

* ### Init

init method is executed in the beginning when the program execution begins. Here’s an example of the init method, where the init method is executed for all groups indicated by the wildcard symbol `'*'`.
```php
App::init(function($response) {
   /* 
      Do stuff that is common to all your endpoints. 
      This can include things like authentication and authorisation checks, implementing rate limits and so on.. 
   */
}, ['response'], '*');
```

* ### Shutdown

Dolph PHP's shutdown callback is used to perform cleanup tasks after a request. This could include closing any open database connections, resetting certain flags, triggering analytics events (if any) and similar tasks.

```php
App::shutdown(function($request) {
   /* 
     Do stuff that needs to be performed at the end of each request. 
     This can include cleanups, logging information, recording usage stats, closing database connections and so on..
   */

}, ['request'], '*');
```


# Running Locally
If you have PHP and Composer installed on your device, you can run Dolph PHP apps locally by downloading the Questgig/dolph-php dependency using `composer require dolph-php/framework` command.

> Dolph PHP Framework requires PHP 7.3 or later. We recommend using the latest PHP version whenever possible.

Wonderful! 😄  You’re all set to create a basic demo app using the Dolph Php framework. If you have any issues or questions feel free to reach out to us on our [Our Email](mailto:opensource@questgig.com).

