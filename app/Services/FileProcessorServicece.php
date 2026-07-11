<?php

namespace App\Services;

use Spatie\PdfToText\Pdf;
use PhpOffice\PhpWord\IOFactory;

class FileProcessorService
{
    public function extractText($filePath, $extension)
    {
        $fullPath = storage_path('app/' . $filePath);

        if ($extension === 'pdf') {
            // تأكد من مسار أداة pdftotext على جهازك (مثلاً '/usr/bin/pdftotext')
            return (new Pdf('/usr/bin/pdftotext'))->setPdf($fullPath)->text();
        }

        if ($extension === 'docx') {
            $phpWord = IOFactory::load($fullPath);
            $text = '';
            foreach ($phpWord->getSections() as $section) {
                foreach ($section->getElements() as $element) {
                    if (method_exists($element, 'getText')) {
                        $text .= $element->getText() . "\n";
                    }
                }
            }
            return $text;
        }

        return null;
    }
}