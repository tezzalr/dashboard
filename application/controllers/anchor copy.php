<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Anchor extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('manchor');
        $this->load->library('excel');
    }
    /**
     * Method for page (public)
     */
    public function index()
    {

		$data['title'] = "Beranda";
		
		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('anchor/index',array(),TRUE);

		$this->load->view('front',$data);
        
    }
    
    public function tes(){
    	$data['title'] = "Pendapatan -";
		
		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('anchor/tes',array(),TRUE);

		$this->load->view('front',$data);
    }
    
    public function tes2(){
    	$data['title'] = "Pendapatan -";
		
		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('anchor/tes2',array(),TRUE);

		$this->load->view('front',$data);
    }
    
    public function realisasi(){
    	$anchor_id = $this->uri->segment(3);
    	$target_ws = $this->manchor->get_anchor_ws_target($anchor_id);
    	$realization_ws = $this->manchor->get_anchor_ws_realization($anchor_id, 5, 2014);
    	
    	$realization = $this->count_realization($target_ws, $realization_ws);
    	$target = $this->count_target($target_ws);
    	
    	$anchor = $this->manchor->get_anchor_by_id($anchor_id);
    	
    	$data['title'] = "Detail";
		
		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('anchor/realisasi',array('rlzn' => $realization, 'tgt' => $target, 'anchor' => $anchor),TRUE);

		$this->load->view('front',$data);
    }
    
    public function pendapatan(){
    	$anchor_id = $this->uri->segment(3);
    	
    	$realization_ws = $this->manchor->get_anchor_ws_realization($anchor_id, 5, 2014);
    	$realization_al = $this->manchor->get_anchor_al_realization($anchor_id, 5, 2014);
    	$anchor = $this->manchor->get_anchor_by_id($anchor_id);
    	
    	$data['title'] = "Pendapatan - $anchor->name";
		
		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('anchor/pendapatan',array('rlzn' => $realization_ws, 'anchor' => $anchor, 'ali' => $realization_al),TRUE);

		$this->load->view('front',$data);
    }
    
    public function wallet(){
    	$anchor_id = $this->uri->segment(3);
    	
    	$wallet_ws = $this->manchor->get_anchor_ws_wallet($anchor_id, 2014);
    	$wallet_al = $this->manchor->get_anchor_al_wallet($anchor_id, 2014);
    	
    	$realization_ws = $this->manchor->get_anchor_ws_realization($anchor_id, 5, 2014);
    	$realization = $this->count_realization_value($realization_ws, $realization_ws->month);
    	
    	$anchor = $this->manchor->get_anchor_by_id($anchor_id);
    	
    	$data['title'] = "Pendapatan - $anchor->name";
		
		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('anchor/wallet',array('wlt_ws' => $wallet_ws, 'anchor' => $anchor, 'wlt_al' => $wallet_al, 'rlz_ws' => $realization),TRUE);

		$this->load->view('front',$data);
    }
    
    public function product(){
    	$data['title'] = "Product";
		
		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('anchor/product',array(),TRUE);

		$this->load->view('front',$data);
    }
    
    public function profile(){
    	$data['title'] = "Profile";
		
		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('anchor/profile',array(),TRUE);

		$this->load->view('front',$data);
    }
    
    private function count_avgbal($target,$realization){
    	if($target && $target>0){
    		return $realization/pow(10,9)/$target*100;
    	}
    	elseif(!$target && $realization){return 100;}
    	else{return 0;}
    }
    
    private function count_sum($target,$realization,$month){
    	if($target && $target>0){
    		return $realization/$month*12/pow(10,9)/$target*100;
    	}
    	elseif(!$target && $realization){return 100;}
    	else{return 0;}
    }
    
    private function count_avgbal_value($realization){
    	return $realization/pow(10,9);
    }
    
    private function count_sum_value($realization,$month){
    	
    	return $realization/$month*12/pow(10,9);
    }
    
    private function count_realization($target_ws, $realization_ws){
		$iptdata['CASA_vol']= $this->count_avgbal($target_ws->CASA_vol,$realization_ws->CASA_vol);
		$iptdata['CASA_inc']=  $this->count_sum($target_ws->CASA_nii+$target_ws->CASA_fbi,$realization_ws->CASA_nii+$realization_ws->CASA_fbi, $realization_ws->month);
		$iptdata['TD_vol']= $this->count_avgbal($target_ws->TD_vol,$realization_ws->TD_vol);
		$iptdata['TD_inc']= $this->count_sum($target_ws->TD_nii,$realization_ws->TD_nii, $realization_ws->month);
		$iptdata['WCL_vol']= $this->count_avgbal($target_ws->WCL_vol,$realization_ws->WCL_vol);
		$iptdata['WCL_inc']= $this->count_sum($target_ws->WCL_nii,$realization_ws->WCL_nii, $realization_ws->month);
		$iptdata['IL_vol']= $this->count_avgbal($target_ws->IL_vol,$realization_ws->IL_vol);
		$iptdata['IL_inc']= $this->count_sum($target_ws->IL_nii,$realization_ws->IL_nii, $realization_ws->month);
		$iptdata['SL_vol']= $this->count_avgbal($target_ws->SL_vol,$realization_ws->SL_vol);
		$iptdata['SL_inc']= $this->count_sum($target_ws->SL_nii,$realization_ws->SL_nii, $realization_ws->month);
		$iptdata['FX_vol']= $this->count_sum($target_ws->FX_vol,$realization_ws->FX_vol,$realization_ws->month)*1000; if(!$target_ws->FX_vol){$iptdata['FX_vol']=$iptdata['FX_vol']/1000;}
		$iptdata['FX_inc']= $this->count_sum($target_ws->FX_fbi,$realization_ws->FX_fbi,$realization_ws->month);
		$iptdata['SCF_vol']= $this->count_sum($target_ws->SCF_vol,$realization_ws->SCF_vol,$realization_ws->month);
		//$iptdata['SCF_fbi']= $target[21];
		$iptdata['Trade_vol']= $this->count_sum($target_ws->Trade_vol,$realization_ws->Trade_vol,$realization_ws->month)*1000; if(!$target_ws->Trade_vol){$iptdata['Trade_vol']=$iptdata['Trade_vol']/1000;}
		$iptdata['Trade_inc']= $this->count_sum($target_ws->Trade_fbi,$realization_ws->Trade_fbi,$realization_ws->month);
		$iptdata['PWE_vol']= $this->count_sum($target_ws->PWE_vol,$realization_ws->PWE_vol,$realization_ws->month);
		$iptdata['PWE_inc']= $this->count_sum($target_ws->PWE_fbi,$realization_ws->PWE_fbi,$realization_ws->month);
		$iptdata['TR_vol']= $this->count_sum($target_ws->TR_vol,$realization_ws->TR_vol,$realization_ws->month);
		$iptdata['TR_inc']= $this->count_sum($target_ws->TR_nii,$realization_ws->TR_nii,$realization_ws->month);
		$iptdata['BG_vol']= $this->count_sum($target_ws->BG_vol,$realization_ws->BG_vol,$realization_ws->month);
		$iptdata['BG_inc']= $this->count_sum($target_ws->BG_fbi,$realization_ws->BG_fbi,$realization_ws->month);
		$iptdata['OIR_vol']= $this->count_sum($target_ws->OIR_vol,$realization_ws->OIR_vol,$realization_ws->month)*pow(10,9); if(!$target_ws->OIR_vol){$iptdata['OIR_vol']=$iptdata['OIR_vol']/pow(10,9);}
		$iptdata['OIR_inc']= $this->count_sum($target_ws->OIR_fbi,$realization_ws->OIR_fbi,$realization_ws->month);
		$iptdata['OW_nii']= $this->count_sum($target_ws->OW_nii,$realization_ws->OW_nii,$realization_ws->month);
		$iptdata['OW_fbi']= $this->count_sum($target_ws->OW_fbi,$realization_ws->OW_fbi,$realization_ws->month);
		$iptdata['ECM_vol']= 1;
		//$iptdata['ECM_fbi']= $target[36];
		$iptdata['DCM_vol']= 1;
		//$iptdata['DCM_fbi']= $target[38];
		$iptdata['MA_vol']= 1;
		//$iptdata['MA_fbi']= $target[40];
		
		$iptdata['LMF'] = $this->count_sum($target_ws->IL_fbi+$target_ws->WCL_fbi,$realization_ws->IL_fbi+$realization_ws->WCL_fbi, $realization_ws->month);
		$iptdata['SF'] = $this->count_sum($target_ws->SL_fbi,$realization_ws->SL_fbi, $realization_ws->month);
		
		return $iptdata;
    }
    
    private function count_realization_value($realization_ws, $month){
		$iptdata['CASA_vol']= $this->count_avgbal_value($realization_ws->CASA_vol);
		$iptdata['CASA_inc']=  $this->count_sum_value($realization_ws->CASA_nii+$realization_ws->CASA_fbi, $realization_ws->month);
		$iptdata['TD_vol']= $this->count_avgbal_value($realization_ws->TD_vol);
		$iptdata['TD_inc']= $this->count_sum_value($realization_ws->TD_nii, $realization_ws->month);
		$iptdata['WCL_vol']= $this->count_avgbal_value($realization_ws->WCL_vol);
		$iptdata['WCL_inc']= $this->count_sum_value($realization_ws->WCL_nii, $realization_ws->month);
		$iptdata['IL_vol']= $this->count_avgbal_value($realization_ws->IL_vol);
		$iptdata['IL_inc']= $this->count_sum_value($realization_ws->IL_nii, $realization_ws->month);
		$iptdata['SL_vol']= $this->count_avgbal_value($realization_ws->SL_vol);
		$iptdata['SL_inc']= $this->count_sum_value($realization_ws->SL_nii, $realization_ws->month);
		$iptdata['FX_vol']= $this->count_sum_value($realization_ws->FX_vol,$realization_ws->month)*1000;
		$iptdata['FX_inc']= $this->count_sum_value($realization_ws->FX_fbi,$realization_ws->month);
		$iptdata['SCF_vol']= $this->count_sum_value($realization_ws->SCF_vol,$realization_ws->month);
		$iptdata['SCF_inc']= $this->count_sum_value($realization_ws->SCF_fbi,$realization_ws->month);
		$iptdata['Trade_vol']= $this->count_sum_value($realization_ws->Trade_vol,$realization_ws->month)*1000;
		$iptdata['Trade_inc']= $this->count_sum_value($realization_ws->Trade_fbi,$realization_ws->month);
		$iptdata['PWE_vol']= $this->count_sum_value($realization_ws->PWE_vol,$realization_ws->month);
		$iptdata['PWE_inc']= $this->count_sum_value($realization_ws->PWE_fbi,$realization_ws->month);
		$iptdata['TR_vol']= $this->count_sum_value($realization_ws->TR_vol,$realization_ws->month);
		$iptdata['TR_inc']= $this->count_sum_value($realization_ws->TR_nii,$realization_ws->month);
		$iptdata['BG_vol']= $this->count_sum_value($realization_ws->BG_vol,$realization_ws->month);
		$iptdata['BG_inc']= $this->count_sum_value($realization_ws->BG_fbi,$realization_ws->month);
		$iptdata['OIR_vol']= $this->count_sum_value($realization_ws->OIR_vol,$realization_ws->month)*pow(10,9);
		$iptdata['OIR_inc']= $this->count_sum_value($realization_ws->OIR_fbi,$realization_ws->month);
		$iptdata['OW_nii']= $this->count_sum_value($realization_ws->OW_nii,$realization_ws->month);
		$iptdata['OW_fbi']= $this->count_sum_value($realization_ws->OW_fbi,$realization_ws->month);
		$iptdata['ECM_vol']= 1;
		//$iptdata['ECM_fbi']= $target[36];
		$iptdata['DCM_vol']= 1;
		//$iptdata['DCM_fbi']= $target[38];
		$iptdata['MA_vol']= 1;
		//$iptdata['MA_fbi']= $target[40];
		
		$iptdata['LMF'] = $this->count_sum_value($realization_ws->IL_fbi+$realization_ws->WCL_fbi, $realization_ws->month);
		$iptdata['SF'] = $this->count_sum_value($realization_ws->SL_fbi, $realization_ws->month);
		
		return $iptdata;
    }
    
    private function count_target($target_ws){
    	$iptdata['CASA_vol']= $this->determine_target($target_ws->CASA_vol);
		$iptdata['CASA_inc']= $this->determine_target($target_ws->CASA_nii+$target_ws->CASA_fbi);
		$iptdata['TD_vol']= $this->determine_target($target_ws->TD_vol);
		$iptdata['TD_inc']= $this->determine_target($target_ws->TD_nii);
		$iptdata['WCL_vol']= $this->determine_target($target_ws->WCL_vol);
		$iptdata['WCL_inc']= $this->determine_target($target_ws->WCL_nii+$target_ws->WCL_fbi);
		$iptdata['IL_vol']= $this->determine_target($target_ws->IL_vol);
		$iptdata['IL_inc']= $this->determine_target($target_ws->IL_nii+$target_ws->IL_fbi);
		$iptdata['SL_vol']= $this->determine_target($target_ws->SL_vol);
		$iptdata['SL_inc']= $this->determine_target($target_ws->SL_nii+$target_ws->SL_fbi);
		
		return $iptdata;
    }
    
    private function determine_target($target){
    	if($target){return 100;}
    	else{return 0;}
    }
    
    public function input_anchor(){
    	$arr_target = $this->get_excel('datadashboard/daftar_perusahaan_ib.xlsx');
    	foreach($arr_target as $target){
    		$anchor['name'] = $target[0];
			$anchor['group'] = $target[1];
			
			$anchor_id = $this->manchor->insert_anchor($anchor);
		}
    }
    
    public function input_wholesale(){
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
    }
    
    public function input_ws_al(){
    	$kind = $this->uri->segment(3);
    	$year = $this->uri->segment(4); $iter=1;
    	$month = '';
    	if($kind == 'realization'){$month = $this->uri->segment(5); $iptdata['month']= $month; $iptdata2['month']= $month;}
    	$arr_target = $this->get_excel('datadashboard/ib/daftar_'.$kind.'_ws_al_'.$year.$month.'.xlsx');
    	
    	foreach($arr_target as $target){
    		$anchor_id = $this->manchor->get_anchor_id($target[0],$target[1]);
			
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
