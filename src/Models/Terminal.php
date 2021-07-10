<?php

namespace Milyoona\ModelConsume\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Terminal extends Model
{
    use SoftDeletes;
    protected $guarded = [];
}
