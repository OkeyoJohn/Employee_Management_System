<?php

namespace App\Http\Controllers;
use App\Models\Employee;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::query();

        if ($search = trim($request->input('search', ''))) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%");
            });
        }

        if ($department = $request->input('department')) {
            $query->where('department', $department);
        }

        $status = $request->input('status');
        if ($status === 'inactive' || $status === 'on_leave') {
            $query->whereRaw('0 = 1');
        }

        $sortBy = $request->input('sort_by', 'name');
        $sortDir = $request->input('sort_dir', 'asc') === 'desc' ? 'desc' : 'asc';

        switch ($sortBy) {
            case 'department':
                $query->orderBy('department', $sortDir);
                break;
            case 'position':
                $query->orderBy('position', $sortDir);
                break;
            case 'hired_at':
                $query->orderBy('hire_date', $sortDir);
                break;
            case 'status':
                $query->orderBy('hire_date', $sortDir);
                break;
            case 'name':
            default:
                $query->orderBy('last_name', $sortDir)
                      ->orderBy('first_name', $sortDir);
                break;
        }

        $employees = $query->paginate(12)->withQueryString();

        $departments = Employee::query()
            ->select('department')
            ->distinct()
            ->orderBy('department')
            ->pluck('department')
            ->all();

        $stats = [
            'total' => Employee::count(),
            'active' => Employee::count(),
            'on_leave' => 0,
            'inactive' => 0,
        ];

        return view('EmployeeList', compact('employees', 'departments', 'stats'));
    }

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

    public function create()
    {
        return redirect()->route('dashboard');
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
