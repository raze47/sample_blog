<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
       dd($req->posts_text);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $post = $user->posts();

        try{
           
           $post->create([
                'content' => $request->posts_text,
            ]);
        }
        catch(\Exception $e){
            print($e);
            dd($request->posts_text);
        }
        return back();
   
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //$data = Posts::orderBy('created_at', 'desc')->with('user')->paginate(10);
        
        $data = Posts::orderBy('created_at', 'desc')->with('user')->paginate(10);
        
        return response()->json([
            'data' => $data,
            'auth_user' => Auth::id()
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function edit(Posts $posts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $post = $user->posts();

        try{
           
           $post->update([
                'content' => $request->posts_text,
            ]);
        }
        catch(\Exception $e){
            print($e);
            dd($request->posts_text);
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try{
            $post = Posts::where('post_id', $request->post_id);            
            $post->delete();

        }
        catch(\Exception $e){
            dd($e);
        }
        return back();
    }
}
