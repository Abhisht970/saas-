@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-2xl font-bold text-gray-800">Sales Overview</h3>
            <p class="text-sm text-gray-500">Last 6 months performance</p>
        </div>
        <span class="px-3 py-1 text-sm font-medium text-green-700 bg-green-100 rounded-full">
            +18% vs last period
        </span>
    </div>

    {{-- Chart Card --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">

        <div class="flex items-end justify-between gap-4 h-64 border-b border-gray-200 pb-2">

            {{-- Bar --}}
            <div class="group flex-1 flex flex-col items-center justify-end h-full">
                <span class="mb-1 text-xs font-semibold text-gray-700 opacity-0 group-hover:opacity-100 transition">₹45K</span>
                <div class="w-full h-[45%] bg-indigo-400 group-hover:bg-indigo-600 rounded-t-md transition"></div>
            </div>

            <div class="group flex-1 flex flex-col items-center justify-end h-full">
                <span class="mb-1 text-xs font-semibold text-gray-700 opacity-0 group-hover:opacity-100 transition">₹60K</span>
                <div class="w-full h-[60%] bg-indigo-400 group-hover:bg-indigo-600 rounded-t-md transition"></div>
            </div>

            <div class="group flex-1 flex flex-col items-center justify-end h-full">
                <span class="mb-1 text-xs font-semibold text-gray-700 opacity-0 group-hover:opacity-100 transition">₹52K</span>
                <div class="w-full h-[52%] bg-indigo-400 group-hover:bg-indigo-600 rounded-t-md transition"></div>
            </div>

            <div class="group flex-1 flex flex-col items-center justify-end h-full">
                <span class="mb-1 text-xs font-semibold text-gray-700 opacity-0 group-hover:opacity-100 transition">₹78K</span>
                <div class="w-full h-[78%] bg-indigo-400 group-hover:bg-indigo-600 rounded-t-md transition"></div>
            </div>

            <div class="group flex-1 flex flex-col items-center justify-end h-full">
                <span class="mb-1 text-xs font-semibold text-gray-700 opacity-0 group-hover:opacity-100 transition">₹70K</span>
                <div class="w-full h-[70%] bg-indigo-400 group-hover:bg-indigo-600 rounded-t-md transition"></div>
            </div>

            <div class="group flex-1 flex flex-col items-center justify-end h-full">
                <span class="mb-1 text-xs font-semibold text-gray-700 opacity-0 group-hover:opacity-100 transition">₹95K</span>
                <div class="w-full h-[95%] bg-indigo-600 group-hover:bg-indigo-700 rounded-t-md transition"></div>
            </div>

        </div>

        {{-- Month labels --}}
        <div class="flex justify-between gap-4 mt-2 text-xs text-center text-gray-500">
            <span class="flex-1">Apr</span>
            <span class="flex-1">May</span>
            <span class="flex-1">Jun</span>
            <span class="flex-1">Jul</span>
            <span class="flex-1">Aug</span>
            <span class="flex-1">Sep</span>
        </div>

        {{-- Legend --}}
        <div class="flex items-center gap-2 mt-4 text-sm text-gray-600">
            <span class="w-3 h-3 bg-indigo-500 rounded-sm"></span> Monthly Sales (₹)
        </div>
    </div>
</div>
@endsection