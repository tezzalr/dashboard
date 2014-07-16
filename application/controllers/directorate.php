<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Directorate extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('manchor');
        $this->load->model('mrealization');
        $this->load->model('mtarget');
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
    	$directorate = $this->uri->segment(3);
    	$target_ws = $this->mtarget->get_directorate_target($directorate,'wholesale');
    	$realization_ws = $this->mrealization->get_directorate_realization($directorate, 5, date('Y'), 'wholesale');
    	
    	$realization = $this->count_realization($target_ws, $realization_ws);
    
    	$dir_header = $this->load->view('directorate/dir_header',array('directorate' => $directorate),TRUE);
    	
    	$data['title'] = "Detail";
		
		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('directorate/realisasi',array('dir_header' => $dir_header, 'rlzn' => $realization, 'tgt' => $target_ws),TRUE);

		$this->load->view('front',$data);
    }
    
    public function pendapatan(){
    	$anchor_id = $this->uri->segment(3);
    	
    	$realization_ws = $this->mrealization->get_anchor_ws_realization($anchor_id, 5, 2014);
    	$realization_al = $this->mrealization->get_anchor_al_realization($anchor_id, 5, 2014);
    	$anchor = $this->manchor->get_anchor_by_id($anchor_id);
    	
    	$anchor_header = $this->load->view('anchor/anchor_header',array('anchor' => $anchor),TRUE);
    	
    	$data['title'] = "Pendapatan - $anchor->name";
		
		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('anchor/pendapatan',array('anchor_header' => $anchor_header, 'rlzn' => $realization_ws, 'anchor' => $anchor, 'ali' => $realization_al),TRUE);

		$this->load->view('front',$data);
    }
    
    public function wallet(){
    	$anchor_id = $this->uri->segment(3);
    	
    	$wallet_ws = $this->manchor->get_anchor_ws_wallet($anchor_id, 2014);
    	$wallet_al = $this->manchor->get_anchor_al_wallet($anchor_id, 2014);
    	
    	$realization_ws = $this->mrealization->get_anchor_ws_realization($anchor_id, 5, 2014);
    	$realization = $this->count_realization_value($realization_ws, $realization_ws->month);
    	
    	$anchor = $this->manchor->get_anchor_by_id($anchor_id);
    	$anchor_header = $this->load->view('anchor/anchor_header',array('anchor' => $anchor),TRUE);
    	
    	$data['title'] = "Wallet - $anchor->name";
		
		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('anchor/wallet',array('anchor_header' => $anchor_header,  'wlt_ws' => $wallet_ws, 'anchor' => $anchor, 'wlt_al' => $wallet_al, 'rlz_ws' => $realization),TRUE);

		$this->load->view('front',$data);
    }
    
    public function product(){
    	$anchor_id = $this->uri->segment(3);
    	
    	$kind = $this->uri->segment(5);
    	$product = $this->uri->segment(4);
    	
    	$realization_now = $this->mrealization->get_anchor_prd_realization_annual($anchor_id, $product, $kind, 2014, date('n'));
    	//$realization_ly = $this->mrealization->get_anchor_prd_realization($anchor_id, $product, $kind, 2013);
    	$anchor = $this->manchor->get_anchor_by_id($anchor_id);
    	$anchor_header = $this->load->view('anchor/anchor_header',array('anchor' => $anchor),TRUE);
    	
    	$data['title'] = "Product - $anchor->name";
		
		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('anchor/product',array('anchor_header' => $anchor_header, 'anchor' => $anchor, 'this_year' => $realization_now, 'last_month_data' => $this->mrealization->get_anchor_last_month($anchor_id, 'wholesale_realization', date('y'))),TRUE);

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
		$iptdata['CASA_inc']=  $this->count_sum($target_ws->CASA_nii,$realization_ws->CASA_nii, $realization_ws->month);
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
		$iptdata['SCF_inc']= $this->count_sum($target_ws->SCF_fbi,$realization_ws->SCF_fbi,$realization_ws->month);
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
		$iptdata['OW_fbi']= $this->count_sum($target_ws->OW_fbi+$target_ws->CASA_fbi,$realization_ws->OW_fbi+$realization_ws->CASA_fbi,$realization_ws->month);
		$iptdata['ECM_vol']= $this->count_sum($target_ws->ECM_vol,$realization_ws->ECM_vol,$realization_ws->month);
		$iptdata['ECM_inc']= $this->count_sum($target_ws->ECM_fbi,$realization_ws->ECM_fbi,$realization_ws->month)/12*$realization_ws->month;
		$iptdata['DCM_vol']= $this->count_sum($target_ws->DCM_vol,$realization_ws->DCM_vol,$realization_ws->month);
		$iptdata['DCM_inc']= $this->count_sum($target_ws->DCM_fbi,$realization_ws->DCM_fbi,$realization_ws->month)/12*$realization_ws->month;
		$iptdata['MA_vol']= $this->count_sum($target_ws->MA_vol,$realization_ws->MA_vol,$realization_ws->month);
		$iptdata['MA_inc']= $this->count_sum($target_ws->MA_fbi,$realization_ws->MA_fbi,$realization_ws->month)/12*$realization_ws->month;
		
		$iptdata['LMF'] = $this->count_sum($target_ws->IL_fbi+$target_ws->WCL_fbi,$realization_ws->IL_fbi+$realization_ws->WCL_fbi, $realization_ws->month)/12*$realization_ws->month;
		$iptdata['SF'] = $this->count_sum($target_ws->SL_fbi,$realization_ws->SL_fbi, $realization_ws->month)/12*$realization_ws->month;
		
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
		$iptdata['OW_inc']= $this->count_sum_value($realization_ws->OW_fbi,$realization_ws->month);
		$iptdata['ECM_vol']= $this->count_sum_value($realization_ws->ECM_vol,$realization_ws->month);
		$iptdata['ECM_inc']= $this->count_sum_value($realization_ws->ECM_fbi,$realization_ws->month);
		$iptdata['DCM_vol']= $this->count_sum_value($realization_ws->DCM_vol,$realization_ws->month);
		$iptdata['DCM_inc']= $this->count_sum_value($realization_ws->DCM_fbi,$realization_ws->month);
		$iptdata['MA_vol']= $this->count_sum_value($realization_ws->MA_vol,$realization_ws->month);
		$iptdata['MA_inc']= $this->count_sum_value($realization_ws->MA_fbi,$realization_ws->month);
		
		$iptdata['LMF'] = $this->count_sum_value($realization_ws->IL_fbi+$realization_ws->WCL_fbi, $realization_ws->month);
		$iptdata['SF'] = $this->count_sum_value($realization_ws->SL_fbi, $realization_ws->month);
		
		return $iptdata;
    }
    
    private function determine_target($target){
    	if($target){return 100;}
    	else{return 0;}
    }
    
}
