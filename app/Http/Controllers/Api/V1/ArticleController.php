<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleIndexRequest;
use App\Http\Resources\ArticleResource;
use App\Services\ArticleService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ArticleController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        private readonly ArticleService $articleService,
    ) {
    }

    /**
     * Display a paginated listing of articles.
     */
    public function index(ArticleIndexRequest $request): AnonymousResourceCollection
    {
        return ArticleResource::collection(
            $this->articleService->paginate($request->validated())
        );
    }

    /**
     * Display the specified article.
     */
    public function show(int $id): ArticleResource
    {
        return new ArticleResource(
            $this->articleService->findOrFail($id)
        );
    }
}