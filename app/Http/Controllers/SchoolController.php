<?php

namespace App\Http\Controllers;
use App\Models\School_Details;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index()
    {
        // Paginate results
        $schools = School_Details::paginate(5);
        return view('schools', compact('schools'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'school_name' => 'required|string|max:255',
            'school_code' => 'required|string|max:50|unique:school_details,school_code',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:20',
            'status' => 'required|string',
        ]);

        School_Details::create($validated);

        return redirect()->route('schools.index')->with('success', 'School added successfully!');
    }

    public function update(Request $request, $id)
    {
        $school = School_Details::findOrFail($id);

        $validated = $request->validate([
            'school_name' => 'required|string|max:255',
            'school_code' => 'required|string|max:50|unique:school_details,school_code,' . $id,
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:20',
            'status' => 'required|string',
        ]);

        $school->update($validated);

        return redirect()->route('schools.index')->with('success', 'School updated successfully!');
    }

    public function destroy($id)
    {
        $school = School_Details::findOrFail($id);
        $school->delete();

        return redirect()->route('schools.index')->with('success', 'School deleted successfully!');
    }
}