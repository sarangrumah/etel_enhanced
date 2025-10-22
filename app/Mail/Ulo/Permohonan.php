<?php

namespace App\Mail\Ulo;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class Permohonan extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('ulo@kominfo.co.id')->subject('Permohonan Uji Laik Operasi')->view('layouts.frontend.email_ulo.permohonan_diterima')->with('data', $this->data);
    }
}
