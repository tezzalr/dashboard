<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of admins
 *
 * @author Maulnick
 */
class Mrealization extends CI_Model {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    //INSERT or CREATE FUNCTION
        
    
    //GET FUNCTION
    
    /*Anchor Function*/
    
    function get_anchor_ws_realization($anchor_id, $year){
    	$month = $this->session->userdata('rptmth');
    	$this->db->where('anchor_id',$anchor_id);
    	$this->db->where('month',$month);
    	$this->db->where('year',$year);
    	$result = $this->db->get('wholesale_realization');
    	$query = $result->result();
        if($query){
        	return $query[0];
        }
    }
    
    function get_anchor_al_realization($anchor_id, $year){
    	$month = $this->session->userdata('rptmth');
    	$this->db->where('anchor_id',$anchor_id);
    	$this->db->where('month',$month);
    	$this->db->where('year',$year);
    	$result = $this->db->get('alliance_realization');
    	$query = $result->result();
        if($query){
        	return $query[0];
        }
    }
    
    function get_anchor_prd_realization_annual($anchor_id, $product, $kind, $year){
    	if($kind == 'volume'){$colom = $product.'_vol';}
    	else{$colom = $product.'_'.$this->get_product_income_type($product);}
    	
    	$db = $this->get_ws_or_al_by_product($product).'_realization';
    	$last_month_data = $this->get_last_month($year);
    	$select_sentence = '';
    	for($i=1;$i<=$last_month_data;$i++)
    	{$select_sentence = $select_sentence.'mth_'.$i.'.'.$colom.' as mth_'.$i.', ';}
    	$this->db->select($select_sentence);
    	$this->db->join('anchor', 'anchor.id = mth_'.$last_month_data.'.anchor_id');
    	for($i=1;$i<$last_month_data;$i++){
    		$this->db->join($db.' as mth_'.$i, 'anchor.id = mth_'.$i.'.anchor_id');
    		$this->db->where('mth_'.$i.'.month',$i);
    		$this->db->where('mth_'.$i.'.year',$year);
    	}
    	$this->db->where('mth_'.$last_month_data.'.month',$last_month_data);
    	$this->db->where('mth_'.$last_month_data.'.year',$year);
    	$this->db->where('anchor.id',$anchor_id);
    	$result = $this->db->get($db.' as mth_'.$last_month_data);
    	$query = $result->result();
        return $query[0];
    }
    
    
    function get_anchor_total_income($anchor_id, $year){
    	$month = $this->session->userdata('rptmth');
    	$ws_realization = $this->get_anchor_ws_realization($anchor_id, $year);
    	$al_realization = $this->get_anchor_al_realization($anchor_id, $year);
    	
		return get_tot_income($ws_realization, $al_realization, $month, 9);
    }
    
    function get_product_income_type($product){
    	$prod_nii = array("CASA", "TD", "IL", "SL", "WCL", "TR", "WM");
    	$prod_fbi = array("FX", "SCF", "Trade", "PWE", "BG", "OIR", "OW", "ECM", "DCM", "MA");
    	if(in_array($product, $prod_nii)){return 'nii';}
    	elseif(in_array($product, $prod_fbi)){return 'fbi';}
    }
    
    function get_ws_or_al_by_product($product){
    	$ws = array("CASA", "TD", "IL", "SL", "WCL", "TR", "FX", "SCF", "Trade", "PWE", "BG", "OIR", "OW", "ECM", "DCM", "MA");
    	$al = array("WM", "DPLK", "PCD");
    	if(in_array($product, $ws)){return 'wholesale';}
    	elseif(in_array($product, $al)){return 'alliance';}
    }
    
    function get_anchor_last_month($anchor_id, $db, $year){
    	$result = $this->db->query('SELECT MAX(month) as month FROM '.$db.' WHERE anchor_id = '.$anchor_id.' AND year = '.$year);
    	return $result->row(0)->month;
    }
    
    function get_last_month($year){
    	$result = $this->db->query('SELECT MAX(month) as month FROM wholesale_realization WHERE year = '.$year);
    	return $result->row(0)->month;
    }
    
