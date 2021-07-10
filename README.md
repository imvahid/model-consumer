## Milyoona Model Consumer

#### How to install

```bash
composer require milyoona/model-consumer
```

```php
// Register Service Providers
$app->register(Bschmitt\Amqp\LumenServiceProvider::class);
$app->register(Flipbox\LumenGenerator\LumenGeneratorServiceProvider::class);
$app->register(Anik\Form\FormRequestServiceProvider::class);
$app->register(Milyoona\ModelConsumer\ModelConsumerServiceProvider::class);
```

```bash
php artisan vendor:publish --tag=milyoona_model_consumer
```

```php
// Register Config Files
$app->configure('milyoona_model_consumer');
```

#### How to use

Set settings in <code>config file</code> and Run this command

```bash
php artisan milyoona:install
```
