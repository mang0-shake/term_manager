<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Column extends Model
{
    protected $table = 'columns';

    protected $fillable = [
        'id',
        'name',
        'html_id',
        'sortable',
        'filterable',
        'element_type',
        'mandatory',
        'position',
    ];
    public $timestamps = false;

    public function dropdownOption()
    {
        return $this->hasMany(DropdownOption::class)->select(['id','position','name']);
    }

    use HasFactory;
}
