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
class Mmyplan extends CI_Model {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    //INSERT or CREATE FUNCTION
    
    function insert_my_plan($my_plan){
        $my_plan['rab_id']=1;
        return $this->db->insert('my_plan', $my_plan);
    }
    
    function insert_my_plan_real($my_plan){
        return $this->db->insert('my_plan', $my_plan);
    }
    
    function insert_rab($rab){
        return $this->db->insert('rab', $rab);
    }
    
    function insert_fix_plan($fix_plan){
    	return $this->db->insert('fix_plan', $fix_plan);
    }
    
    function insert_fix_plan_to_rab($month, $year){
    	$rab_id = $this->get_rab_by_month_year($month, $year);
    	$fix_plans = $this->get_all_fix_plan();
    	foreach ($fix_plans as $plan){
    		$my_plan['kind'] = $plan->kind;
    		$my_plan['label_id'] = $plan->label_id;
    		$my_plan['detail'] = $plan->detail;
    		$my_plan['max_amount'] = $plan->max_amount;
    		$my_plan['rab_id'] = $rab_id;
    		
    		$this->insert_my_plan_real($my_plan);
    	}
    	return true;
    }
    
    //GET FUNCTION
    function get_rab_by_month_year($month, $year){
    	$this->db->where('month',$month);
    	$this->db->where('year',$year);
        $result = $this->db->get('rab');
        $query = $result->result();
        return $query[0]->id;
    }
    
    function get_rab_by_id($id){
    	$this->db->where('id',$id);
        $result = $this->db->get('rab');
        $query = $result->result();
        return $query[0];
    }
    
    function get_all_fix_plan(){
    	$result = $this->db->get('fix_plan');
        $query = $result->result();
        return $query;
    }
    
    function get_myplan_by_RAB($rab_id){
    	//$this->db->select('*, cart_item.id as cart_item_id');
    	$this->db->join('label', 'my_plan.label_id = label.id');
    	$this->db->order_by('my_plan.id', 'desc');
    	$this->db->where('rab_id',$rab_id);
        $result = $this->db->get('my_plan');
        $query = $result->result();
        return $query;
    }
    
    function get_all_rab(){
    	$this->db->order_by('month', 'asc');
    	$result = $this->db->get('rab');
        $query = $result->result();
        return $query;	
    }
}
