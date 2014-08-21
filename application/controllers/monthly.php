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
    
    public function resume(){
    	$dir = $this->uri->segment(3);
    	$year = date('Y');
    	$month = $this->mrealization->get_last_month($year);
    	
    	if($dir == "CB"){$groups = array('CB1','CB2','CB3','AGB','SOG');}
    	elseif($dir == "IB"){$groups = array('IB1','IB2');}
    	elseif($dir == "CBB"){$groups = array('JCS','RCS1','RCS2');}
    	
    	foreach($groups as $group){
    		$casa[$group]["ly"] = $this->manchor->get_total_vol_prd("CASA", 12, $year-1, 'wholesale_realization',$group);
			$casa[$group]["tm"] = $this->manchor->get_total_vol_prd("CASA", $month, $year, 'wholesale_realization',$group);
			$casa[$group]["wal"] = $this->manchor->get_total_vol_prd("CASA", 0, 2014, 'wholesale_wallet_size',$group);
			$casa[$group]["tgt"] = $this->manchor->get_total_vol_prd("CASA", 0, 2014, 'wholesale_target',$group);
			
			$realization_ws_ly = $this->mrealization->get_directorate_realization_w_month($group, $year-1, 'wholesale',12);
    		$real_ly = $this->mrealization->count_realization_value($realization_ws_ly, $realization_ws_ly->month);
    		$realization_ws_tm = $this->mrealization->get_directorate_realization_w_month($group, $year, 'wholesale',$month);
    		$real_tm = $this->mrealization->count_realization_value($realization_ws_tm, $realization_ws_tm->month);
    		$wal = $this->mwallet->get_directorate_wallet($group, date('Y'), 'wholesale');
    		$tgt = $this->mtarget->get_directorate_target($group,'wholesale');
    		
    		$fbi[$group]["ly"] = $real_ly['Trade_inc']+$real_ly['BG_inc']+$real_ly['SF_inc']+$real_ly['FX_inc']+$real_ly['OIR_inc']+$real_ly['LMF_inc'];
    		$fbi[$group]["tm"] = $real_tm['Trade_inc']+$real_tm['BG_inc']+$real_tm['SF_inc']+$real_tm['FX_inc']+$real_tm['OIR_inc']+$real_tm['LMF_inc'];
    		$fbi[$group]["wal"] = $wal->Trade_fbi + $wal->BG_fbi + $wal->SL_fbi + $wal->FX_fbi + $wal->OIR_fbi + $wal->WCL_fbi + $wal->IL_fbi;
    		$fbi[$group]["tgt"] = $tgt->Trade_fbi + $tgt->BG_fbi + $tgt->SL_fbi + $tgt->FX_fbi + $tgt->OIR_fbi + $tgt->WCL_fbi + $tgt->IL_fbi;
			
			$kredit[$group]["ly"] = $this->manchor->get_total_vol_prd("WCL", 12, $year-1, 'wholesale_realization',$group)->WCL_vol+$this->manchor->get_total_vol_prd("IL", 12, $year-1, 'wholesale_realization',$group)->IL_vol;
			$kredit[$group]["tm"] = $this->manchor->get_total_vol_prd("WCL", $month, $year, 'wholesale_realization',$group)->WCL_vol+$this->manchor->get_total_vol_prd("IL", $month, $year, 'wholesale_realization',$group)->IL_vol;
			$kredit[$group]["wal"] = $this->manchor->get_total_vol_prd("WCL", 0, 2014, 'wholesale_wallet_size',$group)->WCL_vol+$this->manchor->get_total_vol_prd("IL", 0, 2014, 'wholesale_wallet_size',$group)->IL_vol;
			$kredit[$group]["tgt"] = $this->manchor->get_total_vol_prd("WCL", 0, 2014, 'wholesale_target',$group)->WCL_vol+$this->manchor->get_total_vol_prd("IL", 0, 2014, 'wholesale_target',$group)->IL_vol;
    	}
    	
    	$header = $this->load->view('monthly/monthly_header',array('directorate' => $dir),TRUE);
    	
    	$total['casa'] = $casa; $total['kredit'] = $kredit; $total['fbi'] = $fbi;
    	$data['title'] = "Laporan CASA";
    	$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('monthly/resume',array('month'=>$month,'total'=>$total, 'header' => $header),TRUE);

		$this->load->view('front',$data);
    }
    
    public function CASA(){
    	$dir = $this->uri->segment(3);
    	$year = date('Y');
    	$month = $this->mrealization->get_last_month($year);
    	$pareto = $this->manchor->get_top_anchor_prd("CASA", $month, $year);
    	$total["ly"] = $this->manchor->get_total_vol_prd("CASA", 12, $year-1, 'wholesale_realization','');
    	$total["tm"] = $this->manchor->get_total_vol_prd("CASA", $month, $year, 'wholesale_realization','');
    	$total["wal"] = $this->manchor->get_total_vol_prd("CASA", 0, 2014, 'wholesale_wallet_size','');
    	$total["tgt"] = $this->manchor->get_total_vol_prd("CASA", 0, 2014, 'wholesale_target','');
    	
    	$header = $this->load->view('monthly/monthly_header',array('directorate' => $dir),TRUE);
    	
    	$data['title'] = "Laporan CASA";
    	$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('monthly/CASA',array('month'=>$month,'pareto'=>$pareto,'total'=>$total, 'header' => $header),TRUE);

		$this->load->view('front',$data);
    }
    
    public function top(){
    	$dir = $this->uri->segment(3);
    	$year = date('Y');
    	$month = $this->mrealization->get_last_month($year);
    	//casa
    	$pareto['casa'] = $this->manchor->get_top_anchor_prd("CASA", $month, $year);
    	$total['casa']["ly"] = $this->manchor->get_total_vol_prd("CASA", 12, $year-1, 'wholesale_realization','');
    	$total['casa']["tm"] = $this->manchor->get_total_vol_prd("CASA", $month, $year, 'wholesale_realization','');
    	
    	//kredit
    	$pareto['kredit'] = $this->manchor->get_top_anchor_kredit($month, $year);
    	$total['kredit']["ly"] = $this->manchor->get_total_vol_prd("WCL", 12, $year-1, 'wholesale_realization','')->WCL_vol+$this->manchor->get_total_vol_prd("IL", 12, $year-1, 'wholesale_realization','')->IL_vol;
		$total['kredit']["tm"] = $this->manchor->get_total_vol_prd("WCL", $month, $year, 'wholesale_realization','')->WCL_vol+$this->manchor->get_total_vol_prd("IL", $month, $year, 'wholesale_realization','')->IL_vol;
		
		$header = $this->load->view('monthly/monthly_header',array('directorate' => $dir),TRUE);
			
    	$data['title'] = "Laporan CASA";
    	$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('monthly/top',array('month'=>$month,'pareto'=>$pareto,'total'=>$total, 'header' => $header),TRUE);

		$this->load->view('front',$data);
    }
    
    public function top_fbi(){
    	$dir = $this->uri->segment(3);
    	$year = date('Y');
    	$month = $this->mrealization->get_last_month($year);
    	$fbis = array('Trade','FX','BG','OIR');
    	$i=0;
    	foreach($fbis as $fbi){
    		$pareto[$i]['prod'] = $this->manchor->get_top_anchor_prd($fbi, $month, $year);
    		$pareto[$i]['name'] = $fbi;
    		$pareto[$i]["ly"] = $this->manchor->get_total_vol_prd($fbi, 12, $year-1, 'wholesale_realization','CB');
    		$pareto[$i]["tm"] = $this->manchor->get_total_vol_prd($fbi, $month, $year, 'wholesale_realization','CB');
    		$i++;
    	}
    	
    	$header = $this->load->view('monthly/monthly_header',array('directorate' => $dir),TRUE);
    		
    	$data['title'] = "Laporan Top FBI";
    	$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('monthly/top_fbi',array('month'=>$month,'pareto'=>$pareto, 'header' => $header),TRUE);

		$this->load->view('front',$data);
    }
    
    public function valas(){
    	$year = date('Y');
    	$dir = $this->uri->segment(3);
    	$month = $this->mrealization->get_last_month($year);
    	$pareto = $this->manchor->get_top_anchor_valas($month, $year,$dir);
    	$total["ly"]["idr"] = $this->manchor->get_total_anything("CASA_idr", 12, $year-1, "detail_realization", $dir);
    	$total["ly"]["val"] = $this->manchor->get_total_anything("CASA_val", 12, $year-1, "detail_realization", $dir);
    	$total["tm"]["idr"] = $this->manchor->get_total_anything("CASA_idr", $month, $year, "detail_realization", $dir);
    	$total["tm"]["val"] = $this->manchor->get_total_anything("CASA_val", $month, $year, "detail_realization", $dir);
    	
    	$header = $this->load->view('monthly/monthly_header',array('directorate' => $dir),TRUE);
    	
    	$data['title'] = "komposisi CASA";
    	$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('monthly/valas',array('month'=>$month,'pareto'=>$pareto,'total'=>$total, 'header' => $header),TRUE);

		$this->load->view('front',$data);
    }
}
