<?php

namespace Mediusware\Affiliate\Models;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class AffiliateInvitation extends Model
{
    protected $fillable = ['register_user_id', 'affiliate_user_id', 'affiliate_commission'];

    public function registerUser()
    {
        return $this->hasOne(User::class, 'id', 'register_user_id');
    }

    public function affiliateUser()
    {
        return $this->hasOne(User::class, 'id', 'affiliate_user_id');
    }
}
