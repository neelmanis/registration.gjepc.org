<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'modules/generic/controllers/Generic.php';

require FCPATH . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * 	Author : Amit Kashte
 */

class Excel extends Generic{
	function __construct() {
		parent::__construct();
		$this->load->model('Mdl_excel');
	}
	
	/**
	 * 	Institution
	 */
	function institution(){

		// Create new Spreadsheet object
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		// Set document properties
    $spreadsheet->getProperties()->setCreator('Adraas')
      ->setLastModifiedBy('Adraas')
      ->setTitle('Institution Master')
      ->setSubject('')
      ->setDescription('');

		// add style to the header
		$styleArray = array(
			'font' => array(
				'bold' => true,
			),
			'alignment' => array(
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			),
			'borders' => array(
				'bottom' => array(
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
					'color' => array('rgb' => '333333'),
				),
			),
			'fill' => array(
				'type'       => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
				'rotation'   => 90,
				'startcolor' => array('rgb' => '0d0d0d'),
				'endColor'   => array('rgb' => 'f2f2f2'),
			),
		);

		$spreadsheet->getActiveSheet()->getStyle('A1:K1')->applyFromArray($styleArray);
    
		// auto fit column to content
		foreach(range('A', 'K') as $columnID) {
      $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
    }

		// set the names of header cells
		$sheet->setCellValue('A1', 'Sr. No.');
		$sheet->setCellValue('B1', 'Date');
		$sheet->setCellValue('C1', 'Organisation Name');
		$sheet->setCellValue('D1', 'Email');
		$sheet->setCellValue('E1', 'Contact No.');
		$sheet->setCellValue('F1', 'Address');
		$sheet->setCellValue('G1', 'Billing Name');
		$sheet->setCellValue('H1', 'Billing Address');
		$sheet->setCellValue('I1', 'GST');
		$sheet->setCellValue('J1', 'PAN');
		$sheet->setCellValue('K1', 'Status');
	
		// Add some data
		$records = $this->Mdl_excel->retrieve("profile_institution",array("1"=>"1"));

		$excel_row = 2;
		$nos = 1;

		if( $records !== "NA" ){
			foreach($records as $r){
				$string_email = ''; $institute_emails='';
				$string_contact = ''; $institute_contact='';
				if(!empty(unserialize($r->email))) {
					$emails = unserialize($r->email);
					foreach ($emails as $key => $email) {
						$string_email .= ", $email";
					}
					$institute_emails = substr($string_email, 1);
				}
				if(!empty(unserialize($r->contact_number))) {
					$contact = unserialize($r->contact_number);
					foreach ($contact as $key => $cont) {
						$string_contact .= ", $cont";
					}
					$institute_contact = substr($string_contact, 1);
				}
				$date = date("d-m-Y",strtotime($r->created_at));

				$sheet->setCellValue('A'.$excel_row, $nos);
				$sheet->setCellValue('B'.$excel_row, $date);
				$sheet->setCellValue('C'.$excel_row, $r->organisation_name);
				$sheet->setCellValue('D'.$excel_row, $institute_emails);
				$sheet->setCellValue('E'.$excel_row, $institute_contact);
				$sheet->setCellValue('F'.$excel_row, $r->address);
				$sheet->setCellValue('G'.$excel_row, $r->billing_name);
				$sheet->setCellValue('H'.$excel_row, $r->billing_address);
				$sheet->setCellValue('I'.$excel_row, $r->gst);
				$sheet->setCellValue('J'.$excel_row, $r->pan);
				$sheet->setCellValue('K'.$excel_row, $r->status);
				$excel_row++;
				$nos++;
			}
		}

		$writer = new Xlsx($spreadsheet);
 
		$filename = 'InstitutionMaster.xlsx';
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'"'); 
		header('Cache-Control: max-age=0');
		
