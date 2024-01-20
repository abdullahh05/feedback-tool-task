<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\FeedBack;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks= FeedBack::query()->latest()->paginate(8);
        $categories = Category::query()->get();
        return view('index',["feedback" => $feedbacks, "categories" => $categories]);
    }
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),[
                "title" => "required",
                "description" => "required",
                "category" => "required",
            ]);
            if($validator->fails()){
                return redirect()->back()->with('error', $validator->errors()->first());
            }
            FeedBack::create([
                "title" => $request->input('title'),
                "description" => $request->input('description'),
                "category_id" => $request->input('category'),
                "submit_by" => auth('web')->user()->id,
            ]);
            return redirect()->route('index')->with('success', 'Feedback added successfully.');
        }catch (\Exception $e){
            return redirect()->route('index')->with('error', $e->getMessage());
        }
    }
    public function commentStore(Request $request)
    {
        try {
            Comment::create([
                "comment" => $request->input('comment'),
                "feedback_id" => $request->input('feedback_id'),
                "created_by" => auth('web')->user()->id,
            ]);
            return response()->json(['success'=>'Comment saved successfully.']);
        }catch (\Exception $e){
            return response()->json(['success'=> $e->getMessage()]);
        }
    }
    public function comments($feedbackID)
    {
        try {
            $comments = Comment::query()->latest()->where('feedback_id', $feedbackID)->get()->transform(function ($comment){
                $_comment = $comment->toArray();
                $_comment['created_by'] = $comment->user->name;
                $_comment['created_at'] = date('Y-m-d h:i:s a', strtotime($comment->created_at));
                return $_comment;
            });
            return response()->json(["status" =>true, "comments" => $comments]);
        }catch (\Exception $e){
            return response()->json(['success'=> $e->getMessage()]);
        }
    }
    public function users()
    {
        $users = User::query()->get();
        return response()->json(["status" => true, "users" => $users]);
    }
}
