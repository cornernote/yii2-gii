# Yii2 Gii Tools

## Installation

Add the following to your `composer.json`:

```json
{
    "require": {
        "cornernote/yii2-gii": "dev-master"
    },
}
```


Add to your yii config in `config/main.php`:

```
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => $allowedIPs,
        'generators' => [
            'giiant-model' => [
                'class' => 'schmunk42\giiant\model\Generator',
                'templates' => [
                    'gii-tools' => '@vendor/cornernote/yii2-gii-tools/giiant/model/gii-tools',
                ],
            ],
            'giiant-crud' => [
                'class' => 'schmunk42\giiant\crud\Generator',
                'templates' => [
                    'gii-tools' => '@vendor/cornernote/yii2-gii-tools/giiant/crud/gii-tools',
                ],
            ],
        ],
    ];
```

## Using Giiant with Providers

https://gist.github.com/cornernote/fdf869048d6153d7aae3
