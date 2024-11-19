<?php

namespace App\Http\Controllers\Api;

use App\Models\Questions;
use App\Models\User_progress;
use App\Models\Levels;
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
            $data = Questions::where('id_level', $id)->with('level', 'sign')->get();
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
    public function create(Request $request, $id)
    {
        $user = auth()->user();
        $question = Questions::where('id', $id)->with('level', 'sign')->first();
        $level = $question->level->level_number;
        $answer = $request->input('answer');

        $levels = Levels::where('level_number', $level)->first();

        $userProgress = User_progress::firstOrNew(['id_user' => $user->id, 'id_level' => $question->id_level]);
        $userScores = User_scores::firstOrNew(['id_user' => $user->id, 'id_level' => $question->id_level]);

        if ($question->correct_option == $answer) {
            $userProgress->attempts = 1;
            $userScores->score = min($userScores->score + 10, $levels->target_score);
            $userScores->completed_at = now();
            $userScores->save();
            $userProgress->save();
            if ($levels->target_score <= $userScores->score) {
                $newLevel = Levels::where('level_number', $level + 1)->first();
                if ($newLevel) {
                    $userProgress->id_user = $user->id;
                    $userProgress->id_level = $newLevel->id;
                    $userProgress->attempts = $userProgress->attempts++;
                    $userProgress->save();
                    User_scores::firstOrCreate(['id_user' => $user->id, 'id_level' => $newLevel->id], [
                        'score' => 0,
                        'completed_at' => now(),
                    ]);
                }
            }
            return response()->json(['message' => 'Benar']);
        } else {
            $userScores->completed_at = now();
            $userScores->save();
            return response()->json(['message' => 'Salah']);
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
