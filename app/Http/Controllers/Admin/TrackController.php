<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Track;

class TrackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tracks=Track::orderBy('id','desc')->paginate(15);
        return view('admin.tracks.index', compact('tracks'));
    }


    public function store(Request $request)
    {
        $rules=[
            'name'=>'required|min:3|max:50',
        ];
        $this->validate($request,$rules);
        if(Track::create($request->all())){
            return redirect('/admin/tracks')->withStatus('Track successfully created');
        }else{
            return redirect('/admin/tracks')->withStatus('something wrong ,try again');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Track $track)
    {
       return view('admin.tracks.edit',compact('track'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Track $track)
    {
        $rules=[
            'name'=>'required|min:3|max:50',
        ];
        $this->validate($request,$rules);
        if($request->has('name')){
            $track->name = $request->name;
        }
        if($track->isDirty()){
            $track->save();
            return redirect('/admin/tracks')->withStatus('track successfully updated');
        }else{
            return redirect('/admin/tracks/'.$track->id.'/edit')->withStatus('nothing change');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Track $track)
    {
        $track->delete();
        return redirect('/admin/tracks')->withStatus('track successfully deleted');
    }
}
