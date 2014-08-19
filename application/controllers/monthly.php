<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Monthly extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('manchor');
        $this->load->model('mrealization');
        $this->load->model('mtarget');
        $this->load->model('mwallet');
        $this->load->library('excel');
    }
    /**
     * Method for page (public)
     */
    public function index()
    {		
    	$month = $this->mrealization->get_last_month(date('Y'));
    	
        $data['title'] = "Monthly Report";
        
        $data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('monthly/opening_page',array('month'=>$month),TRUE);
		
		$this->load->view('front',$data);
    }
    
    public function resume(){
    	$year = date('Y');
    	$month = $this->mrealization->get_last_month($year);
    	
    	$groups = array('CB1','CB2','CB3','AGB','SOG');
    	
    	foreach($groups as $group){
    		$casa[$group]["ly"] = $this->manchor->get_total_vol_prd("CASA", 12, $year-1, 'wholesale_realization',$group);
			$casa[$group]["tm"] = $this->manchor->get_total_vol_prd("CASA", $month, $year, 'wholesale_realization',$group);
			$casa[$group]["wal"] = $this->manchor->get_total_vol_prd("CASA", 0, 2014, 'wholesale_wallet_size',$group);
			$casa[$group]["tgt"] = $this->manchor->get_total_vol_prd("CASA", 0, 2014, 'wholesale_target',$group);
			
			$realization_ws_ly = $this->mrealization->get_directorate_realization_w_month($group, $year-1, 'wholesale',12);
    		$real_ly = $this->mrealization->count_realization_value($realization_ws_ly, $realization_ws_ly->month);
    		$realization_ws_tm = $this->mrealization->get_directorate_realization_w_month($group, $year, 'wholesale',$month);
    		$real_tm = $this->mrealization->count_realization_value($realization_ws_tm, $realization_ws_tm->month);
    		$wal = $this->mwallet->get_directorate_wallet($group, date('Y'), 'wholesale');
    		$tgt = $this->mtarget->get_directorate_target($group,'wholesale');
    		
    		$fbi[$group]["ly"] = $real_ly['Trade_inc']+$real_ly['BG_inc']+$real_ly['SF_inc']+$real_ly['FX_inc']+$real_ly['OIR_inc']+$real_ly['LMF_inc'];
    		$fbi[$group]["tm"] = $real_tm['Trade_inc']+$real_tm['BG_inc']+$real_tm['SF_inc']+$real_tm['FX_inc']+$real_tm['OIR_inc']+$real_tm['LMF_inc'];
    		$fbi[$group]["wal"] = $wal->Trade_fbi + $wal->BG_fbi + $wal->SL_fbi + $wal->FX_fbi + $wal->OIR_fbi + $wal->WCL_fbi + $wal->IL_fbi;
    		$fbi[$group]["tgt"] = $tgt->Trade_fbi + $tgt->BG_fbi + $tgt->SL_fbi + $tgt->FX_fbi + $tgt->OIR_fbi + $tgt->WCL_fbi + $tgt->IL_fbi;
			
			$kredit[$group]["ly"] = $this->manchor->get_total_vol_prd("WCL", 12, $year-1, 'wholesale_realization',$group)->WCL_vol+$this->manchor->get_total_vol_prd("IL", 12, $year-1, 'wholesale_realization',$group)->IL_vol;
			$kredit[$group]["tm"] = $this->manchor->get_total_vol_prd("WCL", $month, $year, 'wholesale_realization',$group)->WCL_vol+$this->manchor->get_total_vol_prd("IL", $month, $year, 'wholesale_realization',$group)->IL_vol;
			$kredit[$group]["wal"] = $this->manchor->get_total_vol_prd("WCL", 0, 2014, 'wholesale_wallet_size',$group)->WCL_vol+$this->manchor->get_total_vol_prd("IL", 0, 2014, 'wholesale_wallet_size',$group)->IL_vol;
			$kredit[$group]["tgt"] = $this->manchor->get_total_vol_prd("WCL", 0, 2014, 'wholesale_target',$group)->WCL_vol+$this->manchor->get_total_vol_prd("IL", 0, 2014, 'wholesale_target',$group)->IL_vol;
    	}
    	$total['casa'] = $casa; $total['kredit'] = $kredit; $total['fbi'] = $fbi;
    	$data['title'] = "Laporan CASA";
    	$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('monthly/resume',array('month'=>$month,'total'=>$total),TRUE);

		$this->load->view('front',$data);
    }
    
    public function CASA(){
    	$year = date('Y');
    	$month = $this->mrealization->get_last_month($year);
    	$pareto = $this->manchor->get_top_anchor_prd("CASA", $month, $year);
    	$total["ly"] = $this->manchor->get_total_vol_prd("CASA", 12, $year-1, 'wholesale_realization','');
    	$total["tm"] = $this->manchor->get_total_vol_prd("CASA", $month, $year, 'wholesale_realization','');
    	$total["wal"] = $this->manchor->get_total_vol_prd("CASA", 0, 2014, 'wholesale_wallet_size','');
    	$total["tgt"] = $this->manchor->get_total_vol_prd("CASA", 0, 2014, 'wholesale_target','');
    	
    	$data['title'] = "Laporan CASA";
    	$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('monthly/CASA',array('month'=>$month,'pareto'=>$pareto,'total'=>$total),TRUE);

		$this->load->view('front',$data);
    }
    
    public function wholesale_income(){
    	$year = date('Y');
    	$month = $this->mrealization->get_last_month($year);
    	$data_ws_inc = array();
    	
    	if($this->uri->segment(3)=='anchor'){
    		$anchor_id = $this->uri->segment(4);
    		$data_ws_inc['ty'] = $this->mrealization->get_anchor_ws_realization($anchor_id, $year);
    		$data_ws_inc['ly'] = $this->mrealization->get_anchor_ws_realization($anchor_id, $year-1);
    		$anchor = $this->manchor->get_anchor_by_id($anchor_id);
    		
    		$data['title'] = "Wholesale Income - $anchor->name";
    		$info_page['type'] = 'anchor'; $info_page['id'] = $anchor_id;
    		$header = $this->load->view('anchor/anchor_header',array('anchor' => $anchor, 'id_ybs' => $anchor->id, 'code' => 'anc'),TRUE);
    	}
    	elseif($this->uri->segment(3)=='directorate'){
    		$direktorat = $this->uri->segment(4);
    		$data_ws_inc['ty'] = $this->mrealization->get_directorate_realization($direktorat, $year, 'wholesale');
    		$data_ws_inc['ly'] = $this->mrealization->get_directorate_realization($direktorat, $year-1, 'wholesale');
    		
    		$data['title'] = "Wholesale Income";
    		$info_page['type'] = 'directorate'; $info_page['id'] = $direktorat;
    		$header = $this->load->view('directorate/dir_header',array('directorate' => $direktorat, 'id_ybs' => $direktorat, 'code' => 'dir'),TRUE);
    	}
    	
    	$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('report/wholesale_income',array('ws_inc' => $data_ws_inc, 'header' => $header, 'month' => $month, 'info_page' => $info_page),TRUE);

		$this->load->view('front',$data);
    }
    
    public function trans_xsell(){
    	$year = date('Y');
    	$data_xsell = array();
    		
    	if($this->uri->segment(3)=='anchor'){
    		$anchor_id = $this->uri->segment(4);
    		
    		$inc = $this->mrealization->get_anchor_ws_realization($anchor_id, $year);
    		$data_xsell['wal'] = $this->mwallet->get_anchor_ws_wallet($anchor_id, $year);		
    		$data_xsell['inc'] = $this->mrealization->count_realization_value($inc, $inc->month);
    		$data_xsell['sow'] = $this->mwallet->get_sow($data_xsell['wal'], $data_xsell['inc'], 'wholesale');
    		
    		$inc_ly = $this->mrealization->get_anchor_ws_realization($anchor_id, ($year-1));
    		$data_xsell['wal_ly'] = $this->mwallet->get_anchor_ws_wallet($anchor_id, ($year-1));
    		$data_xsell['inc_ly'] = $this->mrealization->count_realization_value($inc_ly, $inc_ly->month);
    		$data_xsell['sow_ly'] = $this->mwallet->get_sow($data_xsell['wal_ly'], $data_xsell['inc_ly'], 'wholesale');
    		
    		$anchor = $this->manchor->get_anchor_by_id($anchor_id);
    		
    		$data['title'] = "Transaction Cross Sell - $anchor->name";
    		$info_page['type'] = 'anchor'; $info_page['id'] = $anchor_id;
    		$header = $this->load->view('anchor/anchor_header',array('anchor' => $anchor, 'id_ybs' => $anchor->id, 'code' => 'anc'),TRUE);
    	}
    	elseif($this->uri->segment(3)=='directorate'){
    		$direktorat = $this->uri->segment(4);
    		
    		$inc = $this->mrealization->get_directorate_realization($direktorat, $year, 'wholesale');
    		$data_xsell['wal'] = $this->mwallet->get_directorate_wallet($direktorat, $year, 'wholesale');		
    		$data_xsell['inc'] = $this->mrealization->count_realization_value($inc, $inc->month);
    		$data_xsell['sow'] = $this->mwallet->get_sow($data_xsell['wal'], $data_xsell['inc'], 'wholesale');
    		
    		$inc_ly = $this->mrealization->get_directorate_realization($direktorat, $year-1, 'wholesale');
    		$data_xsell['wal_ly'] = $this->mwallet->get_directorate_wallet($direktorat, $year-1, 'wholesale');
    		$data_xsell['inc_ly'] = $this->mrealization->count_realization_value($inc_ly, $inc_ly->month);
    		$data_xsell['sow_ly'] = $this->mwallet->get_sow($data_xsell['wal_ly'], $data_xsell['inc_ly'], 'wholesale');
    		
    		$data['title'] = "Transaction Cross Sell";
    		$info_page['type'] = 'directorate'; $info_page['id'] = $direktorat;
    		$header = $this->load->view('directorate/dir_header',array('directorate' => $direktorat, 'id_ybs' => $direktorat, 'code' => 'dir'),TRUE);
    	}
    	
    	$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('report/trans_xsell',array('xsell' => $data_xsell, 'header' => $header, 'info_page' => $info_page),TRUE);

		$this->load->view('front',$data);
    }
    
    public function alliance_income(){
    	$year = date('Y');
    	$month = $this->mrealization->get_last_month($year);
    	$data_al_inc = array();
    	
    	if($this->uri->segment(3)=='anchor'){
    		$anchor_id = $this->uri->segment(4);
    		$data_al_inc['ty'] = $this->mrealization->get_anchor_al_realization($anchor_id, $year);
    		$data_al_inc['ly'] = $this->mrealization->get_anchor_al_realization($anchor_id, $year-1);
    		$anchor = $this->manchor->get_anchor_by_id($anchor_id);
    		
    		$data['title'] = "Wholesale Income - $anchor->name";
    		$info_page['type'] = 'anchor'; $info_page['id'] = $anchor_id;
    		$header = $this->load->view('anchor/anchor_header',array('anchor' => $anchor, 'id_ybs' => $anchor->id, 'code' => 'anc'),TRUE);
    	}
    	elseif($this->uri->segment(3)=='directorate'){
    		$direktorat = $this->uri->segment(4);
    		$data_al_inc['ty'] = $this->mrealization->get_directorate_realization($direktorat, $year, 'alliance');
    		$data_al_inc['ly'] = $this->mrealization->get_directorate_realization($direktorat, $year-1, 'alliance');
    		
    		$data['title'] = "Wholesale Income";
    		$info_page['type'] = 'directorate'; $info_page['id'] = $direktorat;
    		$header = $this->load->view('directorate/dir_header',array('directorate' => $direktorat, 'id_ybs' => $direktorat, 'code' => 'dir'),TRUE);
    	}
    	
    	$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('report/alliance_income',array('al_inc' => $data_al_inc, 'header' => $header, 'month' => $month, 'info_page' => $info_page),TRUE);

		$this->load->view('front',$data);
    }
}
