<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    public static function countActiveCategory()
    {
        $data = Category::where('status', 'active')->count();
        if ($data) {
            return $data;
        }
        return 0;
    }
    public function parent_info()
    {
        return $this->hasOne('App\Models\Category', 'id', 'parent_id');
    }
    public static function getAllCategory()
    {
        return  Category::orderBy('id', 'DESC')->with('parent_info')->paginate(10);
    }
}
