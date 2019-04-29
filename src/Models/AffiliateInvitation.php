<?php

namespace Mediusware\Affiliate\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class AffiliateInvitation extends Model
{
    protected $fillable = ['register_user_id', 'affiliate_user_id', 'affiliate_commission'];
}
