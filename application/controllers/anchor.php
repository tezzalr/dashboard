<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Anchor extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('manchor');
        $this->load->model('mrealization');
        $this->load->model('mtarget');
        $this->load->model('mwallet');
        $this->load->library('excel');
        
        $session = $this->session->userdata('userdb');
        
        /*if(!$session){
            redirect('user/login');
        }*/
    }
    /**
     * Method for page (public)
     */
    public function index()
    {
		$data['title'] = "Daftar Anchor";
		
		$lstmth = $this->mrealization->get_last_month(date('Y'));
		$this->session->set_userdata('lstmth',$lstmth);
		
		$rptmth = $this->session->userdata('rptmth');
		if(!$rptmth){
			$rptmth = $this->mrealization->get_last_month(date('Y'));
			$this->session->set_userdata('rptmth',$rptmth);
		}
		
		$anchor['cor'] = $this->manchor->get_anchor_by_direktorat('corporate');
		$anchor['ib'] = $this->manchor->get_anchor_by_direktorat('institutional');
		$anchor['com'] = $this->manchor->get_anchor_by_direktorat('commercial');
		
		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('anchor/index',array('anchor' => $anchor),TRUE);

		$this->load->view('front',$data);
        
    }
    
    public function change_report_month(){
    	$this->session->set_userdata('rptmth',$this->input->post('report_month'));
    	$uri = $this->input->post('last_url');
    	redirect($uri);
    }
    
    
    public function form_input_file(){
    	$data['title'] = "Form Input File";
		
		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('anchor/form_file',array(),TRUE);

		$this->load->view('front',$data);
    }
    
    public function submit_file_input(){
    	$month = $this->input->post('month');
    	$year = $this->input->post('year');
    	$filetype = $this->input->post('filetype');
    	
    	if($filetype == "detail"){
    		$this->manchor->delete_detail($year,$month);
    		$this->input_detail($year,$month);
    	}
    	else{
    		$this->manchor->delete_ws($filetype,$year,$month);
    		$this->manchor->delete_al($filetype,$year,$month);
    		$this->input_ws_al($filetype,$year,$month);
    	}
    	redirect('anchor');
    	
    }
    
    public function input_anchor(){
    	$arr_target = $this->get_excel('datadashboard/daftar_perusahaan_ib.xlsx');
    	foreach($arr_target as $target){
    		$anchor['name'] = $target[0];
			$anchor['group'] = $target[1];
			
			$anchor_id = $this->manchor->insert_anchor($anchor);
		}
    }
    
    private function input_detail($year, $month){
    	$arr_target = $this->get_excel('datadashboard/detail_realization/'.$year.'/detail_realization_'.$year.$month.'.xlsx',"detail");
    	foreach($arr_target as $target){
    		$anchor_id = $this->manchor->get_anchor_id($target[0],$target[1]);
    		if($anchor_id){
    			$iptdata['CASA_trans']= $target[4];
    			$iptdata['CASA_idr']= $target[5];
				$iptdata['CASA_val']= $target[6];
				$iptdata['Trade_eks']= $target[7];
				$iptdata['Trade_imp']= $target[8];
				$iptdata['Trade_skbdn']= $target[9];
				$iptdata['OIR_amt']= $target[10];
				$iptdata['WM_CASA']= $target[11];
				$iptdata['WM_Dep']= $target[12];
				$iptdata['WM_AUM']= $target[13];
				$iptdata['CC_PB']= $target[14];
				$iptdata['CC_TA']= $target[15];
				
				$iptdata['year']= $year;
				$iptdata['anchor_id']= $anchor_id;
				$iptdata['month']= $month;
				
				$this->manchor->insert_detail($iptdata);
    		}
    	}
    }
    
    private function input_ws_al($kind, $year, $month){
    	$iter=1;
    	$month_x = ''; $year_fldr = '';
    	if($kind == 'realization'){
    		$year_fldr= $year."/"; 
    		$iptdata['month']= $month; 
    		$iptdata2['month']= $month;
    		$month_x = $month;
    	}
    	$arr_target = $this->get_excel('datadashboard/'.$kind.'/'.$year_fldr.$kind.'_'.$year.$month_x.'.xlsx',"realisasi");
    	
    	foreach($arr_target as $target){
    		$anchor_id = $this->manchor->get_anchor_id($target[0],$target[1]);
    		/*if(!$anchor_id){
    			$anchor['name'] = $target[0];
				$anchor['group'] = $target[1];
				
    			$anchor_id = $this->manchor->insert_anchor($anchor);
    		}*/
    		
    		if($anchor_id){			
				$iptdata['CASA_vol']= $target[4];
				$iptdata['CASA_nii']= $target[5];
				$iptdata['CASA_fbi']= $target[6];
				$iptdata['CASA_trans']= $target[7];
				$iptdata['TD_vol']= $target[8];
				$iptdata['TD_nii']= $target[9];
				$iptdata['WCL_vol']= $target[10];
				$iptdata['WCL_nii']= $target[11];
				$iptdata['WCL_fbi']= $target[12];
				$iptdata['IL_vol']= $target[13];
				$iptdata['IL_nii']= $target[14];
				$iptdata['IL_fbi']= $target[15]; //salah
				$iptdata['SL_vol']= $target[16];
				$iptdata['SL_nii']= $target[17];
				$iptdata['SL_fbi']= $target[18];
				$iptdata['FX_vol']= $target[19];
				$iptdata['FX_fbi']= $target[20];
				$iptdata['SCF_vol']= $target[21]; //salah
				$iptdata['SCF_fbi']= $target[22]; //salah
				$iptdata['Trade_vol']= $target[23];
				$iptdata['Trade_fbi']= $target[24];//salah
				$iptdata['PWE_vol']= $target[25];
				$iptdata['PWE_fbi']= $target[26];
				$iptdata['TR_vol']= $target[27];
				$iptdata['TR_nii']= $target[28];
				$iptdata['BG_vol']= $target[29];
				$iptdata['BG_fbi']= $target[30];
				$iptdata['OIR_vol']= $target[31];
				$iptdata['OIR_fbi']= $target[32];
				$iptdata['OW_vol']= $target[33];
				$iptdata['OW_nii']= $target[34];
				$iptdata['OW_fbi']= $target[35];
				$iptdata['ECM_vol']= $target[36];
				$iptdata['ECM_fbi']= $target[37];
				$iptdata['DCM_vol']= $target[38];
				$iptdata['DCM_fbi']= $target[39];
				$iptdata['MA_vol']= $target[40];
				$iptdata['MA_fbi']= $target[41];
			
				$iptdata['year']= $year;
				$iptdata['anchor_id']= $anchor_id;
			
				$this->manchor->insert_ws($iptdata, $kind);
			
				$iptdata2['WM_vol']= $target[42];
				$iptdata2['WM_nii']= $target[43];
				$iptdata2['DPLK_vol']= $target[44];
				$iptdata2['DPLK_fbi']= $target[45];
				$iptdata2['PCD_vol']= $target[46];
				$iptdata2['PCD_nii']= $target[47];
				$iptdata2['VCCD_vol']= $target[48];
				$iptdata2['VCCD_nii']= $target[49];
				$iptdata2['VCCD_fbi']= $target[50];
				$iptdata2['VCL_vol']= $target[51];
				$iptdata2['VCL_nii']= $target[52];
				$iptdata2['VCL_fbi']= $target[53];
				$iptdata2['VCLnDF_vol']= $target[54];
				$iptdata2['VCLnDF_nii']= $target[55];
				$iptdata2['VCLnDF_fbi']= $target[56];
				$iptdata2['Micro_Loan_vol']= $target[57];
				$iptdata2['Micro_Loan_nii']= $target[58];
				$iptdata2['Micro_Loan_fbi']= $target[59];
				$iptdata2['MKM_vol']= $target[60];
				$iptdata2['MKM_nii']= $target[61];
				$iptdata2['KPR_vol']= $target[62];
				$iptdata2['KPR_nii']= $target[63];
				$iptdata2['Auto_vol']= $target[64];
				$iptdata2['Auto_nii']= $target[65];
				$iptdata2['CC_vol']= $target[66];
				$iptdata2['CC_nii']= $target[67];
				$iptdata2['EDC_vol']= $target[68];
				$iptdata2['EDC_fbi']= $target[69];
				$iptdata2['ATM_vol']= $target[70];
				$iptdata2['ATM_fbi']= $target[71];
				$iptdata2['AXA_vol']= $target[72];
				$iptdata2['AXA_fbi']= $target[73];
				$iptdata2['MAGI_vol']= $target[74];
				$iptdata2['MAGI_fbi']= $target[75];
				$iptdata2['retail_vol']= $target[76];
				$iptdata2['retail_fbi']= $target[77];
				$iptdata2['cicil_Emas_vol']= $target[78];
				$iptdata2['cicil_Emas_fbi']= $target[79];
				$iptdata2['OA_vol']= $target[80];
				$iptdata2['OA_nii']= $target[81];
				$iptdata2['OA_fbi']= $target[82];
			
				$iptdata2['year']= $year;
				$iptdata2['anchor_id']= $anchor_id;
			
				$this->manchor->insert_al($iptdata2, $kind);
			}
    		
    	}
    }
    
    public function input_ws_al_company(){
    	$kind = $this->uri->segment(3);
    	$year = $this->uri->segment(4); $iter=1;
    	$month = ''; $year_fldr = '';
    	if($kind == 'realization'){
    		$month = $this->uri->segment(5); 
    		$year_fldr= $year."/"; 
    		$iptdata['month']= $month; 
    		$iptdata2['month']= $month;
    	}
    	$arr_target = $this->get_excel_company('datadashboard/company_'.$kind.'/'.$year_fldr.$kind.'_'.$year.$month.'.xlsx',"realisasi");
    	
    	foreach($arr_target as $target){
    		$company_id = $this->manchor->get_anchor_id($target[2],$target[1]);
    		if(!$anchor_id){
    			$anchor['anchor_id'] = $this->manchor->get_anchor_id($target[0],$target[1]);
    			$anchor['name'] = $target[2];
				$anchor['group'] = $target[1];
				
    			$company_id = $this->manchor->insert_anchor($anchor);
    		}
    		
    		if($anchor_id){			
				$iptdata['CASA_vol']= $target[4];
				$iptdata['CASA_nii']= $target[5];
				$iptdata['CASA_fbi']= $target[6];
				$iptdata['CASA_trans']= $target[7];
				$iptdata['TD_vol']= $target[8];
				$iptdata['TD_nii']= $target[9];
				$iptdata['WCL_vol']= $target[10];
				$iptdata['WCL_nii']= $target[11];
				$iptdata['WCL_fbi']= $target[12];
				$iptdata['IL_vol']= $target[13];
				$iptdata['IL_nii']= $target[14];
				$iptdata['IL_fbi']= $target[15]; //salah
				$iptdata['SL_vol']= $target[16];
				$iptdata['SL_nii']= $target[17];
				$iptdata['SL_fbi']= $target[18];
				$iptdata['FX_vol']= $target[19];
				$iptdata['FX_fbi']= $target[20];
				$iptdata['SCF_vol']= $target[21]; //salah
				$iptdata['SCF_fbi']= $target[22]; //salah
				$iptdata['Trade_vol']= $target[23];
				$iptdata['Trade_fbi']= $target[24];//salah
				$iptdata['PWE_vol']= $target[25];
				$iptdata['PWE_fbi']= $target[26];
				$iptdata['TR_vol']= $target[27];
				$iptdata['TR_nii']= $target[28];
				$iptdata['BG_vol']= $target[29];
				$iptdata['BG_fbi']= $target[30];
				$iptdata['OIR_vol']= $target[31];
				$iptdata['OIR_fbi']= $target[32];
				$iptdata['OW_vol']= $target[33];
				$iptdata['OW_nii']= $target[34];
				$iptdata['OW_fbi']= $target[35];
				$iptdata['ECM_vol']= $target[36];
				$iptdata['ECM_fbi']= $target[37];
				$iptdata['DCM_vol']= $target[38];
				$iptdata['DCM_fbi']= $target[39];
				$iptdata['MA_vol']= $target[40];
				$iptdata['MA_fbi']= $target[41];
			
				$iptdata['year']= $year;
				$iptdata['anchor_id']= $anchor_id;
			
				$this->manchor->insert_ws($iptdata, $kind);
			
				$iptdata2['WM_vol']= $target[42];
				$iptdata2['WM_nii']= $target[43];
				$iptdata2['DPLK_vol']= $target[44];
				$iptdata2['DPLK_fbi']= $target[45];
				$iptdata2['PCD_vol']= $target[46];
				$iptdata2['PCD_nii']= $target[47];
				$iptdata2['VCCD_vol']= $target[48];
				$iptdata2['VCCD_nii']= $target[49];
				$iptdata2['VCCD_fbi']= $target[50];
				$iptdata2['VCL_vol']= $target[51];
				$iptdata2['VCL_nii']= $target[52];
				$iptdata2['VCL_fbi']= $target[53];
				$iptdata2['VCLnDF_vol']= $target[54];
				$iptdata2['VCLnDF_nii']= $target[55];
				$iptdata2['VCLnDF_fbi']= $target[56];
				$iptdata2['Micro_Loan_vol']= $target[57];
				$iptdata2['Micro_Loan_nii']= $target[58];
				$iptdata2['Micro_Loan_fbi']= $target[59];
				$iptdata2['MKM_vol']= $target[60];
				$iptdata2['MKM_nii']= $target[61];
				$iptdata2['KPR_vol']= $target[62];
				$iptdata2['KPR_nii']= $target[63];
				$iptdata2['Auto_vol']= $target[64];
				$iptdata2['Auto_nii']= $target[65];
				$iptdata2['CC_vol']= $target[66];
				$iptdata2['CC_nii']= $target[67];
				$iptdata2['EDC_vol']= $target[68];
				$iptdata2['EDC_fbi']= $target[69];
				$iptdata2['ATM_vol']= $target[70];
				$iptdata2['ATM_fbi']= $target[71];
				$iptdata2['AXA_vol']= $target[72];
				$iptdata2['AXA_fbi']= $target[73];
				$iptdata2['MAGI_vol']= $target[74];
				$iptdata2['MAGI_fbi']= $target[75];
				$iptdata2['retail_vol']= $target[76];
				$iptdata2['retail_fbi']= $target[77];
				$iptdata2['cicil_Emas_vol']= $target[78];
				$iptdata2['cicil_Emas_fbi']= $target[79];
				$iptdata2['OA_vol']= $target[80];
				$iptdata2['OA_nii']= $target[81];
				$iptdata2['OA_fbi']= $target[82];
			
				$iptdata2['year']= $year;
				$iptdata2['anchor_id']= $anchor_id;
			
				$this->manchor->insert_al($iptdata2, $kind);
			}
    		
    	}
    }
    
    public function input_data_rm(){
    	$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(TRUE);
		$objPHPExcel = $objReader->load("assets/datadashboard/data_rm_anchor_client.xlsx");

		$objWorksheet = $objPHPExcel->getActiveSheet();
		// Get the highest row and column numbers referenced in the worksheet
		$highestRow = $objWorksheet->getHighestRow(); // e.g. 10
		$highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
		$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
		echo "<table border=1>";
    	$arrres = array();
    	for ($row = 2; $row <= $highestRow; ++$row) {
			echo "<tr>";
			echo "<td>".($row-1)."</td>";
			for ($col = 0; $col < $highestColumnIndex; ++$col) {
				$arrres[$row][$col] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
				echo "<td>".$arrres[$row][$col]."</td>";
			}
			$anchor_id = $this->manchor->get_anchor_id($arrres[$row][1],"");
			echo "<td>".$anchor_id."</td>";
			echo "</tr>";
		}
		/*foreach ($arrres as $res){		
			$iptdata['nip']= $res[0];
			$iptdata['nama']= $res[1];
			$iptdata['sumber']= $res[2];
			$iptdata['jab']= $res[3];
			$iptdata['group']= $res[4];
			$iptdata['departemen']= $res[5];
			$iptdata['sebelum']= $res[6];
			$iptdata['pl']= $res[13];
			$iptdata['tc']= $res[14];
			$iptdata['toeic']= $res[15];
			$iptdata['pendidikan']= $res[16];
			
			$rm_id = $this->mrm->input_rm_and_get_id($iptdata);
			
			for($i=0;$i<3;$i++){
				$nex = $i*2;
				if($res[7+$nex]){
					$nas['nama'] = $res[7+$nex];
					$nas['klasifikasi'] = $res[8+$nex];
					$nas['rm_id'] = $rm_id;
					
					//input nasabah
					$this->mrm->insert_nasabah($nas);
				}
			}
			
			$s1=$res[26]; $s2=$res[27]; $s3=$res[28]; $tot=$s1+$s2+$s3;
			for($i=0;$i<$tot;$i++){
				$nex = $i*3;
				if($i<$s1){$tingkat='S1';}elseif($i>=$s1 && $i<($s1+$s2)){$tingkat='S2';}
				elseif($i>=($s1+$s2) && $i<($s1+$s2+$s3)){$tingkat='S3';}
				$pend['prodi']=$res[17+$nex];
				$pend['univ']=$res[18+$nex];
				$pend['tahun_lulus']=$res[19+$nex];
				$pend['tingkat']=$tingkat;
				$pend['rm_id']=$rm_id;
				
				//input pendidikan
				$this->mrm->insert_pendidikan($pend);
			} 
		
			//$this->manchor->insert_ws($iptdata, $kind);
		}*/
		echo "</table>";
    }
    
    public function input_data_gas(){
    	$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(TRUE);
		$objPHPExcel = $objReader->load("assets/datadashboard/GAS anchor.xlsx");

		$objWorksheet = $objPHPExcel->getActiveSheet();
		// Get the highest row and column numbers referenced in the worksheet
		$highestRow = $objWorksheet->getHighestRow(); // e.g. 10
		$highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
		$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
    	$arrres = array();
    	for ($row = 2; $row <= $highestRow; ++$row) {
			for ($col = 0; $col < $highestColumnIndex; ++$col) {
				$arrres[$row][$col] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
			}
			$anchor['gas'] = $arrres[$row][1];
			$anchor['bank_comp'] = $arrres[$row][2];
			$anchor['srt_name'] = $arrres[$row][3];
			$anchor_id = $this->manchor->get_anchor_id($arrres[$row][0],"");
			
			$this->manchor->update_anchor($anchor, $anchor_id);
			//echo "<td>id : ".$anchor_id."</td>";
		}
    }
    
    public function get_excel($filename, $kind){
    	if($kind == "realisasi"){$jumcol = 82;}
    	elseif($kind == "detail"){$jumcol = 15;}
    	$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(TRUE);
		$objPHPExcel = $objReader->load("assets/".$filename);

		$objWorksheet = $objPHPExcel->getActiveSheet();
		// Get the highest row and column numbers referenced in the worksheet
		$highestRow = $objWorksheet->getHighestRow(); // e.g. 10
		$highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
		$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
		
		$same='';
		$i=1;
		$rachel = array();
		for ($row = 1; $row <= $highestRow; ++$row) {
			$agatha = $objWorksheet->getCellByColumnAndRow(0, $row)->getValue();
			if($agatha != $same){
				for ($col = 0; $col < $highestColumnIndex; ++$col) {
					$rachel[$i][$col] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
				}
				$same = $agatha;
				$i++;
			}
			else{
				for ($ar=4;$ar<=$jumcol;$ar++){
					$rachel[$i-1][$ar] = $rachel[$i-1][$ar]+$objWorksheet->getCellByColumnAndRow($ar, $row)->getValue();	
				}
			}
		}
		return $rachel;
    }
    
    public function get_excel_company($filename, $kind){
    	if($kind == "realisasi"){$jumcol = 40;}
    	elseif($kind == "detail"){$jumcol = 15;}
    	$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(TRUE);
		$objPHPExcel = $objReader->load("assets/".$filename);

		$objWorksheet = $objPHPExcel->getActiveSheet();
		// Get the highest row and column numbers referenced in the worksheet
		$highestRow = $objWorksheet->getHighestRow(); // e.g. 10
		$highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
		$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
		
		$same='';
		$i=1;
		$rachel = array();
		for ($row = 1; $row <= $highestRow; ++$row) {
			for ($col = 0; $col < $highestColumnIndex; ++$col) {
				$rachel[$i][$col] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
			}
			$i++;
		}
		return $rachel;
    }
    
    public function excel(){
    	$kind = $this->uri->segment(3);
    	$year = $this->uri->segment(4);
    	$month = ''; $year_fldr = '';
    	if($kind == 'realization'){
    		$month = $this->uri->segment(5); 
    		$year_fldr= $year."/"; 
    		$iptdata['month']= $month; 
    		$iptdata2['month']= $month;
    	}
    	
    	$data['title'] = "Profile";
    	
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(TRUE);
		$objPHPExcel = $objReader->load('assets/datadashboard/'.$kind.'/'.$year_fldr.$kind.'_'.$year.$month.'.xlsx');

		$objWorksheet = $objPHPExcel->getActiveSheet();
		// Get the highest row and column numbers referenced in the worksheet
		$highestRow = $objWorksheet->getHighestRow(); // e.g. 10
		$highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
		$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5
		
		echo '<table border=1>' . "\n";
		echo '<tr><td rowspan=2>No</td><td rowspan=2>Anchor</td><td rowspan=2>Group</td><td rowspan=2>Company</td><td rowspan=2>Code</td><td colspan=4>CASA</td><td colspan=2>Time Deposit</td><td colspan=3>Working Capital Loan</td>
		<td colspan=3>Investment Loan</td><td colspan=3>Structured Loan</td><td colspan=2>Fx & Derivative</td>
		<td colspan=2>Supply Chain Financing</td><td colspan=2>Trade Services</td><td colspan=2>Pwe Non L/C</td>
		<td colspan=2>Trust Receipt</td><td colspan=2>Bank Guarantee</td><td colspan=2>Outgoing Intl Remittance</td>
		<td colspan=3>Others Wholesale</td><td colspan=2>ECM</td><td colspan=2>DCM</td><td colspan=2>M&A</td>
		<td colspan=2>WM</td>
		<td colspan=2>DPLK</td>
		<td colspan=2>PCD</td>
		<td colspan=3>VCCD</td>
		<td colspan=3>VCL</td>
		<td colspan=3>VCLnDF</td>
		<td colspan=3>Micro</td>
		<td colspan=2>MKM</td>
		<td colspan=2>KPR</td>
		<td colspan=2>Auto</td>
		<td colspan=2>CC</td>
		<td colspan=2>EDC</td>
		<td colspan=2>ATM</td>
		<td colspan=2>AXA</td>
		<td colspan=2>MAGI</td>
		<td colspan=2>retail</td>
		<td colspan=2>cicil Emas</td>
		<td colspan=3>Other Aliansi</td>
		</tr>';
		echo '<tr><td>Volume</td><td>NII</td><td>FBI</td><td>Trans</td><td>Volume</td><td>NII</td><td>Volume</td><td>NII</td><td>FBI</td>
		<td>Volume</td><td>NII</td><td>FBI</td><td>Volume</td><td>NII</td><td>FBI</td>
		<td>Volume</td><td>FBI</td><td>Volume</td><td>FBI</td><td>Volume</td><td>FBI</td><td>Volume</td><td>FBI</td>
		<td>Volume</td><td>NII</td><td>Volume</td><td>FBI</td><td>Volume</td><td>FBI</td>
		<td>Volume</td><td>NII</td><td>FBI</td><td>Volume</td><td>FBI</td><td>Volume</td><td>FBI</td><td>Volume</td><td>FBI</td>
		<td>Volume</td><td>NII</td>
		<td>Volume</td><td>FBI</td>
		<td>Volume</td><td>NII</td>
		<td>Volume</td><td>NII</td><td>FBI</td>
		<td>Volume</td><td>NII</td><td>FBI</td>
		<td>Volume</td><td>NII</td><td>FBI</td>
		<td>Volume</td><td>NII</td><td>FBI</td>
		<td>Volume</td><td>NII</td>
		<td>Volume</td><td>NII</td>
		<td>Volume</td><td>NII</td>
		<td>Volume</td><td>NII</td>
		<td>Volume</td><td>FBI</td>
		<td>Volume</td><td>FBI</td>
		<td>Volume</td><td>FBI</td>
		<td>Volume</td><td>FBI</td>
		<td>Volume</td><td>FBI</td>
		<td>Volume</td><td>FBI</td>
		<td>Volume</td><td>NII</td><td>FBI</td>
		
		</tr>';
		$same='';
		$i=1;
		$rachel = array();
		for ($row = 1; $row <= $highestRow; ++$row) {
			$agatha = $objWorksheet->getCellByColumnAndRow(0, $row)->getValue();
			if($agatha != $same){
				for ($col = 0; $col < $highestColumnIndex; ++$col) {
					$rachel[$i][$col] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
				}
				$same = $agatha;
				$i++;
			}
			else{
				for ($ar=4;$ar<=82;$ar++){
					$rachel[$i-1][$ar] = $rachel[$i-1][$ar]+$objWorksheet->getCellByColumnAndRow($ar, $row)->getValue();	
				}
			}
		}
		$iter=1;
		foreach ($rachel as $target){
			$anchor['name'] = $target[0];
			$anchor['group'] = $target[1];
			
			$iptdata['CASA_vol']= $target[4];
				$iptdata['CASA_nii']= $target[5];
				$iptdata['CASA_fbi']= $target[6];
				$iptdata['CASA_trans']= $target[7];
				$iptdata['TD_vol']= $target[8];
				$iptdata['TD_nii']= $target[9];
				$iptdata['WCL_vol']= $target[10];
				$iptdata['WCL_nii']= $target[11];
				$iptdata['WCL_fbi']= $target[12];
				$iptdata['IL_vol']= $target[13];
				$iptdata['IL_nii']= $target[14];
				$iptdata['IL_fbi']= $target[15]; //salah
				$iptdata['SL_vol']= $target[16];
				$iptdata['SL_nii']= $target[17];
				$iptdata['SL_fbi']= $target[18];
				$iptdata['FX_vol']= $target[19];
				$iptdata['FX_fbi']= $target[20];
				$iptdata['SCF_vol']= $target[21]; //salah
				$iptdata['SCF_fbi']= $target[22]; //salah
				$iptdata['Trade_vol']= $target[23];
				$iptdata['Trade_fbi']= $target[24];//salah
				$iptdata['PWE_vol']= $target[25];
				$iptdata['PWE_fbi']= $target[26];
				$iptdata['TR_vol']= $target[27];
				$iptdata['TR_nii']= $target[28];
				$iptdata['BG_vol']= $target[29];
				$iptdata['BG_fbi']= $target[30];
				$iptdata['OIR_vol']= $target[31];
				$iptdata['OIR_fbi']= $target[32];
				$iptdata['OW_vol']= $target[33];
				$iptdata['OW_nii']= $target[34];
				$iptdata['OW_fbi']= $target[35];
				$iptdata['ECM_vol']= $target[36];
				$iptdata['ECM_fbi']= $target[37];
				$iptdata['DCM_vol']= $target[38];
				$iptdata['DCM_fbi']= $target[39];
				$iptdata['MA_vol']= $target[40];
				$iptdata['MA_fbi']= $target[41];		
				$iptdata2['WM_vol']= $target[42];
				$iptdata2['WM_nii']= $target[43];
				$iptdata2['DPLK_vol']= $target[44];
				$iptdata2['DPLK_fbi']= $target[45];
				$iptdata2['PCD_vol']= $target[46];
				$iptdata2['PCD_nii']= $target[47];
				$iptdata2['VCCD_vol']= $target[48];
				$iptdata2['VCCD_nii']= $target[49];
				$iptdata2['VCCD_fbi']= $target[50];
				$iptdata2['VCL_vol']= $target[51];
				$iptdata2['VCL_nii']= $target[52];
				$iptdata2['VCL_fbi']= $target[53];
				$iptdata2['VCLnDF_vol']= $target[54];
				$iptdata2['VCLnDF_nii']= $target[55];
				$iptdata2['VCLnDF_fbi']= $target[56];
				$iptdata2['Micro_Loan_vol']= $target[57];
				$iptdata2['Micro_Loan_nii']= $target[58];
				$iptdata2['Micro_Loan_fbi']= $target[59];
				$iptdata2['MKM_vol']= $target[60];
				$iptdata2['MKM_nii']= $target[61];
				$iptdata2['KPR_vol']= $target[62];
				$iptdata2['KPR_nii']= $target[63];
				$iptdata2['Auto_vol']= $target[64];
				$iptdata2['Auto_nii']= $target[65];
				$iptdata2['CC_vol']= $target[66];
				$iptdata2['CC_nii']= $target[67];
				$iptdata2['EDC_vol']= $target[68];
				$iptdata2['EDC_fbi']= $target[69];
				$iptdata2['ATM_vol']= $target[70];
				$iptdata2['ATM_fbi']= $target[71];
				$iptdata2['AXA_vol']= $target[72];
				$iptdata2['AXA_fbi']= $target[73];
				$iptdata2['MAGI_vol']= $target[74];
				$iptdata2['MAGI_fbi']= $target[75];
				$iptdata2['retail_vol']= $target[76];
				$iptdata2['retail_fbi']= $target[77];
				$iptdata2['cicil_Emas_vol']= $target[78];
				$iptdata2['cicil_Emas_fbi']= $target[79];
				$iptdata2['OA_vol']= $target[80];
				$iptdata2['OA_nii']= $target[81];
				$iptdata2['OA_fbi']= $target[82];
			
			$iptdata['month']= 5;
			$iptdata['year']= 2014;
			
			echo '<tr>';
			echo '<td>'.$iter.'</td><td>'.$target[0].'</td><td>'.$target[1].'</td><td>'.$target[2].'</td><td>'.$target[3].'</td>';
			for ($ar=4;$ar<=82;$ar++){
				if($target[$ar]){
					if($ar==19 || $ar == 20){$bagi = 6;}
					elseif($ar==31){$bagi = 0;}
					else{$bagi = 9;}
					echo '<td>'.number_format($target[$ar],1,',','.').'</td>';	
				}
				else{
					echo '<td>-</td>';
				}
			}
			echo '</tr>';
			$iter++;	
		}
		echo '</table>' . PHP_EOL;
		
		
		
		//$data['header'] = $this->load->view('shared/header','',TRUE);	
		//$data['footer'] = $this->load->view('shared/footer','',TRUE);
		//$data['content'] = $this->load->view('anchor/excel',array(),TRUE);

		//$this->load->view('front',$data);
    }
}
