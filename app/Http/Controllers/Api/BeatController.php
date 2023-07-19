<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BeatRequest;
use App\Models\Beat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BeatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $beat = Beat::all();

        return response()->json([
            'status' => true,
            'posts' => $beat
        ]);
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
    public function store(BeatRequest $request)
    {

        $freeFile = $request->file('free_file')->store('image', 'public');
        $data = [
            "title" => $request->title,
            "slug" => $request->slug,
            "free_file" => $freeFile
        ];

        if($request->expectsJson()){
            $premiumFile = $request->file('free_file')->store('image', 'public');
            $data["premium_file"] = $premiumFile;
        }

        try{
            $beat = Beat::create($data);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'beat successful created',
            'posts' => $beat
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Beat  $beat
     * @return \Illuminate\Http\Response
     */
    public function show(Beat $beat)
    {

        return response()->json([
            'status' => true,
            'message' => 'beat successful show',
            'post' => $beat->only('title', 'description')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Beat  $beat
     * @return \Illuminate\Http\Response
     */
    public function edit(Beat $beat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Beat  $beat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Beat $beat)
    {
        $data = [
            "title" => $request->title,
            "slug" => $request->slug,
            "free_file" => $request->free_file
        ];

        if($request->expectsJson()){
            $data["premium_file"] = $request->premium_file;
        }

        try{
            $beat->update($data);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'beat successful updated',
            'posts' => $beat
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Beat  $beat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Beat $beat)
    {
        //
    }
}
