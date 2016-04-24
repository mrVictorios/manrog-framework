[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%205.6-8892BF.svg?style=flat-square)](https://php.net/)
[![Build Status](https://travis-ci.org/mrVictorios/manrog-framework.svg?branch=master)](https://travis-ci.org/mrVictorios/manrog-framework)

# manrog-framework

is a lightweight framework.

## Installation

When you have <b>ant</b> installed and a global <b>composer</b> installation.
```bash
$ ant
```
The Script install peet dependencies, tests it and generate the documentation.

each task you can run single

Alternatively, you can install manually.
```bash
$ composer install
$ ./bin/phpunit --configuration phpunit.xml
```


### Ant Tasks

|Tasks|Description|
|---:|-----------|
|setup| prepare and install the Project depends clean, get-composer, install|
|install|install the project depends composer-install, validate|
|validate|runs the test, get the metrics and generate the documentation|
|validate-seq|runs validate on single thread|
|clean|clean the project|
|clean-build|clean the build directory|
|get-composer|gets composer from getcomposer|
|composer-install|installs dependencies|
|update-autoload|update the composer autoloader|
|phpunit|runs the phpunit test|
|phpcpd|runs the copy paste detection|
|phpmd|runs the mess detection|
|phploc|get overview metrics of project||
|phpmetrics|gets overiew metrics of project output will be in html|
|phpdox|generate the documentation|


## Contribute

Please refer to [CONTRIBUTING.md](url::/CONTRIBUTING.md) for information on how to contribute to peet and its related projects.
