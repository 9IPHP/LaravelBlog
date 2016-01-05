<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Validator;
use App\Option;

class OptionController extends Controller
{

    public function __construct()
    {
        $this->middleware('acl:user.manage');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $options = Option::oldest('id')->get();
        return view('admin.options.index', compact('options'));
        dd($options);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.options.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'label' => 'required',
            'name' => 'required|alpha|unique:options',
            'value' => 'required',
            'type' => 'required|alpha',
        ]);
        if ($validation->fails()){
            return redirect()->back()->withErrors($validation);
        }
        Option::create($request->all());
        flash()->message('添加成功');
        return redirect()->back();
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $requests = $request->except(['_token', '_method']);
        $options = Option::latest()->get();
        // dd($requests);
        foreach ($options as $option) {
            if($requests[$option->name] != $option->value){
                $option->value = htmlspecialchars($requests[$option->name]);
                $option->save();
            }
        }
        flash()->message('修改成功！');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
