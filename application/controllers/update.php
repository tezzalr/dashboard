<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Update extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('manchor');
        $this->load->model('mrealization');
        $this->load->model('mtarget');
        $this->load->model('mwallet');
        $this->load->model('mupdate');
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
    
    public function input_analisis(){
    	$data['title'] = "Analisis Anchor";
        
        $header = '';//$this->load->view('survey/survey_header',array(''),TRUE);
        $cb1 = $this->manchor->get_anchor_by_group('CORPORATE BANKING I');
        
        $data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('survey/input_survey',array('header' => $header,'anchor' => $cb1),TRUE);
		
		$this->load->view('front',$data);
    }
    
    public function activity_wall(){
    	$data['title'] = "Activity Wall";
        
        $header = $this->load->view('update/update_header',array('title' => 'Activity List'),TRUE);
        
        $activities = $this->mupdate->get_all_activity();
        
        $data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('update/activity_wall',array('header' => $header, 'acts' => $activities),TRUE);
		
		$this->load->view('front',$data);
    }
    
    public function input_activity(){
    	$data['title'] = "Survey Anchor";
        
        $header = '';//$this->load->view('survey/survey_header',array(''),TRUE);
        $cb1 = $this->manchor->get_anchor_by_group('CORPORATE BANKING I');
        
        $data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('update/input_activity',array('header' => $header,'anchor' => $cb1, 'activity' => ""),TRUE);
		
		$this->load->view('front',$data);
    }
    
    public function submit_activity(){
    	$id = $this->uri->segment(3);
    	$mading['anchor_id'] = $this->input->post('anchor');
    	$mading['cmt'] = $this->input->post('cmt');
    	$mading['activity'] = $this->input->post('activity');
    	$mading['issue'] = $this->input->post('issue');
    	$mading['support'] = $this->input->post('support');
    	$mading['date'] = date('Y-m-d h:i:s');
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
