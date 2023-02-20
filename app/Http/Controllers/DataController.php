<?php

namespace App\Http\Controllers;

use App\Models\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DataController extends Controller
{
    public function saveData(Request $request)
    {
        $data = $request->input('data');
        $model = new Data();
        $model->data = json_encode($data);
        $model->save();

        return response()->json([
            'id' => $model->id,
            'time' => $model->created_at,
            'memory' => memory_get_peak_usage(),
        ]);
    }
}
