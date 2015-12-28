<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Image;

class ImageController extends Controller
{

    public function __construct()
    {
        $this->middleware('acl:image.manage');
    }

    public function index()
    {
        $images = Image::with('user')->orderBy('created_at', 'DESC')->paginate(10);
        // dd($images);
        return view('admin.images.index', compact('images'));
    }

    public function delimage(Request $request)
    {
        $id = (array) $request->id;
        $images = Image::whereIn('id', $id)->get(['url']);
        if($images){
            foreach ($images as $image) {
                @unlink(public_path().$image['url']);
                @unlink(public_path().getThumb($image['url'], 'xs'));
                @unlink(public_path().getThumb($image['url'], 'small'));
                @unlink(public_path().getThumb($image['url'], 'big'));
            }
            Image::whereIn('id', $id)->delete();
            return response()->json(200);
        }else{
            return response()->json(404);
        }
    }
}
