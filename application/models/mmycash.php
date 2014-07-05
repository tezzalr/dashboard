<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of admins
 *
 * @author Maulnick
 */
class Mmycash extends CI_Model {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    //INSERT or CREATE FUNCTION
    
    function insert_my_cash($my_cash){
		$rab = $this->get_rab_id($my_cash['date']);
		$my_cash['rab_id']=$rab->id;
		
        if($this->update_profil($my_cash['amount'], $my_cash['kind'])){
        	return $this->db->insert('my_cash', $my_cash);
        }
    }
    
    function update_profil($amount, $kind){
    	$point = $amount/2500;
    	$info_user = $this->get_user('tezzalr');
    	if($kind == 'Expense'){$user['amount'] = ($info_user->amount - $amount);}
    	else{$user['amount'] = ($info_user->amount + $amount);}
    	$user['point'] = ($info_user->point + $point);
    	
    	$this->db->where('userid','tezzalr');
    	$result = $this->db->update('user', $user);
        return $result;
    }
    
    function redeem_my_point($point){
    	$info_user = $this->get_user('tezzalr');
    	$user['point'] = ($info_user->point - $point);
    	
    	$this->db->where('userid','tezzalr');
    	$result = $this->db->update('user', $user);
        return $result;
    }
    
    
    
    //GET FUNCTION
    function get_user($userid){
    	$this->db->where('userid',$userid);
    	$result = $this->db->get('user');
        $query = $result->result();
        return $query[0];
    }
    
    function get_rab_id($date){
    	$date = DateTime::createFromFormat('Y-m-d', $date);
    	
    	$this->db->where('month',$date->format('m'));
    	$this->db->where('year',$date->format('Y'));
    	$result = $this->db->get('rab');
        $query = $result->result();
        return $query[0];
    }
    
    function get_mycash_by_RAB($rab_id){
    	$this->db->select('*, label.name as label_name');
    	$this->db->join('label', 'my_cash.label_id = label.id');
    	$this->db->join('merchant', 'my_cash.merchant_id = merchant.id', 'left');
    	$this->db->order_by('my_cash.date', 'desc');
    	$this->db->where('rab_id',$rab_id);
        $result = $this->db->get('my_cash');
        $query = $result->result();
        return $query;
    }
    
    function get_all_promo(){
    	$this->db->select('*, label.name as label_name');
    	$this->db->join('label', 'promo.label_id = label.id');
    	$this->db->join('merchant', 'promo.merchant_id = merchant.id', 'left');
    	$this->db->order_by('promo.merchant_id', 'desc');
        $result = $this->db->get('promo');
        $query = $result->result();
        return $query;
    }
    
    function get_mycash_by_label_RAB($label_id, $rab_id){
    	$this->db->join('label', 'my_cash.label_id = label.id');
    	$this->db->order_by('my_cash.id', 'desc');
    	$this->db->where('rab_id',$rab_id);
    	$this->db->where('label_id',$label_id);
        $result = $this->db->get('my_cash');
        $query = $result->result();
        return $query;
    }
    
    function get_position_by_RAB($rab_id){
    	$this->db->where('userid','tezzalr');
    	$result = $this->db->get('user');
        $query = $result->result();
    	return $query[0]->amount;
    }
    
    function get_position_by_label_RAB($label_id, $rab_id){
    	$allmycash = $this->get_mycash_by_label_RAB($label_id, $rab_id);
    	$posisi = 0;
    	foreach ($allmycash as $mycash){
    		$posisi = $posisi+$mycash->amount;
    	}
    	return $posisi;
    }
    
    function get_myplan_max_amount_by_label_RAB($label_id, $rab_id){
    	$this->db->where('rab_id',$rab_id);
    	$this->db->where('label_id',$label_id);
    	$result = $this->db->get('my_plan');
        $query = $result->result();
        if($query){
        	return $query[0]->max_amount;
        }
    }
    
    function get_mycash_labelsort_by_RAB($rab_id){
    	$this->db->select('DISTINCT(label_id), label.name as name, kind');
    	$this->db->join('label', 'my_cash.label_id = label.id');
    	$this->db->where('rab_id',$rab_id);
        $result = $this->db->get('my_cash');
        $allmycash = $result->result();
        $arrlabel = array(); 
        $i=0;
        foreach ($allmycash as $mycash){
        	$maxaloc = $this->get_myplan_max_amount_by_label_RAB($mycash->label_id, $rab_id);
        	if($mycash->kind == 'Expense'){
				$arrlabel[$i]['name']=$mycash->name;
				$arrlabel[$i]['amount']=$this->get_position_by_label_RAB($mycash->label_id, $rab_id);
				$arrlabel[$i]['max-aloc']= $maxaloc;
				$i++;
        	}
        }
        return $arrlabel;
    }
}
