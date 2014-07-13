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
class Manchor extends CI_Model {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    //INSERT or CREATE FUNCTION
    
    function insert_anchor($anchor){
    	if($this->db->insert('anchor', $anchor)){
    		$result = $this->db->query('SELECT MAX(id) as id FROM anchor');
        	if($result->num_rows>0){return $result->row(0)->id;}
            else{return false;}
    	}
    }
    
    function insert_company($company){
    	if($this->db->insert('company', $company)){
    		$result = $this->db->query('SELECT MAX(id) as id FROM company');
        	if($result->num_rows>0){return $result->row(0)->id;}
            else{return false;}
    	}
    }
    
    function insert_ws($iptdata, $kind){ 
    	return $this->db->insert('wholesale_'.$kind, $iptdata);
    }
    
    function insert_al($iptdata, $kind){ 
    	return $this->db->insert('alliance_'.$kind, $iptdata);
    }
    
    
    //GET FUNCTION
    
    /*Anchor Function*/
    function get_anchor_id($name,$group){
    	$this->db->where('name',$name);
    	//$this->db->where('group',$group);
    	
    	$result = $this->db->get('anchor');
        if($result->num_rows>0){return $result->row(0)->id;}
        else{return false;}
    }
    
    function get_anchor_ws_target($anchor_id){
    	$this->db->where('anchor_id',$anchor_id);
    	$result = $this->db->get('wholesale_target');
    	$query = $result->result();
        return $query[0];
    }
    
    function get_anchor_ws_realization($anchor_id, $month, $year){
    	$this->db->where('anchor_id',$anchor_id);
    	$this->db->where('month',$month);
    	$this->db->where('year',$year);
    	$result = $this->db->get('wholesale_realization');
    	$query = $result->result();
        return $query[0];
    }
    
