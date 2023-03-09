<?php

namespace App\Http\Controllers;
use App\ProductSection;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
	public function header(Request $request)
	{
		return view('backend.website_settings.header');
	}
	public function footer(Request $request)
	{	
		$lang = $request->lang;
		return view('backend.website_settings.footer', compact('lang'));
	}
	public function pages(Request $request)
	{
		return view('backend.website_settings.pages.index');
	}
	public function appearance(Request $request)
	{
		return view('backend.website_settings.appearance');
	}
	public function product_section(Request $request)
	{
		return view('backend.website_settings.product_section');
	}
	public function product_section_edit(Request $request)
	{
	    $id=$request->id;
	      $pro=ProductSection::findOrFail($id);
	   // dd($pro);
		return view('backend.website_settings.product_section_edit',compact('pro'));
	}
	public function product_section_update(Request $request)
	{
	    $id=$request->id;
	   // dd($id);
	    $pro= ProductSection::findOrFail($id);
	    $pro->name=$request->name;
	    $pro->url=$request->url;
	    $pro->img=$request->img;
	    $pro->save();
	   flash(translate('Your request updated !!'))->success();
	   return back();
	}
}