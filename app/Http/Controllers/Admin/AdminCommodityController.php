<?php

namespace App\Http\Controllers\Admin;

use App\Models\Commodity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class AdminCommodityController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $commodity =Commodity::orderBy('name')->get();

        return view('admin.commodity.index',compact('commodity'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.commodity.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            $request->validate([
                'name' => 'required|unique:commodities,name',
                'amount' => 'required|numeric',
                'price' => 'required|numeric',
                'body' => 'nullable',
                'image' => 'nullable|image|max:4096',

            ]);


            $commodity =Commodity::create($request->all());

            if($request->hasFile('image') && $request->file('image')->isValid()){
                $file = $request->file('image');
                $file_name = (string)time();
                $file->move(Commodity::STORAGE_DIR , $file_name);
                $commodity->image = $file_name;
                $commodity->save();
            }

        return to_route('admin.commodity.index')->with('success','the %s commodity created!',$request->name);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Commodity  $commodity
     * @return \Illuminate\Http\Response
     */
    public function show(Commodity $commodity)
    {

        return view('admin.commodity.show',compact('commodity'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\commodity  $commodity
     * @return \Illuminate\Http\Response
     */
    public function edit(Commodity $commodity)
    {

        return view('admin.commodity.edit',compact('commodity'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commodity  $commodity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commodity $commodity)
    {
         $request->validate([
                'name' => ['required',Rule::unique('commodities')->ignore($commodity->id)],
                'amount' => 'required|numeric',
                'price' => 'required|numeric',
                'body' => 'nullable',

        ]);

        $commodity->update($request->all());

        if($request->hasFile('image') && $request->file('image')->isValid()){
            if($commodity->image){
                $fp = sprintf('%s$s',Commodity::STORAGE_DIR , $commodity->image);
                if(file_exists($fp)){
                    unlink($fp);
                }
            }

            $file = $request->file('image');
            $file_name = (string)time();
            $file->move(commodity::STORAGE_DIR,$file_name);
            $commodity->image =$file_name;
        }
        $commodity->save();

        return to_route('admin.commodity.index')->with('success','your commodity was updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Commodity  $commodity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commodity $commodity)
    {

       $commodity->purge();
        return to_route('admin.commodity.index')->with('success','the commodity deleted !');
    }


}
