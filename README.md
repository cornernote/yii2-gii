# Yii2 Gii

[![Latest Version](https://img.shields.io/github/tag/cornernote/yii2-gii.svg?style=flat-square&label=release)](https://github.com/cornernote/yii2-gii/tags)
[![Software License](https://img.shields.io/badge/license-BSD-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/cornernote/yii2-gii/master.svg?style=flat-square)](https://travis-ci.org/cornernote/yii2-gii)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/cornernote/yii2-gii.svg?style=flat-square)](https://scrutinizer-ci.com/g/cornernote/yii2-gii/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/cornernote/yii2-gii.svg?style=flat-square)](https://scrutinizer-ci.com/g/cornernote/yii2-gii)
[![Total Downloads](https://img.shields.io/packagist/dt/cornernote/yii2-gii.svg?style=flat-square)](https://packagist.org/packages/cornernote/yii2-gii)

Gii tools and templates for Yii2.


## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
$ composer require cornernote/yii2-gii "*"
```

or add

```
"cornernote/yii2-gii": "*"
```

to the `require` section of your `composer.json` file.


Add to your yii config in `config/main.php`:

```
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => $allowedIPs,
        'generators' => [
            'giiant-model' => [
                'class' => 'schmunk42\giiant\model\Generator',
                'templates' => [
                    'cornernote' => '@vendor/cornernote/yii2-gii/giiant/model/cornernote',
                ],
            ],
            'giiant-crud' => [
                'class' => 'schmunk42\giiant\crud\Generator',
                'templates' => [
                    'cornernote' => '@vendor/cornernote/yii2-gii/giiant/crud/cornernote',
                ],
            ],
        ],
    ];
```

## Using Giiant with Providers

https://gist.github.com/cornernote/fdf869048d6153d7aae3
