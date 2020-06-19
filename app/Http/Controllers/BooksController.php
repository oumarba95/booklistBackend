<?php

namespace App\Http\Controllers;

use App\Book;
use App\User;
use App\Comment;
use App\CommentAnswer;
use Illuminate\Http\Request;
use App\Http\Resources\Answer;
use App\Http\Resources\Book as BookResource;
use App\Http\Resources\Comment as CommentResource;
use App\Http\Resources\BookCollection as BookCollection;

class BooksController extends Controller
{   
    public function  __construct() {
        $this->middleware('auth:api',['except'=>['index','store','show','destroy']]);
    }
    public function index(){
          $query = request()->query('status');
        if (!empty($query)){
              $books = Book::paginate(2);
        }
        else{
            $books = Book::all();
        }
    	return new BookCollection($books);//response()->json($books);
    }
    public function store(Request $request){
    	$file=$request->file('image');
    	$name=$file->getClientOriginalName();
    	$file->move('images',$name);
    	$titre = $request->input('titre');
        $auteur = $request->input('auteur');
        $description = $request->input('description');
    	$book = Book::create(['titre'=>$titre,'auteur'=>$auteur,'image'=>$name,'description'=>$description]);
    	return $book; 	
    }
    public function show($id){
    	$book = Book::find($id);
    	return new BookResource($book);
    }
    public function destroy($id){
        $book = Book::find($id);
        $this->removeAllAboutBook($book);
        $book->delete();
        return $book;
    }
    public function removeAllAboutBook($book){
       foreach($book->comments as $comment){
           $comment->likedBy()->delete();
           $comment->dislikedBy()->delete();
           foreach($comment->answers as $answer){
               $answer->likedBy()->delete();
               $answer->dislikedBy()->delete();
           }
           $comment->answers()->delete();
       }
       $book->comments()->delete();

    }
    public function addComment(Request $request){
       $book_id = $request->input('book_id');
        $book= Book::find($book_id);
        $user = User::find($request->user_id);
        $comment = $book->comments()->create(['user_id'=>$request->user_id,'user_name'=>$user->name,'contenu'=>$request->contenu]);
        return new CommentResource ($comment);
    }

    public function addAnswer(Request $request){
        $comment = Comment::find($request->comment_id);
        $user = User::find($request->user_id);
        $answer = $comment->answers()->create(['user_id'=>$request->user_id,'user_name'=>$user->name,'contenu'=>$request->contenu]);
        return new Answer($answer);

    }

    public function likeComment(Request $request){
       if(User::find($request->user_id) && auth()->user()->id === $request->user_id){
         $comment = Comment::find($request->comment_id);
         if($comment->likedBy()->where('user_id',$request->user_id)->count() > 0){
              $like = $comment->likedBy()->where('user_id',$request->user_id)->first();
              $like->delete();
              return response()->json(['likeSupprime'=>$like]);
         }else if( $comment->dislikedBy()->where('user_id',$request->user_id)->count() > 0){
                $dislike = $comment->dislikedBy()->where('user_id',$request->user_id)->first();
                $dislike->delete(); 
                $like = $comment->likedBy()->create(['user_id'=>$request->user_id]);
                return response()->json([
                    'dislikeRemoved' => $dislike,
                    'like' => $like
                ]);
         }
         $like = $comment->likedBy()->create(['user_id'=>$request->user_id]);
         return  response()->json(['like'=>$like]);
        }else 
          return response()->json(['error'=>'Unautorizated'],401);
    }
    public function dislikeComment(Request $request){
      if(User::find($request->user_id) && auth()->user()->id === $request->user_id){
        $comment = Comment::find($request->comment_id);
        if ($comment->dislikedBy()->where('user_id',$request->user_id)->count() > 0){
            $dislike = $comment->dislikedBy()->where('user_id',$request->user_id)->first();
            $dislike->delete();
            return response()->json([
               'dislikeRemoved' => $dislike
            ]);
    }else if($comment->likedBy()->where('user_id',$request->user_id)->count() > 0){
        $like = $comment->likedBy()->where('user_id',$request->user_id)->first();
        $like->delete(); 
        $dislike = $comment->dislikedBy()->create(['user_id'=>$request->user_id]);
        return response()->json([
            'likeRemoved' => $like,
            'dislike' => $dislike
        ]);
    }
        $dislike = $comment->dislikedBy()->create(['user_id'=>$request->user_id]);
        return response()->json(['dislike'=>$dislike]);
   }else 
     return response()->json(['error'=>'Unauthorizated'],401);
   }
   public function likeAnswer(Request $request){
    if(User::find($request->user_id) && auth()->user()->id === $request->user_id){
    $answer = CommentAnswer::find($request->answer_id);
    if ($answer->likedBy()->where('user_id',$request->user_id)->count() > 0){
        $like = $answer->likedBy()->where('user_id',$request->user_id)->first();
        $like->delete();
        return response()->json([
           'likeRemoved' => $like
        ]);
    }else if ($answer->dislikedBy()->where('user_id',$request->user_id)->count() > 0){
        $dislike = $answer->dislikedBy()->where('user_id',$request->user_id)->first();
        $dislike->delete();
        $like = $answer->likedBy()->create(['user_id'=>$request->user_id]);
        return response()->json([
           'dislikeRemoved' => $dislike,
           'like' => $like
        ]);
    }
    $like = $answer->likedBy()->create(['user_id'=>$request->user_id]);
    return response()->json(['like'=>$like]);
}else
    return response()->json(['error'=>'Unauthorizated'],401);
}
public function dislikeAnswer(Request $request){
    if(User::find($request->user_id) && auth()->user()->id === $request->user_id){
        
    $answer = CommentAnswer::find($request->answer_id);
    if ($answer->dislikedBy()->where('user_id',$request->user_id)->count() > 0){
        $dislike = $answer->dislikedBy()->where('user_id',$request->user_id)->first();
        $dislike->delete();
        return response()->json([
           'dislikeRemoved' => $dislike
        ]);
    }else if ($answer->likedBy()->where('user_id',$request->user_id)->count() > 0){
        $like = $answer->likedBy()->where('user_id',$request->user_id)->first();
        $like->delete();
        $dislike = $answer->dislikedBy()->create(['user_id'=>$request->user_id]);
        return response()->json([
           'likeRemoved' => $like,
           'dislike' => $dislike
        ]);
    }
    $dislike = $answer->dislikedBy()->create(['user_id'=>$request->user_id]);
    return response()->json(['dislike'=>$dislike]);
    }else
      return response()->json(['error'=>'Unauthorizated'],401);
}
}