<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Project;

class ImageController extends Controller
{

    public function getProjectImages($projectId)
    {
        $images = Image::where('project_id', $projectId)->get();

        return response()->json($images);
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('images'), $imageName);

        // Save the image path and name to the database
        $image = new Image();
        $image->project_id = $request->projectId;
        $image->image = 'images/'.$imageName;
        $image->save();

        return response()->json(['message' => 'Image uploaded successfully']);
    }
}