		// download file 
		$writer->save('php://output'); 
	}

	function users(){

		// Create new Spreadsheet object
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		// Set document properties
      $spreadsheet->getProperties()->setCreator('Adraas')
      ->setLastModifiedBy('Adraas')
      ->setTitle('Users Master')
      ->setSubject('')
      ->setDescription('');

		// add style to the header
		$styleArray = array(
			'font' => array(
				'bold' => true,
			),
			'alignment' => array(
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			),
			'borders' => array(
				'bottom' => array(
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
					'color' => array('rgb' => '333333'),
				),
			),
			'fill' => array(
				'type'       => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
				'rotation'   => 90,
				'startcolor' => array('rgb' => '0d0d0d'),
				'endColor'   => array('rgb' => 'f2f2f2'),
			),
		);

		$spreadsheet->getActiveSheet()->getStyle('A1:N1')->applyFromArray($styleArray);
    
		// auto fit column to content
		foreach(range('A', 'N') as $columnID) {
			$spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}

		// set the names of header cells
		$sheet->setCellValue('A1', 'Sr. No.');
		$sheet->setCellValue('B1', 'Date');
		$sheet->setCellValue('C1', 'Full Name');
		$sheet->setCellValue('D1', 'Email');
		$sheet->setCellValue('E1', 'Contact No.');
		$sheet->setCellValue('F1', 'Address');
		$sheet->setCellValue('G1', 'Address Proof');
		$sheet->setCellValue('H1', 'Billing Address Name');
		$sheet->setCellValue('I1', 'Billing Address');
		$sheet->setCellValue('J1', 'GST');
		$sheet->setCellValue('K1', 'Id Proof');
		$sheet->setCellValue('L1', 'Authority Letter');
		$sheet->setCellValue('M1', 'Proof Of Address');
		$sheet->setCellValue('N1', 'Status');
	
		// Add some data
		$records = $this->Mdl_excel->retrieve("profile_user",array("1"=>"1"));

		$excel_row = 2;
		$nos = 1;

		if( $records !== "NA" ){
			foreach($records as $r){
				$date = date("d-m-Y",strtotime($r->created_at));

				$sheet->setCellValue('A'.$excel_row, $nos);
				$sheet->setCellValue('B'.$excel_row, $date);
				$sheet->setCellValue('C'.$excel_row, $r->name);
				$sheet->setCellValue('D'.$excel_row, $r->email);
				$sheet->setCellValue('E'.$excel_row, $r->mobile);
				$sheet->setCellValue('F'.$excel_row, $r->address);
				$sheet->setCellValue('G'.$excel_row, $r->address_proof);
				$sheet->setCellValue('H'.$excel_row, $r->billing_address_name);
				$sheet->setCellValue('I'.$excel_row, $r->billing_address);
				$sheet->setCellValue('J'.$excel_row, $r->gst_number);
				$sheet->setCellValue('K'.$excel_row, $r->id_proof);
				$sheet->setCellValue('L'.$excel_row, $r->authority_letter);
				$sheet->setCellValue('M'.$excel_row, $r->poa);
				$sheet->setCellValue('N'.$excel_row, $r->status);
				$excel_row++;
				$nos++;
			}
		}

		$writer = new Xlsx($spreadsheet);
 
		$filename = 'Users.xlsx';
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'"'); 
		header('Cache-Control: max-age=0');
		
		// download file 
		$writer->save('php://output'); 
	}

	function arbitrators() {
		// Create new Spreadsheet object
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		// Set document properties
      $spreadsheet->getProperties()->setCreator('Adraas')
      ->setLastModifiedBy('Adraas')
      ->setTitle('Arbitrator Master')
      ->setSubject('')
      ->setDescription('');

		// add style to the header
		$styleArray = array(
			'font' => array(
				'bold' => true,
			),
			'alignment' => array(
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			),
			'borders' => array(
				'bottom' => array(
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
					'color' => array('rgb' => '333333'),
				),
			),
			'fill' => array(
				'type'       => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
				'rotation'   => 90,
				'startcolor' => array('rgb' => '0d0d0d'),
				'endColor'   => array('rgb' => 'f2f2f2'),
			),
		);

		$spreadsheet->getActiveSheet()->getStyle('A1:R1')->applyFromArray($styleArray);
    
		// auto fit column to content
		foreach(range('A', 'R') as $columnID) {
			$spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}

		// set the names of header cells
		$sheet->setCellValue('A1', 'Sr. No.');
		$sheet->setCellValue('B1', 'Date');
		$sheet->setCellValue('C1', 'Full Name');
		$sheet->setCellValue('D1', 'Email');
		$sheet->setCellValue('E1', 'Contact No.');
		$sheet->setCellValue('F1', 'Empanelled');
		$sheet->setCellValue('G1', 'Location');
		$sheet->setCellValue('H1', 'Address');
		$sheet->setCellValue('I1', 'Address Proof');
		$sheet->setCellValue('J1', 'Billing Address Name');
		$sheet->setCellValue('K1', 'Billing Address');
		$sheet->setCellValue('L1', 'GST');
		$sheet->setCellValue('M1', 'PAN');
		$sheet->setCellValue('N1', 'Id Proof');
		$sheet->setCellValue('O1', 'Authority Letter');
		$sheet->setCellValue('P1', 'Proof Of Address');
		//$sheet->setCellValue('Q1', 'Professional Details');
		$sheet->setCellValue('Q1', 'More Info');
		$sheet->setCellValue('R1', 'Status');
	
		// Add some data
		$records = $this->Mdl_excel->retrieve("profile_arbitrator",array("1"=>"1"));

		$excel_row = 2;
		$nos = 1;

		if( $records !== "NA" ){
			foreach($records as $r){
				$date = date("d-m-Y",strtotime($r->created_at));

				$sheet->setCellValue('A'.$excel_row, $nos);
				$sheet->setCellValue('B'.$excel_row, $date);
				$sheet->setCellValue('C'.$excel_row, $r->name);
				$sheet->setCellValue('D'.$excel_row, $r->email);
				$sheet->setCellValue('E'.$excel_row, $r->mobile);
				$sheet->setCellValue('F'.$excel_row, $r->isEmpanelled);
				$sheet->setCellValue('G'.$excel_row, $r->location);
				$sheet->setCellValue('H'.$excel_row, $r->address);
				$sheet->setCellValue('I'.$excel_row, $r->address_proof);
				$sheet->setCellValue('J'.$excel_row, $r->billing_name);
				$sheet->setCellValue('K'.$excel_row, $r->billing_address);
				$sheet->setCellValue('L'.$excel_row, $r->gst_number);
				$sheet->setCellValue('M'.$excel_row, $r->pan);
				$sheet->setCellValue('N'.$excel_row, $r->id_proof);
				$sheet->setCellValue('O'.$excel_row, $r->authority_letter);
				$sheet->setCellValue('P'.$excel_row, $r->poa);
				//$sheet->setCellValue('Q'.$excel_row, $r->professional_details);
				$sheet->setCellValue('Q'.$excel_row, $r->more_info);
				$sheet->setCellValue('R'.$excel_row, $r->status);
				$excel_row++;
				$nos++;
			}
		}

		$writer = new Xlsx($spreadsheet);
 
		$filename = 'Arbitrator.xlsx';
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'"'); 
		header('Cache-Control: max-age=0');
		
		// download file 
		$writer->save('php://output'); 
	}

	function cases() {
		// Create new Spreadsheet object
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		// Set document properties
      $spreadsheet->getProperties()->setCreator('Adraas')
      ->setLastModifiedBy('Adraas')
      ->setTitle('Cases Master')
      ->setSubject('')
      ->setDescription('');

		// add style to the header
		$styleArray = array(
			'font' => array(
				'bold' => true,
			),
			'alignment' => array(
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			),
			'borders' => array(
				'bottom' => array(
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
					'color' => array('rgb' => '333333'),
				),
			),
			'fill' => array(
				'type'       => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
				'rotation'   => 90,
				'startcolor' => array('rgb' => '0d0d0d'),
				'endColor'   => array('rgb' => 'f2f2f2'),
			),
		);

		$spreadsheet->getActiveSheet()->getStyle('A1:Y1')->applyFromArray($styleArray);
    
		// auto fit column to content
		foreach(range('A', 'Y') as $columnID) {
			$spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}

		// set the names of header cells
		$sheet->setCellValue('A1', 'Sr. No.');
		$sheet->setCellValue('B1', 'Date');
		$sheet->setCellValue('C1', 'Paid');
		$sheet->setCellValue('D1', 'Amount');
		$sheet->setCellValue('E1', 'Offline Id');
		$sheet->setCellValue('F1', 'Claimant Representative');
		$sheet->setCellValue('G1', 'Respondent Reprentative');
		$sheet->setCellValue('H1', 'Description');
		$sheet->setCellValue('I1', 'More Description');
		$sheet->setCellValue('J1', 'Arbitration Type');
		$sheet->setCellValue('K1', 'Arbitartion Number');
		$sheet->setCellValue('L1', 'Seat');
		$sheet->setCellValue('M1', 'Venue');
		$sheet->setCellValue('N1', 'Currency');
		$sheet->setCellValue('O1', 'Claim Value');
		$sheet->setCellValue('P1', 'Current Claim value');
		$sheet->setCellValue('Q1', 'Administartion Fees');
		$sheet->setCellValue('R1', 'Arbitration Fees');
		$sheet->setCellValue('S1', 'Miscellaneous Fees');
		$sheet->setCellValue('T1', 'Claimant Arbitration Selection Type');
		$sheet->setCellValue('U1', 'Respodent Arbitration Selection Type');
		$sheet->setCellValue('V1', 'Read Terms');
		$sheet->setCellValue('W1', 'Read Arbitrator');
		$sheet->setCellValue('X1', 'Read Privacy');
		$sheet->setCellValue('Y1', 'Status');
	
		// Add some data
		$records = $this->Mdl_excel->retrieve("case_details",array("1"=>"1"));

		$excel_row = 2;
		$nos = 1;

		if( $records !== "NA" ){
			foreach($records as $r){
				$date = date("d-m-Y",strtotime($r->created_at));

				$sheet->setCellValue('A'.$excel_row, $nos);
				$sheet->setCellValue('B'.$excel_row, $date);
				$sheet->setCellValue('C'.$excel_row, $r->isPaid);
				$sheet->setCellValue('D'.$excel_row, $r->amount_paid);
				$sheet->setCellValue('E'.$excel_row, $r->offline_id);
				$sheet->setCellValue('F'.$excel_row, $r->claimant_representative);
				$sheet->setCellValue('G'.$excel_row, $r->respondant_representative);
				$sheet->setCellValue('H'.$excel_row, $r->description);
				$sheet->setCellValue('I'.$excel_row, $r->more_description);
				$sheet->setCellValue('J'.$excel_row, $r->arbitration_type);
				$sheet->setCellValue('K'.$excel_row, $r->arbitration_number);
				$sheet->setCellValue('L'.$excel_row, $r->seat);
				$sheet->setCellValue('M'.$excel_row, $r->venue);
				$sheet->setCellValue('N'.$excel_row, $r->currency);
				$sheet->setCellValue('O'.$excel_row, $r->claim_value);
				$sheet->setCellValue('P'.$excel_row, $r->counter_claim_value);
				$sheet->setCellValue('Q'.$excel_row, $r->administration_fees);
				$sheet->setCellValue('R'.$excel_row, $r->arbitration_fees);
				$sheet->setCellValue('S'.$excel_row, $r->miscellaneous_fees);
				$sheet->setCellValue('T'.$excel_row, $r->c_arbitration_selection_type);
				$sheet->setCellValue('U'.$excel_row, $r->r_arbitration_selection_type);
				$sheet->setCellValue('V'.$excel_row, $r->readTerms);
				$sheet->setCellValue('W'.$excel_row, $r->readArbitrator);
				$sheet->setCellValue('X'.$excel_row, $r->readPrivacy);
				$sheet->setCellValue('Y'.$excel_row, $r->status);
				$excel_row++;
				$nos++;
			}
		}

		$writer = new Xlsx($spreadsheet);
 
		$filename = 'Cases	.xlsx';
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'"'); 
		header('Cache-Control: max-age=0');
		
		// download file 
		$writer->save('php://output'); 
	}

	function newsletter() {
		// Create new Spreadsheet object
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		// Set document properties
      $spreadsheet->getProperties()->setCreator('Adraas')
      ->setLastModifiedBy('Adraas')
      ->setTitle('NewsLetter Master')
      ->setSubject('')
      ->setDescription('');

		// add style to the header
		$styleArray = array(
			'font' => array(
				'bold' => true,
			),
			'alignment' => array(
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			),
			'borders' => array(
				'bottom' => array(
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
					'color' => array('rgb' => '333333'),
				),
			),
			'fill' => array(
				'type'       => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
				'rotation'   => 90,
				'startcolor' => array('rgb' => '0d0d0d'),
				'endColor'   => array('rgb' => 'f2f2f2'),
			),
		);

		$spreadsheet->getActiveSheet()->getStyle('A1:F1')->applyFromArray($styleArray);
    
		// auto fit column to content
		foreach(range('A', 'F') as $columnID) {
			$spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}

		// set the names of header cells
		$sheet->setCellValue('A1', 'Sr. No.');
		$sheet->setCellValue('B1', 'Date');
		$sheet->setCellValue('C1', 'Id');
		$sheet->setCellValue('D1', 'Status');
		$sheet->setCellValue('E1', 'Email Id');
		$sheet->setCellValue('F1', 'Created At');
		
	
		// Add some data
		$records = $this->Mdl_excel->retrieve("newsletter",array("1"=>"1"));

		$excel_row = 2;
		$nos = 1;

		if( $records !== "NA" ){
			foreach($records as $r){
				$date = date("d-m-Y",strtotime($r->created_at));

				$sheet->setCellValue('A'.$excel_row, $nos);
				$sheet->setCellValue('B'.$excel_row, $date);
				$sheet->setCellValue('C'.$excel_row, $r->id);
				$sheet->setCellValue('D'.$excel_row, $r->status);
				$sheet->setCellValue('E'.$excel_row, $r->email_id);
				$sheet->setCellValue('F'.$excel_row, $r->created_at);
				
				$excel_row++;
				$nos++;
			}
		}

		$writer = new Xlsx($spreadsheet);
 
		$filename = 'Newsletter.xlsx';
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'"'); 
		header('Cache-Control: max-age=0');
		
		// download file 
		$writer->save('php://output'); 
	}

	function contactus() {
		// Create new Spreadsheet object
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		// Set document properties
      $spreadsheet->getProperties()->setCreator('Adraas')
      ->setLastModifiedBy('Adraas')
      ->setTitle('Contact Us Enquiries')
      ->setSubject('')
      ->setDescription('');

		// add style to the header
		$styleArray = array(
			'font' => array(
				'bold' => true,
			),
			'alignment' => array(
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			),
			'borders' => array(
				'bottom' => array(
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
					'color' => array('rgb' => '333333'),
				),
			),
			'fill' => array(
				'type'       => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
				'rotation'   => 90,
				'startcolor' => array('rgb' => '0d0d0d'),
				'endColor'   => array('rgb' => 'f2f2f2'),
			),
		);

		$spreadsheet->getActiveSheet()->getStyle('A1:G1')->applyFromArray($styleArray);
    
		// auto fit column to content
		foreach(range('A', 'F') as $columnID) {
			$spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}

		// set the names of header cells
		$sheet->setCellValue('A1', 'Sr. No.');
		$sheet->setCellValue('B1', 'Date');
		$sheet->setCellValue('C1', 'First Name');
		$sheet->setCellValue('D1', 'Last Name');
		$sheet->setCellValue('E1', 'Email Id');
		$sheet->setCellValue('F1', 'Mobile No.');
		$sheet->setCellValue('G1', 'Description.');
		
		
	
		// Add some data
		$records = $this->Mdl_excel->retrieve("contact_us",array("1"=>"1"));

		$excel_row = 2;
		$nos = 1;

		if( $records !== "NA" ){
			foreach($records as $r){
				$date = date("d-m-Y",strtotime($r->created_date));

				$sheet->setCellValue('A'.$excel_row, $nos);
				$sheet->setCellValue('B'.$excel_row, $date);
				$sheet->setCellValue('C'.$excel_row, $r->fname);
				$sheet->setCellValue('D'.$excel_row, $r->lname);
				$sheet->setCellValue('E'.$excel_row, $r->email);
				$sheet->setCellValue('F'.$excel_row, $r->mobile);
				$sheet->setCellValue('G'.$excel_row, $r->description);
		
				
				$excel_row++;
				$nos++;
			}
		}

		$writer = new Xlsx($spreadsheet);
 
		$filename = 'Contactus'.time().'.xlsx';
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'"'); 
		header('Cache-Control: max-age=0');
		
		// download file 
		$writer->save('php://output'); 
	}
	


	/////////Download Scan Report
	function scan_report(){
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		// Set document properties
      $spreadsheet->getProperties()->setCreator('Scan App')
      ->setLastModifiedBy('Scan App')
      ->setTitle('Scan Report')
      ->setSubject('')
      ->setDescription('');

		// add style to the header
		$styleArray = array(
			'font' => array(
				'bold' => true,
			),
			'alignment' => array(
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			),
			'borders' => array(
				'bottom' => array(
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
					'color' => array('rgb' => '333333'),
				),
			),
			'fill' => array(
				'type'       => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
				'rotation'   => 90,
				'startcolor' => array('rgb' => '0d0d0d'),
				'endColor'   => array('rgb' => 'f2f2f2'),
			),
		);

		$spreadsheet->getActiveSheet()->getStyle('A1:G1')->applyFromArray($styleArray);
    
		// auto fit column to content
		foreach(range('A', 'F') as $columnID) {
			$spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}

		// set the names of header cells
		$sheet->setCellValue('A1', 'Sr. No.');
		$sheet->setCellValue('B1', 'Date');
		$sheet->setCellValue('C1', 'User Unique Id');
		$sheet->setCellValue('D1', 'User Name');
		$sheet->setCellValue('E1', 'User PanNo');
		$sheet->setCellValue('F1', 'User Mobile');
		$sheet->setCellValue('G1', 'User Email');

		$sheet->setCellValue('H1', 'Client Unique Id');
		$sheet->setCellValue('I1', 'Client Name');
		$sheet->setCellValue('J1', 'Client PanNo');
		$sheet->setCellValue('K1', 'Client Mobile');
		$sheet->setCellValue('L1', 'Client Email');
		
	
		// Add some data
		$records = $this->Mdl_excel->retrieve("contact_details_scan_log",array("1"=>"1"));

		$excel_row = 2;
		$nos = 1;

		if( $records !== "NA" ){
			foreach($records as $r){
				$date = date("d-m-Y",strtotime($r->created_at));

				$sheet->setCellValue('A'.$excel_row, $nos);
				$sheet->setCellValue('B'.$excel_row, $date);
				$sheet->setCellValue('C'.$excel_row, $r->userUniqueId);
				$sheet->setCellValue('D'.$excel_row, $r->user_name);
				$sheet->setCellValue('E'.$excel_row, $r->user_panno);
				$sheet->setCellValue('F'.$excel_row, $r->user_email);
				$sheet->setCellValue('G'.$excel_row, $r->user_mobile);
				$sheet->setCellValue('H'.$excel_row, $r->clientUniqueId);
				$sheet->setCellValue('I'.$excel_row, $r->client_name);
				$sheet->setCellValue('J'.$excel_row, $r->client_panno);
				$sheet->setCellValue('K'.$excel_row, $r->client_mobile);
				$sheet->setCellValue('L'.$excel_row, $r->client_email);
		
				
				$excel_row++;
				$nos++;
			}
		}

		$writer = new Xlsx($spreadsheet);
 
		$filename = 'Contactus'.time().'.xlsx';
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'"'); 
		header('Cache-Control: max-age=0');
		
		// download file 
		$writer->save('php://output'); 
	}


	
}

















































	