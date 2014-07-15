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
}
