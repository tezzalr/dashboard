<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->model('muser');
        $this->load->model('mitem');
        $this->load->model('mlookbook');
        $this->load->model('mcart');
        $this->load->model('mblog');
        $bahasa = $this->session->userdata('bahasa');
        if(!$bahasa){
            redirect('welcome');
        }
    }
    /**
     * Method for page (public)
     */
    public function index()
    {
        //$data['title'] = "beranda";
        
        $bahasa = $this->session->userdata('bahasa');
        
        if(!$bahasa){
        	redirect('welcome');
        }
        else{
        	redirect('home');
        }
        
    }
    
    public function login($params=null)
    {
    	$session = $this->session->userdata('user');
        if($session){
            redirect('customer');
        }
    	$data['title'] = "User Login";
    	$user_name = $this->muser->get_user_name_header();
        $stock = $this->mitem->check_all_items_stock();
        $lookbook_header = $this->mlookbook->get_lookbook_header();
        $cart_items = $this->mcart->get_user_item_unfinished_cart();
        $tablecart_td = $this->load->view('shared/header/_tablecart_td',array('cart_items' => $cart_items),TRUE); 
        $tablecart = $this->load->view('shared/header/_tablecart',array('tablecart_td' => $tablecart_td),TRUE);
        
        $data['header'] = $this->load->view('shared/header',array('user_name' => $user_name,'stock' => $stock, 'lookbook_header' => $lookbook_header,'tablecart' => $tablecart, 'sum_ci' => count($cart_items), 'blog_header' =>$this->mblog->get_all_blog_show(), 
        'provinces' => $this->muser->get_province(), 'cities' => $this->muser->get_city_by_province(1)),TRUE);	
    	$data['footer'] = $this->load->view('shared/footer','',TRUE);
        $data['content'] = $this->load->view('user/login',array('params' => $params),TRUE);
    
        $this->load->view('front',$data);
    }
    
	public function userEnter()
	{
		$params['username'] = $this->input->post('username');
        $params['password'] = md5($this->input->post('password'));
        
        if($this->check_login($params['username'],$params['password'])){
            $user_id = $this->muser->get_user_id_by_username($params['username']);
            $data = array(
                'username' => $params['username'],
                'user_id' => $user_id->id,
                'name' => $user_id->name,
                'is_logged_in' => true,
                'role' => $user_id->role
            );
            $this->session->set_userdata('user',$data);
            if($user_id->role == 1){
                redirect('admin');
            }elseif($user_id->role == 3){
            	$lasturl=$this->session->userdata('lasturl');
                if($lasturl){$this->session->unset_userdata('lasturl'); redirect($lasturl['url']);}
                else{redirect('customer');}
            }
        }else{
            $params['type_login']="failed";
            $this->login($params);
        }
	}
	
	private function check_login($username, $password){
         if(empty($username) || empty($password)){
             return false;
         }else{
             if($this->muser->verify($username, $password)){return true;}
             else{return false;}
         }
    }
    
    public function check_existing_email($email=null,$format=null){
         if($email==null){
             $email = $this->input->post('email');
         }
         $value;
         if($this->muser->get_existing_email($email)==true){
             $value = false;
         }else{
             $value = true;
         }
         if($format==null){
            $this->output->set_content_type('application/json')
                        ->set_output(json_encode(array("value" => $value)));
         }
         return $value;
     }
     
    public function check_existing_email_edit($email=null,$format=null){
         if($email==null){
             $email = $this->input->post('email');
             $old_email = $this->input->post('old_email');
         }
         $value;
         if($this->muser->get_existing_email_edit($email,$old_email)==true){
             $value = false;
         }else{
             $value = true;
         }
         if($format==null){
            $this->output->set_content_type('application/json')
                        ->set_output(json_encode(array("value" => $value)));
         }
         return $value;
     }
     
     public function check_email_is_user($email=null,$format=null){
     	if($email==null){
             $email = $this->input->post('email');
         }
         $value;
         if($this->muser->get_customer_id_by_username($email)==true){
             $value = true;
         }else{
             $value = false;
         }
         if($format==null){
            $this->output->set_content_type('application/json')
                        ->set_output(json_encode(array("value" => $value)));
         }
         return $value;
     }
     
     public function check_user_password($password=null,$format=null){
         if($password==null){
             $password = $this->input->post('password');
         }
         $value;
         if($this->muser->get_user_password($password)){
             $value = $this->muser->get_user_password($password);
         }else{
             $value = $this->muser->get_user_password($password);
         }
         if($format==null){
            $this->output->set_content_type('application/json')
                        ->set_output(json_encode(array("value" => $value)));
         }
         return $value;
     }
     
    public function register(){
      	$user['username'] = $this->input->post('email');
        $user['password'] = md5($this->input->post('password_su'));
        $user['name'] = $this->input->post('name');
        $user['role'] = '3';
        $user['telp'] = $this->input->post('telp');
        $user['email_lang'] = $this->input->post('email_lang');
        $user['join'] = date('Y-m-d H:i:s');
        $profil['name'] = $this->input->post('name');
        $profil['address'] = $this->input->post('address');
		if($this->input->post('country')=="Other"){$profil['country'] = $this->input->post('country_otr');}else{$profil['country'] = $this->input->post('country');}
        $profil['province'] = $this->input->post('province');
        $profil['city'] = $this->input->post('city');
        $profil['postcode'] = $this->input->post('postcode');
        
        if($this->muser->register($user, $profil)){
        	$user_id = $this->muser->get_user_id_by_username($user['username']);
            $data = array(
                'username' => $user['username'],
                'user_id' => $user_id->id,
                'name' => $user_id->name,
                'is_logged_in' => true,
                'role' => $user_id->role
            );
            $this->session->set_userdata('user',$data);
        	$msg = $this->register_message($user_id->email_lang,$user_id);
        	if($this->send_email($user_id->username,$msg,'Welcome to DYNC')){
        		$lasturl=$this->session->userdata('lasturl');
                if($lasturl){$this->session->unset_userdata('lasturl'); redirect($lasturl['url']);}
                else{$this->welcome();}
        	}
        	else{
        		echo "gagal kirim email";
        	}
        }else{redirect('home');}
    }
    
    public function update_account(){
    	$user['username'] = $this->input->post('email');
        $user['name'] = $this->input->post('name');
        $user['telp'] = $this->input->post('telp');
        $user['email_lang'] = $this->input->post('email_lang');
        
        if($this->muser->update_user($user)){
        	if($this->input->post('signature')){
        		$misc['signature']=$this->input->post('signature');
        		if($this->muser->update_misc($misc)){
        			$json['status']=1;	
        		}else{$json['status']=0;}
        	}else{$json['status']=1;}
        }
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }
    
    public function change_password(){
    	$user['password'] = md5($this->input->post('password_new'));
        
        if($this->muser->update_user($user)){
        	$json['status']=1;
        }
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }
      
	function random_password($length = 10) {
        $validCharacters = "abcdefghijklmnopqrstuxyvwzABCDEFGHIJKLMNOPQRSTUXYVWZ!@#$%^()1234567890";
        $validCharNumber = strlen($validCharacters);
        $result = "";
        for ($i = 0; $i < $length; $i++) {
            $index = mt_rand(0, $validCharNumber - 1);
            $result .= $validCharacters[$index];
        }
        return $result;
     }

	private function welcome(){
		$data['title'] = "Welcome New User";
		$user_name = $this->muser->get_user_name_header();
		$stock = $this->mitem->check_all_items_stock();
		$lookbook_header = $this->mlookbook->get_lookbook_header();
		$cart_items = $this->mcart->get_user_item_unfinished_cart();
		$tablecart_td = $this->load->view('shared/header/_tablecart_td',array('cart_items' => $cart_items),TRUE); 
		$tablecart = $this->load->view('shared/header/_tablecart',array('tablecart_td' => $tablecart_td),TRUE);

		$data['header'] = $this->load->view('shared/header',array('user_name' => $user_name,'stock' => $stock, 'lookbook_header' => $lookbook_header,'tablecart' => $tablecart, 'sum_ci' => count($cart_items), 'blog_header' =>$this->mblog->get_all_blog_show()),TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('user/welcome',array('user'=>$this->muser->get_user_login(), 'follow' => $this->load->view('shared/_followus',array('sosmed' => $this->muser->get_sosmed()),TRUE)),TRUE);

		$this->load->view('front',$data);
	}
      
    public function logout(){
        $this->session->unset_userdata('user');
        redirect('/user/login');
    }
    
    public function input_address(){
    	$id = $this->input->get('id');
    	$form = 'new'; $adr=''; $prov_id=1;
    	if($id){
    		$adr = $this->muser->get_address_by_id($id);
    		$form = 'update';
    		$prov_id = $adr->province;
    	}
    	$iptadr = $this->load->view('customer/address/_inputaddress',array('form'=>$form, 'adr'=>$adr, 
    	'provinces' => $this->muser->get_province(), 'cities' => $this->muser->get_city_by_province($prov_id)),TRUE);
    	$json['html']= $iptadr;
    	$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }
    
    public function delete_address(){
        if($this->muser->delete_address()){
    		$json['status'] = 1;
    	}
    	else{
    		$json['status'] = 0;
    	}
    	$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }
    
    public function load_cities(){
    	$prov=$this->uri->segment(3);
    	echo $this->load->view('user/_cities',array('cities' => $this->muser->get_city_by_province($prov),TRUE));
    }
    
    /* Cart Function
    --------------------------------------------------------*/
    public function add_to_cart(){
    	$session = $this->session->userdata('user');
        if(!$session){
            $data = array(
                'url' => 'catalogue/detail/'.$this->input->post('gender').'/'.$this->input->post('kind').'/'.$this->input->post('code')
        	);
        	$this->session->set_userdata('lasturl',$data);
            $json['status']=0;
            $json['redirect']=base_url().'user/not_login_yet';
        }else{
        	$cart_item['size'] = $this->input->post('size');
        	$cart_item['item_id'] = $this->input->post('item_id');
        	$cart_items = $this->mcart->insert_to_cart($cart_item);
        	$json['status']=1;
        	$json['sum_ci']=count($this->mcart->get_user_item_unfinished_cart());//$cart_items['SizeName'].' '.$cart_items['Info']->name;
        }
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }
    
    public function load_cart_items(){
    	$cart_items = $this->mcart->get_user_item_unfinished_cart();
        $tablecart_td = $this->load->view('shared/header/_tablecart_td',array('cart_items' => $cart_items),TRUE); 
        
    	echo $tablecart_td;
    }
    
    public function delete_cart_item(){
        $cart_item_id = $this->input->post('cart_item_id');
        if($this->mcart->delete_cart_item($cart_item_id)){
    		$json['status'] = 1;
    		$json['sum_ci']=count($this->mcart->get_user_item_unfinished_cart());
    	}
    	else{
    		$json['status'] = 0;
    	}
    	$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}
	
	public function detail_purchase(){
		$ordernum = $this->uri->segment(3);
		$session = $this->session->userdata('user');
		if(!$session){
			$data = array(
                'url' => 'customer/detail_purchase/'.$ordernum
        	);
        	$this->session->set_userdata('lasturl',$data);
            redirect('user/not_login_yet');
		}else{
			redirect('customer/detail_purchase/'.$ordernum);
		}
	}
    
    public function not_login_yet(){
    	$params['type_login']="not_login";
        $this->login($params);
    }
    
     /* Profil Function
    --------------------------------------------------------*/
    public function forgot_password(){
    	$username = $this->input->post('email_forgot');
    	$password = $this->random_password();
    	$user['password'] = md5($password);
    	if($this->muser->update_user_with_username($user,$username)){
    		if(strstr(base_url(),'://localhost')){
    			$json['status']=1;
    			$json['password']=$password;
    		}
    		else{
    			$user = $this->muser->get_user_id_by_username($username);
    			$msg = $this->forgot_message($user->email_lang,$user,$password);
    			if($this->send_email($user->username, $msg, 'Your new DYNC Password')){
    				$json['status']=1;
    			}else{$json['status'] = 0;}
    		}
    	}else{$json['status']=0;}
    	$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }
    
    public function form_indo_input(){
    	echo $indo_input_form = $this->load->view('user/_form_indo_adr',array(
    	'provinces' => $this->muser->get_province(), 'cities' => $this->muser->get_city_by_province(1)),TRUE);
    }
    public function form_otr_input(){
    	echo $indo_input_form = $this->load->view('user/_form_otr_adr',array(),TRUE);
    }
    
     /* Email Function
    --------------------------------------------------------*/
    private function send_email($to, $msg, $sbj){
    	$config = $this->muser->config_email();
        $this->load->library('email',$config);
        $this->email->from('noreply@dync-store.com', 'DYNC');
        $this->email->to($to);
        $this->email->subject($sbj);
        $this->email->message($msg);
        return $this->email->send();
	}
	
	private function forgot_message($lang,$user,$password){
		$msg = "Dear ".$user->name.",<br>"."<br>";
		$sign = $this->muser->get_misc();
		if($lang=="English"){
			$msg = $msg.
					"As you requested, we've sent you a new password.<br>".
					"Your new password: ".$password.
					"<br>"."<br>"."Please login with your new password and change it if needed.";
		}
		else{
			$msg = 	$msg.
					"Sesuai dengan permintaan Anda, kami kirimkan password baru untuk Anda.<br>".
					"Password baru Anda: ".$password.
					"<br>"."<br>"."Silahkan login dengan password baru Anda dan ubah password Anda bila dibutuhkan.";
		}
		$msg = $msg."<br>"."<br>".nl2br($sign->signature);
		return $msg;
	}
	
	private function register_message($lang,$user){
		$msg = "Dear ".$user->name.",<br>"."<br>";
		$sign = $this->muser->get_misc();
		if($lang=="English"){
			$msg = $msg.
					"Thanks for registering with DYNC <br>".
					"You have registered with the following email address: ".$user->username.
					"<br>"."<br>"."Please contact us for any further information at support@dync-store.com".
					"<br>"."<br>"."We hope you enjoy shopping with us.";
		}
		else{
			$msg = 	$msg.
					"Terima kasih telah mendaftar di DYNC <br>".
					"Anda terdaftar dengan alamat email sebagai berikut: ".$user->username.
					"<br>"."<br>"."Untuk informasi lebih lanjut, silakan menghubungi kami di support@dync-store.com".
					"<br>"."<br>"."Kami berharap Anda menikmati berbelanja dengan kami.";
		}
		$msg = $msg."<br>"."<br>".nl2br($sign->signature);
		return $msg;
	}
}
