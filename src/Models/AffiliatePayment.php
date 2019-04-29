<?php

namespace Mediusware\Affiliate\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliatePayment extends Model
{
    protected $fillable = ['user_id', 'paypal_email', 'card_holder_name', 'card_number', 'card_expire', 'card_cvc'];
}
