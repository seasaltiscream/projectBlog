<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use Illuminate\Support\Facades\Auth;

use App\Models\Post;

use Alert;

class HomeController extends Controller
{
    //
    public function index(){
        if(Auth::id()){
            $post=Post::where('post_status', '=', 'active')->get();
            //if someone is trying to login
            $userType = Auth()->user()->userType;
            //fetch the userType from users table, store it to $userType variable
        
            if($userType=='user'){
                //if userType is user
                return view('home.homePage', compact('post'));
                //from resources\views\profile\dashboard.blade.php
            }
            elseif($userType=='admin'){
                //if userType is admin
                return view('admin.adminhome');
                //create admin folder in views
            }

            else{
                return redirect()->back();
                //if no roles, return user to the same page
            }
        }
    }

    public function homePage(){
        $post=Post::where('post_status', '=', 'active')->get();
        //fetch all posts from posts table
        return view('home.homePage', compact('post'));
    }

    public function post_details($id){
        $post=Post::find($id);
        return view('home.post_details',compact('post'));
    }

    public function create_post(){
        return view('home.create_post');
    }

    public function user_post(Request $request){
        $user=Auth()->user();
        //will fetch user type

        $userid=$user->id;
        //fetch logged in user's id

        $username=$user->name;

        $userType=$user->userType;

        $post= new Post;
        //make new model (basically Post is the table)
        $post->title = $request->title;
        $post->description = $request->description;
        $post->user_id=$userid;
        $post->name=$username;
        $post->userType=$userType;
        $post->post_status='pending';
        $image=$request->image;
        if($image){
            $imagename=time().'.'.$image->getClientOriginalExtension();
            $request->image->move('postimage', $imagename);
            $post->image=$imagename;
        }

        $post->save();

        Alert::success('Success', 'Data added successfully');

        return redirect()->back();
        
    }

    public function my_post(){
        $user=Auth()->user();
        //will fetch user type

        $userid=$user->id;
        //fetch logged in user's id

        $data = Post::where('user_id', '=', $userid)->get();
                        //get logged in user id and store it in $userid, the fetch the data                        
        return view('home.my_post', compact('data'));
    }

    public function deleteUserPost($id){
        $data=Post::find($id);
        $data->delete();
        return redirect()->back()->with('message', 'Post deleted successfully');
    }

    public function update_user_post($id){
        $data = Post::find($id);
        return view('home.post_page', compact('data'));
    }

    public function update_postData(Request $request, $id){
        $data=Post::find($id);
        $data->title=$request->title;
        $data->description=$request->description;

        $image=$request->image;
        if($image){
            $imagename=time().'.'.$image->getClientOriginalExtension();
            $request->image->move('postimage', $imagename);
            $data->image=$imagename;
        }
        $data->save();
        return redirect()->back()->with('message', 'Post updated successfully');
    }

}
