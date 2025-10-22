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
            // First, check the basic PDF structure with FPDI
            $pdf = new Fpdi();
            $pdf->setSourceFile($value->getRealPath());

            // Second, scan the raw content for malicious keywords
            $content = file_get_contents($value->getRealPath());
            $maliciousPatterns = [
                '/\/JavaScript\b/',
                '/\/JS\b/',
                '/\/OpenAction\b/',
                '/\/AA\b/',
                '/\/Launch\b/'
            ];

            foreach ($maliciousPatterns as $pattern) {
                if (preg_match($pattern, $content)) {
                    // Found a potentially malicious keyword, reject the file
                    return false;
                }
            }

            return true;
        } catch (\Exception $e) {
            // If FPDI fails, it's not a valid PDF
            return false;
        }
    }

    public function message()
    {
        return 'The :attribute must be a valid and secure PDF file. Files with scripts or potentially malicious content are not allowed.';
    }
}
