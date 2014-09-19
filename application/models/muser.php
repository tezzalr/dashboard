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
class Muser extends CI_Model {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    //INSERT or CREATE FUNCTION
    
    
    
    function verify($username, $password){
        $this->db->where('username',$username);
        $this->db->where('password',$password);
        $result = $this->db->get('user');
        if($result->num_rows==1){
            return true;
        }else{
            return false;
        }
    }
    
    function insert_profil($profil){
        return $this->db->insert('profil', $profil);
    }
    
    function insert_user($user){
        return $this->db->insert('user', $user);
    }
    
    function insert_payment($payment){
        return $this->db->insert('payment', $payment);
    }
    
    function insert_shipping($shipping){
        return $this->db->insert('shipping', $shipping);
    }
    
    function register($user){
    	return $this->db->insert('user', $user);
    }
    
    function insert_get_new_address($profil){
    	if($this->insert_profil($profil)){
    		return $this->get_address_by_id($this->get_last_profil_id());
    	}
    }
    
    function insert_photo_slider($photo_slider){
        return $this->db->insert('photo_slider', $photo_slider);
    }
    
    //GET FUNCTION
    
    function get_all_customer(){
    	$this->db->where('role', 3);
    	$this->db->order_by('id', 'desc');
    	$query = $this->db->get('user');
        return $query->result();
    }
    
    function get_all_customer_order($atr, $how){
    	$this->db->where('role',3);
    	$this->db->order_by($atr, $how);
    	$query = $this->db->get('user');
        return $query->result();
    }
    
    function get_all_customer_search($query){
    	$like = "name LIKE '$query%' OR username LIKE '$query%'";
    	$this->db->where("($like)");
    	$this->db->order_by('id', 'desc');
    	$this->db->where('role',3);
    	$query = $this->db->get('user');
        return $query->result();
    }
    
    function get_user_login(){
        $user = $this->session->userdata('user');
    	$this->db->where('id',$user['user_id']);
        $result = $this->db->get('user');
        if($result->num_rows==1){
            return $result->row(0);
        }else{
        	$this->session->unset_userdata('user');
            return false;
        }
    }
    
    function get_user_id_by_username($username){
        $this->db->where('username',$username);
        $result = $this->db->get('user');
        if($result->num_rows==1){
            return $result->row(0);
        }else{
            return false;
        }
    }
    
    function get_customer_id_by_username($username){
        $this->db->where('username',$username);
        $this->db->where('role',3);
        $result = $this->db->get('user');
        if($result->num_rows==1){
            return $result->row(0);
        }else{
            return false;
        }
    }
    
    function get_user_by_id($id){
        $this->db->where('id',$id);
        $result = $this->db->get('user');
        if($result->num_rows==1){
            return $result->row(0);
        }else{
            return false;
        }
    }
    
    function get_user_detail($id){
    	//$arr = array();
    	$arr['Info'] = $this->get_user_by_id($id);
    	$arr['Adr'] = $this->get_user_all_address_by_user_id($id);
    	return $arr;
    }
    
    function get_user_login_with_address(){
    	$usr = $this->session->userdata('user');
    	$user ='';
    	
    	$this->db->where('id',$usr['user_id']);
    	$query = $this->db->get('user');
        $query = $query->result();
        $info = $query[0];
        if($info){
    		$address = $this->get_user_first_address($usr['user_id']);
    		$user["Info"] = $info;
    		$user["Adr"] = $address;
    	}
        return $user;
    }
    
    function get_user_first_address($user_id){
    	$this->db->order_by('profil.id', 'asc');
    	$this->db->where('user_id',$user_id);
        $this->db->limit(1);
        $this->db->select('profil.*, province_name, city_name');
    	$this->db->join('province', 'province.id = profil.province', 'left');
    	$this->db->join('city', 'city.id = profil.city', 'left');
        $result = $this->db->get('profil');
        if($result->num_rows>0){
            return $result->row(0);
        }else{
            return false;
        }
    }
    
    function get_user_name_header(){
    	$user = $this->session->userdata('user');
        if($user){
        	$user = $this->get_user_login();
        	if(!$user){redirect('home');}
        	$user_first_name = explode(' ',$user->name);
        	return $user_first_name[0];
        }else{
        	return null;
        }
    }
    
