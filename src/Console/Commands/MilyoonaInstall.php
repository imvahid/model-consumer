<?php

namespace Milyoona\ModelConsumer\Console\Commands;

use Illuminate\Console\Command;

class MilyoonaInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'milyoona:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish migrations for this microservice';

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
        $publishedCount = 0;

        if( !empty(config('consumer.publish_migration')) ) {

            foreach(config('consumer.publish_migration') as $migration) {
                $migrations = array_diff(scandir(app()->basePath() . '/database/migrations'), array('.', '..', '.gitkeep'));
                if(!empty($migrations)) {
                    $flag = false;
                    foreach($migrations as $item) {
                        if( strpos($item, rtrim($migration, ':')) != false ) {
                            $flag = true;
                        }
                    }
                    if($flag == false) {
                        $this->call('vendor:publish', ['--tag' => 'consumer_' . rtrim($migration, ':')]);
                        $publishedCount++;
                    }
                } else {
                    $this->call('vendor:publish', ['--tag' => 'consumer_' . rtrim($migration, ':')]);
                    $publishedCount++;
                }
            }
        }
        if ($publishedCount > 0) {
            $this->info($publishedCount .  ' Migration Successfully Published!');
        } else {
            $this->warn('Already published, Not exists to publish!');
        }
    }
}
