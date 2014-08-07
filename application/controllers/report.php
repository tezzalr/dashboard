<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Report extends CI_Controller {
    
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
        
    }
    
    public function relation_income(){
    	if($this->uri->segment(3)=='anchor'){
    		$year = date('Y');
    		$anchor_id = $this->uri->segment(4);
    		$data_rl_inc = array();
    		$data_rl_inc['inc_wal'] = $this->mwallet->get_anchor_total_wallet($anchor_id, $year);
    		$data_rl_inc['inc'] = $this->mrealization->get_anchor_total_income($anchor_id, $year);
    		$data_rl_inc['inc_wal_ly'] = $this->mwallet->get_anchor_total_wallet($anchor_id, ($year-1));
    		$data_rl_inc['inc_ly'] = $this->mrealization->get_anchor_total_income($anchor_id, ($year-1));
    		$anchor = $this->manchor->get_anchor_by_id($anchor_id);
    		
    		$data['title'] = "Relationship Income - $anchor->name";
    
    		$header = $this->load->view('anchor/anchor_header',array('anchor' => $anchor, 'id_ybs' => $anchor->id, 'code' => 'anc'),TRUE);
    	}
    	
    	$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('report/relation_income',array('rl_inc' => $data_rl_inc, 'header' => $header),TRUE);

		$this->load->view('front',$data);
    }
    
    public function wholesale_income(){
    	if($this->uri->segment(3)=='anchor'){
    		$year = date('Y');
    		$month = $this->mrealization->get_last_month($year);
    		$anchor_id = $this->uri->segment(4);
    		$data_ws_inc = array();
    		$data_ws_inc['ty'] = $this->mrealization->get_anchor_ws_realization($anchor_id, $year);
    		$data_ws_inc['ly'] = $this->mrealization->get_anchor_ws_realization($anchor_id, $year-1);
    		$anchor = $this->manchor->get_anchor_by_id($anchor_id);
    		
    		$data['title'] = "Relationship Income - $anchor->name";
    
    		$header = $this->load->view('anchor/anchor_header',array('anchor' => $anchor, 'id_ybs' => $anchor->id, 'code' => 'anc'),TRUE);
    	}
    	
    	$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('report/wholesale_income',array('ws_inc' => $data_ws_inc, 'header' => $header, 'month' => $month),TRUE);

		$this->load->view('front',$data);
    }
    
    public function trans_xsell(){
    	if($this->uri->segment(3)=='anchor'){
    		$year = date('Y');
    		$anchor_id = $this->uri->segment(4);
    		$data_xsell = array();
    		$inc = $this->mrealization->get_anchor_ws_realization($anchor_id, $year);
    		$data_xsell['wal'] = $this->mwallet->get_anchor_ws_wallet($anchor_id, $year);		
    		$data_xsell['inc'] = $this->mrealization->count_realization_value($inc, $inc->month);
    		$data_xsell['sow'] = $this->mwallet->get_sow($data_xsell['wal'], $data_xsell['inc'], 'wholesale');
    		
    		$inc_ly = $this->mrealization->get_anchor_ws_realization($anchor_id, ($year-1));
    		$data_xsell['wal_ly'] = $this->mwallet->get_anchor_ws_wallet($anchor_id, ($year-1));
    		$data_xsell['inc_ly'] = $this->mrealization->count_realization_value($inc_ly, $inc_ly->month);
    		$data_xsell['sow_ly'] = $this->mwallet->get_sow($data_xsell['wal_ly'], $data_xsell['inc_ly'], 'wholesale');
    		
    		$anchor = $this->manchor->get_anchor_by_id($anchor_id);
    		
    		$data['title'] = "Relationship Income - $anchor->name";
    
    		$header = $this->load->view('anchor/anchor_header',array('anchor' => $anchor, 'id_ybs' => $anchor->id, 'code' => 'anc'),TRUE);
    	}
    	
    	$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('report/trans_xsell',array('xsell' => $data_xsell, 'header' => $header),TRUE);

		$this->load->view('front',$data);
    }
    
    public function alliance_income(){
    	if($this->uri->segment(3)=='anchor'){
    		$year = date('Y');
    		$month = $this->mrealization->get_last_month($year);
    		$anchor_id = $this->uri->segment(4);
    		$data_ws_inc = array();
    		$data_ws_inc['ty'] = $this->mrealization->get_anchor_ws_realization($anchor_id, $year);
    		$data_ws_inc['ly'] = $this->mrealization->get_anchor_ws_realization($anchor_id, $year-1);
    		$anchor = $this->manchor->get_anchor_by_id($anchor_id);
    		
    		$data['title'] = "Relationship Income - $anchor->name";
    
    		$header = $this->load->view('anchor/anchor_header',array('anchor' => $anchor, 'id_ybs' => $anchor->id, 'code' => 'anc'),TRUE);
    	}
    	
    	$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('report/alliance_income',array('ws_inc' => $data_ws_inc, 'header' => $header, 'month' => $month),TRUE);

		$this->load->view('front',$data);
    }
}
