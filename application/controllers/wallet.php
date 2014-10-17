<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Wallet extends CI_Controller {
    
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
    
    public function show(){
    	$month = $this->session->userdata('rptmth');
    	
    	if($this->uri->segment(3)=='anchor'){
			$anchor_id = $this->uri->segment(4);
    	
			$wallet_ws = $this->mwallet->get_anchor_ws_wallet($anchor_id, date('Y'));
			$wallet_al = $this->mwallet->get_anchor_al_wallet($anchor_id, date('Y'));
		
			$realization_ws = $this->mrealization->get_anchor_ws_realization($anchor_id, date('Y'));
			$realization = $this->mrealization->count_realization_value($realization_ws, $realization_ws->month);
			$sow_ws = $this->mwallet->get_sow($wallet_ws, $realization, 'wholesale');
		
			$anchor = $this->manchor->get_anchor_by_id($anchor_id);
			$header = $this->load->view('anchor/anchor_header',array('anchor' => $anchor),TRUE);
		
			$arr_prod = array(); for($i=1;$i<=15;$i++){$arr_prod[$i] = $this->mwallet->return_prod_name($i);}
			$arr_name = array(); for($i=1;$i<=15;$i++){$arr_name[$i] = $this->mwallet->change_real_name($arr_prod[$i]);}
		
			$data['title'] = "Wallet - $anchor->name";
		}
		elseif($this->uri->segment(3)=='directorate'){
			$directorate = $this->uri->segment(4);
    	
			$wallet_ws = $this->mwallet->get_directorate_wallet($directorate, date('Y'), 'wholesale');
			$wallet_al = $this->mwallet->get_directorate_wallet($directorate, date('Y'), 'alliance');
		
			$realization_ws = $this->mrealization->get_directorate_realization($directorate, date('Y'), 'wholesale');
			$realization = $this->mrealization->count_realization_value($realization_ws, $realization_ws->month);
			$sow_ws = $this->mwallet->get_sow($wallet_ws, $realization, 'wholesale');
		
			$header = $this->load->view('directorate/dir_header',array('directorate' => $directorate),TRUE);
			$dirname = get_direktorat_full_name($directorate);
			$data['title'] = "Wallet - $dirname";
		}
		$arr_prod = array(); for($i=1;$i<=15;$i++){$arr_prod[$i] = $this->mwallet->return_prod_name($i);}
		$arr_name = array(); for($i=1;$i<=15;$i++){$arr_name[$i] = $this->mwallet->change_real_name($arr_prod[$i]);}
		
		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('grafik/wallet',array('header' => $header,  'wlt_ws' => $wallet_ws, 'wlt_al' => $wallet_al, 'rlz_ws' => $realization, 'sow_ws' => $sow_ws, 'prod' => $arr_prod, 'arr_name' => $arr_name),TRUE);

		$this->load->view('front',$data);
    }
}
