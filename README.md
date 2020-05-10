# Localise Bundle for Symfony
PHP Symfony wrapper for [Localise](https://localise.biz) service.

Installation
============

Make sure Composer is installed globally, as explained in the
[installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Applications that use Symfony Flex
----------------------------------

Open a command console, enter your project directory and execute:

```console
$ composer req cosavostra/localise-bundle
```

Applications that don't use Symfony Flex
----------------------------------------

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer req cosavostra/localise-bundle
```

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    CosaVostra\LocaliseBundle\LocaliseBundle::class => ['all' => true],
];
```

### Step 3: Set the API key

Finally, update your `.env` file by setting the Localise API key of your account:

```dotenv
###> cosavostra/localise-bundle ###
LOCALIZE_EXPORT_KEY=XXXXXXXXXXXXXXX
###> cosavostra/localise-bundle ###
```

Usage
----------------------------------

This bundle is very useful to export translation files from Localise.biz, after installation you'll be able
to access to the command:

```console
$ php bin/console localise:translation:export --extension=yaml --purge
```

The output will be something like below:

```console                                                                    
 ----------------- ------ ------------ -------------- 
  Name              Code   Translated   Untranslated  
 ----------------- ------ ------------ -------------- 
  English US        en     3            0             
  French (France)   fr     3            0             
 ----------------- ------ ------------ --------------                                                                                                                
 [OK] The translations was successfully exported.   
```

**NOTE:** Don't forget to clear the cache of your application after running the command,
and consider using the right environment option, in your prod environment you should run:

```console
$ php bin/console --env=prod localise:translation:export --extension=yaml --purge
```

You can also use the `CosaVostra\LocaliseBundle\LocaliseManager` service to export translations manually
(for example in a controller) like below:

```php
use CosaVostra\LocaliseBundle\LocaliseManager;
use Symfony\Component\HttpFoundation\Response;

public function action(LocaliseManager $localiseManager): Response 
{
    $extension = 'yaml';
    $purge = true; // This flag should be "TRUE" to purge translation directory and remove old files.
    
    $localiseManager->export($extension, $purge);
    
    // Clearing cache here ...

    return new Response('Translations exported.');
}
```

## Questions?

If you have any questions please [open an issue](https://github.com/mradhi/localise-bundle/issues/new).

## License

This library is released under the MIT License. See the bundled [LICENSE](https://github.com/mradhi/localise-bundle/blob/master/LICENSE) file for details.