    function get_existing_email($email){
        // return true jika ada email di tabel user_temp atau user
        $this->db->where('username',$email);
        $result = $this->db->get('user');
        if($result->num_rows>0){
            return true;
        }else{
            return false;
        }
    }
    
    function get_existing_email_edit($email,$old_email){
        // return true jika ada email di tabel user_temp atau user
        $this->db->where('username',$email);
        $result = $this->db->get('user');
        if(($result->num_rows>0)&& $email!=$old_email){
            return true;
        }else{
            return false;
        }
    }
    
    function get_user_password($password){
    	$user = $this->get_user_login();
    	$m = md5($password);
    	if($m == $user->password){return true;}
    	else{return false;}
    }
    
    function get_last_profil_id(){
        $result = $this->db->query('SELECT MAX(id) as id FROM profil');
        if($result->num_rows>0){
            return $result->row(0)->id;
        }else{
            return false;
        }
    }
    
    function get_last_user_id(){
        $result = $this->db->query('SELECT MAX(id) as id FROM user');
        if($result->num_rows>0){
            return $result->row(0)->id;
        }else{
            return false;
        }
    }
    
    function get_address_by_id($id){
    	$this->db->where('profil.id',$id);
    	$this->db->select('profil.*, province_name, city_name');
    	$this->db->join('province', 'province.id = profil.province','left');
    	$this->db->join('city', 'city.id = profil.city','left');
        $result = $this->db->get('profil');
        if($result->num_rows==1){
            return $result->row(0);
        }else{
            return false;
        }
    }
    
    function get_user_all_address(){
    	$user = $this->session->userdata('user');
    	$this->db->select('profil.*, province_name, city_name');
    	$this->db->join('province', 'province.id = profil.province','left');
    	$this->db->join('city', 'city.id = profil.city','left');
    	$this->db->where('user_id',$user['user_id']);
    	$this->db->order_by('profil.id','desc');
        $result = $this->db->get('profil');
        if($result->num_rows>0){
            return $result->result();
        }else{
            return false;
        }
    }
    
    function get_user_all_address_by_user_id($user_id){
    	$this->db->where('user_id',$user_id);
    	$this->db->select('profil.*, province_name, city_name');
    	$this->db->join('province', 'province.id = profil.province','left');
    	$this->db->join('city', 'city.id = profil.city','left');
    	$this->db->order_by('profil.id','desc');
        $result = $this->db->get('profil');
        if($result->num_rows>0){
            return $result->result();
        }else{
            return false;
        }
    }
    
    function is_address_used($id){
    	$this->db->where('billing_adr',$id);
    	$this->db->or_where('shipping_adr',$id);
    	$result = $this->db->get('purchase');
    	if($result->num_rows>0){return true;}
    	else{return false;}
    }
    
    function get_all_slider_photos(){
    	$this->db->order_by('id','desc');
    	$query = $this->db->get('photo_slider');
        $query = $query->result();
        return $query;
    }
    
    function get_photo_slider_by_id($id){
        $this->db->where('id', $id);
        $result = $this->db->get('photo_slider');
        
        return $result->row(0);
    }
    
    function get_all_payment(){
    	$this->db->where('use', 1);
    	$this->db->order_by('id','desc');
    	$query = $this->db->get('payment');
        $query = $query->result();
        return $query;
    }
    
    function get_payment_by_id($id){
        $this->db->where('id', $id);
        $result = $this->db->get('payment');
        
        return $result->row(0);
    }
    
    function is_payment_used($id){
    	$this->db->where('payment_id',$id);
    	$result = $this->db->get('purchase');
    	if($result->num_rows>0){return true;}
    	else{return false;}
    }
    
	function get_all_shipping(){
    	$this->db->where('use', 1);
    	$this->db->order_by('desc','asc');
    	$query = $this->db->get('shipping');
        $query = $query->result();
        return $query;
    }
    
    function get_shipping_by_id($id){
        $this->db->where('id', $id);
        $result = $this->db->get('shipping');
        
        return $result->row(0);
    }
    
