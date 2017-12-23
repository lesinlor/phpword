<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExportController extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    /**
     * image size 413*585
     */
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

    public function table(){
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        $tableStyle = array(
            'borderColor' => '55A457',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );
        $firstRowStyle = array('bgColor' => 'CDFECE');
        $phpWord->addTableStyle('myTable', $tableStyle, $firstRowStyle);
        $header = array('size' => 16, 'bold' => true, 'color'=> '55A457');
        $section->addText('业绩一览表（248个）', $header,array('alignment'=>'center'));
        $section->addText('');
        $section->addText('');
        $table = $section->addTable('myTable');
        $table->addRow();
        for($c = 1; $c<=7; $c++){
            $table->addCell(1750)->addText("测试");
        }
        for ($r = 1; $r <= 8; $r++) {
            $table->addRow();
            for ($c = 1; $c <= 7; $c++) {
                $table->addCell(1750)->addText("Row {$r}, Cell {$c}");
            }
        }
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('helloWorld.doc');
    }
}
