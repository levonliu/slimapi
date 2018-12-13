<?php
/**
 * Created by PhpStorm.
 * User: liuwen
 * Date: 18-12-3
 * Time: 下午1:44
 */

namespace App\Model;

class User extends Model
{
    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
}