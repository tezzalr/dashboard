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
    
    function insert_detail($iptdata){
    	return $this->db->insert('detail_realization', $iptdata);
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
        
    function get_anchor_by_id($anchor_id){
    	$this->db->where('id',$anchor_id);
    	$result = $this->db->get('anchor');
    	$query = $result->result();
        return $query[0];
    }
    
    function get_anchor_by_group($group){
    	$this->db->where('group', $group);
    	$this->db->order_by('name','asc');
    	$result = $this->db->get('anchor');
    	return $result->result();
    }
    
    function get_anchor_by_direktorat($direktorat){
    	if($direktorat == 'corporate' || $direktorat == 'CB'){
    		$this->db->where('group', 'CORPORATE BANKING AGRO BASED');
    		$this->db->or_where('group', 'CORPORATE BANKING I');
    		$this->db->or_where('group', 'CORPORATE BANKING II');
    		$this->db->or_where('group', 'CORPORATE BANKING III');
    		$this->db->or_where('group', 'SYNDICATION, OIL & GAS');
    	}
    	elseif($direktorat == 'institutional' || $direktorat == 'IB'){
    		$this->db->where('group', 'INSTITUTIONAL BANKING I');
    		$this->db->or_where('group', 'INSTITUTIONAL BANKING II');
    	}
    	elseif($direktorat == 'commercial' || $direktorat == 'CBB'){
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
    function get_total_vol_prd($product, $month, $year, $db, $dir){
    	$this->db->select_sum($product.'_vol');
    	if($month!=0){$this->db->where('month',$month);}
    	$this->db->where('year',$year);
    	get_direktorat_where($dir,$this);
    	$this->db->join('anchor', 'anchor.id ='.$db.'.anchor_id');
    	$result = $this->db->get($db);
    	$query = $result->result();
        return $query[0];
    }
    
    function get_total_anything($product, $month, $year, $db, $dir){
    	$this->db->select_sum($product);
    	if($month!=0){$this->db->where('month',$month);}
    	$this->db->where('year',$year);
    	get_direktorat_where($dir,$this);
    	$this->db->join('anchor', 'anchor.id ='.$db.'.anchor_id');
    	$result = $this->db->get($db);
    	$query = $result->result();
        return $query[0];
    }
    
    function get_top_anchor_kredit($month, $year){
    	
    	$this->db->select('(ws_main.IL_vol + ws_main.WCL_vol) as kredit_vol, ws_main.month as month, ws_main.year as year, anchor.name, (ws_ly.IL_vol + ws_ly.WCL_vol) as kredit_vol_ly');
    	$this->db->join('anchor', 'anchor.id = ws_main.anchor_id');
    	$this->db->join('wholesale_realization as ws_ly', 'anchor.id = ws_ly.anchor_id');
    	$this->db->where('ws_main.month',$month);
    	$this->db->where('ws_main.year',$year);
    	$this->db->where('ws_ly.month',12);
    	//$this->db->where("(`group` = 'CORPORATE BANKING AGRO BASED' OR `group` = 'CORPORATE BANKING I' OR `group` = 'CORPORATE BANKING II' OR `group` = 'CORPORATE BANKING III' OR `group` = 'SYNDICATION, OIL & GAS')");
    	$this->db->where('ws_ly.year',2013);
    	$this->db->order_by('kredit_vol', 'desc');
    	$result = $this->db->get('wholesale_realization as ws_main');
    	return $result->result();
    }
    
    function get_top_anchor_valas($month, $year, $direktorat){
    	
    	$this->db->select('ws_main.CASA_vol as CASA_vol, ws_main.month as month, ws_main.year as year, anchor.name, ws_ly.CASA_vol as CASA_vol_ly, dr_main.CASA_idr as idr_tm, dr_main.CASA_val as val_tm, dr_ly.CASA_idr as idr_ly, dr_ly.CASA_val as val_ly');
    	$this->db->join('anchor', 'anchor.id = ws_main.anchor_id');
    	$this->db->join('wholesale_realization as ws_ly', 'anchor.id = ws_ly.anchor_id');
    	$this->db->join('detail_realization as dr_main', 'anchor.id = dr_main.anchor_id');
    	$this->db->join('detail_realization as dr_ly', 'anchor.id = dr_ly.anchor_id');
    	$this->db->where('ws_main.month',$month);
    	$this->db->where('ws_main.year',$year);
    	$this->db->where('ws_ly.month',12);
    	$this->db->where('ws_ly.year',2013);
    	$this->db->where('dr_main.month',$month);
    	$this->db->where('dr_main.year',$year);
    	$this->db->where('dr_ly.month',12);
    	$this->db->where('dr_ly.year',2013);
    	get_direktorat_where($direktorat,$this);
    	$this->db->order_by('CASA_vol', 'desc');
    	$result = $this->db->get('wholesale_realization as ws_main');
    	return $result->result();
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
    	//$this->db->where("(`group` = 'CORPORATE BANKING AGRO BASED' OR `group` = 'CORPORATE BANKING I' OR `group` = 'CORPORATE BANKING II' OR `group` = 'CORPORATE BANKING III' OR `group` = 'SYNDICATION, OIL & GAS')");
    	$this->db->where('ws_ly.year',2013);
    	$this->db->order_by('ws_main.'.$product.'_vol', 'desc');
    	$result = $this->db->get('wholesale_realization as ws_main');
    	return $result->result();
    }
    
    function get_top_anchor_prd_grw($product, $month, $year, $ly_month, $sort){
    	$this->db->select('((ws_main.'.$product.'_vol/'.$month.'*12) - (ws_ly.'.$product.'_vol/'.$ly_month.'*12))/ (ws_ly.'.$product.'_vol/'.$ly_month.'*12) as grow,  (ws_main.'.$product.'_vol/'.$month.'*12) - (ws_ly.'.$product.'_vol/'.$ly_month.'*12) as nom_grow, ws_main.'.$product.'_vol as '.$product.'_vol, ws_main.month as month, ws_main.year as year, anchor.name, ws_ly.'.$product.'_vol as '.$product.'_vol_ly, wholesale_target.'.$product.'_vol as '.$product.'_vol_target');
    	$this->db->join('anchor', 'anchor.id = ws_main.anchor_id');
    	$this->db->join('wholesale_realization as ws_ly', 'anchor.id = ws_ly.anchor_id');
    	$this->db->join('wholesale_target', 'anchor.id = wholesale_target.anchor_id');
    	$this->db->where('ws_main.month',$month);
    	$this->db->where('ws_main.year',$year);
    	$this->db->where('wholesale_target.year',$year);
    	$this->db->where('ws_ly.month',$ly_month);
    	$this->db->where('ws_ly.'.$product.'_vol <>',0);
    	//$this->db->where("(`group` = 'CORPORATE BANKING AGRO BASED' OR `group` = 'CORPORATE BANKING I' OR `group` = 'CORPORATE BANKING II' OR `group` = 'CORPORATE BANKING III' OR `group` = 'SYNDICATION, OIL & GAS')");
    	$this->db->where('ws_ly.year',2013);
    	$this->db->order_by('grow', $sort);
    	$this->db->order_by('nom_grow', 'asc');
    	$this->db->limit(5);
    	$result = $this->db->get('wholesale_realization as ws_main');
    	return $result->result();
    }
    
    function get_top_anchor_prd_nml_grw($product, $month, $year, $ly_month, $sort){
    	$this->db->select('((ws_main.'.$product.'_vol/'.$month.'*12) - (ws_ly.'.$product.'_vol/'.$ly_month.'*12))/12*'.$ly_month.' as nom_grow, ws_main.'.$product.'_vol as '.$product.'_vol, ws_main.month as month, ws_main.year as year, anchor.name, ws_ly.'.$product.'_vol as '.$product.'_vol_ly, wholesale_target.'.$product.'_vol as '.$product.'_vol_target');
    	$this->db->join('anchor', 'anchor.id = ws_main.anchor_id');
    	$this->db->join('wholesale_realization as ws_ly', 'anchor.id = ws_ly.anchor_id');
    	$this->db->join('wholesale_target', 'anchor.id = wholesale_target.anchor_id');
    	$this->db->where('ws_main.month',$month);
    	$this->db->where('ws_main.year',$year);
    	$this->db->where('ws_ly.'.$product.'_vol <>',0);
    	$this->db->where('wholesale_target.year',$year);
    	//$this->db->where("(`group` = 'CORPORATE BANKING AGRO BASED' OR `group` = 'CORPORATE BANKING I' OR `group` = 'CORPORATE BANKING II' OR `group` = 'CORPORATE BANKING III' OR `group` = 'SYNDICATION, OIL & GAS')");
    	$this->db->where('ws_ly.month',$ly_month);
    	$this->db->where('ws_ly.year',2013);
    	$this->db->order_by('nom_grow', $sort);
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
    
    function get_anchor_dir($a){
    	$this->db->where('name',$a);
    	$result = $this->db->get('anchor');
    	$query = $result->result();
    	if($query){return $query[0]->group;}
    }
    
    function delete_detail($year,$month){
    	$this->db->where('month',$month);
    	$this->db->where('year',$year);
    	$this->db->delete('detail_realization');
    }
    function delete_ws($type,$year,$month){
    	if($type=="realization"){
    		$this->db->where('month',$month);
    	}
    	$this->db->where('year',$year);
    	$this->db->delete('wholesale_'.$type);
    }
    function delete_al($type,$year,$month){
    	if($type=="realization"){
    		$this->db->where('month',$month);
    	}
    	$this->db->where('year',$year);
    	$this->db->delete('alliance_'.$type);
    }
}
