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
   	
   	 
	function get_direktorat_where($direktorat,$model){
		if($direktorat == 'CB'){
			$model->db->where("(`group` = 'CORPORATE BANKING AGRO BASED' OR `group` = 'CORPORATE BANKING I' OR `group` = 'CORPORATE BANKING II' OR `group` = 'CORPORATE BANKING III' OR `group` = 'SYNDICATION, OIL & GAS')");
		}
		elseif($direktorat == 'IB'){
			$model->db->where("(`group` = 'INSTITUTIONAL BANKING I' OR `group` = 'INSTITUTIONAL BANKING II')");
		}
		elseif($direktorat == 'CBB'){
			$model->db->where("(`group` = 'JAKARTA COMMERCIAL SALES' OR `group` = 'REGIONAL COMMERCIAL SALES I' OR `group` = 'REGIONAL COMMERCIAL SALES II' )");
		}
		elseif($direktorat == 'CB1'){
			$model->db->where("(`group` = 'CORPORATE BANKING I')");
		}
		elseif($direktorat == 'CB2'){
			$model->db->where("(`group` = 'CORPORATE BANKING II')");
		}
		elseif($direktorat == 'CB3'){
			$model->db->where("(`group` = 'CORPORATE BANKING III')");
		}
		elseif($direktorat == 'AGB'){
			$model->db->where("(`group` = 'CORPORATE BANKING AGRO BASED')");
		}
		elseif($direktorat == 'SOG'){
			$model->db->where("(`group` = 'SYNDICATION, OIL & GAS')");
		}
		elseif($direktorat == 'IB1'){
			$model->db->where("(`group` = 'INSTITUTIONAL BANKING I')");
		}
		elseif($direktorat == 'IB2'){
			$model->db->where("(`group` = 'INSTITUTIONAL BANKING II')");
		}
		elseif($direktorat == 'JCS'){
			$model->db->where("(`group` = 'JAKARTA COMMERCIAL SALES')");
		}
		elseif($direktorat == 'RCS1'){
			$model->db->where("(`group` = 'REGIONAL COMMERCIAL SALES I')");
		}
		elseif($direktorat == 'RCS2'){
			$model->db->where("(`group` = 'REGIONAL COMMERCIAL SALES II')");
		}
	}
	
	function get_type_select_month($type,$model){
    	if($type == 'wholesale'){
    		$model->db->select('month, SUM(CASA_vol) as CASA_vol,
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
    		$model->db->select('month, SUM(WM_vol) as WM_vol,
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
    
    function get_type_select($type,$model){
    	if($type == 'wholesale'){
    		$model->db->select('SUM(CASA_vol) as CASA_vol,
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
    		$model->db->select('SUM(WM_vol) as WM_vol,
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
    
    function get_tot_income($ws, $al, $month,$pow){
    	$arr_tot_inc = array();
    	
    	$arr_tot_inc['ws'] = ((($ws->WCL_nii +  $ws->IL_nii +  $ws->SL_nii + $ws->CASA_nii + $ws->TR_nii + $ws->OW_nii + $ws->TD_nii + 
    					$ws->CASA_fbi + $ws->FX_fbi + $ws->SCF_fbi + $ws->Trade_fbi + $ws->PWE_fbi + $ws->BG_fbi + $ws->OIR_fbi + $ws->OW_fbi)/$month*12) + $ws->IL_fbi + $ws->SL_fbi + $ws->WCL_fbi)/pow(10,$pow);
    	$arr_tot_inc['al'] = ($al->WM_nii + $al->DPLK_fbi + $al->PCD_nii + $al->VCCD_nii + $al->VCCD_fbi + $al->VCL_nii + $al->VCL_fbi+ $al->VCLnDF_nii + $al->VCLnDF_fbi + $al->Micro_Loan_nii + $al->Micro_Loan_fbi + 
					$al->MKM_nii + $al->KPR_nii + $al->Auto_nii + $al->CC_nii + $al->EDC_fbi + $al->ATM_fbi + $al->AXA_fbi + $al->MAGI_fbi + $al->retail_fbi + $al->cicil_Emas_fbi)/$month*12/pow(10,$pow);
		$arr_tot_inc['tot'] = $arr_tot_inc['ws'] + $arr_tot_inc['al'];
		return $arr_tot_inc;
    }
    
    function get_direktorat_full_name($directorate){
    	if($directorate == 'CB'){$title = 'Corporate Banking';}
		elseif($directorate == 'IB'){$title = 'Institutional Banking';}
		elseif($directorate == 'CBB'){$title = 'Commercial and Bussines Banking';}
		elseif($directorate == 'CB1'){$title = 'CORPORATE BANKING I';}
		elseif($directorate == 'CB2'){$title = 'CORPORATE BANKING II';}
		elseif($directorate == 'CB3'){$title = 'CORPORATE BANKING III';}
		elseif($directorate == 'AGB'){$title = 'CORPORATE BANKING AGRO BASED';}
		elseif($directorate == 'SOG'){$title = 'SYNDICATION, OIL & GAS';}
		elseif($directorate == 'IB1'){$title = 'INSTITUTIONAL BANKING I';}
		elseif($directorate == 'IB2'){$title = 'INSTITUTIONAL BANKING II';}
		elseif($directorate == 'JCS'){$title = 'JAKARTA COMMERCIAL SALES';}
		elseif($directorate == 'RCS1'){$title = 'REGIONAL COMMERCIAL SALES I';}
		elseif($directorate == 'RCS2'){$title = 'REGIONAL COMMERCIAL SALES II';}
		else{$title = 'BANKWIDE BANK MANDIRI';}
		
		return $title;
    }
    
    function get_produk_pow($product){
    	$bagi=9; if($product == 'FX' || $product == 'Trade'){$bagi=6;}elseif($product == 'OIR'){$bagi=0;}
    	return $bagi;
    }
    
    function get_month_name($month){
    	if($month == 1){return "Jan";}
    	elseif($month == 2){return "Feb";}
    	elseif($month == 3){return "Mar";}
    	elseif($month == 4){return "Apr";}
    	elseif($month == 5){return "Mei";}
    	elseif($month == 6){return "Jun";}
    	elseif($month == 7){return "Jul";}
    	elseif($month == 8){return "Agu";}
    	elseif($month == 9){return "Sep";}
    	elseif($month == 10){return "Okt";}
    	elseif($month == 11){return "Nov";}
    	elseif($month == 12){return "Des";}
    }
