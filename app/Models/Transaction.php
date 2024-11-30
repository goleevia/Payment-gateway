<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public $incrementing = false; // Ensures UUID is not auto-incremented
    protected $keyType = 'string'; // Set primary key type as string since we use UUIDs

    protected $fillable = [
        'id', 'masked_card_number', 'amount', 'currency', 'customer_email', 'metadata', 'status'
    ];

    protected $casts = [
        'metadata' => 'array', // Cast metadata to array when retrieved from the database
    ];
}