    function get_shipping_by_city($city){
    	if($city){
			$this->db->join('city', 'city.shipping_id = shipping.id');
			$this->db->where('city.id', $city);
    	}
    	else{
    		$this->db->where('shipping.id', 11);
    	}
        $result = $this->db->get('shipping');
        
        return $result->row(0);
    }
    
    function is_shipping_used($id){
    	$this->db->where('shipping_id',$id);
    	$result = $this->db->get('purchase');
    	if($result->num_rows>0){return true;}
    	else{return false;}
    }
    
    function get_misc(){
    	$query = $this->db->get('misc');
    	$query = $query->result();
        return $query[0];
    }
    
    function get_sosmed(){
    	$query = $this->db->get('sosmed');
    	$query = $query->result();
        return $query;
    }
    
    function get_province(){
    	$this->db->order_by('id','asc');
    	$query = $this->db->get('province');
    	$query = $query->result();
        return $query;
    }
    function get_city_by_province($prov){
    	$this->db->where('province_id',$prov);
    	$this->db->order_by('id','desc');
    	$query = $this->db->get('city');
    	$query = $query->result();
        return $query;
    }
    
    //UPDATE FUNCTION
    function update_profil($profil,$id){
        $this->db->where('id',$id);
        return $this->db->update('profil', $profil);
    }
    
    function update_get_address($profil,$id){
    	if($this->update_profil($profil,$id)){
    		return $this->get_address_by_id($id);
    	}
    }
    
    function update_user($user){
    	$usr = $this->session->userdata('user');
        $this->db->where('id', $usr['user_id']);
        return $this->db->update('user', $user);
    }
    
    function update_user_with_username($user,$username){
        $this->db->where('username', $username);
        return $this->db->update('user', $user);
    }
    
    function update_payment($payment,$id){
        $this->db->where('id',$id);
        return $this->db->update('payment', $payment);
    }
    
    function update_shipping($shipping,$id){
        $this->db->where('id',$id);
        return $this->db->update('shipping', $shipping);
    }
    
    function update_misc($misc){
        $this->db->where('id',1);
        return $this->db->update('misc', $misc);
    }
    function update_sosmed($sosmed,$id){
        $this->db->where('id',$id);
        return $this->db->update('sosmed', $sosmed);
    }
    
    
    //DELETE FUNCTION
    function delete_address(){
    	$address_id = $this->input->post('address_id');
    	if($this->is_address_used($address_id)){
    		$this->db->where('id',$address_id);
    		$profil['user_id'] = '';
			return $this->db->update('profil', $profil);	
    	}else{
    		$this->db->where('id',$address_id);
    		return $this->db->delete('profil');
    	}
    }
    function delete_customer($id){
    	$this->db->where('user_id',$id);
    	if($this->db->delete('profil')){
    		$this->db->where('id',$id);
    		return $this->db->delete('user');
    	}
    }
    
     function delete_photo_slider($id){
    	$this->db->where('id',$id);
    	$this->db->delete('photo_slider');
    	if($this->db->affected_rows()>0){
    		return true;
    	}
    	else{
    		return false;
    	}
    }
    
    function delete_payment(){
    	$id = $this->input->post('id');
    	if($this->is_payment_used($id)){
    		$this->db->where('id',$id);
    		$payment['use'] = 0;
			return $this->db->update('payment', $payment);	
    	}else{
    		$this->db->where('id',$id);
    		return $this->db->delete('payment');
    	}
    }
    
    function delete_shipping(){
    	$id = $this->input->post('id');
    	if($this->is_shipping_used($id)){
    		$this->db->where('id',$id);
    		$shipping['use'] = 0;
			return $this->db->update('shipping', $shipping);	
    	}else{
    		$this->db->where('id',$id);
    		return $this->db->delete('shipping');
    	}
    }
    
    // OTHER FUNCTION
    function config_email(){
    	$config['protocol'] = 'smtp';
        $config['smtp_port'] = '25';
        $config['smtp_host'] = 'mail.dync-store.com';
        $config['smtp_user'] = 'dyn10000';
        $config['smtp_pass'] = 'dyn24157';
        $config['mailtype'] = 'html';
        $config['newline'] = "<br>";
        $config['wordwrap'] = TRUE;
        
        return $config;
    }
}
