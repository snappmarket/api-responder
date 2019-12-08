# API Responder

This package provides some tools to generate API responses based on the [White House Standards](https://github.com/WhiteHouse/api-standards)  and some customization for SnappMarket team in Laravel.

:bulb: To start over, please read  [this document](https://github.com/emyoutis/laravel-whitehouse-responder).

## Installation
```
$ composer require snappmarket/api-responder
```

## Usage
The bellow aliases are being registered in the main service provider of this package. 
- `ApiResponderResponse` for `SnappMarket\ApiResponder\Facades\Response`
- `ApiResponderErrors` for `SnappMarket\ApiResponder\Facades\ErrorsRepository`

In all the examples below, the aliases are being used instead of the full namespaces. 


### Registering Errors
Based on the White House Standards, every error code should points to an error entity. In the API Responder, you can register your errors and their information in an ErrorsRepository class to use them after that.

```php
ApiResponderErrors::register(
     '40001',
     'Verbose, plain language description of the problem. Provide developers suggestions about how to solve their problems here',
     'This is a message that can be passed along to end-users, if needed.',
     'http://www.example.gov/developer/path/to/help/for/444444'
);
```

### Unregistering Errors
It is a common problem that you need to unregister an error after registering it. You can do that with the code below.
```php
ApiResponderErrors::unregister('40001');
```


### Making Failure Responses
Given that in the White House Standards failure responses should return `400` or `500` responses. So that we have two usable methods to return errors with these statuses.
- `clientError()`: This method is ready to generate the response body for the client errors.
    ```php
    ApiResponderResponse::clientError('40001');
    ```
- `serverError()`: This method is ready to generate the response body for the server errors.
    
    ```php
    ApiResponderResponse::serverError('40001');
    ```

After that, we also have another method to be used when you want to specify the status manually.
```php
ApiResponderResponse::error('40001', 422);
```

in SnappMarket, we add an object to the response JSON with name `errors`. This field can contain the detailed errors.

#### Replacements

You can place some replaceable phrases in the errors info while registering it, to make their contents dynamic. The replaceable phrases should start with a `:`.
```php
ApiResponderResponse::register(
     '40001',
     'The class `:class` is undefined.',
     'An error has been occurred in while finding the :entity.',
     'http://www.example.gov/developer/path/to/help/for/444444'
);

return ApiResponderResponse::clientError(40001, [
     'class'  => 'Entities/User',
     'entity' => 'user',
],
[
     'field' => [
         'The field has an error.'
     ]
])
```

The returning value will be:
```json
{
  "status": 400,
  "developerMessage": "The class `Entities/User` is undefined.",
  "userMessage": "An error has been occurred in while finding the user.",
  "errorCode": "40001",
  "moreInfo": "http://www.example.gov/developer/path/to/help/for/444444",
  "errors": {
      "field": [
          "The field has an error."
      ]
  }
}
```


#### Omitting Error Exception
By default, the errors repository throws exceptions on registering a previously registered error code and requesting for a non-existing error code. But you can disable throwing these exceptions with the code below.
```php
ApiResponderErrors::disableExceptions();
```

### Making Success Responses
As the White House Standards says, the success responses must contain two parts; `results` and `metadata`. We also add a `meessages` array to the metadata to contain messages. These parts can be passed to a `success()` method to generate a success response.
```php
$results  = [
     [
          'id'    => 1,
          'title' => 'First Item',
     ],
     [
          'id'    => 2,
          'title' => 'Second Item',
     ],
];
$metadata = ['page' => 1];
$messages = [
    'The list of the items may be incomplete in some cases'
];
    
$response = ApiResponderResponse::success($results, $metadata, $messages);
```

### Key Formatter
You can register a closure to be used to format all the keys which are being generated by the package. For example, if we have a `snake_case()` function to map strings to the snake-case format, we can use the below code.

```php
ApiResponderErrors::register(
     '40001',
     'Verbose, plain language description of the problem. Provide developers suggestions about how to solve their problems here',
     'This is a message that can be passed along to end-users, if needed.',
     'http://www.example.gov/developer/path/to/help/for/444444'
);

ApiResponderErrors::registerFormatter(function ($key) {
    return snake_case($key);
});


return ApiResponderErrors::clientError(40001);
```

The returning result of this code will be:

```:bulb:
{
  "status": 400,
  "developer_message": "Verbose, plain language description of the problem. Provide developers suggestions about how to solve their problems here",
  "user_message": "This is a message that can be passed along to end-users, if needed.",
  "error_code": "40001",
  "more_info": "http://www.example.gov/developer/path/to/help/for/444444"
}
```

:bulb: Changing the keys may take your responses out of the WhiteHouse Standards.
