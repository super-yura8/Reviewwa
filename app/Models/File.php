<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'file';

    protected $fillable = ['file_path', 'origin_file_name', 'hash_file_name'];
}
