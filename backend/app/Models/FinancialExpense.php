<?php

namespace App\Models;

use App\Models\AppUser;
use App\Traits\ModelSearchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FinancialExpense extends Model
{
    use HasFactory, SoftDeletes, ModelSearchTrait;
    protected $table = 'financial_expense';
    protected $fillable = ['user_id', 'description', 'date', 'amount'];

    public function searchParams()
    {
        return [
            'q' => null,
            'date_min' => null,
            'date_max' => null,
        ];
    }

    public function searchQuery($query, $request)
    {
        if ($search = $request->input('q')) {
            $query->where(function ($query) use ($search) {
                $query->where('description', 'like', "%{$search}%");
            });
        }

        if ($date_min = $request->input('date_min')) {
            $query->where('date', '>', $date_min);
        }

        if ($date_max = $request->input('date_max')) {
            $query->where('date', '<', $date_max);
        }

        return $query;
    }

    public function appUser(): BelongsTo
    {
        return $this->belongsTo(AppUser::class, 'user_id');
    }
}
