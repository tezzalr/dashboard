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
class Makun extends CI_Model {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    //INSERT or CREATE FUNCTION
    function insert_akun($akun){
        if($akun['parent_id']){
        	$this->update_parent_amount($akun['parent_id'], $akun['amount']);
        }
        return $this->db->insert('akun', $akun);
    }
    
    //GET FUNCTION
    function get_all_real_source(){
    	$this->db->order_by('name','desc');
    	$query = $this->db->get('real_source');
        $query = $query->result();
        return $query;
    }
    
    function get_akun_by_id($id){
    	$this->db->where('id',$id);
        $result = $this->db->get('akun');
        $query = $result->result();
        return $query[0];
    }
    
    function get_all_akun_parent(){
    	$this->db->order_by('name','asc');
    	$this->db->where('parent_id',NULL);
    	$query = $this->db->get('akun');
        $query = $query->result();
        return $query;
    }
    
    function get_all_akun_with_child(){
    	//$this->db->select('*, real_source.name as real_source, akun.name as akun_name, akun.note as akun_note');
    	//$this->db->join('real_source', 'akun.real_source_id = real_source.id', 'left');
        $arr_akun = array();
        $i=0;
        $result = $this->get_all_akun_parent();
        $akuns = $result;
        foreach($akuns as $akun){
        	$arr_akun[$i]['akun']=$akun;
        	$arr_akun[$i]['child']=$this->get_all_akun_child($akun->id);
        	$arr_akun[$i]['total']=$akun->amount+$this->get_child_total_amount($akun->id);
        	$i++;
        }
        return $arr_akun;
    }
    
    function get_all_akun_child($parent_id){
    	$this->db->where('parent_id',$parent_id);
        $result = $this->db->get('akun');
        $query = $result->result();
        return $query;
    }
    function get_child_total_amount($parent_id){
    	$child = $this->get_all_akun_child($parent_id);
    	$tot = 0;
    	foreach($child as $kid){
    		$tot = $tot+$kid->amount;
    	}
    	return $tot;
    }
    
    function update_akun($akun_id, $akun){
    	$this->db->where('id',$akun_id);
    	return $this->db->update('akun', $akun);
    }
    
    function update_parent_amount($parent_id, $amount){
    	$parent = $this->get_akun_by_id($parent_id);
    	$akun['amount'] = $parent->amount - $amount;
    	$this->db->where('id',$parent_id);
    	return $this->db->update('akun', $akun);
    }
}
