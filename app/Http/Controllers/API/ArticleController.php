<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\ArticleImage;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\File;

class ArticleController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::with(['articleImages'])
            ->where('_user_id', \request()->user()->id)->get();
        $articlesCollection = ArticleResource::collection($articles);
        return $this->responseSuccess($articlesCollection);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $article = new Article();
        $article->fill($request->all());
        $article->_user_id = $request->user()->id;
        if ($article->save()) {
            if ($request->hasFile('image')) {
                $images = $request->file('image');
                foreach ($images as $img) {
                    $ext = $img->getClientOriginalExtension();
                    $name = time() . '.' . $ext;
                    $path = public_path('\image');

                    $articleImage = new ArticleImage;
                    $img->move($path, $name);
                    $articleImage->path = $name;
                    $articleImage->article_id = $article->id;
                    $articleImage->save();
                }

            }
            $article->load(['articleImages']);

            return $this->responseSuccess(
                new ArticleResource($article),
                ['article created successfully'],
                201
            );
        } else {
            return $this->responseError(['article not created, please try again'], 501);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return $this->responseSuccess(new ArticleResource($article));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {


//        $this->validate($request, [
//
//            'title' => 'required|nullable|max:1000',
//            'description' => 'required|nullable|max:5000'
//        ]);

        $article->fill($request->all());
//        $article->_user_id = $request->user()->id;
        $article->save();

        return $this->responseSuccess(new ArticleResource($article));
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return $this->responseSuccess(null, [], 204);

    }

}
