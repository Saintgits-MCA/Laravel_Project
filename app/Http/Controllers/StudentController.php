<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Services\SearchService;

class StudentController extends Controller
{
    // Display registration form and student list
    public function index(Request $request, SearchService $searchService)
    {
        $status = in_array($request->status, ['Active', 'Inactive'], true)
            ? $request->status
            : null;
        // Common search using SearchService
        $students = $searchService->search(
            model: Student::class,
            columns: ['name', 'email', 'phone', 'course'],
            search: $request->search,
            perPage: 5,
            direction: 'asc',
            status: $status,
        );


        // Load a student into the form when Edit is clicked
        $editingStudent = $request->query('edit')
            ? Student::findOrFail($request->query('edit'))
            : null;

        return view('students', compact(
            'students',
            'editingStudent'
        ));
    }

    // Register a new student
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:students,email',
            ],
            'phone' => ['nullable', 'string', 'max:30'],
            'course' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['Active', 'Inactive'])],
            'address' => ['nullable', 'string', 'max:1000'],
        ]);

        Student::create($validated);

        return redirect()
            ->route('students')
            ->with('success', 'Student Registered Successfully!');
    }

    // Update an existing student
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('students', 'email')->ignore($student->id),
            ],
            'phone' => ['nullable', 'string', 'max:30'],
            'course' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['Active', 'Inactive'])],
            'address' => ['nullable', 'string', 'max:1000'],
        ]);

        $student->update($validated);

        return redirect()
            ->route('students')
            ->with('success', 'Student Updated Successfully!');
    }

    // Delete a student
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()
            ->route('students')
            ->with('success', 'Student deleted successfully!');
    }
}