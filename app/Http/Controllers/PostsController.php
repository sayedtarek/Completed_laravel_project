<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Posts;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth',['except'=>['index','show']]);
    }
    public function index()
    {
        $posts = Posts::orderBy('created_at','desc')->paginate(3);
        return view('posts.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create'); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'subject'   =>'required',
            'firstname' =>'required',
            'lastname'  =>'required',
            'body'      =>'required',
            'post_image'=>'image|nullable|max:1024', 
        ]);

      /*  if($request->hasFile('post_image')){  

            $filenameWithExtention = $request->file('post_image')->getClientOriginalName();
            $fileName = pathinfo($filenameWithExtention,PATHINFO_FILENAME);
            $extension = $request->file('post_image')->getClientOriginalExtension();
            $fileNameStore = $fileName .'_'.time().'.'.$extension;

            $path = $request->file('post_image')->move(base_path() . '/public/images/', $fileNameStore);
  
 
            
        }else{
                $fileNameStore = 'noImage.jpg';
              }*/

         if($request->hasFile('post_image')){
     $filenameWithExtention = $request->file('post_image')->getClientOriginalName();
     $fileName = pathinfo($filenameWithExtention,PATHINFO_FILENAME);
     $extension = $request->file('post_image')->getClientOriginalExtension();
     $fileNameStore = $fileName .'_'.time().'.'.$extension;
     $path = $request->file('post_image')->storeAs('public/post_image',$fileNameStore);
 }else{
     $fileNameStore = 'noImage.jpg';
 }
              

        $posts = new Posts;
        $posts->subject   = $request->input('subject');
        $posts->firstname = $request->input('firstname');
        $posts->lastname  = $request->input('lastname');
        $posts->body      = $request->input('body');
        $posts->user_id   =  auth()->user()->id;
        $posts->post_image = $fileNameStore;
        $posts->save();

        return redirect('posts')->with('success','donesuccessfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Posts::find($id);
        return view('posts.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Posts::find($id);
        if (auth()->user()->id !== $post->user_id) {
            return redirect('/posts')->with('error','unautherized');
        }
        return view('posts.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'subject'   =>'required',
            'firstname' =>'required',
            'lastname'  =>'required',
            'body'      =>'required',
        ]);

        if($request->hasFile('post_image')){
             $filenameWithExtention = $request->file('post_image')->getClientOriginalName();
             $fileName = pathinfo($filenameWithExtention,PATHINFO_FILENAME);
             $extension = $request->file('post_image')->getClientOriginalExtension();
             $fileNameStore = $fileName .'_'.time().'.'.$extension;
             $path = $request->file('post_image')->storeAs('public/post_image',$fileNameStore);
         }

        $posts =  Posts::find($id);
        $posts->subject   = $request->input('subject');
        $posts->firstname = $request->input('firstname');
        $posts->lastname  = $request->input('lastname');
        $posts->body      = $request->input('body');
        if($request->hasFile('post_image')){
            $posts->post_image  = $fileNameStore;
        }
        $posts->save();

        return redirect('posts')->with('success','donesuccessfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Posts::find($id);
        if (auth()->user()->id !== $post->user_id) {
            return redirect('/posts')->with('error','unautherized');
        }
        if($post->post_image != 'noImage.jpg'){
         Storage::delete('public/images/'.$post->post_image);
 
        }
        $post->delete();
        return redirect('posts')->with('success','donesuccessfully');
    }
}
