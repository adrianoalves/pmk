<?php

namespace App\Models\PaymentMethod;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    use HasFactory;

    protected $table = 'payment_method_credit';

    protected $guarded = [];
}
