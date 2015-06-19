# Yii2 Gii

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
