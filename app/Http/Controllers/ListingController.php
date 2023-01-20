<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
	//Get and Show all listings
	public function index()
	{
		//Filter by tag
		return view('listings.index', [
			'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6)
		]);
	}

	//Get and show 1 listing
	public function show(Listing $listing)
	{
		return view('listings.show', [
			'listing' => $listing
		]);
	}
	//show create form
	public function create()
	{
		return view('listings.create');
	}
	//store listing data
	public function store(Request $request)
	{

		$formFields = $request->validate([
			'title' => 'required',
			'company' => ['required', Rule::unique('listings', 'company')],
			'location' => 'required',
			'website' => 'required',
			'email' => ['required', 'email'],
			'tags' => 'required',
			'description' => 'required'
		]);

		if ($request->hasFile('logo')) {
			$formFields['logo'] = $request->file('logo')->store('logos', 'public');
		}

		$formFields['user_id'] = auth()->id();

		Listing::create($formFields); //puts in database

		return redirect('/')->with('message', 'Listing created successfully!');
	}

	//show edit form
	public function edit(Listing $listing)
	{
		return view('listings.edit', ['listing' => $listing]);
	}

	//update listing data
	public function update(Request $request, Listing $listing)
	{

		//Make sure logged in user is owner
		if ($listing->user_id != auth()->id()) {
			abort('403', 'Unauthorized Action');
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

		if ($request->hasFile('logo')) {
			$formFields['logo'] = $request->file('logo')->store('logos', 'public');
		}


		$listing->update($formFields); //puts in database

		return back()->with('message', 'Listing updated successfully!');
	}
	//Delete Listing
	public function destroy(Listing $listing)
	{
		if ($listing->user_id != auth()->id()) {
			abort('403', 'Unauthorized Action');
		}

		$listing->delete();
		return redirect('/')->with('message', 'Listing deleted successfully!');
	}

	//Manage listing function
	public function manage()
	{
		return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);  //takes in listings and the relationship data 
	}
}