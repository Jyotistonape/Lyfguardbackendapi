<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use App\Models\FirstAidCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class FirstAidCategoryController extends Controller
{
    private $category;

    public function __construct()
    {
        $this->category = new FirstAidCategory();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['categories'] = $this->category->getAllCategory();
        $data['pageName'] = "First Aid Categories";
        return view('panel.firstaid-category.list-category')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['pageName'] = "Add First Aid Category";
        return view('panel.firstaid-category.create-category')->with('data', $data);
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
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $category = FirstAidCategory::create([
            'slug' => $this->generateSlug($request->input('name'), 'first_aid_categories'),
            'name' => $request->input('name'),
        ]);
        if ($category)
            return \redirect(route('listFirstAidCategory'))->with('success', 'First Aid Category Added');
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
        $category = $this->category->getCategoryByID($id);
        if ($category) {
            $data['category'] = $category;
            $data['pageName'] = "Edit First Aid Category";
            return view('panel.firstaid-category.edit-category')->with('data', $data);
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
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $category = FirstAidCategory::where('id', $id)->where('status', 1)->update([
            'name' => $request->input('name'),
        ]);
        if ($category)
            return \redirect(route('listFirstAidCategory'))->with('success', 'First Aid Category Updated');
        return Redirect::back()->with('error', 'Please try again');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = FirstAidCategory::where('id', $id)->where('status', 1)->update([
            'status' => 0,
        ]);
        if ($category)
            return Redirect::back()->with('success', 'First Aid Category Deleted');
        return Redirect::back()->with('error', 'Please try again');
    }
}
