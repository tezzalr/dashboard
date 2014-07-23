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
    
    function get_anchor_ws_realization($anchor_id, $month, $year){
    	$this->db->where('anchor_id',$anchor_id);
    	$this->db->where('month',$month);
    	$this->db->where('year',$year);
    	$result = $this->db->get('wholesale_realization');
    	$query = $result->result();
        return $query[0];
    }
    
    function get_anchor_al_realization($anchor_id, $month, $year){
    	$this->db->where('anchor_id',$anchor_id);
    	$this->db->where('month',$month);
    	$this->db->where('year',$year);
    	$result = $this->db->get('alliance_realization');
    	$query = $result->result();
        return $query[0];
    }
    
    function get_anchor_prd_realization_annual($anchor_id, $product, $kind, $year, $last_month){
    	if($kind == 'volume'){$colom = $product.'_vol';}
    	else{$colom = $product.'_'.$this->get_product_income_type($product);}
    	
    	$db = $this->get_ws_or_ol_by_product($product).'_realization';
    	$last_month_data = $this->get_anchor_last_month($anchor_id, $db, $year);
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
    
    function get_product_income_type($product){
    	$prod_nii = array("CASA", "TD", "IL", "SL", "WCL", "TR");
    	$prod_fbi = array("FX", "SCF", "Trade", "PWE", "BG", "OIR", "OW", "ECM", "DCM", "MA");
    	if(in_array($product, $prod_nii)){return 'nii';}
    	elseif(in_array($product, $prod_fbi)){return 'fbi';}
    }
    
    function get_ws_or_ol_by_product($product){
    	$ws = array("CASA", "TD", "IL", "SL", "WCL", "TR", "FX", "SCF", "Trade", "PWE", "BG", "OIR", "OW", "ECM", "DCM", "MA");
    	$al = array("WM, DPLK, PCD");
    	if(in_array($product, $ws)){return 'wholesale';}
    	elseif(in_array($product, $al)){return 'alliance';}
    }
    
    function get_anchor_last_month($anchor_id, $db, $year){
    	$result = $this->db->query('SELECT MAX(month) as month FROM '.$db.' WHERE anchor_id = '.$anchor_id.' AND year = '.$year);
    	return $result->row(0)->month;
    }
    
    /*Directorate Function*/
    function get_directorate_realization($direktorat, $month, $year, $type){
    	$db = $type.'_realization';
    	$this->get_type_select($type);
    	$this->get_direktorat_where($direktorat);
    	$this->db->join('anchor', 'anchor.id = '.$db.'.anchor_id');
    	$this->db->where('month',$month);
    	$this->db->where('year',$year);
    	$result = $this->db->get($db);
    	$query = $result->result();
        return $query[0];
    }
    
    function get_direktorat_where($direktorat){
    	if($direktorat == 'CB'){
    		$this->db->where("(`group` = 'CORPORATE BANKING AGRO BASED' OR `group` = 'CORPORATE BANKING I' OR `group` = 'CORPORATE BANKING II' OR `group` = 'CORPORATE BANKING III' OR `group` = 'SYNDICATION, OIL & GAS')");
    	}
    	elseif($direktorat == 'IB'){
    		$this->db->where("(`group` = 'INSTITUTIONAL BANKING I' OR `group` = 'INSTITUTIONAL BANKING II')");
    	}
    	else{
    		$this->db->where("(`group` = 'JAKARTA COMMERCIAL SALES' OR `group` = 'REGIONAL COMMERCIAL SALES I' OR `group` = 'REGIONAL COMMERCIAL SALES II' )");
    	}
    }
    
    function get_type_select($type){
    	if($type == 'wholesale'){
    		$this->db->select('month, SUM(CASA_vol) as CASA_vol,
								SUM(CASA_nii) as CASA_nii,
								SUM(CASA_fbi) as CASA_fbi,
								SUM(TD_vol) as TD_vol,
								SUM(TD_nii) as TD_nii,
								SUM(WCL_vol) as WCL_vol,
								SUM(WCL_nii) as WCL_nii,
								SUM(WCL_fbi) as WCL_fbi,
								SUM(IL_vol) as IL_vol,
								SUM(IL_nii) as IL_nii,
								SUM(IL_fbi) as IL_fbi,
								SUM(SL_vol) as SL_vol,
								SUM(SL_nii) as SL_nii,
								SUM(SL_fbi) as SL_fbi,
								SUM(FX_vol) as FX_vol,
								SUM(FX_fbi) as FX_fbi,
								SUM(SCF_vol) as SCF_vol,
								SUM(SCF_fbi) as SCF_fbi,
								SUM(Trade_vol) as Trade_vol,
								SUM(Trade_fbi) as Trade_fbi,
								SUM(PWE_vol) as PWE_vol,
								SUM(PWE_fbi) as PWE_fbi,
								SUM(TR_vol) as TR_vol,
								SUM(TR_nii) as TR_nii,
								SUM(BG_vol) as BG_vol,
								SUM(BG_fbi) as BG_fbi,
								SUM(OIR_vol) as OIR_vol,
								SUM(OIR_fbi) as OIR_fbi,
								SUM(OW_vol) as OW_vol,
								SUM(OW_nii) as OW_nii,
								SUM(OW_fbi) as OW_fbi,
								SUM(ECM_vol) as ECM_vol,
								SUM(ECM_fbi) as ECM_fbi,
								SUM(DCM_vol) as DCM_vol,
								SUM(DCM_fbi) as DCM_fbi,
								SUM(MA_vol) as MA_vol,
								SUM(MA_fbi) as MA_fbi,');
    	}else{
    		$this->db->select('month, SUM(WM_vol) as WM_vol,
								SUM(WM_nii) as WM_nii,
								SUM(DPLK_vol) as DPLK_vol,
								SUM(DPLK_fbi) as DPLK_fbi,
								SUM(PCD_vol) as PCD_vol,
								SUM(PCD_nii) as PCD_nii,
								SUM(VCCD_vol) as VCCD_vol,
								SUM(VCCD_nii) as VCCD_nii,
								SUM(VCCD_fbi) as VCCD_fbi,
								SUM(VCL_vol) as VCL_vol,
								SUM(VCL_nii) as VCL_nii,
								SUM(VCL_fbi) as VCL_fbi,
								SUM(VCLnDF_vol) as VCLnDF_vol,
								SUM(VCLnDF_nii) as VCLnDF_nii,
								SUM(VCLnDF_fbi) as VCLnDF_fbi,
								SUM(Micro_Loan_vol) as Micro_Loan_vol,
								SUM(Micro_Loan_nii) as Micro_Loan_nii,
								SUM(Micro_Loan_fbi) as Micro_Loan_fbi,
								SUM(MKM_vol) as MKM_vol,
								SUM(MKM_nii) as MKM_nii,
								SUM(KPR_vol) as KPR_vol,
								SUM(KPR_nii) as KPR_nii,
								SUM(Auto_vol) as Auto_vol,
								SUM(Auto_nii) as Auto_nii,
								SUM(CC_vol) as CC_vol,
								SUM(CC_nii) as CC_nii,
								SUM(EDC_vol) as EDC_vol,
								SUM(EDC_fbi) as EDC_fbi,
								SUM(ATM_vol) as ATM_vol,
								SUM(ATM_fbi) as ATM_fbi,
								SUM(AXA_vol) as AXA_vol,
								SUM(AXA_fbi) as AXA_fbi,
								SUM(MAGI_vol) as MAGI_vol,
								SUM(MAGI_fbi) as MAGI_fbi,
								SUM(retail_vol) as retail_vol,
								SUM(retail_fbi) as retail_fbi,
								SUM(cicil_Emas_vol) as cicil_Emas_vol,
								SUM(cicil_Emas_fbi) as cicil_Emas_fbi,
								SUM(OA_vol) as OA_vol,
								SUM(OA_nii) as OA_nii,
								SUM(OA_fbi) as OA_fbi,');
    	}
    	
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
		$iptdata['PWE_vol']= $this->count_sum($target_ws->PWE_vol,$realization_ws->PWE_vol,$realization_ws->month);
		$iptdata['PWE_inc']= $this->count_sum($target_ws->PWE_fbi,$realization_ws->PWE_fbi,$realization_ws->month);
		$iptdata['TR_vol']= $this->count_sum($target_ws->TR_vol,$realization_ws->TR_vol,$realization_ws->month);
		$iptdata['TR_inc']= $this->count_sum($target_ws->TR_nii,$realization_ws->TR_nii,$realization_ws->month);
		$iptdata['BG_vol']= $this->count_sum($target_ws->BG_vol,$realization_ws->BG_vol,$realization_ws->month);
		$iptdata['BG_inc']= $this->count_sum($target_ws->BG_fbi,$realization_ws->BG_fbi,$realization_ws->month);
		$iptdata['OIR_vol']= $this->count_sum($target_ws->OIR_vol,$realization_ws->OIR_vol,$realization_ws->month)*pow(10,9); if(!$target_ws->OIR_vol){$iptdata['OIR_vol']=$iptdata['OIR_vol']/pow(10,9);}
		$iptdata['OIR_inc']= $this->count_sum($target_ws->OIR_fbi,$realization_ws->OIR_fbi,$realization_ws->month);
		$iptdata['OW_nii_inc']= $this->count_sum($target_ws->OW_nii,$realization_ws->OW_nii,$realization_ws->month);
		$iptdata['OW_fbi_inc']= $this->count_sum($target_ws->OW_fbi+$target_ws->CASA_fbi,$realization_ws->OW_fbi+$realization_ws->CASA_fbi,$realization_ws->month);
		$iptdata['ECM_vol']= $this->count_sum($target_ws->ECM_vol,$realization_ws->ECM_vol,$realization_ws->month);
		$iptdata['ECM_inc']= $this->count_sum($target_ws->ECM_fbi,$realization_ws->ECM_fbi,$realization_ws->month)/12*$realization_ws->month;
		$iptdata['DCM_vol']= $this->count_sum($target_ws->DCM_vol,$realization_ws->DCM_vol,$realization_ws->month);
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
		$iptdata['PWE_vol']= $realization_ws->PWE_vol;
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
		$iptdata['PWE_vol']= $this->count_sum_value($realization_ws->PWE_vol,$realization_ws->month);
		$iptdata['PWE_inc']= $this->count_sum_value($realization_ws->PWE_fbi,$realization_ws->month);
		$iptdata['TR_vol']= $this->count_sum_value($realization_ws->TR_vol,$realization_ws->month);
		$iptdata['TR_inc']= $this->count_sum_value($realization_ws->TR_nii,$realization_ws->month);
		$iptdata['BG_vol']= $this->count_sum_value($realization_ws->BG_vol,$realization_ws->month);
		$iptdata['BG_inc']= $this->count_sum_value($realization_ws->BG_fbi,$realization_ws->month);
		$iptdata['OIR_vol']= $this->count_sum_value($realization_ws->OIR_vol,$realization_ws->month)*pow(10,9);
		$iptdata['OIR_inc']= $this->count_sum_value($realization_ws->OIR_fbi,$realization_ws->month);
		$iptdata['OW_nii_inc']= $this->count_sum_value($realization_ws->OW_nii,$realization_ws->month);
		$iptdata['OW_fbi_inc']= $this->count_sum_value($realization_ws->OW_fbi+$realization_ws->CASA_fbi,$realization_ws->month);
		$iptdata['ECM_vol']= $this->count_sum_value($realization_ws->ECM_vol,$realization_ws->month);
		$iptdata['ECM_inc']= $this->count_sum_value($realization_ws->ECM_fbi,$realization_ws->month);
		$iptdata['DCM_vol']= $this->count_sum_value($realization_ws->DCM_vol,$realization_ws->month);
		$iptdata['DCM_inc']= $this->count_sum_value($realization_ws->DCM_fbi,$realization_ws->month);
		$iptdata['MA_vol']= $this->count_sum_value($realization_ws->MA_vol,$realization_ws->month);
		$iptdata['MA_inc']= $this->count_sum_value($realization_ws->MA_fbi,$realization_ws->month);
		
		$iptdata['LMF_inc'] = $this->count_sum_value($realization_ws->IL_fbi+$realization_ws->WCL_fbi, $realization_ws->month);
		$iptdata['SF_inc'] = $this->count_sum_value($realization_ws->SL_fbi, $realization_ws->month);
		
		return $iptdata;
    }
}
