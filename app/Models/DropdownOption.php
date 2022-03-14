<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DropdownOption extends Model
{
    protected $table = 'dropdown_options';

    protected $fillable = [
        'id',
        'column_id',
        'position',
        'name'
    ];

    public $timestamps = false;

    public function columns(){
        return $this->belongsTo(Column::class);
    }

    use HasFactory;
}
