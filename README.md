# synetic/json_api_client #

This module will expose some services which you can use to connect to a json_api standardized api.

## Usage ##

This is a json_api standards api client. This will prepare your requests to the standard and execute the request and 
return a `GuzzleHttp\Psr7\Response` object which you will be able to parse.

To inject the client into your object / service. Use the following line as an argument in your services file.

```
- '@synetic.json_api_client.client'
```

This will use the default client setup including the error response parser. The parser
uses 'uuid' as default identifier. Sometimes you would need to use `id`. If so, then 
overwrite the `synetic.json_api_client.identifier_field` parameter in your services file.

## Installation

- Install the package using composer.

In your Drupal 8 project, add the following repository to your `composer.json` file
```
"repositories": [
        {
            "type": "composer",
            "url": "https://packagist.synetic.nl"
        }
    ]
```

You will need to install the following composer package: `composer require oomphinc/composer-installers-extender:^1.1` for the 
synetic-module installer to work properly.

In the `extra` block in your composer file you will need to add the following.
```
"extra": {
        "installer-types": ["synetic-module"],
        "installer-paths": {
            "web/modules/synetic/{$name}": ["type:synetic-module"],
        }
    }
```

Use the following command to require the package `composer require synetic/json_api_client:*@dev`

This will install the module into `web/modules/synetic`

When you want to imply a drupal module dependency on this module. Add the following into your own module.info.yml

```
dependencies:
 - "synetic:json_api_client"
```

# json_api server #

Drupal 8 had a module for serving json_api requests as a rest service. For this you can use the json_api module.
https://www.drupal.org/docs/8/modules/json-api
