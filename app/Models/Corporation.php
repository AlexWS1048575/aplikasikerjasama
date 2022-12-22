<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Notifications\Notifiable;

class Corporation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'title', 'document_no', 'assignment_date', 'summary', 
    'duration', 'pic', 'phonenumber', 'attachment', 'attachment2', 'status_id', 'type_id', 'durationtype_id', 'corporationtype_id','created_by', 'updated_by'];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function corporationtype()
    {
        return $this->belongsTo(CorporationType::class);
    }

    public function durationtype()
    {
        return $this->belongsTo(DurationType::class);
    }
}