    /*Directorate Function*/
    function get_directorate_realization($direktorat, $year, $type){
    	$month = $this->session->userdata('rptmth');
    	$db = $type.'_realization';
    	get_type_select_month($type,$this);
    	get_direktorat_where($direktorat,$this);
    	$this->db->join('anchor', 'anchor.id = '.$db.'.anchor_id');
    	$this->db->where('month',$month);
    	$this->db->where('year',$year);
    	$result = $this->db->get($db);
    	$query = $result->result();
        return $query[0];
    }
    
    function get_directorate_realization_w_month($direktorat, $year, $type,$month){
    	$db = $type.'_realization';
    	get_type_select_month($type,$this);
    	get_direktorat_where($direktorat,$this);
    	$this->db->join('anchor', 'anchor.id = '.$db.'.anchor_id');
    	$this->db->where('month',$month);
    	$this->db->where('year',$year);
    	$result = $this->db->get($db);
    	$query = $result->result();
        return $query[0];
    }
    
    function get_dir_prd_realization_annual($product, $kind, $year, $direktorat){
    	if($kind == 'volume'){$colom = $product.'_vol';}
    	else{$colom = $product.'_'.$this->get_product_income_type($product);}
    	
    	$db = $this->get_ws_or_al_by_product($product).'_realization';
    	$last_month_data = $this->get_last_month($year);
    	$select_sentence = '';
    	for($i=1;$i<=$last_month_data;$i++)
    	{$select_sentence = $select_sentence.'SUM(mth_'.$i.'.'.$colom.') as mth_'.$i.', ';}
    	$this->db->select($select_sentence.', group');
    	$this->db->join('anchor', 'anchor.id = mth_'.$last_month_data.'.anchor_id');
    	for($i=1;$i<$last_month_data;$i++){
    		$this->db->join($db.' as mth_'.$i, 'anchor.id = mth_'.$i.'.anchor_id');
    		$this->db->where('mth_'.$i.'.month',$i);
    		$this->db->where('mth_'.$i.'.year',$year);
    	}
    	$this->db->where('mth_'.$last_month_data.'.month',$last_month_data);
    	$this->db->where('mth_'.$last_month_data.'.year',$year);
    	get_direktorat_where($direktorat,$this);
    	$result = $this->db->get($db.' as mth_'.$last_month_data);
    	$query = $result->result();
        return $query[0];
    }
    
    function get_directorate_total_income($direktorat, $year){
    	$month = $this->session->userdata('rptmth');
    	$ws_realization = $this->get_directorate_realization($direktorat, $year, 'wholesale');
    	$al_realization = $this->get_directorate_realization($direktorat, $year, 'alliance');
    	
		return get_tot_income($ws_realization, $al_realization, $month, 9);
    }
    
    /*Shared Function*/
    
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
    
