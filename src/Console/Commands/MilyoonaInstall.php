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
    protected $description = 'Publish migrations and config for this microservice';

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
        if( !empty(config('milyoona_model_consumer.publish_migration')) ) {

            foreach(config('milyoona_model_consumer.publish_migration') as $migration) {
                // Base migrations
                if(strpos($migration, ':') != false) {
                    $migrations = array_diff(scandir(app()->basePath() . '/database/migrations'), array('.', '..', '.gitkeep'));
                    if(!empty($migrations)) {
                        $flag = false;
                        foreach($migrations as $item) {
                            if( strpos($item, rtrim($migration, ':')) != false ) {
                                $flag = true;
                            }
                        }
                        if($flag == false) {
                            $this->call('vendor:publish', ['--tag' => 'base_' . rtrim($migration, ':')]);
                        }
                    } else {
                        $this->call('vendor:publish', ['--tag' => 'base_' . rtrim($migration, ':')]);
                    }
                } else {
                    // Free migrations
                    $migrations = array_diff(scandir(app()->basePath() . '/database/migrations'), array('.', '..', '.gitkeep'));
                    if(!empty($migrations)) {
                        $flag = false;
                        foreach($migrations as $item) {
                            if( strpos($item, $migration) != false ) {
                                $flag = true;
                            }
                        }
                        if($flag == false) {
                            $this->call('vendor:publish', ['--tag' => 'free_' . $migration]);
                        }
                    } else {
                        $this->call('vendor:publish', ['--tag' => 'free_' . $migration]);
                    }
                }
            }
        }
        $this->info('Successfully Published!');
    }
}
