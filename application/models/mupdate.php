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
class Mupdate extends CI_Model {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    //INSERT or CREATE FUNCTION
        
    //GET FUNCTION
    
    function get_all_activity(){
    	$this->db->select('*, mading.id as mading_id');
    	$this->db->join('anchor', 'anchor.id = mading.anchor_id');
    	$this->db->order_by('mading.id','desc');
    	$result = $this->db->get('mading');
    	return $result->result();
    }
    
    function get_activity_by_id($id){
    	$this->db->select('*, mading.id as mading_id');
    	$this->db->join('anchor', 'anchor.id = mading.anchor_id');
    	$this->db->where('mading.id',$id);
    	$this->db->order_by('mading.id','desc');
    	$result = $this->db->get('mading');
    	$act = $result->result();
    	return $act[0];
    }
    
   //INSERT FUNCTION
   function insert_mading($mading){
        return $this->db->insert('mading', $mading);
    }
    
    //UPDATE
    function update_mading($mading,$id){
        $this->db->where('id',$id);
        return $this->db->update('mading', $mading);
    }
    
    //DELETE FUNCTION
    function delete_mading(){
    	$id = $this->input->post('id');
    	$this->db->where('id',$id);
    	$this->db->delete('mading');
    	if($this->db->affected_rows()>0){
    		return true;
    	}
    	else{
    		return false;
    	}
    }
}
