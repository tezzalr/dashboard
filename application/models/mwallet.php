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
class Mwallet extends CI_Model {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    //INSERT or CREATE FUNCTION
        
    
    //GET FUNCTION
    
    /*Anchor Function*/
    
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
    
    function get_anchor_total_wallet($anchor_id, $year){
    	$ws_wallet = $this->get_anchor_ws_wallet($anchor_id, $year);
    	$al_wallet = $this->get_anchor_al_wallet($anchor_id, $year);

		return get_tot_income($ws_wallet, $al_wallet,12,0);
    }
    
    /*Directorate Function*/
    function get_directorate_wallet($direktorat, $year, $type){
    	$db = $type.'_wallet_size';
    	get_type_select($type,$this);
    	get_direktorat_where($direktorat,$this);
    	$this->db->join('anchor', 'anchor.id = '.$db.'.anchor_id');
    	$this->db->where('year',$year);
    	$result = $this->db->get($db);
    	$query = $result->result();
        return $query[0];
    }
    
    function get_directorate_total_wallet($direktorat, $year){
    	$ws_wallet = $this->get_directorate_wallet($direktorat, $year, "wholesale");
    	$al_wallet = $this->get_directorate_wallet($direktorat, $year, "alliance");

		return get_tot_income($ws_wallet, $al_wallet,12,0);
    }
    
    function get_sow($wallet, $realization, $type){
    	$arr_sow = array();
    	if($type == 'wholesale'){
    		for($i=1;$i<=15;$i++){
    			$wlt_prd = $this->return_prod_name($i)."_vol";
    			if(!$wallet->$wlt_prd){$arr_sow[$i]=100;}
    			else{$arr_sow[$i]=$realization[$wlt_prd]/$wallet->$wlt_prd*100;}
    		}
    		for($i=16;$i<=30;$i++){
    			$nii_arr = array(16,17,18,19,20,21);
    			$imbuhan = "_fbi"; if(in_array($i,$nii_arr)){$imbuhan = "_nii";}
    			$wlt_inc = $this->return_prod_name($i-15).$imbuhan;
    			if(!$wallet->$wlt_inc){$arr_sow[$i]=100;}
    			else{$arr_sow[$i]=$realization[$this->return_prod_name($i-15)."_inc"]/$wallet->$wlt_inc*100;}	
    		}
    	}
    	return $arr_sow;
    }
    
    function return_prod_name($i){
    	if($i==1){return "CASA";}
    	elseif($i==2){return "TD";}
    	elseif($i==3){return "WCL";}
    	elseif($i==4){return "IL";}
    	elseif($i==5){return "SL";}
    	elseif($i==6){return "TR";}
    	elseif($i==7){return "FX";}
    	elseif($i==8){return "SCF";}
    	elseif($i==9){return "Trade";}
    	elseif($i==10){return "BG";}
    	elseif($i==11){return "OIR";}
    	elseif($i==12){return "PWE";}
    	elseif($i==13){return "ECM";}
    	elseif($i==14){return "DCM";}
    	elseif($i==15){return "MA";}
    	elseif($i==16){return "LMF";}
    	elseif($i==17){return "SF";}
    	elseif($i==18){return "OW_nii";}
    	elseif($i==19){return "OW_fbi";}
    }
       
    function change_real_name($initial){
    	if($initial == "CASA"){return "CASA";}
    	elseif($initial ==  "TD"){return "Time Deposit";}
		elseif($initial ==  "WCL"){return 'Working Capital Loan';}
		elseif($initial ==  "IL"){return 'Investment Loan';}
		elseif($initial ==  "SL"){return 'Structured Loan';}
		elseif($initial ==  "TR"){return 'Trust Receipt';}
		elseif($initial ==  "FX"){return 'FX & Derivatives';}
		elseif($initial ==  "SCF"){return 'Supply Chain Financing';}
		elseif($initial ==  "Trade"){return 'Trade Services';}
		elseif($initial ==  "BG"){return 'Bank Guarantee';}
		elseif($initial ==  "OIR"){return 'Outgoing Intl Remittance';}
		elseif($initial ==  "PWE"){return 'PWE non L/C';}
		elseif($initial ==  "ECM"){return 'ECM';}
		elseif($initial ==  "DCM"){return 'DCM';}
		elseif($initial ==  "MA"){return 'M&A';}
		elseif($initial ==  "LMF"){return 'Loan Maintenance Fee';}
		elseif($initial ==  "SF"){return 'Syndication Fee';}
		elseif($initial ==  "OW_nii"){return 'NII Others';}
		elseif($initial ==  "OW_fbi"){return 'FBI Others';}
    }
}
