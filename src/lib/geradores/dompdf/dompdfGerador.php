<?php

use classes\Classes\Object;
class dompdfGerador extends classes\Classes\Object {
    
    public function __construct(){
    
    	require_once( dirname(__FILE__). "/files/dompdf_config.inc.php");
        set_time_limit(0);
        ini_set('memory_limit','512M');
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
    
    public function pdfSaveToServer($html, $filename, $dir="", $orientation = 'portrait'){
        
        $this->dompdf->load_html($html);
        $this->dompdf->set_paper('letter', $orientation);
        $this->dompdf->render();
        
    	//configs do seu DOMPDF….
		$pdfoutput = $this->dompdf->output();
		$filename = DIR_DEFAULT_UPLOAD."/dompdf/$dir/$filename.pdf";
		$fp = fopen($filename, "a");
		fwrite($fp, $pdfoutput);
		fclose($fp);
    }
    
}

?>
