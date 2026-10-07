<?php

namespace App\Http\Controllers;

use App\Models\DynamicObject;
use Illuminate\Http\Request;
use App\Models\DynamicRecord;

class DynamicRecordController extends Controller
{

    public function index($objectKey)
    {
        $dynamicObject = DynamicObject::where('key', $objectKey)
            ->where('is_active', true)
            ->firstOrFail();

        $fields = $dynamicObject->listFields()
            ->orderBy('sort_order')
            ->get();

        $records = DynamicRecord::where('object_id', $dynamicObject->id)
            ->latest('id')
            ->paginate(20);

        return view('dynamic-records.index', compact(
            'dynamicObject',
            'fields',
            'records'
        ));
    }
    public function create($objectKey)
    {
        $dynamicObject = DynamicObject::query()
            ->where('key', $objectKey)
            ->where('is_active', true)
            ->firstOrFail();

        $fields = $dynamicObject->activeFields()
            ->orderBy('sort_order')
            ->get();

        return view('dynamic-records.create', compact(
            'dynamicObject',
            'fields'
        ));
    }

    public function store(Request $request, $objectKey)
    {
        $dynamicObject = DynamicObject::where('key', $objectKey)
            ->where('is_active', true)
            ->firstOrFail();

        $fields = $dynamicObject->activeFields()
            ->orderBy('sort_order')
            ->get();

        $data = [];

        foreach ($fields as $field) {
            $data[$field->key] = $request->input($field->key);
        }

        $record = DynamicRecord::create([
            'object_id' => $dynamicObject->id,
            'record_name' => $data['title'] ?? null,
            'data' => $data,
            'owner_id' => auth()->id(),
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        return redirect()
            ->route('dynamic-records.index', $dynamicObject->key)
            ->with('success', $dynamicObject->name . ' created successfully.');
    }

    public function show($objectKey, $record)
    {
        $dynamicObject = DynamicObject::where('key', $objectKey)
            ->where('is_active', true)
            ->firstOrFail();

        $record = DynamicRecord::where('object_id', $dynamicObject->id)
            ->findOrFail($record);

        $fields = $dynamicObject->activeFields()
            ->orderBy('sort_order')
            ->get();

        return view('dynamic-records.show', compact(
            'dynamicObject',
            'record',
            'fields'
        ));
    }
}