<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\vw_exp_dataResponSurvei;
use App\Exports\vw_exp_dataResponSummary;
use App\Exports\vw_exp_alokasipenomoran;
use App\Exports\vw_exp_penomoran_req;
use App\Exports\vw_exp_penomoran_tetap;
use App\Exports\vw_survei_summary;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class GenerateExcelReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $reportType;
    protected $userId;
    protected $parameters;
    protected $filename;

    /**
     * Create a new job instance.
     */
    public function __construct($reportType, $userId, $parameters = [], $filename = null)
    {
        $this->reportType = $reportType;
        $this->userId = $userId;
        $this->parameters = $parameters;
        $this->filename = $filename ?? $this->generateFilename();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $filePath = "exports/{$this->filename}";

            switch ($this->reportType) {
                case 'data_respond_survei':
                    Excel::store(new vw_exp_dataResponSurvei, $filePath);
                    break;

                case 'data_respond_summary':
                    Excel::store(new vw_exp_dataResponSummary, $filePath);
                    break;

                case 'data_alokasi_penomoran':
                    Excel::store(new vw_exp_alokasipenomoran, $filePath);
                    break;

                case 'req_penomoran':
                    Excel::store(new vw_exp_penomoran_req, $filePath);
                    break;

                case 'tetap_penomoran':
                    Excel::store(new vw_exp_penomoran_tetap, $filePath);
                    break;

                case 'all_summary':
                    $results = DB::select('CALL prd_summary(?, ?, ?)', [
                        $this->parameters['period_year'],
                        $this->parameters['period_month'],
                        $this->parameters['type']
                    ]);

                    if (!empty($results)) {
                        $headers = array_keys((array)$results[0]);
                        array_unshift($results, $headers);
                    }

                    Excel::store(new vw_survei_summary($results, $headers), $filePath);
                    break;

                case 'all_quest_active':
                    $results = DB::select('SELECT * FROM vw_survei_active_quest');

                    if (!empty($results)) {
                        $headers = array_keys((array)$results[0]);
                        array_unshift($results, $headers);
                    }

                    Excel::store(new vw_survei_summary($results, $headers), $filePath);
                    break;

                default:
                    throw new \Exception("Unknown report type: {$this->reportType}");
            }

            // Log successful generation
            Log::info("Excel report generated successfully", [
                'report_type' => $this->reportType,
                'user_id' => $this->userId,
                'filename' => $this->filename
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to generate Excel report", [
                'report_type' => $this->reportType,
                'user_id' => $this->userId,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Generate a unique filename for the report
     */
    protected function generateFilename(): string
    {
        $timestamp = now()->format('Y-m-d_H-i-s');
        return "{$this->reportType}_{$timestamp}.xlsx";
    }

    /**
     * Get the filename for the generated report
     */
    public function getFilename(): string
    {
        return $this->filename;
    }
}
