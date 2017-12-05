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

register ServiceProvider:
Add to `config/app.php` in section `providers`:

`Bagart\LaravelApiProvider\LaravelApiProviderProvider::class,`


## Features
used:
 - `Guzzle` (curl inside as options)

## Todo
 - request empty logic and API empty format
 
## Tech details

### Contracts
- `Bagart\LaravelApiProvider\ApiClientContract`
- `Bagart\LaravelApiProvider\DataProviderContract`
- `Bagart\LaravelApiProvider\DataContainerContract`

## Exceptions
All of expected Exception is instance of `Bagart\LaravelApiProvider\Exceptions\LaravelApiProviderException` 