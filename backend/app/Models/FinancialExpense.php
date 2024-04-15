<?php

namespace App\Models;

use App\Traits\ModelSearchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FinancialExpense extends Model
{
    use HasFactory, SoftDeletes, ModelSearchTrait;
    protected $table = 'financial_expense';
    protected $fillable = ['user_id', 'description', 'date', 'amount'];
}
