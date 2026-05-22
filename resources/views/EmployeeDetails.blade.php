<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Employee Details
            </h2>
            <a
                href="{{ route('dashboard') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 text-white text-sm font-medium rounded-md hover:bg-gray-900"
            >
                Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if($employee->image)
                        <div class="mb-6">
                            <img
                                src="{{ asset('storage/' . $employee->image) }}"
                                alt="{{ $employee->first_name }} {{ $employee->last_name }}"
                                class="w-full max-w-sm rounded-xl border border-gray-200 shadow-sm"
                            >
                        </div>
                    @endif

                    <div class="space-y-4">
                        <div>
                            <span class="font-semibold text-gray-700">Name:</span>
                            <span class="text-gray-600">{{ $employee->first_name }} {{ $employee->last_name }}</span>
                        </div>

                        <div>
                            <span class="font-semibold text-gray-700">Email:</span>
                            <span class="text-gray-600">{{ $employee->email }}</span>
                        </div>

                        <div>
                            <span class="font-semibold text-gray-700">Position:</span>
                            <span class="text-gray-600">{{ $employee->position }}</span>
                        </div>

                        <div>
                            <span class="font-semibold text-gray-700">Department:</span>
                            <span class="text-gray-600">{{ $employee->department }}</span>
                        </div>

                        <div>
                            <span class="font-semibold text-gray-700">Phone Number:</span>
                            <span class="text-gray-600">{{ $employee->phone_number }}</span>
                        </div>

                        <div>
                            <span class="font-semibold text-gray-700">Hire Date:</span>
                            <span class="text-gray-600">{{ $employee->hire_date }}</span>
                        </div>

                        <div>
                            <span class="font-semibold text-gray-700">Salary:</span>
                            <span class="text-gray-600">${{ number_format($employee->salary, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