    function count_realization($target_ws, $realization_ws){
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
		$iptdata['PWE_vol']= $this->count_sum($target_ws->PWE_vol,$realization_ws->PWE_vol,$realization_ws->month)*1000; if(!$target_ws->PWE_vol){$iptdata['PWE_vol']=$iptdata['PWE_vol']/1000;}
		$iptdata['PWE_inc']= $this->count_sum($target_ws->PWE_fbi,$realization_ws->PWE_fbi,$realization_ws->month);
		$iptdata['TR_vol']= $this->count_sum($target_ws->TR_vol,$realization_ws->TR_vol,$realization_ws->month);
		$iptdata['TR_inc']= $this->count_sum($target_ws->TR_nii,$realization_ws->TR_nii,$realization_ws->month);
		$iptdata['BG_vol']= $this->count_sum($target_ws->BG_vol,$realization_ws->BG_vol,$realization_ws->month);
		$iptdata['BG_inc']= $this->count_sum($target_ws->BG_fbi,$realization_ws->BG_fbi,$realization_ws->month);
		$iptdata['OIR_vol']= $this->count_sum($target_ws->OIR_vol,$realization_ws->OIR_vol,$realization_ws->month)*pow(10,9); if(!$target_ws->OIR_vol){$iptdata['OIR_vol']=$iptdata['OIR_vol']/pow(10,9);}
		$iptdata['OIR_inc']= $this->count_sum($target_ws->OIR_fbi,$realization_ws->OIR_fbi,$realization_ws->month);
		$iptdata['OW_nii_inc']= $this->count_sum($target_ws->OW_nii,$realization_ws->OW_nii,$realization_ws->month);
		$iptdata['OW_fbi_inc']= $this->count_sum($target_ws->OW_fbi+$target_ws->CASA_fbi,$realization_ws->OW_fbi+$realization_ws->CASA_fbi,$realization_ws->month);
		$iptdata['ECM_vol']= $this->count_avgbal($target_ws->ECM_vol,$realization_ws->ECM_vol,$realization_ws->month);
		$iptdata['ECM_inc']= $this->count_sum($target_ws->ECM_fbi,$realization_ws->ECM_fbi,$realization_ws->month)/12*$realization_ws->month;
		$iptdata['DCM_vol']= $this->count_avgbal($target_ws->DCM_vol,$realization_ws->DCM_vol,$realization_ws->month);
		$iptdata['DCM_inc']= $this->count_sum($target_ws->DCM_fbi,$realization_ws->DCM_fbi,$realization_ws->month)/12*$realization_ws->month;
		$iptdata['MA_vol']= $this->count_sum($target_ws->MA_vol,$realization_ws->MA_vol,$realization_ws->month);
		$iptdata['MA_inc']= $this->count_sum($target_ws->MA_fbi,$realization_ws->MA_fbi,$realization_ws->month)/12*$realization_ws->month;
		
		$iptdata['LMF_inc'] = $this->count_sum($target_ws->IL_fbi+$target_ws->WCL_fbi,$realization_ws->IL_fbi+$realization_ws->WCL_fbi, $realization_ws->month)/12*$realization_ws->month;
		$iptdata['SF_inc'] = $this->count_sum($target_ws->SL_fbi,$realization_ws->SL_fbi, $realization_ws->month)/12*$realization_ws->month;
		
		return $iptdata;
    }
    
    function count_realization_now($realization_ws){
		$iptdata['CASA_vol']= $realization_ws->CASA_vol;
		$iptdata['CASA_inc']=  $realization_ws->CASA_nii;
		$iptdata['TD_vol']= $realization_ws->TD_vol;
		$iptdata['TD_inc']= $realization_ws->TD_nii;
		$iptdata['WCL_vol']= $realization_ws->WCL_vol;
		$iptdata['WCL_inc']= $realization_ws->WCL_nii;
		$iptdata['IL_vol']= $realization_ws->IL_vol;
		$iptdata['IL_inc']= $realization_ws->IL_nii;
		$iptdata['SL_vol']= $realization_ws->SL_vol;
		$iptdata['SL_inc']= $realization_ws->SL_nii;
		$iptdata['FX_vol']= $realization_ws->FX_vol*1000;
		$iptdata['FX_inc']= $realization_ws->FX_fbi;
		$iptdata['SCF_vol']= $realization_ws->SCF_vol;
		$iptdata['SCF_inc']= $realization_ws->SCF_fbi;
		$iptdata['Trade_vol']= $realization_ws->Trade_vol*1000;
		$iptdata['Trade_inc']= $realization_ws->Trade_fbi;
		$iptdata['PWE_vol']= $realization_ws->PWE_vol*1000;
		$iptdata['PWE_inc']= $realization_ws->PWE_fbi;
		$iptdata['TR_vol']= $realization_ws->TR_vol;
		$iptdata['TR_inc']= $realization_ws->TR_nii;
		$iptdata['BG_vol']= $realization_ws->BG_vol;
		$iptdata['BG_inc']= $realization_ws->BG_fbi;
		$iptdata['OIR_vol']= $realization_ws->OIR_vol*pow(10,9);
		$iptdata['OIR_inc']= $realization_ws->OIR_fbi;
		$iptdata['OW_nii_inc']= $realization_ws->OW_nii;
		$iptdata['OW_fbi_inc']= $realization_ws->OW_fbi+$realization_ws->CASA_fbi;
		$iptdata['ECM_vol']= $realization_ws->ECM_vol;
		$iptdata['ECM_inc']= $realization_ws->ECM_fbi;
		$iptdata['DCM_vol']= $realization_ws->DCM_vol;
		$iptdata['DCM_inc']= $realization_ws->DCM_fbi;
		$iptdata['MA_vol']= $realization_ws->MA_vol;
		$iptdata['MA_inc']= $realization_ws->MA_fbi;
		
		$iptdata['LMF_inc'] = $realization_ws->IL_fbi+$realization_ws->WCL_fbi;
		$iptdata['SF_inc'] = $realization_ws->SL_fbi;
		
		return $iptdata;
    }
    
