<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Levels;
use App\Http\Resources\DataResource;

class LevelController extends Controller
{
    public function index()
    {
        try {
            $data = Levels::all();
            return new DataResource(true, 'List Data Levels', $data);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
