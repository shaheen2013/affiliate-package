<?php

namespace Mediusware\Affiliate\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
    protected $fillable = ['user_id', 'promotion_message', 'website_url', 'commission_type', 'commission', 'use_limit', 'affiliate_code', 'user_code', 'banner_id', 'status'];

    public function user()
    {
        return $this->hasOne( \App\User::class, 'id', 'user_id' );
    }

    public function payment()
    {
        return $this->hasOne(AffiliatePayment::class, 'user_id', 'user_id');
    }

    public function activeBanner()
    {
        return $this->hasOne(AffiliateBanner::class, 'id', 'banner_id');
    }


}
