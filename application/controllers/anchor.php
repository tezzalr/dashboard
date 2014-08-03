<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Anchor extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('manchor');
        $this->load->model('mrealization');
        $this->load->model('mtarget');
        $this->load->model('mwallet');
        $this->load->library('excel');
    }
    /**
     * Method for page (public)
     */
    public function index()
    {

		$data['title'] = "Daftar Anchor";
		
		$anchor['cor'] = $this->manchor->get_anchor_by_direktorat('corporate');
		$anchor['ib'] = $this->manchor->get_anchor_by_direktorat('institutional');
		$anchor['com'] = $this->manchor->get_anchor_by_direktorat('commercial');
		
		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('anchor/index',array('anchor' => $anchor),TRUE);

		$this->load->view('front',$data);
        
    }
    
    public function realisasi(){
    	$anchor_id = $this->uri->segment(3);
    	$target_ws = $this->mtarget->get_anchor_ws_target($anchor_id);
    	$realization_ws = $this->mrealization->get_anchor_ws_realization($anchor_id, 5, date('Y'));
    	$realization = $this->mrealization->count_realization($target_ws, $realization_ws);
    	
    	$arr_prod = array(); for($i=1;$i<=19;$i++){$arr_prod[$i] = $this->mwallet->return_prod_name($i);}
    	$arr_name = array(); for($i=1;$i<=19;$i++){$arr_name[$i] = $this->mwallet->change_real_name($arr_prod[$i]);}
    	
    	$anchor = $this->manchor->get_anchor_by_id($anchor_id);
    	$anchor_header = $this->load->view('anchor/anchor_header',array('anchor' => $anchor),TRUE);
    	
    	$data['title'] = "Realisasi - $anchor->name";
    	
		$graphview = $this->load->view('grafik/realisasi/_graph_view',array('rlzn' => $realization, 'tgt' => $target_ws, 'prod' => $arr_prod, 'arr_name' => $arr_name),TRUE);

		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('grafik/realisasi',array('header' => $anchor_header, 'anchor' => $anchor, 'graphview' => $graphview),TRUE);

		$this->load->view('front',$data);
    }
    
    public function realization_table_view(){
        $anchor_id = $this->input->get('id');
        $target_ws = $this->mtarget->get_anchor_ws_target($anchor_id);
    	$realization_ws = $this->mrealization->get_anchor_ws_realization($anchor_id, 5, date('Y'));
    	$realization_now = $this->mrealization->count_realization_now($realization_ws);
    	$realization_percent = $this->mrealization->count_realization($target_ws, $realization_ws);
    	$realization_YTD = $this->mrealization->count_realization_value($realization_ws, $realization_ws->month);
    	
    	$arr_prod = array(); for($i=1;$i<=19;$i++){$arr_prod[$i] = $this->mwallet->return_prod_name($i);}
    	$arr_name = array(); for($i=1;$i<=19;$i++){$arr_name[$i] = $this->mwallet->change_real_name($arr_prod[$i]);}
    	
		if($target_ws && $realization_ws){
			$json['status'] = 1;
    		$tableview = $this->load->view('grafik/realisasi/_table_view',array('ytd' => $realization_YTD, 'pct' =>$realization_percent, 'rlzn' => $realization_now, 'tgt' => $target_ws, 'prod' => $arr_prod, 'arr_name' => $arr_name),TRUE);
            $json['html'] = $tableview;
		}else{
			$json['status'] = 0;
		}
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}
	
	public function realization_graph_view(){
        $anchor_id = $this->input->get('id');
    	$target_ws = $this->mtarget->get_anchor_ws_target($anchor_id);
    	$realization_ws = $this->mrealization->get_anchor_ws_realization($anchor_id, 5, date('Y'));
    	$realization = $this->mrealization->count_realization($target_ws, $realization_ws);
    	
    	$arr_prod = array(); for($i=1;$i<=19;$i++){$arr_prod[$i] = $this->mwallet->return_prod_name($i);}
    	$arr_name = array(); for($i=1;$i<=19;$i++){$arr_name[$i] = $this->mwallet->change_real_name($arr_prod[$i]);}
    	
		if($target_ws && $realization_ws){
			$json['status'] = 1;
    		$graphview = $this->load->view('grafik/realisasi/_graph_view',array('rlzn' => $realization, 'tgt' => $target_ws, 'prod' => $arr_prod, 'arr_name' => $arr_name),TRUE);
            $json['html'] = $graphview;
		}else{
			$json['status'] = 0;
		}
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}
    
    public function pendapatan(){
    	$anchor_id = $this->uri->segment(3);
    	
    	$month = 5;
    	
    	$realization_ws = $this->mrealization->get_anchor_ws_realization($anchor_id, $month, date('Y'));
    	$realization_al = $this->mrealization->get_anchor_al_realization($anchor_id, $month, date('Y'));
    	$wallet_ws = $this->mwallet->get_anchor_ws_wallet($anchor_id, date('Y'));
    	$anchor = $this->manchor->get_anchor_by_id($anchor_id);
    	
    	$anchor_header = $this->load->view('anchor/anchor_header',array('anchor' => $anchor),TRUE);
    	
    	$data['title'] = "Pendapatan - $anchor->name";
		
		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('grafik/pendapatan',array('header' => $anchor_header, 'rlzn' => $realization_ws, 'anchor' => $anchor, 'ali' => $realization_al, 'wlt' => $wallet_ws, 'month' => $month),TRUE);

		$this->load->view('front',$data);
    }
    
    public function wallet(){
    	$anchor_id = $this->uri->segment(3);
    	
    	$wallet_ws = $this->mwallet->get_anchor_ws_wallet($anchor_id, date('Y'));
    	$wallet_al = $this->mwallet->get_anchor_al_wallet($anchor_id, date('Y'));
    	
    	$realization_ws = $this->mrealization->get_anchor_ws_realization($anchor_id, 5, date('Y'));
    	$realization = $this->mrealization->count_realization_value($realization_ws, $realization_ws->month);
    	
    	$sow_ws = $this->mwallet->get_sow($wallet_ws, $realization, 'wholesale');
    	
    	$anchor = $this->manchor->get_anchor_by_id($anchor_id);
    	$anchor_header = $this->load->view('anchor/anchor_header',array('anchor' => $anchor),TRUE);
    	
    	$arr_prod = array(); for($i=1;$i<=15;$i++){$arr_prod[$i] = $this->mwallet->return_prod_name($i);}
    	$arr_name = array(); for($i=1;$i<=15;$i++){$arr_name[$i] = $this->mwallet->change_real_name($arr_prod[$i]);}
    	
    	$data['title'] = "Wallet - $anchor->name";
		
		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('grafik/wallet',array('header' => $anchor_header,  'wlt_ws' => $wallet_ws, 'anchor' => $anchor, 'wlt_al' => $wallet_al, 'rlz_ws' => $realization, 'sow_ws' => $sow_ws, 'prod' => $arr_prod, 'arr_name' => $arr_name),TRUE);

		$this->load->view('front',$data);
    }
    
    public function product(){
    	$anchor_id = $this->uri->segment(3);
    	
    	$kind = $this->uri->segment(5);
    	$product = $this->uri->segment(4);
    	
    	$realization_now = $this->mrealization->get_anchor_prd_realization_annual($anchor_id, $product, $kind, date('Y'), date('n'));
    	$realization_ly = $this->mrealization->get_anchor_prd_realization_annual($anchor_id, $product, $kind, 2013,12);
    	$anchor = $this->manchor->get_anchor_by_id($anchor_id);
    	$anchor_header = $this->load->view('anchor/anchor_header',array('anchor' => $anchor),TRUE);
    	
    	
    	$data['title'] = "Product - $anchor->name";
		
		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('grafik/product',array('header' => $anchor_header, 
												'anchor' => $anchor, 'this_year' => $realization_now, 'ly_year' => $realization_ly, 'last_month_data' => $this->mrealization->get_anchor_last_month($anchor_id, 'wholesale_realization', date('y')), 
												'product_name' => $this->mwallet->change_real_name($product)),TRUE);

		$this->load->view('front',$data);
    }
    
    public function profile(){
    	$data['title'] = "Profile";
		
		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('grafik/profile',array(),TRUE);

		$this->load->view('front',$data);
    }
    
    public function input_anchor(){
    	$arr_target = $this->get_excel('datadashboard/daftar_perusahaan_ib.xlsx');
    	foreach($arr_target as $target){
    		$anchor['name'] = $target[0];
			$anchor['group'] = $target[1];
			
			$anchor_id = $this->manchor->insert_anchor($anchor);
		}
    }
    
    /*public function input_wholesale(){
    	$kind = $this->uri->segment(3);
    	$year = $this->uri->segment(4);
    	$month = '';
    	if($kind == 'realization'){$month = $this->uri->segment(5); $iptdata['month']= $month;}
    	$arr_target = $this->get_excel('datadashboard/corporate/daftar_'.$kind.'_ws_'.$year.$month.'.xlsx');
    	foreach($arr_target as $target){
    		
			$anchor_id = $this->manchor->get_anchor_id($target[0],$target[1]);
			
			$iptdata['CASA_vol']= $target[4];
			$iptdata['CASA_nii']= $target[5];
			$iptdata['CASA_fbi']= $target[6];
			$iptdata['TD_vol']= $target[7];
			$iptdata['TD_nii']= $target[8];
			$iptdata['WCL_vol']= $target[9];
			$iptdata['WCL_nii']= $target[10];
			$iptdata['WCL_fbi']= $target[11];
			$iptdata['IL_vol']= $target[12];
			$iptdata['IL_nii']= $target[13];
			$iptdata['IL_fbi']= $target[14]; //salah
			$iptdata['SL_vol']= $target[15];
			$iptdata['SL_nii']= $target[16];
			$iptdata['SL_fbi']= $target[17];
			$iptdata['FX_vol']= $target[18];
			$iptdata['FX_fbi']= $target[19];
			$iptdata['SCF_vol']= $target[20]; //salah
			$iptdata['SCF_fbi']= $target[21]; //salah
			$iptdata['Trade_vol']= $target[22];
			$iptdata['Trade_fbi']= $target[23];//salah
			$iptdata['PWE_vol']= $target[24];
			$iptdata['PWE_fbi']= $target[25];
			$iptdata['TR_vol']= $target[26];
			$iptdata['TR_nii']= $target[27];
			$iptdata['BG_vol']= $target[28];
			$iptdata['BG_fbi']= $target[29];
			$iptdata['OIR_vol']= $target[30];
			$iptdata['OIR_fbi']= $target[31];
			$iptdata['OW_vol']= $target[32];
			$iptdata['OW_nii']= $target[33];
			$iptdata['OW_fbi']= $target[34];
			$iptdata['ECM_vol']= $target[35];
			$iptdata['ECM_fbi']= $target[36];
			$iptdata['DCM_vol']= $target[37];
			$iptdata['DCM_fbi']= $target[38];
			$iptdata['MA_vol']= $target[39];
			$iptdata['MA_fbi']= $target[40];
			
			$iptdata['year']= $year;
			$iptdata['anchor_id']= $anchor_id;
			
			$this->manchor->insert_ws($iptdata, $kind);
			//echo $anchor_id.' = '.$target[4].'; ddd = '.$iptdata['CASA_vol'].'<br>';
    	}
    }
    
    public function input_alliance(){
    	$kind = $this->uri->segment(3);
    	$year = $this->uri->segment(4);
    	$month = '';
    	if($kind == 'realization'){$month = $this->uri->segment(5); $iptdata['month']= $month;}
    	$arr_target = $this->get_excel('datadashboard/corporate/daftar_'.$kind.'_al_'.$year.$month.'.xlsx');
    	foreach($arr_target as $target){
    		
			$anchor_id = $this->manchor->get_anchor_id($target[0],$target[1]);
			
			$iptdata['WM_vol']= $target[4];
			$iptdata['WM_nii']= $target[5];
			$iptdata['DPLK_vol']= $target[6];
			$iptdata['DPLK_fbi']= $target[7];
			$iptdata['PCD_vol']= $target[8];
			$iptdata['PCD_nii']= $target[9];
			$iptdata['VCCD_vol']= $target[10];
			$iptdata['VCCD_nii']= $target[11];
			$iptdata['VCCD_fbi']= $target[12];
			$iptdata['VCL_vol']= $target[13];
			$iptdata['VCL_nii']= $target[14];
			$iptdata['VCL_fbi']= $target[15];
			$iptdata['VCLnDF_vol']= $target[16];
			$iptdata['VCLnDF_nii']= $target[17];
			$iptdata['VCLnDF_fbi']= $target[18];
			$iptdata['Micro_Loan_vol']= $target[19];
			$iptdata['Micro_Loan_nii']= $target[20];
			$iptdata['Micro_Loan_fbi']= $target[21];
			$iptdata['MKM_vol']= $target[22];
			$iptdata['MKM_nii']= $target[23];
			$iptdata['KPR_vol']= $target[24];
			$iptdata['KPR_nii']= $target[25];
			$iptdata['Auto_vol']= $target[26];
			$iptdata['Auto_nii']= $target[27];
			$iptdata['CC_vol']= $target[28];
			$iptdata['CC_nii']= $target[29];
			$iptdata['EDC_vol']= $target[30];
			$iptdata['EDC_fbi']= $target[31];
			$iptdata['ATM_vol']= $target[32];
			$iptdata['ATM_fbi']= $target[33];
			$iptdata['AXA_vol']= $target[34];
			$iptdata['AXA_fbi']= $target[35];
			$iptdata['MAGI_vol']= $target[36];
			$iptdata['MAGI_fbi']= $target[37];
			$iptdata['retail_vol']= $target[38];
			$iptdata['retail_fbi']= $target[39];
			$iptdata['cicil_Emas_vol']= $target[40];
			$iptdata['cicil_Emas_fbi']= $target[41];
			$iptdata['OA_vol']= $target[42];
			$iptdata['OA_nii']= $target[43];
			$iptdata['OA_fbi']= $target[44];
			
			$iptdata['year']= $year;
			$iptdata['anchor_id']= $anchor_id;
			
			$this->manchor->insert_al($iptdata, $kind);
			//echo $anchor_id.' = '.$target[4].'; ddd = '.$iptdata['CASA_vol'].'<br>';
    	}
    }*/
    
    public function input_ws_al(){
    	$kind = $this->uri->segment(3);
    	$year = $this->uri->segment(4); $iter=1;
    	$month = ''; $year_fldr = '';
    	if($kind == 'realization'){$month = $this->uri->segment(5); $year_fldr= $year."/"; $iptdata['month']= $month; $iptdata2['month']= $month;}
    	$arr_target = $this->get_excel('datadashboard/'.$kind.'/'.$year_fldr.$kind.'_'.$year.$month.'.xlsx');
    	
    	foreach($arr_target as $target){
    		$anchor_id = $this->manchor->get_anchor_id($target[0],$target[1]);
    		
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
    
    public function get_excel($filename){
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
				for ($ar=4;$ar<=40;$ar++){
					$rachel[$i-1][$ar] = $rachel[$i-1][$ar]+$objWorksheet->getCellByColumnAndRow($ar, $row)->getValue();	
				}
			}
		}
		return $rachel;
    }
    
    public function excel(){
    	$data['title'] = "Profile";
    	
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(TRUE);
		$objPHPExcel = $objReader->load("assets/datadashboard/ib/daftar_target_ws_al_2014.xlsx");

		$objWorksheet = $objPHPExcel->getActiveSheet();
		// Get the highest row and column numbers referenced in the worksheet
		$highestRow = $objWorksheet->getHighestRow(); // e.g. 10
		$highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
		$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5
		
		echo '<table border=1>' . "\n";
		echo '<tr><td rowspan=2>No</td><td rowspan=2>Anchor</td><td rowspan=2>Group</td><td rowspan=2>Company</td><td rowspan=2>Code</td><td colspan=3>CASA</td><td colspan=2>Time Deposit</td><td colspan=3>Working Capital Loan</td>
		<td colspan=3>Investment Loan</td><td colspan=3>Structured Loan</td><td colspan=2>Fx & Derivative</td>
		<td colspan=2>Supply Chain Financing</td><td colspan=2>Trade Services</td><td colspan=2>Pwe Non L/C</td>
		<td colspan=2>Trust Receipt</td><td colspan=2>Bank Guarantee</td><td colspan=2>Outgoing Intl Remittance</td>
		<td colspan=3>Others Wholesale</td><td colspan=2>ECM</td><td colspan=2>DCM</td><td colspan=2>M&A</td>
		</tr>';
		echo '<tr><td>Volume</td><td>NII</td><td>FBI</td><td>Volume</td><td>NII</td><td>Volume</td><td>NII</td><td>FBI</td>
		<td>Volume</td><td>NII</td><td>FBI</td><td>Volume</td><td>NII</td><td>FBI</td>
		<td>Volume</td><td>FBI</td><td>Volume</td><td>FBI</td><td>Volume</td><td>FBI</td><td>Volume</td><td>FBI</td>
		<td>Volume</td><td>NII</td><td>Volume</td><td>FBI</td><td>Volume</td><td>FBI</td>
		<td>Volume</td><td>NII</td><td>FBI</td><td>Volume</td><td>FBI</td><td>Volume</td><td>FBI</td><td>Volume</td><td>FBI</td>
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
				for ($ar=4;$ar<=40;$ar++){
					$rachel[$i-1][$ar] = $rachel[$i-1][$ar]+$objWorksheet->getCellByColumnAndRow($ar, $row)->getValue();	
				}
			}
		}
		$iter=1;
		foreach ($rachel as $cinta){
			$anchor['name'] = $cinta[0];
			$anchor['group'] = $cinta[1];
			
			//$anchor_id = $this->manchor->insert_anchor($anchor);
			
			//$company['name'] = $cinta[2];
			//$company['code'] = $cinta[3];
			
			//$company_id = $this->manchor->insert_company($company);
			
			$iptdata['CASA_vol']= $cinta[4];
			$iptdata['CASA_nii']= $cinta[5];
			$iptdata['CASA_fbi']= $cinta[6];
			$iptdata['TD_vol']= $cinta[7];
			$iptdata['TD_nii']= $cinta[8];
			$iptdata['WCL_vol']= $cinta[9];
			$iptdata['WCL_nii']= $cinta[10];
			$iptdata['WCL_fbi']= $cinta[11];
			$iptdata['IL_vol']= $cinta[12];
			$iptdata['IL_nii']= $cinta[13];
			$iptdata['IL_fbi']= $cinta[14];
			$iptdata['SL_vol']= $cinta[15];
			$iptdata['SL_nii']= $cinta[16];
			$iptdata['SL_fbi']= $cinta[17];
			$iptdata['FX_vol']= $cinta[18];
			$iptdata['FX_fbi']= $cinta[19];
			$iptdata['SCF_vol']= $cinta[20];
			$iptdata['SCF_fbi']= $cinta[21];
			$iptdata['Trade_vol']= $cinta[22];
			$iptdata['Trade_fbi']= $cinta[23];
			$iptdata['PWE_vol']= $cinta[24];
			$iptdata['PWE_fbi']= $cinta[25];
			$iptdata['TR_vol']= $cinta[26];
			$iptdata['TR_nii']= $cinta[27];
			$iptdata['BG_vol']= $cinta[28];
			$iptdata['BG_fbi']= $cinta[29];
			$iptdata['OIR_vol']= $cinta[30];
			$iptdata['OIR_fbi']= $cinta[31];
			$iptdata['OW_vol']= $cinta[32];
			$iptdata['OW_nii']= $cinta[33];
			$iptdata['OW_fbi']= $cinta[34];
			$iptdata['ECM_vol']= $cinta[35];
			$iptdata['ECM_fbi']= $cinta[36];
			$iptdata['DCM_vol']= $cinta[37];
			$iptdata['DCM_fbi']= $cinta[38];
			$iptdata['MA_vol']= $cinta[39];
			$iptdata['MA_fbi']= $cinta[40];
			
			$iptdata['month']= 5;
			$iptdata['year']= 2014;
			//$iptdata['anchor_id']= $anchor_id;
			
			//$this->manchor->insert_ws($iptdata, 'realization');
			
			echo '<tr>';
			echo '<td>'.$iter.'</td><td>'.$cinta[0].'</td><td>'.$cinta[1].'</td><td>'.$cinta[2].'</td><td>'.$cinta[3].'</td>';
			for ($ar=4;$ar<=40;$ar++){
				if($cinta[$ar]){
					if($ar==18 || $ar == 19){$bagi = 6;}
					elseif($ar==30){$bagi = 0;}
					else{$bagi = 9;}
					echo '<td>'.number_format($cinta[$ar],1,',','.').'</td>';	
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
