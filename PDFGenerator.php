<?php namespace Libraries;

class PDFGenerator {

	public static function generate($html, $fileName = 'boleto.pdf')
	{
		/// works, but has a lot of problems with some htmls
		// return \PDF::loadHTML($html)
		// 		->setPaper('A4')
		// 		->setOrientation('portrait')
		// 		->setWarnings(false)
		// 		->download($fileName);

		$mpdf = new \mPDF(); 

		$mpdf->WriteHTML($html);

		// $mpdf->Output();

		echo "aaa";
		die;
	}

}