    function count_realization_value($realization_ws, $month){
		$iptdata['CASA_vol']= $this->count_avgbal_value($realization_ws->CASA_vol);
		$iptdata['CASA_inc']=  $this->count_sum_value($realization_ws->CASA_nii, $realization_ws->month);
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
		$iptdata['PWE_vol']= $this->count_sum_value($realization_ws->PWE_vol,$realization_ws->month)*1000;
		$iptdata['PWE_inc']= $this->count_sum_value($realization_ws->PWE_fbi,$realization_ws->month);
		$iptdata['TR_vol']= $this->count_sum_value($realization_ws->TR_vol,$realization_ws->month);
		$iptdata['TR_inc']= $this->count_sum_value($realization_ws->TR_nii,$realization_ws->month);
		$iptdata['BG_vol']= $this->count_sum_value($realization_ws->BG_vol,$realization_ws->month);
		$iptdata['BG_inc']= $this->count_sum_value($realization_ws->BG_fbi,$realization_ws->month);
		$iptdata['OIR_vol']= $this->count_sum_value($realization_ws->OIR_vol,$realization_ws->month)*pow(10,9);
		$iptdata['OIR_inc']= $this->count_sum_value($realization_ws->OIR_fbi,$realization_ws->month);
		$iptdata['OW_nii_inc']= $this->count_sum_value($realization_ws->OW_nii,$realization_ws->month);
		$iptdata['OW_fbi_inc']= $this->count_sum_value($realization_ws->OW_fbi+$realization_ws->CASA_fbi,$realization_ws->month);
		$iptdata['ECM_vol']= $this->count_avgbal_value($realization_ws->ECM_vol,$realization_ws->month);
		$iptdata['ECM_inc']= $this->count_sum_value($realization_ws->ECM_fbi,$realization_ws->month);
		$iptdata['DCM_vol']= $this->count_avgbal_value($realization_ws->DCM_vol,$realization_ws->month);
		$iptdata['DCM_inc']= $this->count_sum_value($realization_ws->DCM_fbi,$realization_ws->month);
		$iptdata['MA_vol']= $this->count_sum_value($realization_ws->MA_vol,$realization_ws->month);
		$iptdata['MA_inc']= $this->count_sum_value($realization_ws->MA_fbi,$realization_ws->month);
		
		$iptdata['LMF_inc'] = $this->count_avgbal_value($realization_ws->IL_fbi+$realization_ws->WCL_fbi, $realization_ws->month);
		$iptdata['SF_inc'] = $this->count_avgbal_value($realization_ws->SL_fbi, $realization_ws->month);
		
		return $iptdata;
    }
    
