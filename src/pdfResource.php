<?php

class pdfResource extends \classes\Interfaces\resource{
    
    /**
    * @uses Contém a instância do banco de dados
    */
    private static $instance = NULL;
    
    /**
    * Construtor da classe
    * @uses Carregar os arquivos necessários para o funcionamento do recurso
    * @throws DBException
    * @return retorna um objeto com a instância do banco de dados
    */
    public function __construct() {
        $this->dir = dirname(__FILE__);
        return $this->load();
    }
    
    /**
    * retorna a instância do banco de dados
    * @uses Faz a chamada do contrutor
    * @throws DBException
    * @return retorna um objeto com a instância do banco de dados
    */
    public static function getInstanceOf(){
        
        $class_name = __CLASS__;
        if (!isset(self::$instance)) {
            self::$instance = new $class_name;
        }

        return self::$instance;
    }
    
    
   /**
    * @abstract Loader da classe
    * @uses Carregar os arquivos necessários para o funcionamento do recurso
    */
    public function load(){
        
        $this->LoadResourceFile("classes/config.php"); 
        $class = pdf_gerador_default . "Gerador";
        $this->LoadResourceFile("lib/geradores/$class.php");
        $this->pdf = call_user_func("$class::getInstanceOf");
    }
    
   /**
    * @abstract gera o pdf
    */
    public function pdf_create($html, $filename, $stream = TRUE, $orientation = 'portrait'){
        
        $this->pdf->pdf_create($html, $filename, $stream, $orientation);
        
    }
    
    public function setPropriety($propriety, $value){
        $this->pdf->setPropriety($propriety, $value);
        return $this;
    }
    
    public function save($html, $filename, $dir=""){
        
        $this->pdf->pdfSaveToServer($html, $filename, $dir);
        
    }
    
}