<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Scorecard extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('manchor');
        $this->load->model('mrealization');
        $this->load->model('mwallet');
        
    }
    /**
     * Method for page (public)
     */
    public function show(){
		$data['title'] = "Scorecard";
		
		$sc = array(); $i=0; 
		$real = array();
		$p1=0; $p2=0; $p3=0; $g1=0; $g2=0; $g3=0; $s1=0; $s2=0; $s3=0;
		$month = $this->session->userdata('rptmth');
		//$arrsc = array('platinum','gold','silver');
		
		$anchors = $this->manchor->get_anchor_sc();
		foreach($anchors as $anchor){
			$rlz_raw = $this->mrealization->get_anchor_ws_realization($anchor->id, date('Y'));
			$wallet = $this->mwallet->get_anchor_ws_wallet($anchor->id, date('Y'));		
    		$rlz = $this->mrealization->count_realization_value($rlz_raw, $month);
    		$sow = $this->mwallet->get_sow($wallet, $rlz, 'wholesale');
    		
			$sc[$i]['anchor'] = $anchor;
			$sc[$i]['wal'] = $this->mwallet->get_anchor_total_wallet($anchor->id, date('Y'));
			$sc[$i]['inc'] = $this->mrealization->get_anchor_total_income($anchor->id, date('Y'));
			$sc[$i]['sow'] = $sc[$i]['inc']['ws']/$sc[$i]['wal']['ws'];
			if($sow[32]){
				$sc[$i]['trx'] = $sow[34]/$sow[32];
			}else{$sc[$i]['trx'] = 0;}
			if($rlz['IL_vol']+$rlz['WCL_vol']+$rlz['SL_vol']){
				$sc[$i]['casx'] = $rlz['CASA_vol']/($rlz['IL_vol']+$rlz['WCL_vol']+$rlz['SL_vol']);
			}else{$sc[$i]['casx'] = 0;}
			$i++;
		}
		
		foreach($sc as $each){
			if($each['sow']<=0.1 || $each['trx']<=0.5 || $each['casx']<=0.05){
				$ring = 3;
			}
			elseif(($each['sow']>0.1 && $each['sow']<=0.3) || ($each['trx']>0.5 && $each['trx']<=1) || ($each['casx']>0.05 && $each['casx']<=0.1)){
				$ring = 2;
			}else{
				$ring = 1;
			}
			if($each['anchor']->gas >20000){
				if($ring==1){$x=$p1;}elseif($ring==2){$x=$p2;}else{$x=$p3;}
				$arrsc['platinum'][$ring][$x] = $each;
				if($ring==1){$p1++;}elseif($ring==2){$p2++;}else{$p3++;}
			}
			elseif($each['anchor']->gas < 20000 && $each['anchor']->gas > 5000){
				if($ring==1){$x=$g1;}elseif($ring==2){$x=$g2;}else{$x=$g3;}
				$arrsc['gold'][$ring][$x] = $each;
				if($ring==1){$g1++;}elseif($ring==2){$g2++;}else{$g3++;}
			}
			elseif($each['anchor']->gas < 5000){
				if($ring==1){$x=$s1;}elseif($ring==2){$x=$s2;}else{$x=$s3;}
				$arrsc['silver'][$ring][$x] = $each;
				if($ring==1){$s1++;}elseif($ring==2){$s2++;}else{$s3++;}
			}
		}
		
		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('scorecard/scorecard_table',array('scs'=>$arrsc),TRUE);

		$this->load->view('front',$data);
        
    }
}
