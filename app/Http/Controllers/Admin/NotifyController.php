<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Notify;
use App\User;
use Validator;
use App\Http\Requests\NotifyRequest;

class NotifyController extends BaseController
{

    public function __construct()
    {
        $this->middleware('acl:system.manage');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = Notify::with('user')->whereIsSystem(1)->latest()->paginate(10);
        return view('admin.notifications.index', compact('notifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.notifications.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NotifyRequest $request)
    {
        $data = $request->all();
        $data['is_system'] = 1;
        if(!$data['to_all'] && !$data['user_id']){
            return redirect()->back()->withErrors(['请指定用户ID或发送给所有用户'])->withInput();
        }
        Notify::notify([$request->user_id], $request->body, $request->type, $request->to_all, 1);

        flash()->message('发送成功！');
        return redirect('/admin/notifications/index');
        dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Notify::whereId($id)->delete();
        return response()->json(200);
    }
}
