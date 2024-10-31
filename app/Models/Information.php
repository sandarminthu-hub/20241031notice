<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Information extends Model
{
    protected $table = 'asms_inforamtion';
    protected $fillable = [
        'information_id',
        'information_title' ,
        'information_kbn' ,
        'keisai_ymd',
        'enable_start_ymd',
        'enable_end_ymd',
        'information_naiyo',
        'create_user_cd',
        'update_user_cd',
    ];

    public function newQuery($excludeDeleted = true) {
        return parent::newQuery($excludeDeleted)
            ->where('delete_flag', '=', null);
    }
   
}