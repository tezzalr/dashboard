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
class Mtarget extends CI_Model {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    //INSERT or CREATE FUNCTION
        
    //GET FUNCTION
    
    /*Anchor Function*/
    
    function get_anchor_ws_target($anchor_id){
    	$this->db->where('anchor_id',$anchor_id);
    	$result = $this->db->get('wholesale_target');
    	$query = $result->result();
        return $query[0];
    }
    
    function get_anchor_al_target($anchor_id){
    	$this->db->where('anchor_id',$anchor_id);
    	$result = $this->db->get('alliance_target');
    	$query = $result->result();
        return $query[0];
    }
     /*Directorate Function*/
     function get_directorate_target($direktorat,$type){
     	$db = $type.'_target';
    	get_type_select($type, $this);
    	get_direktorat_where($direktorat,$this);
    	$this->db->where('year',2014);
    	$this->db->join('anchor', 'anchor.id = '.$db.'.anchor_id');
    	$result = $this->db->get($db);
    	$query = $result->result();
        return $query[0];
    }
}
