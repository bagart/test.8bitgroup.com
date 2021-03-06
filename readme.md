Need to implement Symfony3 or Laravel bundle for getting JSON-encoded locations data stored in predefined format.

Acceptance criteria
1. Client should be defined as a service class in a bundle config;
2. Client should utilize CURL as a transport layer (can rely upon any third-party **bundle however should be implemented as a separate class/package);
3. Properly defined exceptions should be thrown on CURL errors, malformed JSON response and error JSON response;
4. Resulting data should be fetched as an array (or other collection) of properly


JSON response format
```json
{
    "data": {
        "locations": [
            {
                "name": "Eiffel Tower",
                "coordinates": {
                    "lat": 21.12,
                    "long": 19.56
                }
            },
            ...
        ]
    },
    "success": true
}
```

JSON error response format
```
{
    "data": {
        "message": <string error message>,
        "code": <string error code>
    },
    "success": false
}
```


## INSTALL
```bash
composer require bagart/laravel-api-provider '@dev'
```

## Usage
```php
    /**
     * @var \Bagart\LaravelApiProvider\Providers\DataProvider $data_provider
     */
    $data_provider = app(\Bagart\LaravelApiProvider\Providers\DataProvider::class);

    dump($data_provider->request('http://dockerhost/example.json', 'locations'));
    dump($data_provider->request('http://dockerhost/example2.json', 'locations'));
    try {
        $data_provider->request('http://dockerhost/error.json', 'locations');
    } catch (\Bagart\LaravelApiProvider\Exceptions\LaravelApiProviderException $e) {
        dump("LaravelApiProviderException: {$e->getMessage()}");
    }
```
        
## Features
used:
 - `Guzzle` (curl inside as options)

## Todo
 - request empty logic and API empty format
 - PHPUnit tests 
## Tech details

### Contracts
- `Bagart\LaravelApiProvider\ApiClientContract`
- `Bagart\LaravelApiProvider\DataProviderContract`
- `Bagart\LaravelApiProvider\DataContainerContract`

## Exceptions
All of expected Exception is instance of `Bagart\LaravelApiProvider\Exceptions\LaravelApiProviderException` 
