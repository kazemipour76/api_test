<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleImage extends Model
{
    use HasFactory;
    protected $table='article_images';
//    protected $fillable = [
//        'path',
//        'article_id',
//    ];
    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }
}
