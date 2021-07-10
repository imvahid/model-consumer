## Milyoona Model Consumer

#### How to install

```bash
composer require milyoona/model-consumer
```

```php
// Register Service Provider to app.php
$app->register(Milyoona\ModelConsumer\ModelConsumerServiceProvider::class);
```

```bash
php artisan vendor:publish --tag=consumer
```

```php
// Add Config Files to app.php
$app->configure('amqp');
$app->configure('consumer');
$app->configure('database');
```

#### How to publish migrations

Set settings in <code>config file</code> and Run this command

```bash
php artisan milyoona:install
```

#### How to <code>publish</code> on queue

```php
// In Repository
Amqp::publish( 'users', json_encode( ['method' => 'store', 'data' => $user->setAppends([])] ) ); // method: store, update, delete, forceDelete

return $user->setAppends( ['full_name'] );
```

#### How to <code>consume</code> from queue

```bash
php artisan milyoona:consume
```