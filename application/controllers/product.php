<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Product extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('manchor');
        $this->load->model('mrealization');
        $this->load->model('mwallet');
        
    }
    /**
     * Method for page (public)
     */
    public function index()
    {

		$data['title'] = "Bankwide";
		
		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('bankwide/index',array(),TRUE);

		$this->load->view('front',$data);
        
    }
    
    public function product(){
    	$data['title'] = "Product";
		
		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('bankwide/product',array(),TRUE);

		$this->load->view('front',$data);
    }
    
    public function top_transaksi(){
    	$data['title'] = "Top Anchor Product";
    	$product = $this->uri->segment(3);
    	$year = date('Y');
    	$month = $this->session->userdata('rptmth');
    	$total_prd = $this->manchor->get_total_vol_prd($product, $month, $year, 'wholesale_realization','');
    	$top_anchor_vol = $this->manchor->get_top_anchor_prd($product, $month, $year);
    	$top_anchor_nom_grow = $this->manchor->get_top_anchor_prd_nml_grw($product, $month, $year, 12, 'desc');
    	$top_anchor_nom_grow_min = $this->manchor->get_top_anchor_prd_nml_grw($product, $month, $year, 12, 'asc');
    	$top_anchor_nom_grow_tm = $this->manchor->get_top_anchor_prd_nml_grw($product, $month, $year, $month, 'desc');
    	$top_anchor_nom_grow_tm_min = $this->manchor->get_top_anchor_prd_nml_grw($product, $month, $year, $month, 'asc');
    	$top_anchor_grow = $this->manchor->get_top_anchor_prd_grw($product, $month, $year, 12, 'desc');
    	$top_anchor_grow_min = $this->manchor->get_top_anchor_prd_grw($product, $month, $year, 12, 'asc');
    	$top_anchor_grow_tm = $this->manchor->get_top_anchor_prd_grw($product, $month, $year, $month, 'desc');
    	$top_anchor_grow_tm_min = $this->manchor->get_top_anchor_prd_grw($product, $month, $year, $month, 'asc');
    	
    	$top_anchor['nom_grow'] = $this->manchor->get_top_anchor_prd_nml_grw($product, $month, $year, 12, 'desc');
    	$top_anchor['nom_grow_min'] = $this->manchor->get_top_anchor_prd_nml_grw($product, $month, $year, 12, 'asc');
    	$top_anchor['grow'] = $this->manchor->get_top_anchor_prd_grw($product, $month, $year, 12, 'desc');
    	$top_anchor['grow_min'] = $this->manchor->get_top_anchor_prd_grw($product, $month, $year, 12, 'asc');
    	
    	$growth_tab = $this->load->view('product/_growth',array('asu' => 'ytd','top_anchor' => $top_anchor, 'product' => $product, 'month' => $month,'total_prd' => $total_prd),TRUE);
    	
    	$prd_name = $this->manchor->get_product_name_by_inisial($product);
    	
    	$arr_prod = array(); 
    	for($i=1;$i<=15;$i++){
    		$arr_prod[$i]['id'] = $this->mwallet->return_prod_name($i);
    		$arr_prod[$i]['name'] = $this->mwallet->change_real_name($arr_prod[$i]['id']);
    	}
		
		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('product/top_transaksi',array('asu' => 'ytd', 'growth_tab' => $growth_tab, 'arr_prod' => $arr_prod, 'month' => $month, 'top_anchor_vol' => $top_anchor_vol, 'product' => $product, 'total_prd' => $total_prd, 'prd_name' => $prd_name),TRUE);

		$this->load->view('front',$data);
    }
    
    public function refresh_top(){
    	$prod = $this->input->post('product');
    	
    	redirect('product/top_transaksi/'.$prod);
    }
    
    public function change_growth_table(){
    	$product = $this->input->get('prod');
    	$type = $this->input->get('type');
    	
    	$year = date('Y');
    	$month = $this->session->userdata('rptmth');
    	
    	if($type == 'ytd'){$month_ly = 12;}
    	else{$month_ly = $month;}
    	
    	$top_anchor['nom_grow'] = $this->manchor->get_top_anchor_prd_nml_grw($product, $month, $year, $month_ly, 'desc');
		$top_anchor['nom_grow_min'] = $this->manchor->get_top_anchor_prd_nml_grw($product, $month, $year, $month_ly, 'asc');
		$top_anchor['grow'] = $this->manchor->get_top_anchor_prd_grw($product, $month, $year, $month_ly, 'desc');
		$top_anchor['grow_min'] = $this->manchor->get_top_anchor_prd_grw($product, $month, $year, $month_ly, 'asc');
		$total_prd = $this->manchor->get_total_vol_prd($product, $month, $year, 'wholesale_realization','');
        
		if($top_anchor['nom_grow'] && $top_anchor['grow']){
			$json['status'] = 1;
    		$growth_tab = $this->load->view('product/_growth',array('top_anchor' => $top_anchor, 'product' => $product, 'month' => $month,'total_prd' => $total_prd, 'asu' => $type),TRUE);
			$json['html'] = $growth_tab;
			$json['type'] = $type;
			if($type == 'ytd'){$json['rev'] = 'tm';}else{$json['rev'] = 'ytd';}
		}else{
			$json['status'] = 0;
		}
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }
    
    public function casa_xsell(){
    	$data['title'] = "Product";
    	$dir = $this->uri->segment(3);
    	$anc_xsll = array(); $i=0;
    	$month = $this->session->userdata('rptmth');
    	
    	$anchors = $this->manchor->get_anchor_by_direktorat($dir);
    	foreach($anchors as $anchor){
    		$rlz = $this->mrealization->get_anchor_ws_realization($anchor->id, date('Y'));
			$data_xsell['wal'] = $this->mwallet->get_anchor_ws_wallet($anchor->id, date('Y'));		
    		$data_xsell['rlz'] = $this->mrealization->count_realization_value($rlz, $month);
    		$data_xsell['sow'] = $this->mwallet->get_sow($data_xsell['wal'], $data_xsell['rlz'], 'wholesale');
    		if($data_xsell['sow'][31]>100){$data_xsell['sow'][31]=100;}
    		if(!$data_xsell['sow'][31]){$casa_xsell=1;}
    		else{$casa_xsell = $data_xsell['sow'][1]/$data_xsell['sow'][31];}
    		if($casa_xsell<1){
    			$anc_xsll[$i]['anchor'] = $anchor;
    			$anc_xsll[$i]['wallet_casa'] = $data_xsell['wal']->CASA_vol;
    			$anc_xsll[$i]['rlz_casa'] = $data_xsell['rlz']['CASA_vol'];
    			$anc_xsll[$i]['wallet_loan'] = $data_xsell['wal']->WCL_vol+$data_xsell['wal']->SL_vol+$data_xsell['wal']->IL_vol;
    			$anc_xsll[$i]['rlz_loan'] = $data_xsell['rlz']['WCL_vol']+$data_xsell['rlz']['IL_vol']+$data_xsell['rlz']['SL_vol'];
    			$anc_xsll[$i]['sow_casa'] = $data_xsell['sow'][1];
    			$anc_xsll[$i]['sow_loan'] = $data_xsell['sow'][31];
    			$anc_xsll[$i]['casa_xsell'] = $casa_xsell;
    			$i++;
    		}	
    	}
		
		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('product/casa_xsell',array('anchors' => $anc_xsll,'month' => $month),TRUE);

		$this->load->view('front',$data);
    }
    
    public function casa_sow(){
    	$data['title'] = "Product";
    	$dir = $this->uri->segment(3);
    	$anc_xsll = array(); $i=0;
    	$month = $this->session->userdata('rptmth');
    	
    	$anchors = $this->manchor->get_anchor_by_direktorat($dir);
    	foreach($anchors as $anchor){
    		$rlz = $this->mrealization->get_anchor_ws_realization($anchor->id, date('Y'));
			$data_xsell['wal'] = $this->mwallet->get_anchor_ws_wallet($anchor->id, date('Y'));		
    		$data_xsell['rlz'] = $this->mrealization->count_realization_value($rlz, $month);
    		$data_xsell['sow'] = $this->mwallet->get_sow($data_xsell['wal'], $data_xsell['rlz'], 'wholesale');
    		if(!$data_xsell['sow'][31]){$casa_xsell=1;}
    		else{$casa_xsell = $data_xsell['sow'][1]/$data_xsell['sow'][31];}
    		if($data_xsell['sow'][1]<30 && $casa_xsell>1){
    			$anc_xsll[$i]['anchor'] = $anchor;
    			$anc_xsll[$i]['wallet'] = $data_xsell['wal']->CASA_vol;
    			$anc_xsll[$i]['rlz'] = $data_xsell['rlz']['CASA_vol'];
    			$anc_xsll[$i]['sow_casa'] = $data_xsell['sow'][1];
    			$anc_xsll[$i]['sow_loan'] = $data_xsell['sow'][31];
    			$anc_xsll[$i]['casa_xsell'] = $casa_xsell;
    			$i++;
    		}	
    	}
		
		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('product/casa_sow',array('anchors' => $anc_xsll,'month' => $month),TRUE);

		$this->load->view('front',$data);
    }
}
