<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    //Display all listings
    public function index(){

        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag','search']))->paginate(6)
        ]);
    }

    //Display single listing
    public function show(Listing $listing){
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    //Display create listing form
    public function create(){
        return view('listings.create');
    }

    //Store listing to DB
    public function store(Request $request){

        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formFields['user_id'] = auth()->id();

        Listing::create($formFields);

        return redirect()->route('home')->with('message', 'Listing created successfully');
    }

    //Show edit form
    public function edit(Listing $listing){
        return view('listings.edit', ['listing' => $listing]);
    }

    //Update Listing
    public function update(Request $request, Listing $listing){

        //Make sure the editor is the owner of the listing
        if($listing->user_id != auth()->id){
            abort('403', 'Unauthorized Action');
       }

       //Validate Input
        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }
         $listing->update($formFields);

        return back()->with('message', 'Listing updated successfully');
    }

    //Delete Listing
    public function destroy(Listing $listing){

         //Make sure the editor is the owner of the listing
         if($listing->user_id != auth()->id){
            abort('403', 'Unauthorized Action');
       }

        $listing->delete();

        return redirect('/')->with('message', 'Listing deleted successfully');
    }

    //Manage Listing
    public function manage(){
       return view('listings.manage', [ 'listings' => auth()->user()->listings()->get()]);
}
}
