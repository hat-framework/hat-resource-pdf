<?php

interface Gerador{
	public function pdf_create($html, $filename, $stream, $orientation);
	
	public function pdfSaveToServer($html, $filename, $dir);
}

?>
