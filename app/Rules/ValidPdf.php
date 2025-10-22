<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use setasign\Fpdi\Fpdi;

class ValidPdf implements Rule
{
    public function passes($attribute, $value)
    {
        if ($value->getClientOriginalExtension() !== 'pdf') {
            return false;
        }

        try {
            $pdf = new Fpdi();
            $pdf->setSourceFile($value->getRealPath());
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function message()
    {
        return 'The :attribute must be a valid PDF file.';
    }
}
