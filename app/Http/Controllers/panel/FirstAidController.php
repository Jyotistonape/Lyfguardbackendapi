<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use App\Models\FirstAid;
use App\Models\FirstAidCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Str;
class FirstAidController extends Controller
{
    private $category, $firstAid;

    public function __construct()
    {
        $this->category = new FirstAidCategory();
        $this->firstAid = new FirstAid();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['firstAid'] = $this->firstAid->getAllFirstAid();
        $data['pageName'] = "First Aid";
        return view('panel.firstaid.list-firstaid')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['pageName'] = "Add First Aid";
        $data['categories'] = $this->category->getAllCategory();
        return view('panel.firstaid.create-firstaid')->with('data', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required',
            'title' => 'required',
            'description' => 'required',
            'video_link' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        // Take the video link in a variable
        $video_link = $request->input('video_link');

        // Validate the link
        $link = Str::contains($video_link, 'https://www.youtube.com/watch?v');

        //  Check 
        if($link == true){
            $firstaid = FirstAid::create([
                'slug' => $this->generateSlug($request->input('title'), 'first_aids'),
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'video_link' => $video_link,
                'cat_id' => $request->input('category'),
            ]);
            if ($firstaid)
                return \redirect(route('listFirstAid'))->with('success', 'First Aid Added');
        }
        else{
            return Redirect::back()->with('error', 'Link is not correct, Please try again')->withInput();
        }

        return Redirect::back()->with('error', 'Please try again');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $firstaid = $this->firstAid->getFirstAidByID($id);
        if ($firstaid) {
            $data['firstaid'] = $firstaid;
            $data['pageName'] = "Edit First Aid";
            $data['categories'] = $this->category->getAllCategory();
            return view('panel.firstaid.edit-firstaid')->with('data', $data);
        }
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required',
            'title' => 'required',
            'description' => 'required',
            'video_link' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        // Take the video link in a variable
        $video_link = $request->input('video_link');

        // Validate the link
        $link = Str::contains($video_link, 'https://www.youtube.com/watch?v');

        if($link == true){
            $firstaid = FirstAid::where('id', $id)->where('status', 1)->update([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'video_link' => $request->input('video_link'),
                'cat_id' => $request->input('category'),
            ]);
            if ($firstaid)
                return \redirect(route('listFirstAid'))->with('success', 'First Aid Updated');
            return Redirect::back()->with('error', 'Please try again');

        }
        else{
            return Redirect::back()->with('error', 'Link is not correct, Please try again')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $firstaid = FirstAid::where('id', $id)->where('status', 1)->update([
            'status' => 0,
        ]);
        if ($firstaid)
            return Redirect::back()->with('success', 'First Aid Deleted');
        return Redirect::back()->with('error', 'Please try again');
    }
}
