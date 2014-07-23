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
    
    function get_directorate_wallet($direktorat, $year, $type){
    	$db = $type.'_wallet_size';
    	$this->get_type_select($type);
    	$this->get_direktorat_where($direktorat);
    	$this->db->join('anchor', 'anchor.id = '.$db.'.anchor_id');
    	$this->db->where('year',$year);
    	$result = $this->db->get($db);
    	$query = $result->result();
        return $query[0];
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
    	}else{
    		$this->db->select('SUM(WM_vol) as WM_vol,
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
