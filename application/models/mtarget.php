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
class Mtarget extends CI_Model {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    //INSERT or CREATE FUNCTION
        
    //GET FUNCTION
    
    /*Anchor Function*/
    
    function get_anchor_ws_target($anchor_id){
    	$this->db->where('anchor_id',$anchor_id);
    	$result = $this->db->get('wholesale_target');
    	$query = $result->result();
        return $query[0];
    }
    
    function get_anchor_al_target($anchor_id){
    	$this->db->where('anchor_id',$anchor_id);
    	$result = $this->db->get('alliance_target');
    	$query = $result->result();
        return $query[0];
    }
     /*Directorate Function*/
     function get_directorate_target($direktorat,$type){
     	$db = $type.'_target';
    	$this->get_type_select($type);
    	$this->get_direktorat_where($direktorat);
    	$this->db->where('year',2014);
    	$this->db->join('anchor', 'anchor.id = '.$db.'.anchor_id');
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
    		$this->db->select('SUM(CASA_vol) as CASA_vol,
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
