<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\user;
use App\Models\Thread;
use App\Models\Comments;


class AuthController extends Controller
{
    //
    public function index(){
        return view('auth.login');
    }
    public function register_view(){

        return view('auth.register');
    }

    public function update(){
        // $users = users::all();Auth::user()->name
        $user_details = User::where('id', Auth::user()->id)->first();
        // return view('auth.update', compact('user_details'));
        
        return view('auth.update',compact('user_details'));
    }
    public function update_profile(Request $request, $user){
        // echo "hii";
        // dd($request->all());
        $user = User::find($user);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = \Hash::make($request->password);
        // $user->update($user);
        $user->save(); 
        return redirect('home');
    }

    public function register(Request $request){
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Hash::make($request->password)
        ]);
        if(\Auth::attempt($request->only('email','password'))){
            return redirect('home');
        }
        return redirect('register')->withError('Error');
        // echo "hii";die;
    }

    public function login( Request $request){
        // dd($request->all());
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        if(\Auth::attempt($request->only('email','password'))){
            return redirect('home');
        }
        return redirect('login')->withError('Login details are not valid');
    }

    public function home( ){
        $threads = thread::orderby('id','desc')->get();
        $comments = comments::orderby('id','desc')->get();
        return view('home',compact('threads','comments'));
    }
    public function guest( ){
        $threads = thread::orderby('id','desc')->get();
        $comments = comments::orderby('id','desc')->get();
        return view('home',compact('threads','comments'));
    }
    public function logout(){
        \Session::flush();
        \Auth::logout();
        return redirect('/');
    }

    public function add_comment(Request $request){
        if(Auth::id()){
            $threads=new thread;
            $threads->name = Auth::user()->name;
            $threads->user_id = Auth::user()->id;
            $threads->threads = $request->thread;
            $threads->save();
            return redirect('home');

        }else{
            return redirect('login')->withError('Please login to create thread');
        }

    }

    public function add_replay(Request $request){
        // echo "hii";
        if(Auth::id()){
            $comments=new comments;
            $comments->name = Auth::user()->name;
            $comments->user_id = Auth::user()->id;
            $comments->thread_id = $request->threads_id;
            $comments->comments = $request->replay;
            $comments->save();
            return redirect('home');

        }else{
            return redirect('login')->withError('Please login to create thread');
        }

    }
    public function best_replay($comment_id){
        if(Auth::id()){
            $comments = comments::find($comment_id);
            $comments->best_replay	 = '1';
            $comments->save(); 
            return redirect('home');

        }else{
            return redirect('login')->withError('Please login to create thread');
        }
    }
}
