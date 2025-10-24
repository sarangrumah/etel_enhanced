<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessFileUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $fileContent;
    protected $originalName;
    protected $id_izin;
    protected $id_maplist;
    protected $user_name;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($fileContent, $originalName, $id_izin, $id_maplist, $user_name)
    {
        $this->fileContent = $fileContent;
        $this->originalName = $originalName;
        $this->id_izin = $id_izin;
        $this->id_maplist = $id_maplist;
        $this->user_name = $user_name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $filename = "KOMINFO-" . time() . uniqid() . '.' . pathinfo($this->originalName, PATHINFO_EXTENSION);
        $storagePath = storage_path('app/public/file_syarat/' . $filename);

        // Move the file from the temporary location to the final destination
        \Illuminate\Support\Facades\Storage::disk('local')->put('public/file_syarat/' . $filename, $this->fileContent);

        $path = 'storage/file_syarat/' . $filename;

        \Illuminate\Support\Facades\DB::table('tb_trx_persyaratan')->insert([
            'id_trx_izin' => $this->id_izin,
            'id_map_listpersyaratan' => $this->id_maplist,
            'filled_document' => $path,
            'nama_file_asli' => $this->originalName,
            'created_by' => $this->user_name,
            'is_active' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
