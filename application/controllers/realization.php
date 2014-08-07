<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Realization extends CI_Controller {
    
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
    	if($this->uri->segment(3)=='anchor'){
			$anchor_id = $this->uri->segment(4);
			$target_ws = $this->mtarget->get_anchor_ws_target($anchor_id);
			$realization_ws = $this->mrealization->get_anchor_ws_realization($anchor_id, date('Y'));
	
			$anchor = $this->manchor->get_anchor_by_id($anchor_id);
			$header = $this->load->view('anchor/anchor_header',array('anchor' => $anchor, 'id_ybs' => $anchor->id, 'code' => 'anc'),TRUE);
			$data['title'] = "Realisasi - $anchor->name";
		}
		elseif($this->uri->segment(3)=='directorate'){
			$directorate = $this->uri->segment(4);
			$target_ws = $this->mtarget->get_directorate_target($directorate,'wholesale');
			$realization_ws = $this->mrealization->get_directorate_realization($directorate, date('Y'), 'wholesale');
			
			$header = $this->load->view('directorate/dir_header',array('directorate' => $directorate, 'id_ybs' => $directorate, 'code' => 'dir'),TRUE);
			$data['title'] = "Realisasi";
		}
		$realization = $this->mrealization->count_realization($target_ws, $realization_ws);
		$arr_prod = array(); for($i=1;$i<=19;$i++){$arr_prod[$i] = $this->mwallet->return_prod_name($i);}
		$arr_name = array(); for($i=1;$i<=19;$i++){$arr_name[$i] = $this->mwallet->change_real_name($arr_prod[$i]);}
    	
		$graphview = $this->load->view('grafik/realisasi/_graph_view',array('rlzn' => $realization, 'tgt' => $target_ws, 'prod' => $arr_prod, 'arr_name' => $arr_name),TRUE);

		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('grafik/realisasi',array('header' => $header, 'graphview' => $graphview),TRUE);

		$this->load->view('front',$data);
    }
    
    public function realization_table_view(){
        $code = $this->input->get('code');
        if($code == 'anc'){
			$anchor_id = $this->input->get('id');
			$target_ws = $this->mtarget->get_anchor_ws_target($anchor_id);
			$realization_ws = $this->mrealization->get_anchor_ws_realization($anchor_id, date('Y'));
		}
		elseif($code == 'dir'){
			$directorate = $this->input->get('id');
			$target_ws = $this->mtarget->get_directorate_target($directorate,'wholesale');
			$realization_ws = $this->mrealization->get_directorate_realization($directorate, date('Y'), 'wholesale');
		}
		$realization_now = $this->mrealization->count_realization_now($realization_ws);
		$realization_percent = $this->mrealization->count_realization($target_ws, $realization_ws);
		$realization_YTD = $this->mrealization->count_realization_value($realization_ws, $realization_ws->month);
    	$arr_prod = array(); for($i=1;$i<=19;$i++){$arr_prod[$i] = $this->mwallet->return_prod_name($i);}
    	$arr_name = array(); for($i=1;$i<=19;$i++){$arr_name[$i] = $this->mwallet->change_real_name($arr_prod[$i]);}
    	
		if($target_ws && $realization_ws){
			$json['status'] = 1;
    		$tableview = $this->load->view('grafik/realisasi/_table_view',array('ytd' => $realization_YTD, 'pct' =>$realization_percent, 'rlzn' => $realization_now, 'tgt' => $target_ws, 'prod' => $arr_prod, 'arr_name' => $arr_name),TRUE);
            $json['html'] = $tableview;
		}else{
			$json['status'] = 0;
		}
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}
	
	public function realization_graph_view(){
       	$code = $this->input->get('code');
        if($code == 'anc'){
			$anchor_id = $this->input->get('id');
			$target_ws = $this->mtarget->get_anchor_ws_target($anchor_id);
			$realization_ws = $this->mrealization->get_anchor_ws_realization($anchor_id, date('Y'));
		}
		elseif($code = 'dir'){
			$directorate = $this->input->get('id');
			$target_ws = $this->mtarget->get_directorate_target($directorate,'wholesale');
			$realization_ws = $this->mrealization->get_directorate_realization($directorate, date('Y'), 'wholesale');
		}
    	$realization = $this->mrealization->count_realization($target_ws, $realization_ws);
    	
    	$arr_prod = array(); for($i=1;$i<=19;$i++){$arr_prod[$i] = $this->mwallet->return_prod_name($i);}
    	$arr_name = array(); for($i=1;$i<=19;$i++){$arr_name[$i] = $this->mwallet->change_real_name($arr_prod[$i]);}
    	
		if($target_ws && $realization_ws){
			$json['status'] = 1;
    		$graphview = $this->load->view('grafik/realisasi/_graph_view',array('rlzn' => $realization, 'tgt' => $target_ws, 'prod' => $arr_prod, 'arr_name' => $arr_name),TRUE);
            $json['html'] = $graphview;
		}else{
			$json['status'] = 0;
		}
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}
}
