<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Concordat;


class ExportController extends Controller
{
    protected $fileHandler = null;

    protected $directory = null;

    protected $files = [];

    protected $unExportedFields = [
        'created_at','updated_at','created_user_id','updated_user_id'
    ];

    protected $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);
    protected $cellVCentered = array('valign' => 'center');

    function __construct()
    {
        parent::__construct();
    }

    function __destruct()
    {
        if($this->fileHandler)
            closedir($this->fileHandler);
    }

    /**
     * 返回合同表所有字段及字段相关配置
     */
    public function column(){
        $columns = $this->getColumn();
        if($columns)
            parent::success($columns);
        parent::fail($this->errorCode['noContent'],'暂无相关数据');
    }

    /**
     * image size 413*585
     */
    public function export(){
        $validator = Validator::make($request->all(),[
            'id' =>  'required',
            'field' => 'required|string'
        ]);
        if($validator->fails()){
            parent::fail($this->errorCode['paramError'], '参数错误');
        }
        $fields = explode(',',parent::rq('field'));
        $field = [];
        $column = $this->getColumn();
        foreach ($fields as $item){
            if(array_key_exists($item, $column)){
                $field[] = $item;
            }
        }
        $ids = explode(',', parent::rq('id'));
        $param = [];
        foreach ($ids as $id){
            if(is_numeric($id)){
                $param[] = (int)$id;
            }
        }
        if($param) {
            $phpWord = new \PhpOffice\PhpWord\PhpWord();
            $concrodats = new Concordat();
            $data = $concrodats->whereIn('id', $param)->get($field);
            $section = $phpWord->addSection();
            $tableStyle = array(
                'borderColor' => '55A457',
                'borderSize' => 6,
                'cellMargin' => 50,
            );
            $firstRowStyle = array('bgColor' => 'CDFECE', 'bold' => true);
            $phpWord->addTableStyle('myTable', $tableStyle, $firstRowStyle);
            $header = array('size' => 16, 'bold' => true, 'color' => '55A457');
            $section->addText('业绩一览表（' . (int)count($ids) . '）', $header, array('alignment' => 'center'));
            $section->addText('');
            $section->addText('');
            $table = $section->addTable('myTable');
            $table->addRow();
            /*****************获取表头*****************/
            foreach ($field as $item) {
                $table->addCell(1750)->addText($column[$item]);
            }
            /***************获取表头结束***************/
            foreach ($data as $item) {
                $tmpData = $item->toArray();
                $table->addRow();
                foreach ($tmpData as $v) {
                    $table->addCell(1750)->addText($v, $this->cellHCentered);
                }
            }
        }
    }

    /**
     * 导出表格
     * @param Request $request
     * @throws \PhpOffice\PhpWord\Exception\Exception
     */
    public function table(Request $request){
        $validator = Validator::make($request->all(),[
            'id' =>  'required',
            'field' => 'required|string'
        ]);
        if($validator->fails()){
            parent::fail($this->errorCode['paramError'], '参数错误');
        }
        $fields = explode(',',parent::rq('field'));
        $field = [];
        $column = $this->getColumn();
        foreach ($fields as $item){
            if(array_key_exists($item, $column)){
                $field[] = $item;
            }
        }
        $ids = explode(',', parent::rq('id'));
        $param = [];
        foreach ($ids as $id){
            if(is_numeric($id)){
                $param[] = (int)$id;
            }
        }
        if($param){
            $phpWord = new \PhpOffice\PhpWord\PhpWord();
            $concrodats = new Concordat();
            $data = $concrodats->whereIn('id',$param)->get($field);
            $section = $phpWord->addSection();
            $tableStyle = array(
                'borderColor' => '55A457',
                'borderSize'  => 6,
                'cellMargin'  => 50,
            );
            $firstRowStyle = array('bgColor' => 'CDFECE','bold'=>true);
            $phpWord->addTableStyle('myTable', $tableStyle, $firstRowStyle);
            $header = array('size' => 16, 'bold' => true, 'color'=> '55A457');
            $section->addText('业绩一览表（'.(int)count($ids).'）', $header,array('alignment'=>'center'));
            $section->addText('');
            $section->addText('');
            $table = $section->addTable('myTable');
            $table->addRow();
            /*****************获取表头*****************/
            foreach ($field as $item){
                $table->addCell(1750)->addText($column[$item]);
            }
            /***************获取表头结束***************/
            foreach ($data as $item){
                $tmpData = $item->toArray();
                $table->addRow();
                foreach ($tmpData as $v){
                    $table->addCell(1750)->addText($v,$this->cellHCentered);
                }
            }
            /***********写入图片*******/
            $concordat = new \App\ConcordatImg();
            $imgs = $concordat
                ->whereIn('concordat_id',$param)
                ->orderBy('concordat_id','desc')
                ->orderBy('sort', 'asc')
                ->get(['directory','path']);
            if($imgs) {
                $imgConfig = array(
                    'positioning' => 'relative',
                    'marginTop' => 20,
                    'marginLeft' => 20,
                    'width' => 413,
                    'height' => 585,
                    'alignment' => 'both'
                );
                foreach ($imgs as $img) {
                    if ($this->fileIsExists($img->directory, $img->path)) {
                        $path = public_path() . '/contract/' . $img->directory . '/' . $img->path;
                        $section = $phpWord->addSection();
                        $section->addImage($path, $imgConfig);
                    }
                }
            }
            $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
            $objWriter->save('helloWorld.doc');
        }
    }

    /**
     * @param Request $request
     * @throws \PhpOffice\PhpWord\Exception\Exception
     */
    public function pic(Request $request){
        $validator = Validator::make($request->all(),[
            'id' => 'required|string'
        ]);
        if($validator->fails()){
            parent::fail($this->errorCode['paramError'], '参数错误');
        }
        $concordat = new \App\ConcordatImg();
        $ids = explode(',', parent::rq('id'));
        $param = [];
        foreach ($ids as $id){
            if(is_numeric($id)){
                $param[] = (int)$id;
            }
        }
        if($param){
            $imgs = $concordat
                ->whereIn('concordat_id',$param)
                ->orderBy('concordat_id','desc')
                ->orderBy('sort', 'asc')
                ->get(['directory','path']);
//            dd($imgs->toArray());
            if($imgs){
                $phpWord = new \PhpOffice\PhpWord\PhpWord();
                $imgConfig = array(
                    'positioning'   => 'relative',
                    'marginTop'     => 20,
                    'marginLeft'    => 20,
                    'width'         => 413,
                    'height'        => 585,
                    'alignment'     => 'both'
                );
                foreach ($imgs as $img){
                    if($this->fileIsExists($img->directory,$img->path)){
                        $path = public_path(). '/contract/'. $img->directory.'/'.$img->path;
                        $section = $phpWord->addSection();
                        $section->addImage($path,$imgConfig);
                    }
                }
                $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
                $objWriter->save('test.doc');
            }
        }
    }


    /**
     * 获取文件下的所有文件
     * @param $directory
     * @return array
     */
    private function listFiles($directory){
        $files = [];
        $handler = opendir($directory);
        while (($filename = readdir($handler)) !== false) {//务必使用!==，防止目录下出现类似文件名“0”等情况
            if ($filename != "." && $filename != "..") {
                $files[] = $filename ;
            }
        }
        closedir($handler);
        return $files;
    }

    /**
     * 检查文件是否存在
     * @param $directory
     * @param $file
     * @return bool
     */
    private function fileIsExists($directory, $file){
        //防止同一个操作中多次实例化handler
        if(!$this->directory || $directory != $this->directory){
            $this->fileHandler = opendir(public_path().'/contract/'.$directory);
            $this->directory = $directory;
            while (($filename = readdir($this->fileHandler)) !== false){
                if ($filename != "." && $filename != "..") {
                    $this->files[] = $filename ;
                }
            }
        }
        return in_array($file, $this->files);
    }

    /**
     * 获取所有表结构
     * @return array
     */
    private function getColumn(){
        $columns = [];
        $data = \Illuminate\Support\Facades\DB::select('show full fields from concordats');
        if($data){
            foreach ($data as $item){
                if(!in_array($item->Field,$this->unExportedFields)){
                    $columns[$item->Field] = $item->Comment;
                }
            }
        }
        return $columns;
    }
}
