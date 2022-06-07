<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Http\Resources\ArticleImageResource;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\ArticleImage;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ArticleImageController extends Controller
{
    use ApiResponse;

    public function index()
    {
//        return $this->responseSuccess(ArticleImageResource::collection(ArticleImage::all()));

    }


    public function store(Request $request)
    {
        if ($request->hasFile('image')) {
            $images = $request->file('image');
            foreach ($images as $img) {
                $ext = $img->getClientOriginalExtension();
                $name = time() . '.' . $ext;
                $path = public_path('\image');

                $articleImage = new ArticleImage;
                $img->move($path, $name);
                $articleImage->path = $name;
                $articleImage->article_id = \request('article_id');
                $articleImage->save();
            }

        }

    }

    public function show(ArticleImage $articleImage)
    {
          //

    }


    public function update(Article $article, ArticleImage $articleImage, Request $request)
    {
        if (isset($articleImage)) {
            File::delete(public_path('image/' . $articleImage->path));
            $articleImage->delete();
        }

        if ($request->hasFile('image')) {
            $images = $request->file('image');

            $ext = $images->getClientOriginalExtension();
            $name = time() . '.' . $ext;
            $path = public_path('\image');

            $articleImage = new ArticleImage;
            $images->move($path, $name);
            $articleImage->path = $name;
            $articleImage->article_id = $article->id;
            $articleImage->save();

        }
    }


    public function destroy(Article $article, ArticleImage $articleImage)
    {
        if (isset($articleImage)) {
            File::delete(public_path('image/' . $articleImage->path));
            $articleImage->delete();
        }
        return $this->responseSuccess(null, [], 204);

    }
}
