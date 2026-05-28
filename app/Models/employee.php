<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'position',
        'department',
        'salary',
        'hire_date',
        'image',
    ];

    protected $casts = [
        'hire_date' => 'date',
        'salary' => 'decimal:2',
    ];

    public $timestamps = false;

    public function getNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function getAvatarAttribute(): ?string
    {
        return $this->image;
    }

    public function getHiredAtAttribute()
    {
        return $this->hire_date;
    }

    public function getInitials(): string
    {
        return strtoupper(substr($this->first_name, 0, 1) . substr($this->last_name, 0, 1));
    }

    public function getStatusLabel(): string
    {
        return 'Active';
    }

    public function getStatusBadgeClass(): string
    {
        return 'badge-active';
    }
}
