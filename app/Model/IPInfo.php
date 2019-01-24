<?php
/**
 * Class Role
 * @package App\Model
 * Author:huangzhongxi@rockfintech.com
 * Date: 2018/11/9 11:22 AM
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class IPInfo  extends Model
{

    protected $table = 'ip_infos';

    protected $fillable = [
        'ip',
        'country',
        'province',
        'city',
        'isp',
        'area',
        'created_at',
        'updated_at',
    ];

}