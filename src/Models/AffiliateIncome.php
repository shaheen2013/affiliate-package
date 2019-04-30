<?php

namespace Mediusware\Affiliate\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class AffiliateIncome extends Model
{
    protected $fillable = ['paid_user_id', 'paid_amount', 'income_user_id', 'income_commission', 'income_amount'];

    public function paidUser()
    {
        return $this->hasOne(User::class, 'id', 'paid_user_id');
    }

    public function incomeUser()
    {
        return $this->hasOne(User::class, 'id', 'income_user_id');
    }
}
