<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExportController extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function export(){
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
// Adding Text element to the Section having font styled by default...
        $section->addText(
            '"Learn from yesterday, live for today, hope for tomorrow. '
            . 'The important thing is not to stop questioning." '
            . '(Albert Einstein)'
        );
        $section->addImage('http://upload-images.jianshu.io/upload_images/270478-a18f5a82fc144dd0.jpg?imageMogr2/auto-orient/strip%7CimageView2/2/w/600');
        // Saving the document as OOXML file...
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('helloWorld.doc');
    }
}
