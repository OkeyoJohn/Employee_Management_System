<?php

namespace App\Http\Controllers;
use App\Models\Employee;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'phone_number' => 'required|string|max:20',
            'position' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'salary' => 'required|numeric',
            'hire_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('employee_images', 'public');
            $validatedData['image'] = $imagePath;
        }

        Employee::create($validatedData);

        return redirect()->route('dashboard')->with('success', 'Employee created successfully.');
    }

    protected function ensureAdmin(): void
    {
        if (! auth()->user()?->isAdmin()) {
            abort(403);
        }
    }

    public function show(Employee $employee)
    {
        $this->ensureAdmin();

        return view('EmployeeView', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $this->ensureAdmin();

        return redirect()->route('employees.show', $employee);
    }

    public function destroy(Employee $employee)
    {
        $this->ensureAdmin();

        $employee->delete();

        return redirect()->route('dashboard')->with('success', 'Employee deleted successfully.');
    }
}
