# USDOE 50001 Ready Guidance


[![Latest Stable Version](https://poser.pugx.org/michaelbmuller/50001-ready-guidance-test/v/stable)](https://packagist.org/packages/michaelbmuller/50001-ready-guidance-test)
[![Total Downloads](https://poser.pugx.org/michaelbmuller/50001-ready-guidance-test/downloads)](https://packagist.org/packages/michaelbmuller/50001-ready-guidance-test)
[![Build Status](https://travis-ci.org/michaelbmuller/50001-ready-guidance-test.svg?branch=master)](https://travis-ci.org/michaelbmuller/50001-ready-guidance-test)
[![License](https://poser.pugx.org/michaelbmuller/50001-ready-guidance-test/license)](https://packagist.org/packages/michaelbmuller/50001-ready-guidance-test)
[![codecov](https://codecov.io/gh/michaelbmuller/50001-ready-guidance-test/branch/master/graph/badge.svg)](https://codecov.io/gh/michaelbmuller/50001-ready-guidance-test)
[![PHP-Eye](https://php-eye.com/badge/michaelbmuller/50001-ready-guidance-test/tested.svg?style=flat)](https://php-eye.com/package/michaelbmuller/50001-ready-guidance-test)

This support library includes all of the USDOE 50001 Ready Navigator guidance broken into 25 individual tasks.
The 50001 Ready Navigator provides step-by-step guidance for implementing and maintaining 
an energy management system in conformance with the ISO 50001 Energy Management System Standard.


## Installation

### With Composer

```
$ composer require michaelbmuller/50001-ready-guidance-test
```

```json
{
    "require": {
        "michaelbmuller/50001-ready-guidance-test": "dev-master"
    }
}
```

#### Loading Guidance

```php
<?php
require 'vendor/autoload.php';

use DOE_50001_Ready\Guidance;

//Load guidance
$guidance = new Guidance();

//Load alternate language (example: español) 
$guidance = new Guidance('es'); 

//Get All Tasks
$guidance->getTasks();

//Get Section Tasks
$guidance->getTasks([sectionCode]);

//Get Task
$guidance->getTask([taskId]);
```

#### Accessing Task Details

```php
<?php
require 'vendor/autoload.php';

use DOE_50001_Ready\Guidance;

//Load Task (example: task #1)
$guidance = new Guidance();
$task = $guidance->getTask(1);

//Available Task Data 
$task->id;
$task->menuName;
$task->version;
$task->sectionCode;
$task->section;
$task->language;
$task->language_displayed;
$task->getting_it_done;
$task->task_overview;
$task->full_description;
$task->other_iso_tips;
$task->energyStar_tips;
```

## Contributors

Primary Library Developer: Michael B Muller

50001 Ready Task Guidance Developed by the:
* US Department of Energy
* Lawrence Berkeley National Laboratory
* Georgia Institute of Technology