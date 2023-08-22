<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'catalog_name',
        'image_id',
        
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }
    public function addImage(Image $image)
{
    $image->user_id = auth()->user()->id; // กำหนดค่า user_id จากผู้ใช้ที่ล็อกอินอยู่
    return $this->images()->save($image);
}

}
