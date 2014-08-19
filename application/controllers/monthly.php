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
    
    public function CASA(){
    	$year = date('Y');
    	$month = $this->mrealization->get_last_month($year);
    	$pareto = $this->manchor->get_top_anchor_prd("CASA", $month, $year);
    	$total["ly"] = $this->manchor->get_total_vol_prd("CASA", 12, $year-1, 'wholesale_realization');
    	$total["tm"] = $this->manchor->get_total_vol_prd("CASA", $month, $year, 'wholesale_realization');
    	$total["wal"] = $this->manchor->get_total_vol_prd("CASA", 0, 2014, 'wholesale_wallet_size');
    	$total["tgt"] = $this->manchor->get_total_vol_prd("CASA", 0, 2014, 'wholesale_target');
    	
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
