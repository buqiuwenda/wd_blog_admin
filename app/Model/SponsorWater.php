<?php
/**
 * Class Role
 * @package App\Model
 * Author:huangzhongxi@rockfintech.com
 * Date: 2018/11/9 11:22 AM
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class SponsorWater  extends Model
{

    protected $table = 'sponsor_waters';

    protected $fillable = [
        'nickname',
        'amount',
        'pay_mode',
        'type',
        'sponsor_date',
        'remark',
        'member_id',
        'last_member_id',
        'status',
        'created_at',
        'updated_at'
    ];


    public function members()
    {
        return $this->hasOne(Member::class, 'id', 'member_id');
    }


    public function lastMembers()
    {
        return $this->hasOne(Member::class, 'id', 'last_member_id');
    }
}