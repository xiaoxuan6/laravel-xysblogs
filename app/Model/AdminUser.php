<?php

namespace App\Model;

use App\Events\RegisterSendMail;
use App\Observers\AdminUserObserve;
use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::observe(AdminUserObserve::class);
    }

    /**
     * ģ���¼� <==> event(new RegisterSendMail($re));
     * @var array
     */
    protected $dispatchesEvents = [
        'creating' => RegisterSendMail::class,
    ];



}
