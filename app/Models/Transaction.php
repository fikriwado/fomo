<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\WithBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Transaction extends Model
{
    use HasFactory, WithBuilder;

    protected $fillable = [
        'total_amount',
    ];

    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Transaction $transaction): void {
            if ($transaction->code) {
                return;
            }

            do {
                $year = date('y');
                $month = date('n');
                $day = date('j');
                $random = Str::upper(Str::random(5));
                $code = "INV-{$year}{$month}{$day}-{$random}";
            } while (self::query()->where('code', $code)->exists());

            $transaction->code = $code;
        });
    }

    public function items(): HasMany
    {
        return $this->hasMany(TransactionItem::class);
    }
}
