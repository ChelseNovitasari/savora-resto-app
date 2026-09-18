<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_code',
        'name',
        'phone',
        'table_number',
        'reservation_date',
        'reservation_time',
        'guest_count',
        'total_price',
        'notes',
        'status',
        'payment_status',
        'payment_proof'
    ];

    // Relasi ke ReservationDetail
    public function details(): HasMany
    {
        return $this->hasMany(ReservationDetail::class);
    }

    // Akses langsung ke Menu melalui ReservationDetail
    public function menus(): HasManyThrough
    {
        return $this->hasManyThrough(
            Menu::class,
            ReservationDetail::class,
            'reservation_id', // Foreign key di ReservationDetail
            'id',             // Foreign key di Menu
            'id',             // Local key di Reservation
            'menu_id'         // Local key di ReservationDetail
        );
    }

    // Relasi ke Testimonial
    public function testimonial()
    {
        return $this->hasOne(Testimonial::class);
    }
}
