<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Listing;

// Common Resource Routes:
// index - Show all listings
// show - Show single listing
// create - Show form to create new listing
// store - Store new listing
// edit - Show form to edit listing
// update - Update listing
// destroy - Delete listing
class ListingController extends Controller
{
    //show all listing
    public function index(Request $request){
        // dd($request);
        return view('listings.index',[
            'listings' =>Listing::latest()->filter(request(['tag','search']))->paginate(4)
               ]);
    }

    //show single listing
    public function show(Listing $listing){
        return view('listings.show',[
            'listing' => $listing,
           ]);
    }

    //show form to create new listing
    public function create(){
        return view('listings.create');
    }

    public function store(Request $request){
        // dd($request);
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formFields['user_id'] = auth()->id();

        Listing::create($formFields);

        return redirect('/') -> with('message','List created successfully');
    }

    //show form to edit listing
    public function edit(Listing $listing){
        return view('listings.edit',[
            'listing' => $listing,
           ]);
    }

    //update listing
    public function destroy(Listing $listing){
       $listing -> delete();
       return redirect('/')->with('message', 'Listing deleted successfully');
    }

    //update a listing
    public function update(Request $request, Listing $listing) {
        // Make sure logged in user is owner
        if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }
        
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required'],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $listing->update($formFields);

        return back()->with('message', 'Listing updated successfully!');
    }

    public function manage(){ 
        return view('listings.manage',[
            'listings' => auth()->user()->listings()->get(),
           ]);
    }

}
