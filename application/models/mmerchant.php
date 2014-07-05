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
class Mmerchant extends CI_Model {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    //INSERT or CREATE FUNCTION
    
	function insert_get_new_label($label){
		if($this->db->insert('label', $label)){
    		$result = $this->db->query('SELECT MAX(id) as id FROM label');
        	if($result->num_rows>0){return $result->row(0)->id;}
            else{return false;}
    	}
	}
	
	//GET FUNCTION
	
	function get_all_merchant(){
    	$this->db->order_by('name','desc');
    	$query = $this->db->get('merchant');
        $query = $query->result();
        return $query;
    }
}
