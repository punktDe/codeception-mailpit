# punktde/codeception-mailpit

## Gherkin Steps and module functions to test using MailPit

### How to use

### Prequesits

You have to have MailPit installed and have your application configured to send mails to mailpit. See https://mailpit.axllent.org

#### Module

You have to add the `Webdriver` module to your config to use the `MailPit` module.
Use the module `PunktDe\Codeception\MailPit\Module\MailPit` in your `codeception.yaml`. You can configure under which uri the mailpit client is reachable (default is http://127.0.0.1:8025)

```yaml
modules:
   enabled:
      - WebDriver:
        url: 'http://acceptance.dev.punkt.de/'
        browser: chrome
        restart: true
        window_size: 1920x2080
        capabilities:
          chromeOptions:
            args:
              - '--headless'
              - '--disable-gpu'
              - '--disable-dev-shm-usage'
              - '--no-sandbox'
      - PunktDe\Codeception\MailPit\Module\MailPit:
        base_uri: http://mailpit.project
```

You can add authentication parameters to authenticate with the guzzle client when necessary. For futher details see https://docs.guzzlephp.org/en/latest/request-options.html#auth

```yaml
modules:
   enabled:
      - PunktDe\Codeception\MailPit\Module\MailPit:
        base_uri: http://mailpit.project
        username: 'user'
        password: 'secret'
        atheticationType: 'basic'
```

#### Gherkin steps

Just add the trait `PunktDe\Codeception\MailPit\ActorTraits\MailPit` to your testing actor. Then you can use `*.feature` files to write your gherkin tests with the new steps.

##### Example actor

```php
<?php

/*
 *  (c) 2026 punkt.de GmbH - Karlsruhe, Germany - http://punkt.de
 *  All rights reserved.
 */

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;
    use \PunktDe\Codeception\MailPit\ActorTraits\MailPit; // use the mailpit steps trait
}
```

##### Which steps are there?

To get all the steps available you can just run the following command:

```bash
vendor/bin/codecept -c path/to/codeception.yaml gherkin:steps suiteName
```

This will give you a table of all the steps available.
