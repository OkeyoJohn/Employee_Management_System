<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
<div>
    

    <div class="min-h-screen bg-slate-100 py-10">

        <div class="max-w-5xl mx-auto px-6">

            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-slate-800">
                    Add Employee Profile
                </h1>

                <p class="text-slate-500 mt-2">
                    Create and manage employee information
                </p>
            </div>

            <!-- Validation Errors -->
            @if ($errors->any())

                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-6">

                    <ul class="list-disc list-inside">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <!-- Form Card -->
            <div class="bg-white shadow-xl rounded-3xl p-8">

                <form 
                    action="/" 
                    method="POST"
                    enctype="multipart/form-data"
                    class="space-y-8"
                >

                    @csrf

                    <!-- Profile Upload -->
                    <div>

                        <label class="block text-sm font-semibold text-slate-700 mb-3">
                            Employee Profile Image
                        </label>

                        <div class="border-2 border-dashed border-slate-300 rounded-2xl p-8 text-center hover:border-blue-500 transition">

                            <input 
                                type="file"
                                name="image"
                                id="image"
                                accept="image/*"
                                class="block w-full text-sm text-slate-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-lg file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100"
                            >

                            <p class="text-slate-400 text-sm mt-3">
                                PNG, JPG, JPEG up to 2MB
                            </p>

                        </div>

                    </div>

                    <!-- Form Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- First Name -->
                        <div>

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                First Name
                            </label>

                            <input
                                type="text"
                                name="first_name"
                                value="{{ old('first_name') }}"
                                placeholder="John"
                                class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                            >

                        </div>

                        <!-- Last Name -->
                        <div>

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Last Name
                            </label>

                            <input
                                type="text"
                                name="last_name"
                                value="{{ old('last_name') }}"
                                placeholder="Doe"
                                class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                            >

                        </div>

                        <!-- Email -->
                        <div>

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Email Address
                            </label>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="john@example.com"
                                class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                            >

                        </div>

                        <!-- Phone -->
                        <div>

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Phone Number
                            </label>

                            <input
                                type="text"
                                name="phone_number"
                                value="{{ old('phone_number') }}"
                                placeholder="+254700000000"
                                class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                            >

                        </div>

                        <!-- Position -->
                        <div>

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Position
                            </label>

                            <input
                                type="text"
                                name="position"
                                value="{{ old('position') }}"
                                placeholder="Software Developer"
                                class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                            >

                        </div>

                        <!-- Department -->
                        <div>

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Department
                            </label>

                            <input
                                type="text"
                                name="department"
                                value="{{ old('department') }}"
                                placeholder="IT Department"
                                class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                            >

                        </div>

                        <!-- Salary -->
                        <div>

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Salary
                            </label>

                            <input
                                type="number"
                                name="salary"
                                value="{{ old('salary') }}"
                                placeholder="50000"
                                class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                            >

                        </div>

                        <!-- Hire Date -->
                        <div>

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Hire Date
                            </label>

                            <input
                                type="date"
                                name="hire_date"
                                value="{{ old('hire_date') }}"
                                class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                            >

                        </div>

                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">

                        <button
                            type="submit"
                            class="w-full md:w-auto px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition duration-300 shadow-lg"
                        >
                            Add Employee
                        </button>


                        @if(isset($latestEmployee))
                            <a
                                href="{{ route('employees.show', $latestEmployee) }}"
                                class="inline-flex items-center justify-center w-full md:w-auto px-8 py-3 bg-gray-800 hover:bg-gray-900 text-white font-semibold rounded-xl transition duration-300 shadow-lg ml-4"
                            >
                                Show Latest Employee Details
                            </a>
                        @else
                            <button
                                type="button"
                                disabled
                                class="inline-flex items-center justify-center w-full md:w-auto px-8 py-3 bg-gray-300 text-gray-600 font-semibold rounded-xl shadow-lg ml-4 cursor-not-allowed"
                            >
                                No Employee Yet
                            </button>
                        @endif

                    </div>

                </form>

            </div>

        </div>

    </div>


</div>
 
</x-app-layout>
