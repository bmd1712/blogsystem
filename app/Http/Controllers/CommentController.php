<?php 

namespace App\Http\Controllers;

use App\Services\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function index($postId, Request $request)
    {
        $perPage = $request->get('per_page', 10);
        return response()->json($this->commentService->getCommentsForPost($postId, $perPage));
    }
    
    public function store(Request $request, $postId)
    {
        $request->validate(['content' => 'required|string']);
        $comment = $this->commentService->addComment(
            $request->user()->id,
            $postId,
            $request->content
        );

        return response()->json($comment, 201);
    }

    public function destroy($id)
    {
        $this->commentService->deleteComment($id);
        return response()->json(['message' => 'Deleted successfully']);
    }
}
