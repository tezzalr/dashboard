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
    
    function get_all_activity($anchor_id){
    	if($anchor_id){$this->db->where('mading.anchor_id',$anchor_id);}
    	
    	$this->db->select('mading.*, mading.id as mading_id, user.name as cmt, anchor.name as name, mading.cmt as cmtid');
    	$this->db->join('anchor', 'anchor.id = mading.anchor_id');
    	$this->db->join('user', 'user.id = mading.cmt');
    	$this->db->order_by('mading.date','desc');
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
    
    function get_activity_by_anchor_id($id){
    	$this->db->select('*, mading.id as mading_id');
    	$this->db->join('anchor', 'anchor.id = mading.anchor_id');
    	$this->db->where('mading.id',$id);
    	$this->db->order_by('mading.id','desc');
    	$result = $this->db->get('mading');
    	$act = $result->result();
    	return $act[0];
    }
    
    function get_list_product_analysis($product){
    	$this->db->where('product_id',$product);
    	$this->db->order_by('report_month','asc');
    	$result = $this->db->get('product_anal');
    	return $result->result();
    }
    
    function get_all_list_product_analysis(){
    	$arr = array(); $i=0;
    	$prods = get_product_anal_prod();
    	foreach($prods as $prod){
    		$arr[$i]['prod_name'] = $prod['name'];
    		$arr[$i]['analysis'] = $this->get_list_product_analysis($prod['ins']);
    		$i++;
    	}
		return $arr;
    }
    
    function get_all_list_anchor_analysis($dir){
    	get_direktorat_where($dir,$this);
    	$this->db->order_by('anchor.name','asc');
    	$result = $this->db->get('anchor');
    	$result = $result->result();
    	
    	$arr = array(); $i=0;
    	foreach($result as $res){
    		$arr[$i]['anchor'] = $res;
    		$arr[$i]['act'] = $this->get_anchor_last_act($res->id);
    		$i++;
    	}
    	return $arr;
    }
    
    function get_anchor_last_act($anchor_id){
    	$this->db->where('anchor_id',$anchor_id);
    	$this->db->order_by('id','desc');
    	$this->db->limit(1);
    	$result = $this->db->get('mading');
    	if($result->num_rows>0){
            return $result->row(0);
        }else{
            return false;
        }
    }
    
   //INSERT FUNCTION
   function insert_mading($mading){
        return $this->db->insert('mading', $mading);
    }
    
    function insert_product_anal($prod){
        return $this->db->insert('product_anal', $prod);
    }
    
    //UPDATE
    function update_mading($mading,$id){
        $this->db->where('id',$id);
        return $this->db->update('mading', $mading);
    }
    
    function update_product_anal($prod,$id){
        $this->db->where('id',$id);
        return $this->db->update('product_anal', $prod);
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
