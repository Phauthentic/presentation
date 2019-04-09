# Presentation

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Scrutinizer Coverage](https://img.shields.io/scrutinizer/coverage/g/Phauthentic/presentation/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/Phauthentic/presentation/)
[![Code Quality](https://img.shields.io/scrutinizer/g/Phauthentic/presentation/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/Phauthentic/presentation/)

**WORK IN PROGRESS - NOT READY FOR PRODUCTION!**

A framework and library agnostic presentation layer implementation. The purpose of this is to provide a data transfer object to make your application independent from the underlying rendering implementation.

This library uses a view object that will carry all the information from where ever to the renderer objects, that will read the information and render the desired output depending on the underlying library and implementation. It is pretty easy so switch the rendering sub system with this approach and everything is strict typed as well.

## Featured renderer included

 * **Twig** via [twig/twig](https://github.com/twigphp/Twig)
 * **Mustache** and **Handlebars** via [zordius/lightncandy](https://github.com/zordius/lightncandy)
 * **pdf** documents via [wkhtmltopdf](https://wkhtmltopdf.org/)
 * plain php templates

Missing something? It is very easy to implement your own renderer!

## Documentation & Installation

Please check [the docs folder](./docs/index.md).

## Copyright & License

Licensed under the [MIT license](LICENSE.txt).

Copyright (c) [Phauthentic](https://github.com/Phauthentic)
