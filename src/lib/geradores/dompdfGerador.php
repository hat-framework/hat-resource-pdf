<?php

use classes\Classes\Object;
class dompdfGerador extends classes\Classes\Object {
    
    public function __construct(){
        define('DOMPDF_ENABLE_AUTOLOAD'      , false);
        define('DOMPDF_UNICODE_ENABLED'      , true);
        define('DOMPDF_ENABLE_PHP'           , true);
        define('DOMPDF_ENABLE_REMOTE'        , true);
        define('DOMPDF_ENABLE_CSS_FLOAT'     , true);
        define('DOMPDF_ENABLE_JAVASCRIPT'    , true);
        define('DOMPDF_ENABLE_HTML5PARSER'   , true);
        define('DOMPDF_ENABLE_FONTSUBSETTING', true);
        set_time_limit(0);
        ini_set('memory_limit','512M');
        require_once BASE_DIR.'/vendor/dompdf/dompdf/dompdf_config.inc.php';
    	$this->dompdf = new DOMPDF();
    }
    
    static private $instance;
    public static function getInstanceOf(){

        $class_name = __CLASS__;
        if (!isset(self::$instance)) {
            self::$instance = new $class_name;
        }

        return self::$instance;
    }
    
    public function pdf_create($html, $filename, $stream=TRUE, $orientation = 'portrait')
    {
        $this->dompdf->load_html($html);
        $this->dompdf->set_paper('letter', $orientation);
        $this->dompdf->render();
        if ($stream) {
            $this->dompdf->stream($filename.".pdf");
        } else {
            $CI =& get_instance();
            $CI->load->helper('file');
            write_file("./temp/pdf_$filename.pdf", $this->dompdf->output());
        }
    }
    
    private $propriety = array();
    public function setPropriety($propriety, $value){
        if(!method_exists($this->dompdf, $propriety)){return;}
        $this->propriety[$propriety] = $value;
    }
    
    public function pdfSaveToServer($html, $filename, $dir="", $orientation = 'portrait'){
        
        $this->dompdf->load_html($html);
        $this->dompdf->set_paper('letter', $orientation);
        foreach($this->propriety as $name => $value){
            if(!method_exists($this->dompdf, $name)){continue;}
            $this->dompdf->$name($customPaper);
        }
        $this->dompdf->render();
        
    	//configs do seu DOMPDF….
        $pdfoutput = $this->dompdf->output();
        $file      = "$dir/$filename";
        $this->LoadResource('files/dir', 'dobj')->create($dir, "");
        
        $f         = str_replace(".pdf.pdf", '.pdf', "$file.pdf");
        $fp        = fopen($f, "a");
        if(false === $fp){
            die("erro");
        }
        fwrite($fp, $pdfoutput);
        fclose($fp);
    }
    
}