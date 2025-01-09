<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class ProjectController extends Controller
{

    public function index(Request $request)
    {
            $token = $request->bearerToken();
        if (!$token) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('remember_token', $token)->first();
        if (!$user) {
            return response()->json(['message' => 'Invalid token'], 401);
        }

        $projects = Project::where('user_id', $user->id)->get();
        return response()->json($projects);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'description' => 'required|string',
            ]);

            // Verify the token and authenticate the user
            $token = $request->bearerToken();
            if (!$token) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            // Validate the token
            $user = User::where('remember_token', $token)->first();
            if (!$user) {
                return response()->json(['message' => 'Invalid token'], 401);
            }

            // Create a new project
            $project = new Project();
            $project->name = $request->input('name');
            $project->description = $request->input('description');
            $project->user_id = $user->id;

            // Save the project
            $project->save();

            return response()->json(['message' => 'Project created successfully!']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Error creating project'], 500);
        }
    }

    public function destroy($id)
    {
        $project = Project::find($id);
        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }
        $project->delete();
        return response()->json(['message' => 'Project deleted successfully']);
    }
}
