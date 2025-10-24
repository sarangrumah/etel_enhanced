<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Helpers\EmailHelper;

class SendEmailNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $penanggungjawab;
    protected $email_jenis;
    protected $izins;
    protected $departemen;
    protected $catatan_hasil_evaluasi;
    protected $nama2;
    protected $nibs;
    protected $koreksi_all;
    protected $user;
    protected $jabatan;

    public function __construct($penanggungjawab, $email_jenis, $izins, $departemen, $catatan_hasil_evaluasi, $nama2, $nibs, $koreksi_all, $user = null, $jabatan = null)
    {
        $this->penanggungjawab = $penanggungjawab;
        $this->email_jenis = $email_jenis;
        $this->izins = $izins;
        $this->departemen = $departemen;
        $this->catatan_hasil_evaluasi = $catatan_hasil_evaluasi;
        $this->nama2 = $nama2;
        $this->nibs = $nibs;
        $this->koreksi_all = $koreksi_all;
        $this->user = $user;
        $this->jabatan = $jabatan;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new EmailHelper();
        if ($this->email_jenis === 'pemenuhan-syarat') {
            $email->kirim_email($this->penanggungjawab, $this->email_jenis, $this->izins, $this->departemen, $this->catatan_hasil_evaluasi, $this->nama2, $this->nibs, $this->koreksi_all);
        } elseif ($this->email_jenis === 'koordinator-syarat' && $this->user) {
            $email->kirim_email2($this->user, $this->email_jenis, $this->izins, $this->departemen, $this->catatan_hasil_evaluasi, $this->nama2, $this->nibs, $this->koreksi_all, $this->jabatan);
        }
    }
}
