<?php

namespace Milyoona\ModelConsumer\Console\Commands;

use Milyoona\ModelConsumer\Models\Product;
use Bschmitt\Amqp\Facades\Amqp;
use Illuminate\Console\Command;

class ProductConsumer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'consumer:product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Product consumer command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Amqp::consume(config('milyoona_model_consumer.queue_name'), function ($message, $resolver) {
            $method = json_decode($message->body, true)['method'];
            $data = json_decode($message->body, true)['data'];

            switch($method) {
                case 'store':
                    Product::create($data);
                    break;
                case 'update':
                    Product::where('id', $data['id'])->updade($data);
                    break;
                case 'delete':
                    Product::where('id', $data['id'])->delete();
                    break;
                case 'forceDelete':
                    Product::where('id', $data['id'])->forceDelete();
                    break;
            }
            $resolver->acknowledge($message);
        }, [
                'routing' => 'product',
                'persistent' => true
        ]);
    }
}