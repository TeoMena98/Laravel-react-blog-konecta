<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\Category;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Yajra\DataTables\DataTables;
use View;
use DB;

class CategoryController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      return view('backend.admin.category.all');
   }

   public function allcategory()
   {
      DB::statement(DB::raw('set @rownum=0'));
      $usecategory = Category::get(['categories.*', DB::raw('@rownum  := @rownum  + 1 AS rownum')]);
      return Datatables::of($usecategory)
        ->addColumn('action', 'backend.admin.category.action')
        ->make(true);
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create(Request $request)
   {
      if ($request->ajax()) {
         $haspermision = auth()->user()->can('category-create');
         if ($haspermision) {
            $view = View::make('backend.admin.category.create')->render();
            return response()->json(['html' => $view]);
         } else {
            abort(403, 'Sorry, you are not authorized to access the page');
         }
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {

      if ($request->ajax()) {
         // Setup the validator
         $rules = [
           'name' => 'required|unique:categories'
         ];

         $validator = Validator::make($request->all(), $rules);
         if ($validator->fails()) {
            return response()->json([
              'type' => 'error',
              'errors' => $validator->getMessageBag()->toArray()
            ]);
         } else {
            Category::create($request->name);
            return response()->json(['type' => 'success', 'message' => "Successfully Created"]);
         }
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }

   }

   /**
    * Display the specified resource.
    *
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
   public function show(Request $request, Category $category)
   {
      if ($request->ajax()) {

      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
   public function edit(Request $request, Category $category)
   {
      if ($request->ajax()) {
         $haspermision = auth()->user()->can('category-edit');
         if ($haspermision) {
            $view = View::make('backend.admin.category.edit', compact('category'))->render();
            return response()->json(['html' => $view]);
         } else {
            abort(403, 'Sorry, you are not authorized to access the page');
         }
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request $request
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, Category $category)
   {
      if ($request->ajax()) {
         // Setup the validator
         Category::findOrFail($category->id);

         $rules = [
           'name' => 'required|unique:categories,name,' . $category->id
         ];

         $validator = Validator::make($request->all(), $rules);
         if ($validator->fails()) {
            return response()->json([
              'type' => 'error',
              'errors' => $validator->getMessageBag()->toArray()
            ]);
         } else {
            $category->name = $request->name;
            $category->save();
            return response()->json(['type' => 'success', 'message' => "Successfully Updated"]);
         }
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
  
      public function destroy($id, Request $request)
      {
         if ($request->ajax()) {
            $haspermision = auth()->user()->can('category-delete');
            if ($haspermision) {
               $user = Category::findOrFail($id); //Get user with specified id
               $user->delete();
               return response()->json(['type' => 'success', 'message' => "Successfully Deleted"]);
            } else {
               abort(403, 'Sorry, you are not authorized to access the page');
            }
         } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
         }
      }
   
}
