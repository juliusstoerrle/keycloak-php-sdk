# Keycloak PHP SDK

## About
PHP SDK for Keycloak Admin API using PSR18. At the time of creation, available PHP SDKs for Keycloak have a hard dependency on the `guzzle/http-client` package which is not ideal for projects that already include a different HTTP client. To ease integration into larger projects this library relies as much as possible on abstractions. Therefore, projects can provide implementations already used in their codebase and ease configuration, dependency management and the learning curve of their project.

The project does not aim to include all Keycloak API operations from the first release but rather an extensible base. Pull requests for additional operations are welcome.

## Features
 - Fully typed requests ("operations") & responses ("representations")
 - Relies on PSR18 HTTP-Client abstraction for HTTP Requests to the Keycloak API
 - Easy to extend with custom operations
 - Configurable through dependency injection (Inject your own HTTP Client, Object Mapper etc.)
 - Low on dependencies (the direct dependencies only depend on PSR interfaces and common php extensions)
 - Can be provided with a PSR3 logger implementation
 - Planned: Can use a semaphore to restrain API calls and avoid race conditions when authenticating.

## Keycloak API Coverage
This section will contain an overview of already implemented operations.

## Usage

To use the sdk you must require `juliusstoerrle/keycloak-php-sdk` and `league/object-mapper` (or inject an alternative object mapper) together with an implementation of the PSR18 standard.

````php
TODO
````

### Calling the Keycloak API

To call the API you must instantiate an API operation and pass it to the `KeycloakApiClient::execute()` method. You can find all available operations in the `./src/Operations` folder or you create your own (see further down).

````php
try {
    $res = $keycloakApiClient->execute(new UserWithIdQuery(id: `<uuid>`));
    // $res is a User object in this case, the type is correctly inferred by tooling from the query passed
} catch (KeycloakSdkException $e) {
    // your custom error handling
}
````

### Creating your own operation

The KeycloakService::query method accepts any instance of the query interface, so you can simply create a new implementation of this interface to extend the library.

````php
/**
 * This description should be adapted: Operation to fetch a single user resource identified by its id.
 *
 * @todo You may alternatively implement OperationWithPayload interface for (POST) requests with a body. For Operations requiring no authentication you can **add** the UnauthenticatedOperation marker-interface
 * @implements Operation<User>
 */
readonly class UserWithIdQuery implements Operation
{
    /** @todo change the URI to point to your endpoint */
    public const string URI_TEMPLATE = '/admin/realms/%s/users/%s';

    /** @todo add your own query parameters & payload data  */
    public function __construct(public string $id, public string $realm = '{defaultRealm}')
    {
    }

    #[\Override] public function method(): string
    {
        /** @todo adapt the method for the http request */
        return 'GET';
    }

    #[\Override] public function uri(): string
    {
        /** @todo adapt the uri parameter replacement and optionally append a custom query string */
        return sprintf(self::URI_TEMPLATE, $this->realm, $this->id);
    }

    #[\Override] public function resultRepresentation(): string
    {
        /** @todo replace this with a (simple) php object class that the result must be hydrated to */
        return User::class;
    }
}
````

If you are implementing a standard operation that isn't part of this package but should be, please make a pull request.

## Contribution, Development & Testing

We welcome all contributions to this repository. Please open an issue if you found a bug, DX problem or have an idea for improving the library. You may create pull requests for new operations without creating an issue first.

To create a pull request please fork & clone this repository to your device.

During development please verify you changes by running the included test suite with `composer run test`. The test suite includes architecture checks, unit and integration tests. The integration tests require you to run them through the included `docker-compose.yaml`.

Please run `composer run rector` before your commit to ensure the style of coding is aligned.

## Get Help

To ask a question, please use GitHub Discussions, we are happy to help. If you have a specific consulting need, please contact a maintainer to arrange support.