    function count_realization_al($target_al, $realization_al){
		$iptdata['WM_vol']= $this->count_avgbal($target_al->WM_vol,$realization_al->WM_vol);
		$iptdata['WM_inc']=  $this->count_sum($target_al->WM_nii,$realization_al->WM_nii, $realization_al->month);
		$iptdata['DPLK_vol']= $this->count_avgbal($target_al->DPLK_vol,$realization_al->DPLK_vol);
		$iptdata['DPLK_inc']= $this->count_sum($target_al->DPLK_nii,$realization_al->DPLK_nii, $realization_al->month);
		$iptdata['PCD_vol']= $this->count_avgbal($target_al->PCD_vol,$realization_al->PCD_vol);
		$iptdata['PCD_inc']= $this->count_sum($target_al->PCD_nii,$realization_al->PCD_nii, $realization_al->month);
		$iptdata['VCCD_vol']= $this->count_avgbal($target_al->VCCD_vol,$realization_al->VCCD_vol);
		$iptdata['VCCD_inc']= $this->count_sum($target_al->VCCD_nii,$realization_al->VCCD_nii, $realization_al->month);
		$iptdata['VCL_vol']= $this->count_avgbal($target_al->VCL_vol,$realization_al->VCL_vol);
		$iptdata['VCL_inc']= $this->count_sum($target_al->VCL_nii,$realization_al->VCL_nii, $realization_al->month);
		$iptdata['Micro_Loan_vol']= $this->count_sum($target_al->Micro_Loan_vol,$realization_al->Micro_Loan_vol,$realization_al->month)*1000; if(!$target_al->Micro_Loan_vol){$iptdata['Micro_Loan_vol']=$iptdata['Micro_Loan_vol']/1000;}
		$iptdata['Micro_Loan_inc']= $this->count_sum($target_al->Micro_Loan_fbi,$realization_al->Micro_Loan_fbi,$realization_al->month);
		$iptdata['MKM_vol']= $this->count_sum($target_al->MKM_vol,$realization_al->MKM_vol,$realization_al->month);
		$iptdata['MKM_inc']= $this->count_sum($target_al->MKM_fbi,$realization_al->MKM_fbi,$realization_al->month);
		$iptdata['KPR_vol']= $this->count_sum($target_al->KPR_vol,$realization_al->KPR_vol,$realization_al->month)*1000; if(!$target_al->KPR_vol){$iptdata['KPR_vol']=$iptdata['KPR_vol']/1000;}
		$iptdata['KPR_inc']= $this->count_sum($target_al->KPR_fbi,$realization_al->KPR_fbi,$realization_al->month);
		$iptdata['Auto_vol']= $this->count_sum($target_al->Auto_vol,$realization_al->Auto_vol,$realization_al->month)*1000; if(!$target_al->Auto_vol){$iptdata['Auto_vol']=$iptdata['Auto_vol']/1000;}
		$iptdata['Auto_inc']= $this->count_sum($target_al->Auto_fbi,$realization_al->Auto_fbi,$realization_al->month);
		$iptdata['CC_vol']= $this->count_sum($target_al->CC_vol,$realization_al->CC_vol,$realization_al->month);
		$iptdata['CC_inc']= $this->count_sum($target_al->CC_nii,$realization_al->CC_nii,$realization_al->month);
		$iptdata['EDC_vol']= $this->count_sum($target_al->EDC_vol,$realization_al->EDC_vol,$realization_al->month);
		$iptdata['EDC_inc']= $this->count_sum($target_al->EDC_fbi,$realization_al->EDC_fbi,$realization_al->month);
		$iptdata['ATM_vol']= $this->count_sum($target_al->ATM_vol,$realization_al->ATM_vol,$realization_al->month)*pow(10,9); if(!$target_al->ATM_vol){$iptdata['ATM_vol']=$iptdata['ATM_vol']/pow(10,9);}
		$iptdata['ATM_inc']= $this->count_sum($target_al->ATM_fbi,$realization_al->ATM_fbi,$realization_al->month);
		$iptdata['AXA_vol']= $this->count_avgbal($target_al->AXA_vol,$realization_al->AXA_vol,$realization_al->month);
		$iptdata['AXA_inc']= $this->count_sum($target_al->AXA_fbi,$realization_al->AXA_fbi,$realization_al->month)/12*$realization_al->month;
		$iptdata['MAGI_vol']= $this->count_avgbal($target_al->retailGI_vol,$realization_al->retailGI_vol,$realization_al->month);
		$iptdata['MAGI_inc']= $this->count_sum($target_al->retailGI_fbi,$realization_al->retailGI_fbi,$realization_al->month)/12*$realization_al->month;
		$iptdata['retail_vol']= $this->count_sum($target_al->retail_vol,$realization_al->retail_vol,$realization_al->month);
		$iptdata['retail_inc']= $this->count_sum($target_al->retail_fbi,$realization_al->retail_fbi,$realization_al->month)/12*$realization_al->month;
		$iptdata['cicil_Emas_vol']= $this->count_sum($target_al->retail_vol,$realization_al->retail_vol,$realization_al->month);
		$iptdata['cicil_Emas_inc']= $this->count_sum($target_al->retail_fbi,$realization_al->retail_fbi,$realization_al->month)/12*$realization_al->month;
		return $iptdata;
    }
}
