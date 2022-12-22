<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wish extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'detail', 'filename', 'phone', 'pic', 'organization', 'requester_id', 'status_id', 'created_by', 'updated_by'];

    public function requester()
    {
        return $this->belongsTo(Requester::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function pengguna()
    {
        return $this->belongsTo(User::class);
    }
}
