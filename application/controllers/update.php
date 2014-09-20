<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Update extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('manchor');
        $this->load->model('mrealization');
        $this->load->model('mtarget');
        $this->load->model('mwallet');
        $this->load->model('mupdate');
        $this->load->model('muser');
        $this->load->library('excel');
        
        $session = $this->session->userdata('userdb');
        
        if(!$session){
            redirect('user/login');
        }
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
    
    public function input_analisis(){
    	$data['title'] = "Analisis Anchor";
        
        $header = '';//$this->load->view('survey/survey_header',array(''),TRUE);
        $cb1 = $this->manchor->get_anchor_by_group('CORPORATE BANKING I');
        
        $data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('survey/input_survey',array('header' => $header,'anchor' => $cb1),TRUE);
		
		$this->load->view('front',$data);
    }
    
     /*Function Anchor Analysis*/
    
    public function list_anchor_analysis(){
    	$data['title'] = "Anchor Analysis";
        
        $header = $this->load->view('update/update_header',array('title' => 'Anchor Analysis'),TRUE);
        
        $anal_anchor = $this->mupdate->get_all_list_anchor_analysis('CB1');
        $tableanal = $this->load->view('update/_table_list_anchor_anal',array('anal_anchor' => $anal_anchor),TRUE);
        
        $data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('update/list_anchor_anal',array('header' => $header,'tableanal' => $tableanal),TRUE);
		
		$this->load->view('front',$data);
    }
    
    public function change_anchor_anal(){
    	$group = $this->input->get('group');
    	$anal_anchor = $this->mupdate->get_all_list_anchor_analysis($group);
    	
		if($anal_anchor){
			$json['status'] = 1;
    		$group_member = $this->load->view('update/_table_list_anchor_anal',array('anal_anchor' => $anal_anchor),TRUE);
			$json['html'] = $group_member;
		}else{
			$json['status'] = 0;
		}
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }
    
    public function activity_wall(){
    	$data['title'] = "Activity Wall";
		$anchor_id = $this->uri->segment(3);
		
        $header = $this->load->view('update/update_header',array('title' => 'Activity List'),TRUE);
        $user = $this->session->userdata('userdb');
        $activities = $this->mupdate->get_all_activity($anchor_id);
        
        $data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('update/activity_wall',array('header' => $header, 'acts' => $activities,'user'=>$user),TRUE);
		
		$this->load->view('front',$data);
    }
    
    public function input_activity(){
    	$data['title'] = "Anchor Activity";
        
        $header = '';//$this->load->view('survey/survey_header',array(''),TRUE);
        $user = $this->session->userdata('userdb');
        $user = $this->muser->get_user_by_id($user['id']);
        $grups = explode(";", $user->anchor);
        $anchor = $this->manchor->get_anchor_by_group($grups[0]);
        
        $data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('update/input_activity',array('header' => $header,'anchor' => $anchor,'grups' => $grups, 'activity' => ""),TRUE);
		
		$this->load->view('front',$data);
    }
    
    public function submit_activity(){
    	$id = $this->uri->segment(3);
    	$user = $this->session->userdata('userdb');
    	$mading['anchor_id'] = $this->input->post('anchor');
    	$mading['cmt'] = $user['id'];
    	$mading['activity'] = $this->input->post('activity');
    	$mading['issue'] = $this->input->post('issue');
    	$mading['title'] = $this->input->post('title');
    	$mading['nextstep'] = $this->input->post('nextstep');
    	$mading['progress'] = $this->input->post('progress');
    	//$mading['support'] = $this->input->post('support');
    	$mading['report_month'] = $this->input->post('report_month');
    	$mading['date'] = date('Y-m-d h:i:s');
    	
    	$date = DateTime::createFromFormat('m/d/Y', $this->input->post('deadline'));
    	$mading['deadline'] = $date->format('Y-m-d');
    	
    	if($id){
			if($this->mupdate->update_mading($mading,$id)){
				redirect('update/activity_wall');
			}
    	}else{
			if($this->mupdate->insert_mading($mading)){
				redirect('update/activity_wall');
			}
    	}
    }
    
    public function edit_activity(){
    	$data['title'] = "Survey Anchor";
        $id = $this->uri->segment(3);
        $activity = $this->mupdate->get_activity_by_id($id);
        $header = '';//$this->load->view('survey/survey_header',array(''),TRUE);
        $anchor = $this->manchor->get_anchor_by_group($activity->group);
        
        $data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('update/input_activity',array('header' => $header,'anchor' => $anchor,'activity' => $activity),TRUE);
		
		$this->load->view('front',$data);
    }
    
    public function delete_activity(){
        if($this->mupdate->delete_mading()){
    		$json['status'] = 1;
    	}
    	else{
    		$json['status'] = 0;
    	}
    	$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}
    
    /*Function Product Analysis*/
    
    public function list_product_analysis(){
    	$data['title'] = "Product Analysis";
        
        $header = $this->load->view('update/update_header',array('title' => 'Product Analysis'),TRUE);
        
        $analysis = $this->mupdate->get_all_list_product_analysis();
        
        $data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('update/list_product_anal',array('header' => $header,'analysis' => $analysis),TRUE);
		
		$this->load->view('front',$data);
    }
    
    public function input_product_analysis(){
    	$data['title'] = "Input Product Analysis";
        
        $header = '';//$this->load->view('survey/survey_header',array(''),TRUE);
        $user = $this->session->userdata('userdb');
        $user = $this->muser->get_user_by_id($user['id']);
        $prods = explode(";", $user->product);
        
        $data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('update/input_product_anal',array('header' => $header,'prodsusr' => $prods, 'activity' => ""),TRUE);
		
		$this->load->view('front',$data);
    }
    
    public function submit_product_analysis(){
    	$id = $this->uri->segment(3);
    	$user = $this->session->userdata('userdb');
    	$mading['product_id'] = $this->input->post('product');
    	$mading['cmt'] = $user['id'];
    	$mading['analysis'] = $this->input->post('analysis');
    	$mading['issue'] = $this->input->post('issue');
    	$mading['report_month'] = $this->input->post('report_month');
    	$mading['report_year'] = $this->input->post('report_year');
    	$mading['date'] = date('Y-m-d h:i:s');
    	
    	if($id){
			if($this->mupdate->update_product_anal($mading,$id)){
				redirect('update/list_product_analysis');
			}
    	}else{
			if($this->mupdate->insert_product_anal($mading)){
				redirect('update/list_product_analysis');
			}
    	}
    }
    
    /*Other Function*/
    public function change_group_member(){
    	$group = $this->input->get('group');
    	$members = $this->manchor->get_anchor_by_group($group);
    	
		if($members){
			$json['status'] = 1;
    		$group_member = $this->load->view('update/_group_member',array('members' => $members),TRUE);
			$json['html'] = $group_member;
		}else{
			$json['status'] = 0;
		}
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }
}