    function get_anchor_al_target($anchor_id){
    	$this->db->where('anchor_id',$anchor_id);
    	$result = $this->db->get('alliance_target');
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
    
    function get_anchor_by_id($anchor_id){
    	$this->db->where('id',$anchor_id);
    	$result = $this->db->get('anchor');
    	$query = $result->result();
        return $query[0];
    }
    
    function get_anchor_by_direktorat($direktorat){
    	if($direktorat == 'corporate'){
    		$this->db->where('group', 'CORPORATE BANKING AGRO BASED');
    		$this->db->or_where('group', 'CORPORATE BANKING I');
    		$this->db->or_where('group', 'CORPORATE BANKING II');
    		$this->db->or_where('group', 'CORPORATE BANKING III');
    		$this->db->or_where('group', 'SYNDICATION, OIL & GAS');
    	}
    	elseif($direktorat == 'institutional'){
    		$this->db->where('group', 'INSTITUTIONAL BANKING I');
    		$this->db->or_where('group', 'INSTITUTIONAL BANKING II');
    	}
    	else{
    		$this->db->where('group', 'JAKARTA COMMERCIAL SALES');
    		$this->db->or_where('group', 'REGIONAL COMMERCIAL SALES I');
    		$this->db->or_where('group', 'REGIONAL COMMERCIAL SALES II');
    	}
    	$this->db->order_by('group','asc');
    	$this->db->order_by('name','asc');
    	$result = $this->db->get('anchor');
    	return $result->result();	
    }
    
    /*Bank Wide Function*/
    function get_total_vol_prd($product, $month, $year){
    	$this->db->select_sum($product.'_vol');
    	$this->db->where('month',$month);
    	$this->db->where('year',$year);
    	$result = $this->db->get('wholesale_realization');
    	$query = $result->result();
        return $query[0];
    }
    
    function get_top_anchor_prd($product, $month, $year){
    	$this->db->select('ws_main.'.$product.'_vol as '.$product.'_vol, ws_main.month as month, ws_main.year as year, anchor.name, ws_ly.'.$product.'_vol as '.$product.'_vol_ly, wholesale_target.'.$product.'_vol as '.$product.'_vol_target');
    	$this->db->join('anchor', 'anchor.id = ws_main.anchor_id');
    	$this->db->join('wholesale_realization as ws_ly', 'anchor.id = ws_ly.anchor_id');
    	$this->db->join('wholesale_target', 'anchor.id = wholesale_target.anchor_id');
    	$this->db->where('ws_main.month',$month);
    	$this->db->where('ws_main.year',$year);
    	$this->db->where('wholesale_target.year',$year);
    	$this->db->where('ws_ly.month',12);
    	$this->db->where('ws_ly.year',2013);
    	$this->db->order_by('ws_main.'.$product.'_vol', 'desc');
    	$result = $this->db->get('wholesale_realization as ws_main');
    	return $result->result();
    }
    
    function get_top_anchor_prd_grw($product, $month, $year){
    	$this->db->select('((ws_main.'.$product.'_vol/'.$month.'*12) - ws_ly.'.$product.'_vol)/ ws_ly.'.$product.'_vol as grow, ws_main.'.$product.'_vol as '.$product.'_vol, ws_main.month as month, ws_main.year as year, anchor.name, ws_ly.'.$product.'_vol as '.$product.'_vol_ly, wholesale_target.'.$product.'_vol as '.$product.'_vol_target');
    	$this->db->join('anchor', 'anchor.id = ws_main.anchor_id');
    	$this->db->join('wholesale_realization as ws_ly', 'anchor.id = ws_ly.anchor_id');
    	$this->db->join('wholesale_target', 'anchor.id = wholesale_target.anchor_id');
    	$this->db->where('ws_main.month',$month);
    	$this->db->where('ws_main.year',$year);
    	$this->db->where('wholesale_target.year',$year);
    	$this->db->where('ws_ly.month',12);
    	$this->db->where('ws_ly.year',2013);
    	$this->db->order_by('grow', 'desc');
    	$this->db->limit(5);
    	$result = $this->db->get('wholesale_realization as ws_main');
    	return $result->result();
    }
    
    function get_top_anchor_prd_nml_grw($product, $month, $year){
    	$this->db->select('(ws_main.'.$product.'_vol/'.$month.'*12) - ws_ly.'.$product.'_vol as nom_grow, ws_main.'.$product.'_vol as '.$product.'_vol, ws_main.month as month, ws_main.year as year, anchor.name, ws_ly.'.$product.'_vol as '.$product.'_vol_ly, wholesale_target.'.$product.'_vol as '.$product.'_vol_target');
    	$this->db->join('anchor', 'anchor.id = ws_main.anchor_id');
    	$this->db->join('wholesale_realization as ws_ly', 'anchor.id = ws_ly.anchor_id');
    	$this->db->join('wholesale_target', 'anchor.id = wholesale_target.anchor_id');
    	$this->db->where('ws_main.month',$month);
    	$this->db->where('ws_main.year',$year);
    	$this->db->where('wholesale_target.year',$year);
    	$this->db->where('ws_ly.month',12);
    	$this->db->where('ws_ly.year',2013);
    	$this->db->order_by('nom_grow', 'desc');
    	$this->db->limit(5);
    	$result = $this->db->get('wholesale_realization as ws_main');
    	return $result->result();
    } 
    
    function get_product_name_by_inisial($inisial){
    	$name = '';
    	if($inisial == 'FX'){$name = 'FX & Derivatives';}
    	elseif($inisial == 'CASA'){$name = 'CASA';}
    	elseif($inisial == 'TD'){$name = 'Time Deposit';}
    	elseif($inisial == 'BG'){$name = 'Bank Guarantee';}
    	elseif($inisial == 'Trade'){$name = 'Trade Services';}
    	elseif($inisial == 'WCL'){$name = 'Working Capital Loan';}
    	elseif($inisial == 'IL'){$name = 'Investment Loan';}
    	
    	return $name;
    }
    
    /*Wallet Function*/
    function get_anchor_ws_wallet($anchor_id, $year){
    	$this->db->where('anchor_id',$anchor_id);
    	$this->db->where('year',$year);
    	$result = $this->db->get('wholesale_wallet_size');
    	$query = $result->result();
        return $query[0];
    }
    
    function get_anchor_al_wallet($anchor_id, $year){
    	$this->db->where('anchor_id',$anchor_id);
    	$this->db->where('year',$year);
    	$result = $this->db->get('alliance_wallet_size');
    	$query = $result->result();
        return $query[0];
    }
}
