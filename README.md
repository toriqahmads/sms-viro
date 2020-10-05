# SMS Viro Package for PHP Application

[![Latest Version on Packagist](https://img.shields.io/packagist/v/toriqahmads/sms-viro.svg?style=flat-square)](https://packagist.org/packages/toriqahmads/sms-viro)
[![Build Status](https://img.shields.io/travis/toriqahmads/sms-viro/master.svg?style=flat-square)](https://travis-ci.org/toriqahmads/sms-viro)
[![Quality Score](https://img.shields.io/scrutinizer/g/toriqahmads/sms-viro.svg?style=flat-square)](https://scrutinizer-ci.com/g/toriqahmads/sms-viro)
[![Total Downloads](https://img.shields.io/packagist/dt/toriqahmads/sms-viro.svg?style=flat-square)](https://packagist.org/packages/toriqahmads/sms-viro)

## Installation

You can install the package via composer:

```bash
composer require toriqahmads/sms-viro
```

## Usage
Create an instance of class, pass apikey and sender name
```php
use Toriqahmads\SmsViro\SmsViro;

$smsviro = new SmsViro('707474e01fead92a7c9421a4069f21cd-12969e36-b3ef-46d8-8e93-f78804cee22d', 'YourAwesomeApp');
$smsviro->sendSms('089668639048', 'Your otp code is 6989');
var_dump($smsviro->isRequestSuccess());
```

## Framework Integrations
### Laravel
#### 1. Direct in controller
Import package in the top of classname
``` php
use Toriqahmads\SmsViro\SmsViro;
```
In method/function, pass apikey and sender name on instance class. call `sendSms` to send your message
``` php
...
$smsviro = new SmsViro('707474e01fead92a7c9421a4069f21cd-12969e36-b3ef-46d8-8e93-f78804cee22d', 'YourAwesomeApp');
$smsviro->sendSms('089668639048', 'Your otp code is 6989');
$smsviro->isRequestSuccess();
...
```
#### 2. Dependency Injection
Bind class on register method
```php
...
use Toriqahmads\SmsViro\SmsViro;

class OptimusServiceProvider extends ServiceProvider
{
    public function register()
    {
        ...
        $this->app->singleton(SmsViro::class, function ($app) {
            return new SmsViro('707474e01fead92a7c9421a4069f21cd-12969e36-b3ef-46d8-8e93-f78804cee22d', 'YourAwesomeApp');
        });
    }
...
```
Example controller
```php
...
use Toriqahmads\SmsViro\SmsViro;

class TestController extends Controller
{
    public function sendSms(SmsViro $smsviro)
    {
        $smsviro->sendSms('089668639048', 'Your otp code is 6989');
        $smsviro->isRequestSuccess();
    }
}
...
```


### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email toriq@edu.unisbank.ac.id instead of using the issue tracker.

## Credits

- [Toriq Ahmad](https://github.com/toriqahmads)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## PHP Package Boilerplate

This package was generated using the [PHP Package Boilerplate](https://laravelpackageboilerplate.com).
