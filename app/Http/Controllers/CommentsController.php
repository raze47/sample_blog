<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\User;
use App\Models\Posts;
use Auth;
use DB;
use Carbon;
use Illuminate\Http\Request;




class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
       $comments = new Comments;
     
        try{
           $comments->insert([
                'comment' => $request->comment,
                'user_id' => Auth::id(),
                'post_id' => $request->post_id,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
            ]);
   //         $comments->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
    //        $comments->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            return back();
        }
        catch(\Exception $e){
            print($e);
            dd($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comments  $comments
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $data = Comments::orderBy('comment_id', 'asc')->with('user')->paginate(1000);

        return response()->json([
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comments  $comments
     * @return \Illuminate\Http\Response
     */
    public function edit(Comments $comments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comments  $comments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comments $comments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comments  $comments
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try{
            $comment = Comments::where('comment_id', $request->comment_id);            
            $comment->delete();

        }
        catch(\Exception $e){
            dd($e);
        }
        return back();
    }
}
