<?php

namespace Mediusware\Affiliate\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliateIncome extends Model
{
    protected $fillable = ['paid_user_id', 'paid_amount', 'income_user_id', 'income_commission', 'income_amount'];
}
