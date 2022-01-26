<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products=product::all();
        return response()->json($products,200);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [

                    'name' =>  ['required','unique:products','max:255'],
                    'description' => ['max:255'],
                    'price' => ['required','numeric','min:0'],
                    'image' => ['max:255'],

            ]);

        $product= new product;

        $product->name=$request->input('name');
        $product->description=$request->input('description') ;
        $product->price=$request->input('price') ;
        $product->image=$request->input('image') ;

        if(!$validator->fails())
        {
            $product->save();
            return response()->json($product, 200);
        }
        else
        {
           return response()->json(['errors'=>$validator->errors()]);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $products=product::find($id);
        return response()->json($products,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $rules=['name'=>[],'description'=>[],'price'=>[],'image'=>[]];


        $product= product::find($id);

        if($request->input("name"))
        {
            $product->name = $request->input('name');
            $rules['name'] = ['required','unique:products','max:255'];
        }

        if($request->input("description"))
        {
            $product->description = $request->input('description');
            $rules['description'] = ['max:255'];

        }

        if($request->input("price"))
        {
            $product->price = $request->input('price');
            $rules['price']= ['required','numeric','min:0'];
        }

        if($request->input("image"))
        {
            $product->image = $request->input('image');
            $rules['image'] = ['max:255'];
        }

        $validator = Validator::make($request->all(),$rules );


        if(!$validator->fails())
        {
            $product->save();
            return response()->json($product, 200);
        }
        else
        {
            return response()->json(['errors'=>$validator->errors()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $products=product::find($id)->delete();
        return response()->json($products,200);
    }
}

