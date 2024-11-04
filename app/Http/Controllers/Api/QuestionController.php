<?php

namespace App\Http\Controllers\Api;

use App\Models\Questions;
use App\Models\User_progress;
use App\Models\User_scores;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Resources\DataResource;
use Symfony\Component\Console\Question\Question;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
         try {
            $data = Questions::where('id_level', $id)->get();
            return new DataResource(true, 'List Data Questions', $data);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function show($id)
    {
         try {
            $data = Questions::where('id', $id)->with('level', 'sign')->first();
            return new DataResource(true, 'List Detail Questions', $data);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request,$id)
    {
        $user = auth()->user();
        $question = Questions::where('id', $id)->with('level', 'sign')->first();
        $level = $question->level->level_number;
        $answer = $request->input('answer');

        $userProgress = User_progress::firstOrNew(['user_id' => $user->id, 'id_level' => $question->id_level]);
        $userScores = User_scores::firstOrNew(['user_id' => $user->id, 'id_level' => $question->id_level]);

        if ($question->correct_option == $answer) {
            $userProgress->increment('progress', 1);
            $userScores->increment('score', 100);
            $userScores->save();
            $userProgress->save();
            return response()->json(['message' => 'Benar, point Anda bertambah 1']);
        } else {
            $userScores->decrement('score', 100);
            $userScores->save();
            return response()->json(['message' => 'Salah, point Anda berkurang 1']);
        }

        if ($level == 4) {
            $result = $question;
            if ($result->correct_option == $answer) {
                $user_point += 100;
                $user->point = $user_point;
                $user->save();
                return response()->json(['message' => 'Benar, point Anda bertambah 1']);
            } else {
                $user_point -= 100;
                $user->point = $user_point;
                $user->save();
                return response()->json(['message' => 'Salah, point Anda berkurang 1']);
            }
        } else {
            return response()->json(['message' => 'Level tidak sesuai']);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */


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
