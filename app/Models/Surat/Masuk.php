<?php

namespace App\Models\Surat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\User;

class Masuk extends Model
{
    use HasFactory;

    protected $table = 'surat_masuk';
    protected $fillable = [
        'perihal',
        'pengirim',
        'penerima',
        'kategori_id',
        'atas_nama',
        'file',
        'disposisi',
        'approved_by',
        'status',
    ];

    public function penerima(): BelongsTo {
        return $this->belongsTo(User::class, 'penerima', 'id');
    }

    public function atasNama(): BelongsTo {
        return $this->belongsTo(User::class, 'atas_nama', 'id');
    }

    public function approvedBy(): BelongsTo {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }
}
