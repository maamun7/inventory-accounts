<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	 function create_pdf_cv($htmView,$fileName) {
		$CI =& get_instance();
		$pdfName = $fileName;
		$pdfData = pdf_create($htmView, $pdfName);

		write_file('Progress Repost', $pdfData);   
	}
