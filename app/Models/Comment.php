<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'user_id',
        'post_id',
        'parent_id',
    ];

    public function post() {
        return $this->belongsTo(Post::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    // Eloquentは、リレーションメソッドの名前を調べ、メソッド名の末尾に_idを付けることにより、外部キー名を決定します。したがって、この場合、EloquentはPhoneモデルにuser_idカラムがあると想定します。ただし、Phoneモデルの外部キーがuser_idでない場合は、カスタムキー名をbelongsToメソッドの２番目の引数として渡してください。
    public function parent() {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function children() {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function addReplyToComment(Request $request, Comment $comment)
{
    $reply = new Comment;
    $reply->content = $request->content;
    $reply->user_id = auth()->id(); // Assuming you have a user logged in
    $reply->post_id = $comment->post_id; // Assuming the reply is for the same post
    $reply->parent_id = $comment->id; // Link the reply to the parent comment
    $reply->save();

    return redirect()->back()->with('message', 'Reply added successfully');
}
}
