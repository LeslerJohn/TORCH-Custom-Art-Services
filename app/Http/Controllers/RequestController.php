<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Request as ModelsRequest;
use App\Models\RequestImage;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requests = ModelsRequest::where('client_id', Auth::user()->id)->get();
        return view('client.request.index', compact('requests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Service $service)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'width' => 'required|integer|min:1',
            'height' => 'required|integer|min:1',
            'unit' => 'required|string|max:255',
            'deadline' => 'required|date',
            'references.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $modelrequest = ModelsRequest::create([
            'client_id' => Auth::user()->id,
            'total_price' => 0,
            'description' => $request->description,
            'width' => $request->width,
            'height' => $request->height,
            'unit' => $request->unit,
            'deadline' => $request->deadline,
            'service_id' => $service->id,
            'status' => 'pending',
        ]);

        if ($request->hasFile('references')) {
            foreach ($request->file('references') as $file) {
            $path = $file->store('references', 'public');

            $attachment = Attachment::create([
                'filename' => $file->getClientOriginalName(),
                'path' => $path,
                'mime_type' => $file->getMimeType(),
            ]);

            RequestImage::create([
                'request_id' => $modelrequest->id,
                'attachment_id' => $attachment->id,
            ]);
            }
        }

        return redirect()->route('client.request.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
