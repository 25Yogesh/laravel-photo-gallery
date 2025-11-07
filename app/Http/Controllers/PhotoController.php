<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PhotoController extends Controller
{
    use AuthorizesRequests;
    // only authenticated users
    public function __construct()
    {
        // $this->middleware('auth');
    }

    // show gallery for logged-in user only
    public function index()
    {
        $user = Auth::user();
        // load photos in created order
        $photos = $user->photos()->get();
        // echo "<pre>";print_r($photos->toArray());
        // echo "</pre>";
        return view('gallery.index', compact('photos'));
    }

    // store uploaded photo
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'view_type' => ['required', 'in:vertical,horizontal'],
            'image' => ['required', 'image', 'max:5120'], // max 5MB
        ]);

        // $file = $request->file('image');
        // $path = $file->store('public/photos');
        $path = $request->file('image')->store('photos', 'public');

        // convert to public/storage path reference
        $publicPath = str_replace('public/', '', $path);

        $photo = Photo::create([
            'user_id' => Auth::id(),
            'name' => $request->input('name'),
            'view_type' => $request->input('view_type'),
            'path' => $publicPath,
        ]);

        return redirect()->route('gallery.index')->with('success', 'Photo uploaded.');
    }

    // optional delete

    public function destroy(Photo $photo)
    {
        if ($photo->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        Storage::disk('public')->delete($photo->path);
        $photo->delete();

        return back()->with('success', 'Photo deleted.');
    }
}
