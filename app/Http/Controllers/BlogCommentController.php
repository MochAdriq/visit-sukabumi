<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\BlogComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogCommentController extends Controller
{
    public function store(Request $request, BlogPost $post)
    {
        $rules = [
            'comment' => 'required|string|min:3|max:1000',
        ];

        if (!Auth::check()) {
            $rules['name'] = 'required|string|min:2|max:100';
            $rules['email'] = 'nullable|email|max:150';
        }

        $validated = $request->validate($rules);

        BlogComment::create([
            'blog_post_id' => $post->id,
            'user_id' => Auth::id(),
            'name' => Auth::check() ? Auth::user()->name : ($validated['name'] ?? null),
            'email' => Auth::check() ? Auth::user()->email : ($validated['email'] ?? null),
            'comment' => trim(strip_tags($validated['comment'])),
            'is_approved' => true,
        ]);

        return redirect()->to(route('blog.show', $post->slug) . '#comments')
            ->with('comment_success', 'Terima kasih! Komentar Anda berhasil dikirim.');
    }
}
