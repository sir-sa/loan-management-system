<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'loan_amount',
        'interest_rate',
        'loan_term_months',
        'status',
        'payment_due_date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function loanPayments()
    {
        return $this->hasMany(Payment::class);
    }
}
