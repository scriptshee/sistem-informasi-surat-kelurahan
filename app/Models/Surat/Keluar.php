<?php

namespace App\Models\Surat;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Keluar extends Model
{
    use HasFactory;
    protected $table = 'surat_keluar';
    protected $fillable = [
        'perihal',
        'tujuan',
        'kategori_id',
        'author_id',
        'file',
        'approved_by',
        'status',
    ];
    
    public function author() : BelongsTo {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }
    
    public function ketegori() : BelongsTo {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }

    public function approve() : BelongsTo {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }
}
