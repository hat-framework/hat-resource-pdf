<?php
/*
		 * Convert a doc/docx/odt file to PDF
		 * @param filePath string the path of the file to be converted.
		 * This path can be absolute or relative to the folder where this
		 * class is placed. Furthermore, the php/apache user MUST have permissions
		 * to read the file
		 * 
		 * @param outputPath string optional If not specified, the resulting
		 * file will be created in the same folder of the source file. The output
		 * path MUST have writing permission for the php/apache user
		 * ./input/teste.docx OR /var/www/input/teste.docx would work.
		 * 
		 * WARNING this function will NOT work if the LibreOffice GUI is opened!
		 */

class doc2pdfResource extends \classes\Interfaces\resource {
    
		static public function convert($filePath, $outputPath) {
			
			/* get the file name */
			$file = substr($filePath, strrpos($filePath,'/') + 1, strlen($filePath));
			$extension = substr($file, strrpos($file, '.') + 1, strlen($file));
			$fileName = substr($file, 0, strrpos($file, '.'));
			
			/* Execute the commad */
			copy($filePath, "./tmp/{$file}");
			$command = "export HOME=/tmp && libreoffice --headless -convert-to pdf {$file} --outdir {$outputPath}";
			exec($command, $out, $err);
			echo $err;
			/* test if it was successfull */
			if(file_exists("./output/{$fileName}.pdf"))
				return dirname(__FILE__)."/output/{$fileName}.pdf";
			else
				return FALSE;
			
			//mitah
			//andresaude@mitahtech.com
			
			
		}
		
}

/*
$documento = "processamento.pdf"; //ARQUIVO A SER PESQUISADO
$pdf = new PDF2Text();
$texto = $pdf->decodePDF($documento);
echo $texto;
 *
 */