<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(5),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('listings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $formData = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' =>  'required',
            'description' => 'required'
        ]);

        if ($request->hasFile('logo')) {
            $formData['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formData['user_id'] = auth()->id();

        Listing::create($formData);

        return redirect('/')->with('message', 'Listing created successfully ');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Listing $listing)
    {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Listing $listing)
    {
        return view('listings.edit', ['listing' => $listing]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Listing $listing)
    {
        if ($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorize user');
        }

        $formData = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' =>  'required',
            'description' => 'required'
        ]);

        if ($request->hasFile('logo')) {
            $formData['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $listing->update($formData);

        return back()->with('message', 'Listing updated successfully ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Listing $listing)
    {
        if ($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorize user');
        }

        $listing->delete();

        return redirect('/')->with('message', 'Listing Delete Successfully');
    }

    public function manage()
    {
        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    }
}
