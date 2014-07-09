<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Bankwide extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('manchor');
        
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
    	
    	$total_prd = $this->manchor->get_total_vol_prd($product, 5, 2014);
    	$top_anchor_vol = $this->manchor->get_top_anchor_prd($product, 5, 2014);
    	$top_anchor_nom_grow = $this->manchor->get_top_anchor_prd_nml_grw($product, 5, 2014);
    	$top_anchor_grow = $this->manchor->get_top_anchor_prd_grw($product, 5, 2014);
    	
    	$prd_name = $this->manchor->get_product_name_by_inisial($product);
		
		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('bankwide/top_transaksi',array('top_anchor_vol' => $top_anchor_vol, 'top_anchor_nom_grow' => $top_anchor_nom_grow, 'top_anchor_grow' => $top_anchor_grow, 'product' => $product, 'total_prd' => $total_prd, 'prd_name' => $prd_name),TRUE);

		$this->load->view('front',$data);
    }
    
    public function top_volume(){
    	$data['title'] = "Top Anchor Product";
    	$product = $this->uri->segment(3);
    	
    	$total_prd = $this->manchor->get_total_vol_prd($product, 5, 2014);
    	$top_anchor = $this->manchor->get_top_anchor_prd($product, 5, 2014);
    	$prd_name = $this->manchor->get_product_name_by_inisial($product);
		
		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('bankwide/top_volume',array('top_anchor' => $top_anchor, 'product' => $product, 'total_prd' => $total_prd, 'prd_name' => $prd_name),TRUE);

		$this->load->view('front',$data);
    }
    
    public function top_nominal_growth(){
    	$data['title'] = "Top Anchor Product";
    	$product = $this->uri->segment(3);
    	
    	$total_prd = $this->manchor->get_total_vol_prd($product, 5, 2014);
    	$top_anchor = $this->manchor->get_top_anchor_prd_nml_grw($product, 5, 2014);
    	$prd_name = $this->manchor->get_product_name_by_inisial($product);
		
		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('bankwide/top_nominal_growth',array('top_anchor' => $top_anchor, 'product' => $product, 'total_prd' => $total_prd, 'prd_name' => $prd_name),TRUE);

		$this->load->view('front',$data);
    }
    
    public function top_growth(){
    	$data['title'] = "Top Anchor Product";
    	$product = $this->uri->segment(3);
    	
    	$total_prd = $this->manchor->get_total_vol_prd($product, 5, 2014);
    	$top_anchor = $this->manchor->get_top_anchor_prd_grw($product, 5, 2014);
    	$prd_name = $this->manchor->get_product_name_by_inisial($product);
		
		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('bankwide/top_growth',array('top_anchor' => $top_anchor, 'product' => $product, 'total_prd' => $total_prd, 'prd_name' => $prd_name),TRUE);

		$this->load->view('front',$data);
    }
    
    public function month(){
    	$data['title'] = "Product";
		
		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('bankwide/month',array(),TRUE);

		$this->load->view('front',$data);
    }
    
    public function profile(){
    	$data['title'] = "Profile";
		
		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('anchor/profile',array(),TRUE);

		$this->load->view('front',$data);
    }
}
