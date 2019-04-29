<?php

namespace Mediusware\Affiliate\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class AffiliateBanner extends Model
{
    protected $fillable = ['user_id', 'banner_message', 'banner_image', 'banner_heading', 'status'];

    public function activeBannerUser()
    {
        return $this->hasOne(Affiliate::class, 'banner_id', 'id')->where('user_id', Auth::user()->id);
    }
}
