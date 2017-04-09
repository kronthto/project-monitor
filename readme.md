# Project Monitor - Get notified about problems

[![Software License][ico-license]](LICENSE.md)
[![Latest Stable Version][ico-githubversion]][link-releases]

This tool can check if your projects are up and send a push-notification otherwise.

## Features

* Check HTTP Services
* Telegram notification

## Install

``` bash
$ composer install (--no-dev -o)
$ cp .env.example .env
```
* Adjust *.env* to your environment (database, telegram-apikey)
``` bash
$ ./artisan migrate
```
* Put your checks and recipients in the DB-tables
* Register the `artisan schedule:run` cronjob

## Changelog

Please see the [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see the [License File](LICENSE.md) for more information.

[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-githubversion]: https://poser.pugx.org/kronthto/project-monitor/v/stable

[link-releases]: https://github.com/kronthto/project-monitor/releases
[link-contributors]: ../../contributors
