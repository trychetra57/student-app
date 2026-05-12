<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'grade',
        'address',
        'date_of_birth',
        'guardian_name',
        'guardian_phone',
        'status',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relationships
    public function documents(): HasMany
    {
        return $this->hasMany(StudentDocument::class);
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class, 'model_id')->where('model_type', self::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    public function scopeGraduated($query)
    {
        return $query->where('status', 'graduated');
    }

    public function scopeSearch($query, $search)
    {
        if (!empty($search)) {
            return $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('grade', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%");
        }
        return $query;
    }

    public function scopeFilterByStatus($query, $status)
    {
        if ($status && $status !== 'all') {
            return $query->where('status', $status);
        }
        return $query;
    }

    public function scopeSort($query, $sort = 'name', $direction = 'asc')
    {
        $allowedColumns = ['name', 'email', 'grade', 'status', 'created_at'];
        if (in_array($sort, $allowedColumns)) {
            return $query->orderBy($sort, $direction);
        }
        return $query->orderBy('name', 'asc');
    }

    // Accessors
    public function getAgeAttribute()
    {
        return $this->date_of_birth ? $this->date_of_birth->age : null;
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'active' => '<span class="badge badge-success">Active</span>',
            'inactive' => '<span class="badge badge-warning">Inactive</span>',
            'graduated' => '<span class="badge badge-info">Graduated</span>',
        ];
        return $badges[$this->status] ?? '';
    }
}
