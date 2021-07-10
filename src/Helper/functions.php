<?php

if ( ! function_exists('checkRelation') )
{
    function checkRelation($table = '')
    {
        $migrations = config('milyoona_model_consumer.publish_migration');
        if(!empty($migrations)) {
            foreach($migrations as $migration) {
                if($table == rtrim($migration, ':')) {
                    return true;
                }
            }
        }

        return false;
    }
}
