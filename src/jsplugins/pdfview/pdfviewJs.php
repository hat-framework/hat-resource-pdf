<?php

use classes\Classes\JsPlugin;
class pdfviewJs extends JsPlugin{
    
    static private $instance;
    public static function getInstanceOf($plugin){
        $class_name = __CLASS__;
        if (!isset(self::$instance)) self::$instance = new $class_name($plugin);
        return self::$instance;
    } 
    
    public function init(){
        $this->Html->LoadJs($this->url .'/pdfobject');
    }
    
    public function showPdf($file){
        echo "<object data='$file' type='application/pdf' width='100%' height='600px'>
 
            <p>It appears you don't have a PDF plugin for this browser.
            No biggie... you can <a href='$file'>click here to
            download the PDF file.</a></p>

          </object>";
    }
}