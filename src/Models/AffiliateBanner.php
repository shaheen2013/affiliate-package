<?php

namespace Mediusware\Affiliate\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliateBanner extends Model
{
    protected $fillable = ['user_id', 'banner_message', 'banner_image', 'banner_heading', 'status'];
}
