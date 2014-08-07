<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Directorate extends CI_Controller {
    
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

		$data['title'] = "Daftar Anchor";
		
		$anchor['cor'] = $this->manchor->get_anchor_by_direktorat('corporate');
		$anchor['ib'] = $this->manchor->get_anchor_by_direktorat('institutional');
		$anchor['com'] = $this->manchor->get_anchor_by_direktorat('commercial');
		
		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('directorate/index',array('anchor' => $anchor),TRUE);

		$this->load->view('front',$data);
        
    }
    
    public function realisasi(){
    	$directorate = $this->uri->segment(3);
    	$target_ws = $this->mtarget->get_directorate_target($directorate,'wholesale');
    	$realization_ws = $this->mrealization->get_directorate_realization($directorate, 5, date('Y'), 'wholesale');
    	
    	$arr_prod = array(); for($i=1;$i<=19;$i++){$arr_prod[$i] = $this->mwallet->return_prod_name($i);}
    	$arr_name = array(); for($i=1;$i<=19;$i++){$arr_name[$i] = $this->mwallet->change_real_name($arr_prod[$i]);}
    	$realization = $this->mrealization->count_realization($target_ws, $realization_ws);
    
    	$dir_header = $this->load->view('directorate/dir_header',array('directorate' => $directorate),TRUE);
    	
    	$data['title'] = "Realisasi";
		
		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('grafik/realisasi',array('header' => $dir_header, 'rlzn' => $realization, 'tgt' => $target_ws, 'prod' => $arr_prod, 'arr_name' => $arr_name),TRUE);

		$this->load->view('front',$data);
    }
    
    public function pendapatan(){
    	$directorate = $this->uri->segment(3);
    	$month = $this->mrealization->get_last_month(date('Y'));
    	$realization_ws = $this->mrealization->get_directorate_realization($directorate, date('Y'), 'wholesale');
    	$realization_al = $this->mrealization->get_directorate_realization($directorate, date('Y'), 'alliance');
    	$wallet_ws = $this->mwallet->get_directorate_wallet($directorate, date('Y'), 'wholesale');
    	
    	$dir_header = $this->load->view('directorate/dir_header',array('directorate' => $directorate),TRUE);
    	
    	$data['title'] = "Pendapatan - ";
		
		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('grafik/pendapatan',array('header' => $dir_header, 'rlzn' => $realization_ws, 'ali' => $realization_al, 'wlt' => $wallet_ws, 'month' => $month),TRUE);

		$this->load->view('front',$data);
    }
    
    public function wallet(){
    	$directorate = $this->uri->segment(3);
    	
    	$wallet_ws = $this->mwallet->get_directorate_wallet($directorate, date('Y'), 'wholesale');
    	$wallet_al = $this->mwallet->get_directorate_wallet($directorate, date('Y'), 'alliance');
    	
    	$realization_ws = $this->mrealization->get_directorate_realization($directorate, date('Y'), 'wholesale');
    	$realization = $this->mrealization->count_realization_value($realization_ws, $realization_ws->month);
    	$sow_ws = $this->mwallet->get_sow($wallet_ws, $realization, 'wholesale');
    	
    	$arr_prod = array(); for($i=1;$i<=15;$i++){$arr_prod[$i] = $this->mwallet->return_prod_name($i);}
    	$arr_name = array(); for($i=1;$i<=15;$i++){$arr_name[$i] = $this->mwallet->change_real_name($arr_prod[$i]);}
    	
    	$dir_header = $this->load->view('directorate/dir_header',array('directorate' => $directorate),TRUE);
    	
    	$data['title'] = "Wallet - ";
		
		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('grafik/wallet',array('header' => $dir_header,  'wlt_ws' => $wallet_ws, 'wlt_al' => $wallet_al, 'rlz_ws' => $realization, 'sow_ws' => $sow_ws, 'prod' => $arr_prod, 'arr_name' => $arr_name),TRUE);

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
