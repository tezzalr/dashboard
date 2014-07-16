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
    		$this->db->where('group', 'INSTITUTIONAL BANKING I');
    		$this->db->or_where('group', 'INSTITUTIONAL BANKING II');
    	}
    	else{
    		$this->db->where('group', 'JAKARTA COMMERCIAL SALES');
    		$this->db->or_where('group', 'REGIONAL COMMERCIAL SALES I');
    		$this->db->or_where('group', 'REGIONAL COMMERCIAL SALES II');
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
    	}
    }
}