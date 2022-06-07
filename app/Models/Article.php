<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;


    protected $table='articles';
    protected $fillable=['title','description'];


    protected $hidden=[];

    public function user()
    {
        return $this->belongsTo(User::class, '_user_id');
    }
    public function articleImages()
    {
        return $this->hasMany(ArticleImage::class, 'article_id');
    }
}
