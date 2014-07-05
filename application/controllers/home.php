<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Home extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('mmycash');
        
    }
    /**
     * Method for page (public)
     */
    public function index()
    {

		$data['title'] = "Beranda";
		
		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('home/index',array(),TRUE);

		$this->load->view('front',$data);
        
    }
    
    public function product(){
    	$data['title'] = "Product";
		
		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('home/product',array(),TRUE);

		$this->load->view('front',$data);
    }
    
    public function profile(){
    	$data['title'] = "Profile";
		
		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('home/profile',array(),TRUE);

		$this->load->view('front',$data);
    }
    
    public function input_bahasa()
    {
    	$bahasa = $this->input->post('bahasa');
        
        if(!$bahasa){
        	redirect('welcome');
        }
        else{
        	$this->session->set_userdata('bahasa',$bahasa);
        	redirect('home');
        }	
    }
    
    public function SApage()
    {
    	$data['header'] = $this->load->view('shared/header','',TRUE);
        $data['footer'] = $this->load->view('shared/footer','',TRUE);
        $data['content'] = $this->load->view('home/','',TRUE);
    }
    
    private function get_user_name_header(){
    	$user = $this->session->userdata('user');
        if($user){
        	return $user['name'];
        }else{
        	return null;
        }
    }
}
