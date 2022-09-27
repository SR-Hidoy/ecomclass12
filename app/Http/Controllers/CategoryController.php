<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Auth;
use Carbon\Carbon;
use Image;

class CategoryController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }
    //addcategory
    function addcategory(){
      $categories = Category::all();
      $deleted_categories = Category::onlyTrashed()->get();

      return view('admin.category.index', compact('categories', 'deleted_categories'));
    }
    function addcategorypost(Request $request){
      $request->validate([
        'category_name' => 'required|unique:categories,category_name',
        'category_photo' => 'required|image',
      ],[
        'category_name.required' => 'তোমার ক্যেটাগরি  কই..?',
        'category_name.unique' => 'You can not use this category name!!',
        // 'category_image.required' => 'The category photo must be an Image file.!',


      ]);


      // Laravel

    $category_id = Category::insertGetId([
        'category_name' => $request->category_name,
        'user_id' =>  Auth::user()->id,
        'category_photo' => $request->category_name,
        'created_at' => Carbon::now()
      ]);
      // Photos Upload start
      $uploaded_photo = $request->file('category_photo');
      $new_name = $category_id .".". $uploaded_photo->getClientOriginalExtension();
      $new_upload_location = base_path('public/uploads/category_photos/'.$new_name);
      image::make($uploaded_photo)->resize(600,470)->save($new_upload_location, 50);
      // Photos Upload end
      Category::find($category_id)->update([
          'category_photo' => $new_name
      ]);
      return back()->with('success_message', 'Your category added successfully!');

      // echo $request->category_name;
      // return view('admin.category.index');
    }
    function updatecategory($category_id){
      // echo $category_id;
      $category_name = Category::find($category_id)->category_name;
      $category_photo = Category::find($category_id)->category_photo;
      return view('admin.category.update', compact('category_name', 'category_id', 'category_photo'));
    }
    function updatecategorypost(Request $request){
      if($request->hasFile('new_category_photo')){
        // old photo delete start
        $delete_old_photo_location = base_path('public/uploads/category_photos/'.Category::find($request->category_id)->category_photo);
        unlink($delete_old_photo_location);
        // old photo delete end

        // new photo uplode start
        $uploaded_photo = $request->file('new_category_photo');
        $new_name = $request->category_id .".". $uploaded_photo->getClientOriginalExtension();
        $new_upload_location = base_path('public/uploads/category_photos/'.$new_name);
        image::make($uploaded_photo)->resize(600,470)->save($new_upload_location, 50);
        // new photo uplode end

        // new photo info uplode at db start
         Category::find($request->category_id)->update([
           'category_photo' => $new_name
         ]);
        // new photo info uplode at db end
      }
      // print_r($request->category_name);
      // print_r($request->category_id);
      // print_r($request->file('new_category_photo'));

      Category::find($request->category_id)->update([
        'category_name' => $request->category_name
      ]);
      return redirect('add/category')->with('update_status', 'Category Updated Successfully..!');
    }
    function deletecategory($category_id){
      // echo $category_id;
      Category::find($category_id)->delete();
      return back()->with('delete_status', 'Category Deleted Successfully.!');
      // $category_name = Category::find($category_id)->category_name;
      // return view('admin.category.delete', compact('category_name', 'category_id'));
    }
    function restorecategory($category_id){
      Category::withTrashed()->find($category_id)->restore();
      return back()->with('restore_status', 'Category Restored Successfully.!');
    }
    function harddeletecategory($category_id){
      $delete_photo_location = base_path('public/uploads/category_photos/'.Category::onlyTrashed()->find($category_id)->category_photo);
      Category::onlyTrashed()->find($category_id)->forceDelete();
      unlink($delete_photo_location);
      return back()->with('force_delete_status', 'Your Category force delete Successfully.!');
    }
}
