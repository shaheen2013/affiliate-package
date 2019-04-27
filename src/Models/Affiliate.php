<?php

namespace Mediusware\Affiliate\Models;

use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
    protected $fillable = ['user_id', 'promotion_message', 'website_url', 'commission_type', 'commission', 'use_limit', 'affiliate_code', 'user_code', 'banner_id', 'status'];

    public function user()
    {
        return $this->hasOne( \App\User::class, 'id', 'user_id' );
    }
}
