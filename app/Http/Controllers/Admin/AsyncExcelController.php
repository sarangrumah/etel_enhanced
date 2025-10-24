<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Jobs\GenerateExcelReport;

class AsyncExcelController
{
    /**
     * Generate data respond survei report asynchronously
     */
    public function data_respond_survei_async(Request $request)
    {
        $userId = Auth::id();
        GenerateExcelReport::dispatch('data_respond_survei', $userId);

        return response()->json([
            'message' => 'Report generation started in background',
            'status' => 'queued'
        ]);
    }

    /**
     * Generate data respond summary report asynchronously
     */
    public function data_respond_summary_async(Request $request)
    {
        $userId = Auth::id();
        GenerateExcelReport::dispatch('data_respond_summary', $userId);

        return response()->json([
            'message' => 'Report generation started in background',
            'status' => 'queued'
        ]);
    }

    /**
     * Generate data alokasi penomoran report asynchronously
     */
    public function data_alokasi_penomoran_async(Request $request)
    {
        $userId = Auth::id();
        GenerateExcelReport::dispatch('data_alokasi_penomoran', $userId);

        return response()->json([
            'message' => 'Report generation started in background',
            'status' => 'queued'
        ]);
    }

    /**
     * Generate req penomoran report asynchronously
     */
    public function req_penomoran_async(Request $request)
    {
        $userId = Auth::id();
        GenerateExcelReport::dispatch('req_penomoran', $userId);

        return response()->json([
            'message' => 'Report generation started in background',
            'status' => 'queued'
        ]);
    }

    /**
     * Generate tetap penomoran report asynchronously
     */
    public function tetap_penomoran_async(Request $request)
    {
        $userId = Auth::id();
        GenerateExcelReport::dispatch('tetap_penomoran', $userId);

        return response()->json([
            'message' => 'Report generation started in background',
            'status' => 'queued'
        ]);
    }

    /**
     * Generate all summary report asynchronously
     */
    public function all_summary_async(Request $request)
    {
        $userId = Auth::id();
        $parameters = [
            'period_year' => $request->input('period_year', date('Y')),
            'period_month' => $request->input('period_month', date('m')),
            'type' => $request->input('type', 'monthly')
        ];

        GenerateExcelReport::dispatch('all_summary', $userId, $parameters);

        return response()->json([
            'message' => 'Report generation started in background',
            'status' => 'queued'
        ]);
    }

    /**
     * Generate all quest active report asynchronously
     */
    public function all_quest_active_async(Request $request)
    {
        $userId = Auth::id();
        GenerateExcelReport::dispatch('all_quest_active', $userId);

        return response()->json([
            'message' => 'Report generation started in background',
            'status' => 'queued'
        ]);
    }

    /**
     * Check report generation status
     */
    public function reportStatus($jobId)
    {
        // In a real implementation, you would check the job status from the queue
        // For now, we'll return a simple status
        return response()->json([
            'job_id' => $jobId,
            'status' => 'processing', // This would be dynamic based on actual job status
            'message' => 'Report is being generated in the background'
        ]);
    }
}
