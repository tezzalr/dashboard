<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'file'));
        $this->load->model('muser');
        $this->load->model('mitem');
        $this->load->model('mlookbook');
        $this->load->model('mblog');
        $this->load->model('mcart');
        $this->load->model('mguide');
        
        $role = $this->session->userdata('user');
        if($role['role']!=1){
            redirect('home');
        }
    }
    /**
     * Method for page (public)
     */
    public function index()
    {
        $data['title'] = "Admin Page";
        
        $photoslider = $this->load->view('admin/home/slider/_photosslider',array('photos' => $this->muser->get_all_slider_photos()),TRUE);
        
        $pymnttd = $this->load->view('admin/home/payment/_payment_td',array('allpayment' => $this->muser->get_all_payment()),TRUE);
        $pymnt = $this->load->view('admin/home/payment/_payment',array('pymnttd' => $pymnttd),TRUE);
        
        $shippingtd = $this->load->view('admin/home/shipping/_shipping_td',array('allshipping' => $this->muser->get_all_shipping()),TRUE);
        $shipping = $this->load->view('admin/home/shipping/_shipping',array('shippingtd' => $shippingtd),TRUE);
        
        $formslider = $this->load->view('admin/home/slider/_formslider',array('photoslider' => $photoslider),TRUE);
        
        $compinfo = $this->load->view('admin/home/compinfo/_compinfo',array('data' => 'company',
        'formcompinfo' => $this->load->view('admin/home/compinfo/_formcompinfo',array('misc' => $this->muser->get_misc(),'data' => 'company'),TRUE)),TRUE);
        
        $sosmed = $this->load->view('admin/home/_formsosmed',array('sosmed' => $this->muser->get_sosmed()),TRUE);
        
        $admin_content = $this->load->view('admin/home/_homeidx',array(
        	'formslider' => $formslider,
        	'payment' => $pymnt,
        	'shipping' => $shipping,
        	'compinfo' =>$compinfo,
        	'sosmed' => $sosmed),TRUE);
        
        $user_name = $this->muser->get_user_name_header();
        $stock = $this->mitem->check_all_items_stock();
        $lookbook_header = $this->mlookbook->get_lookbook_header();
        
        $data['header'] = $this->load->view('shared/header',array('user_name' => $user_name,'stock' => $stock, 'lookbook_header' => $lookbook_header, 'blog_header' =>$this->mblog->get_all_blog_show()),TRUE);	
    	$data['footer'] = $this->load->view('shared/footer','',TRUE);
        $data['content'] = $this->load->view('admin/index',array('admin_content' => $admin_content),TRUE);
    
        $this->load->view('front',$data);
        
    }
    
     /* SLIDER
	-------------------------------------------------- */
    public function upload_photo_slider(){
    	if($_FILES){
        	$upload_path = 'img/slider/';

        	$config = $this->upload_config($upload_path,'');
        	
        	$this->load->library('upload', $config); //Meload library upload dengan config dari $config
			if ($this->upload->do_multi_upload("photoslider")){
				$photos = $this->upload->get_multi_upload_data();
				foreach($photos as $photo){
					$data_photo = $photo;
					$photoname = $data_photo['file_name'];
					$target_folder = 'assets/'.$upload_path;
					$photolocation = base_url().$target_folder.$photoname;
			
					//make thumbnail
					$this->make_photo_thumb($photoname,$photolocation,$target_folder,272,'_thumbnail.jpg');
			
					//insert photo db
					$photo_slider['name'] = $target_folder.$photoname;
					
					if($this->muser->insert_photo_slider($photo_slider)){
					}
				}
				$photoslider = $this->load->view('admin/home/slider/_photosslider',array('photos' => $this->muser->get_all_slider_photos()),TRUE);
				$json['photoslider']=$photoslider;
				$json['status']=1;
				$this->output->set_content_type('application/json')
									 ->set_output(json_encode($json));
			}
			//echo "Berhasil gan";
        	
        	else{echo "Gagal gan";}
        }
        else{echo "Pilih Gambar!";}
    }
    
    public function delete_photo_slider(){
		$id = $this->input->post('id');
        $photo = $this->muser->get_photo_slider_by_id($id);
        $pname = $photo->name;
        if(unlink($pname)&&unlink($pname."_thumbnail.jpg")){
        	if($this->muser->delete_photo_slider($id)){
        		$json['status'] = 1;
        	}else{
        		$json['status'] = 0;
        	}
        	$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
        }
	}
	
	/* PAYMENT AND SHIPPING
	-------------------------------------------------- */
	public function input_payment(){
    	$id = $this->input->get('id');
    	$form = 'new'; $pay='';
    	if($id){
    		$pay = $this->muser->get_payment_by_id($id);
    		$form = 'update';
    	}
    	$iptpay = $this->load->view('admin/home/payment/_inputpayment',array('form'=>$form, 'pay'=>$pay),TRUE);
    	$json['html']= $iptpay;
    	$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }
    
    public function save_payment(){
    	$action = $this->uri->segment(3);
    	
		$payment['desc'] = $this->input->post('desc');
		$payment['bank'] = $this->input->post('bank');
		$payment['an'] = $this->input->post('an');
		$payment['norek'] = $this->input->post('norek');
		if($action=='new'){
			$payment['use'] = 1;
			$this->muser->insert_payment($payment);
		}
		elseif($action=='update'){
			$payid = $this->input->post('id');
			$this->muser->update_payment($payment,$payid);
		}
        
        $json['html'] = $this->load->view('admin/home/payment/_payment_td',array('allpayment' => $this->muser->get_all_payment()),TRUE);
        
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }
    
    public function load_payment(){
    	$pymnttd = $this->load->view('admin/home/payment/_payment_td',array('allpayment' => $this->muser->get_all_payment()),TRUE);
    	echo $pymnttd;
    }
    
    public function delete_payment(){
        if($this->muser->delete_payment()){
    		$json['status'] = 1;
    	}
    	else{
    		$json['status'] = 0;
    	}
    	$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }
    
    public function input_shipping(){
    	$id = $this->input->get('id');
    	$form = 'new'; $ship='';
    	if($id){
    		$ship = $this->muser->get_shipping_by_id($id);
    		$form = 'update';
    	}
    	$iptship = $this->load->view('admin/home/shipping/_inputshipping',array('form'=>$form, 'ship'=>$ship),TRUE);
    	$json['html']= $iptship;
    	$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }
    
    public function save_shipping(){
    	$action = $this->uri->segment(3);
    	
		$shipping['desc'] = $this->input->post('desc');
		$shipping['cost'] = $this->input->post('cost');
		if($action=='new'){
			$shipping['use'] = 1;
			$this->muser->insert_shipping($shipping);
		}
		elseif($action=='update'){
			$shipid = $this->input->post('id');
			$this->muser->update_shipping($shipping,$shipid);
		}
        
        $json['html'] = $this->load->view('admin/home/shipping/_shipping_td',array('allshipping' => $this->muser->get_all_shipping()),TRUE);
        
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }
    
    public function load_shipping(){
    	$shippingtd = $this->load->view('admin/home/shipping/_shipping_td',array('allshipping' => $this->muser->get_all_shipping()),TRUE);
    	echo $shippingtd;
    }
    
    public function delete_shipping(){
        if($this->muser->delete_shipping()){
    		$json['status'] = 1;
    	}
    	else{
    		$json['status'] = 0;
    	}
    	$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }
    
    /* Company Info
	-------------------------------------------------- */
    public function update_compinfo(){
		$data = $this->input->post('data_type');
		$misc[$data.'_ind'] = $this->input->post('editor_ind');
		$misc[$data.'_eng'] = $this->input->post('editor_eng');
		if($this->muser->update_misc($misc)){
			$json['status'] = 1;
		}
		else{
			$json['status'] = 0;
		}
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}
	
	public function change_formcompinfo(){
		 $data = $this->uri->segment(3);
		 echo $this->load->view('admin/home/compinfo/_formcompinfo',array('misc' => $this->muser->get_misc(),'data' => $data),TRUE);
	}
	
	/* Sosmed
	-------------------------------------------------- */
    public function update_sosmed(){
		for($i=1;$i<=9;$i++){
			$text = 'text_'.$i; $link = 'link_'.$i; 
			$sosmed['text'] = $this->input->post($text);
			$sosmed['link'] = $this->input->post('link_'.$i);
			if($this->muser->update_sosmed($sosmed,$i)){
				$json['status'] = 1;
			}
			else{
				$json['status'] = 0;
				break;
			}
		}
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}
    
    /* BARANG
	-------------------------------------------------- */
    public function barang()
    {
    	$data['title'] = "Admin Barang";
    	
    	$allbarang = $this->mitem->get_all_item_with_size_name();
    	$new_value = $this->mitem->get_new_value();
    	$size_name = $this->mitem->get_size_name('Top');
    	
    	$allbarang = $this->mcart->get_stat_cart_items_by_items($allbarang);
    	
    	$sizenameinput = $this->load->view('admin/barang/_sizenameinput',array('size_name' => $size_name, 'barang' => ''),TRUE);
    	$addbarang = $this->load->view('admin/barang/_addbarang',array('sizenameinput' => $sizenameinput),TRUE);
    	
    	$tablebarangtd = $this->load->view('admin/barang/_tablebarang_td',array('allbarang' => $allbarang,'new_value' => $new_value),TRUE);
    	$tablebarang = $this->load->view('admin/barang/_tablebarang',array('tablebarangtd' => $tablebarangtd),TRUE);
        
        $admin_content = $this->load->view('admin/barang/_barangidx',array(
        	'addbarang' => $addbarang,
        	'tablebarang' => $tablebarang),TRUE);

        $user_name = $this->muser->get_user_name_header();
        $stock = $this->mitem->check_all_items_stock();
        $lookbook_header = $this->mlookbook->get_lookbook_header();
        
        $data['header'] = $this->load->view('shared/header',array('user_name' => $user_name,'stock' => $stock, 'lookbook_header' => $lookbook_header, 'blog_header' =>$this->mblog->get_all_blog_show()),TRUE);	
    	$data['footer'] = $this->load->view('shared/footer','',TRUE);
        $data['content'] = $this->load->view('admin/index',array('admin_content' => $admin_content),TRUE);
    
        $this->load->view('front',$data);
    }
    
    public function load_all_barang(){
    	$allbarang = $this->mitem->get_all_item_filter_with_size_name();
    	$allbarang = $this->mcart->get_stat_cart_items_by_items($allbarang);
    	$new_value = $this->mitem->get_new_value();
    	$tablebarangtd = $this->load->view('admin/barang/_tablebarang_td',array('allbarang' => $allbarang,'new_value' => $new_value),TRUE);
    	
    	echo $tablebarangtd;
    }
    
    public function order_by(){
    	$atr = $this->uri->segment(5);
    	$kind = $this->uri->segment(6);
    	$allbarang = $this->mitem->get_all_item_order_with_size_name($atr, $kind);
    	$allbarang = $this->mcart->get_stat_cart_items_by_items($allbarang);
    	$new_value = $this->mitem->get_new_value();
    	$tablebarangtd = $this->load->view('admin/barang/_tablebarang_td',array('allbarang' => $allbarang,'new_value' => $new_value),TRUE);
    	
    	echo $tablebarangtd;
    }
    
    public function input_barang(){
    	$item['code'] = $this->input->post('code');
    	$item['name'] = $this->input->post('name');
    	$item['price'] = $this->input->post('price');
    	$item['kind'] = $this->input->post('kind');
    	$item['gender'] = $this->input->post('gender');
    	$item['size_1'] = $this->input->post('size_1');
    	$item['size_2'] = $this->input->post('size_2');
    	$item['size_3'] = $this->input->post('size_3');
    	$item['size_4'] = $this->input->post('size_4');
    	$item['size_5'] = $this->input->post('size_5');
    	$item['size_6'] = $this->input->post('size_6');
    	$item['size_7'] = $this->input->post('size_7');
    	$item['size_8'] = $this->input->post('size_8');
    	$item['size_9'] = $this->input->post('size_9');
    	$item['size_10'] = $this->input->post('size_10');
    	$item['size_11'] = $this->input->post('size_11');
    	$item['date_added'] = date('Y-m-d H:i:s');
    	
    	if($this->mitem->insert_item($item)){
    		$item_just_add = $this->mitem->get_item_by_code($this->input->post('code'));
    		$oldmask = umask(0);
    		mkdir('assets/img/item/'.$item_just_add->id, 0777, TRUE);
    		umask($oldmask);
    		$json['id_item'] = $item_just_add->id;
    		$json['msg'] = "Barang berhasil ditambahkan";
    	 	$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    	}
    	
    }
    
    public function edit_barang(){
        $id = $this->input->get('id');
        $kind = $this->input->get('kind');
		$barang = $this->mitem->get_item_by_id($id);
		$size_name = $this->mitem->get_size_name($kind);
    	$sizenameinput = $this->load->view('admin/barang/_sizenameinput',array('barang' => $barang, 'size_name' => $size_name),TRUE);
    	
		if($barang){
			$json['status'] = 1;
    		$editbarang = $this->load->view('admin/barang/_editbarang',array('barang' => $barang, 'sizenameinput' => $sizenameinput),TRUE);
            $json['html'] = $editbarang;
		}else{
			$json['status'] = 0;
		}
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}
	
	public function update_barang(){
    	$item['code'] = $this->input->post('code');
    	$item['name'] = $this->input->post('name');
    	$item['price'] = $this->input->post('price');
    	$item['discount'] = $this->input->post('discount');
    	$item['kind'] = $this->input->post('kind');
    	$item['gender'] = $this->input->post('gender');
    	$item['size_1'] = $this->input->post('size_1');
    	$item['size_2'] = $this->input->post('size_2');
    	$item['size_3'] = $this->input->post('size_3');
    	$item['size_4'] = $this->input->post('size_4');
    	$item['size_5'] = $this->input->post('size_5');
    	$item['size_6'] = $this->input->post('size_6');
    	$item['size_7'] = $this->input->post('size_7');
    	$item['size_8'] = $this->input->post('size_8');
    	$item['size_9'] = $this->input->post('size_9');
    	$item['size_10'] = $this->input->post('size_10');
    	$item['size_11'] = $this->input->post('size_11');
    	
    	
    	if($this->mitem->update_item($item)){
    	 	$json['status'] = 1;
    	 	$json['id'] = $this->input->post('id');
    	}
    	$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }
    
    public function delete_barang(){
        $item = $this->mitem->get_item_by_id($this->input->post('item_id'));
        
        if($this->mitem->delete_item()){
    		$json['status'] = 1;
    	}
    	else{
    		$json['status'] = 0;
    	}
    	$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}
	
	public function search_barang(){
		$query = $this->input->get('query');
		$allbarang = $this->mitem->get_all_item_search_with_size_name($query);
		$allbarang = $this->mcart->get_stat_cart_items_by_items($allbarang);
		if($allbarang){
			$json['status'] = 1;
			$new_value = $this->mitem->get_new_value();
    		$tablebarangtd = $this->load->view('admin/barang/_tablebarang_td',array('allbarang' => $allbarang,'new_value' => $new_value),TRUE);
            $json['html'] = $tablebarangtd;
		}else{
			$json['status'] = 0;
		}
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}
    
    public function check_existing_code($code=null,$format=null){
         if($code==null){
             $code = $this->input->post('code');
         }
         $value;
         if($this->mitem->get_existing_code($code)==true){
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
     
     public function check_existing_code_edit($code=null,$format=null){
         if($code==null){
             $code = $this->input->post('code');
             $old_code = $this->input->post('old_code');
         }
         $value;
         if($this->mitem->get_existing_code_edit($code,$old_code)==true){
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
    
    public function upload_image(){
    	if($_FILES){
    		$formid = $this->uri->segment(3);
    		$filename = "photoimg_".$formid;

        	$itemcode = $this->input->post('hidden_code');
        	$itemid = $this->input->post('hidden_id');
        	$image_pure_name = $itemcode."_$formid";
        	$config = $this->upload_config('img/item/'.$itemid.'/',$image_pure_name);
        	
        	$this->load->library('upload', $config); //Meload library upload dengan config dari $config
        	if ($this->upload->do_upload($filename)){
            	$data_photo = $this->upload->data();
            	$photoname = $data_photo['file_name'];
            	$photolocation = base_url().'assets/img/item/'.$itemid.'/'.$photoname;
            	
            	//delete old photo
            	$this->delete_old_photo($photoname, $itemid, $formid);
            	
            	//make thumbnail
            	$target_folder = 'assets/img/item/'.$itemid.'/';
            	$this->make_photo_thumb($photoname,$photolocation,$target_folder,285,'_thumbnail_med.jpg');
            	$this->make_photo_thumb($photoname,$photolocation,$target_folder,55,'_thumbnail_tny.jpg');
            	list($width, $height) = getimagesize($photolocation);
            	$config2['width'] = 626;
            	$config2['height'] = 626*$height/$width;
        		$config2['maintain_ratio'] = TRUE;
        		$config2['source_image'] = 'assets/img/item/'.$itemid.'/'.$photoname;
            	$this->load->library('image_lib', $config2); 
				if ( ! $this->image_lib->resize())
				{
					echo $this->image_lib->display_errors();
				}
            	
            	if($this->mitem->update_photo($itemid, $formid, $photoname)){
            		//echo "<img src=\"$thumb_tny\">";
            		$json['tny'] = base_url().'assets/img/item/'.$itemid.'/'.$photoname.'_thumbnail_tny.jpg';
            		$json['med'] = base_url().'assets/img/item/'.$itemid.'/'.$photoname.'_thumbnail_med.jpg';
            		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
            	}
        	}
        	else{
            	echo "Upload Foto Gagal";
        	}
        }
        else{
        	echo "Pilih Gambar!";
        }	
    }
    
    private function delete_old_photo($photoname, $itemid, $formid){
    	if(!($this->mitem->is_photoname_same($photoname, $itemid, $formid))){
    		$item = $this->mitem->get_item_by_id($itemid);
        	$this->delete_file_photo($item, $formid);
    	}	
    }
    
    private function delete_file_photo($item, $atr){
		if($item->$atr && ($item->$atr!='no_pic/no_pic.jpg')){
			$img = 'assets/img/item/'.$item->id.'/'.$item->$atr;
    		$img_med = $img.'_thumbnail_med.jpg';
    		$img_tny = $img.'_thumbnail_tny.jpg';
			unlink($img);
			unlink($img_med);
			unlink($img_tny);
		}
	}
	
	public function change_size_input(){
		$kind = $this->input->get('kind');
		$size_name = $this->mitem->get_size_name($kind);
    	
		if($size_name){
			$json['status'] = 1;
			$sizenameinput = $this->load->view('admin/barang/_sizenameinput',array('size_name' => $size_name, 'barang' => ''),TRUE);
            $json['html'] = $sizenameinput;
		}else{
			$json['status'] = 0;
		}
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}
	
	/* LOOLKBOOK
	-------------------------------------------------- */
	public function lookbook()
    {
    	$data['title'] = "Admin Lookbook";
    	
    	$formnewphotolb = $this->load->view('admin/lookbook/_formnewphotolb',array('tablephotolookbook'=>'','form'=>'new', 'lb_id' =>'', 'lb_gender' => $this->uri->segment(3)),TRUE);
    	$addlookbook = $this->load->view('admin/lookbook/_addlookbook',array('formnewphotolb' => $formnewphotolb),TRUE);

		$alllookbook = $this->mlookbook->get_all_lookbook_gender($this->uri->segment(3));
		
    	$tablelookbook = $this->load->view('admin/lookbook/_tablelookbook',array('alllookbook' => $alllookbook),TRUE);
        
        $admin_content = $this->load->view('admin/lookbook/_lookbookidx',array(
        	'addlookbook' => $addlookbook,
        	'tablelookbook' => $tablelookbook),TRUE);

        $user_name = $this->muser->get_user_name_header();
        $stock = $this->mitem->check_all_items_stock();
        $lookbook_header = $this->mlookbook->get_lookbook_header();
        
        $data['header'] = $this->load->view('shared/header',array('user_name' => $user_name,'stock' => $stock, 'lookbook_header' => $lookbook_header, 'blog_header' =>$this->mblog->get_all_blog_show()),TRUE);	
    	$data['footer'] = $this->load->view('shared/footer','',TRUE);
        $data['content'] = $this->load->view('admin/index',array('admin_content' => $admin_content),TRUE);
    
        $this->load->view('front',$data);
    }
    
    public function input_lookbook(){
    	$lookbook['gender'] = $this->input->post('gender');
    	$lookbook['name'] = $this->input->post('name');
    	$lookbook['date_added'] = date('Y-m-d H:i:s');
    	
    	if($this->mlookbook->insert_lookbook($lookbook)){
    		$lookbook_just_add = $this->mlookbook->get_newest_lookbook_id();
    		$oldmask = umask(0);
    		mkdir('assets/img/lookbook/'.$this->input->post('gender').'/'.$lookbook_just_add, 0777, TRUE);
    		umask($oldmask);
    		$json['status'] = 1;
    		$json['id_lb'] = $lookbook_just_add;
    		$json['msg'] = "Lookbook berhasil ditambahkan";
    	}
    	else{
			$json['status'] = 0;
		}
    	$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }
    
    public function upload_photo_lookbook(){
    	if($_FILES){
        	$form = $this->uri->segment(3);
        	$lookbookid = $this->input->post('loookbook_id_'.$form);
        	$lookbookgender = $this->input->post('loookbook_gender_'.$form);
        	$upload_path = 'img/lookbook/'.$lookbookgender.'/'.$lookbookid.'/';

        	$config = $this->upload_config($upload_path,'');
        	
        	$this->load->library('upload', $config); //Meload library upload dengan config dari $config
        	if ($this->upload->do_upload("photolb_".$form)){
            	$data_photo = $this->upload->data();
            	$photoname = $data_photo['file_name'];
            	$target_folder = 'assets/'.$upload_path;
            	$photolocation = base_url().$target_folder.$photoname;
            	
            	//make thumbnail
            	$this->make_photo_thumb($photoname,$photolocation,$target_folder,380,'_thumbnail.jpg');
            	
            	//insert photo db
            	$photo_lb['name'] = $target_folder.$photoname;
            	$photo_lb['lookbook_id'] = $lookbookid;
            	if($this->mlookbook->insert_photo_lb($photo_lb)){
            		$newestphotolb = $this->mlookbook->get_newest_photo_lb();
            		$formphotolb = $this->load->view('admin/lookbook/_formphotolb',array('photo_lb' => $newestphotolb),TRUE);
            		$json['newphotolb'] = $formphotolb;
            		$json['newplbid'] = $newestphotolb->id;
            		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
            	}
            	//echo "Berhasil gan";
        	}
        	else{
            	echo "Gagal gan";
        	}
        }
        else{
        	echo "Pilih Gambar!";
        }	
    }
    
    public function edit_lookbook(){
        $id = $this->input->get('id');
		$lookbook = $this->mlookbook->get_lookbook_by_id_with_plb($id);
    	
		if($lookbook){
			$form_plb_arr = $this->load_all_photo_lookbook($lookbook['Photo']);
			$tablephotolookbook = $this->load->view('admin/lookbook/_tablephotolookbook',array('form_plb_arr' => $form_plb_arr),TRUE);
			$formnewphotolb = $this->load->view('admin/lookbook/_formnewphotolb',array('tablephotolookbook' => $tablephotolookbook, 'form'=>'edit', 'lb_id' => $id, 'lb_gender' => $lookbook['Info']->gender),TRUE);
    		$editlookbook = $this->load->view('admin/lookbook/_editlookbook',array('lookbook' => $lookbook,'formnewphotolb' => $formnewphotolb),TRUE);
    		$json['status'] = 1;
            $json['html'] = $editlookbook;
		}else{
			$json['status'] = 0;
		}
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}
	
	public function update_lookbook(){
		$lookbook['name'] = $this->input->post('name');
		if($this->mlookbook->update_lookbook($lookbook)){
			$json['status'] = 1;
		}
		else{
			$json['status'] = 0;
		}
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}
	
	public function update_photo_lookbook(){
		$id = $this->uri->segment(3);
		$photo_lb['desc'] = $this->input->post('editor'.$id);
		if($this->mlookbook->update_photo_lookbook($photo_lb, $id)){
			$json['s'] = $photo_lb['desc'];
			$json['p'] = $this->input->post('id');
			$json['status'] = 1;
		}
		else{
			$json['status'] = 0;
		}
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}
	
	private function load_all_photo_lookbook($all_pht_lb){
    	$i=0;
    	$form_plb_arr = array();
    	foreach($all_pht_lb as $pht_lb){
        	$form_plb_arr[$i] = $this->load->view('admin/lookbook/_formphotolb',array('photo_lb' => $pht_lb),TRUE);
        	$i++;
    	}
    	return $form_plb_arr;
    }
    
    public function delete_lookbook(){
        if($this->mlookbook->delete_lookbook()){
        	$id= $this->input->post('id');
        	$gender= $this->input->post('gender');
        	$dir= 'assets/img/lookbook/'.$gender.'/'.$id.'/';
        	
        	if(delete_files($dir, true)&&rmdir($dir)){
    			$json['status'] = 1;
    		}
    		else{
    			$json['status'] = 0;
    		}
    	}
    	else{
    		$json['status'] = 0;
    	}
    	$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}
	
	public function delete_lookbook_photo(){
		$id = $this->input->post('id');
        $photo = $this->mlookbook->get_photo_lb_by_id($id);
        $pname = $photo->name;
        if(unlink($pname)&&unlink($pname."_thumbnail.jpg")){
        	if($this->mlookbook->delete_photo_lb($id)){
        		$json['status'] = 1;
        	}else{
        		$json['status'] = 0;
        	}
        	$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
        }
	}
	
	public function finish_add_lb(){
		$formnewphotolb = $this->load->view('admin/lookbook/_formnewphotolb',array('tablephotolookbook'=>'','form'=>'new', 'lb_id' =>'', 'lb_gender' => $this->uri->segment(3)),TRUE);
    	$addlookbook = $this->load->view('admin/lookbook/_addlookbook',array('formnewphotolb' => $formnewphotolb),TRUE);

		$alllookbook = $this->mlookbook->get_all_lookbook_gender($this->uri->segment(3));
		
    	$tablelookbook = $this->load->view('admin/lookbook/_tablelookbook',array('alllookbook' => $alllookbook),TRUE);
    	
    	$json['addlookbook'] = $addlookbook;
    	$json['tablelookbook'] = $tablelookbook;
    	$json['status'] = 1;
    	
    	$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}
    
    public function load_table_lookbook(){
    	$alllookbook = $this->mlookbook->get_all_lookbook_gender($this->uri->segment(3));
    	$tablelookbook = $this->load->view('admin/lookbook/_tablelookbook',array('alllookbook' => $alllookbook),TRUE);
    	echo $tablelookbook.'<div style="clear:both"></div>';
    }
    
    public function load_form_addfotolb(){
    	$formnewphotolb = $this->load->view('admin/lookbook/_formnewphotolb',array('tablephotolookbook'=>'','form'=>'new', 'lb_id' =>'', 'lb_gender' => $this->uri->segment(3)),TRUE);
    	echo $formnewphotolb;
    }
    
    public function load_photo_lb(){
    	$id = $this->uri->segment(3);
		$lookbook = $this->mlookbook->get_lookbook_by_id_with_plb($id);
    	
		if($lookbook){
			$form_plb_arr = $this->load_all_photo_lookbook($lookbook['Photo']);
			$tablephotolookbook = $this->load->view('admin/lookbook/_tablephotolookbook',array('form_plb_arr' => $form_plb_arr),TRUE);
			echo $tablephotolookbook;
		}
    }
    
    public function photo_lb_up(){
    	$id = $this->input->get('id');
    	if($this->mlookbook->photo_lb_up($id)){
    		$json['status'] = 1;
    	
    		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    	}
    }
    
    public function photo_lb_down(){
    	$id = $this->input->get('id');
    	if($this->mlookbook->photo_lb_down($id)){
    		$json['status'] = 1;
    	
    		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    	}
    }
    
    /* BLOG
	-------------------------------------------------- */
	public function blog()
    {
    	$data['title'] = "Admin Blog";
    	
    	$formnewphotolb = $this->load->view('admin/lookbook/_formnewphotolb',array('tablephotolookbook'=>'','form'=>'new', 'lb_id' =>'', 'lb_gender' => $this->uri->segment(3)),TRUE);
    	$addblog = $this->load->view('admin/blog/_addblog',array('formnewphotolb' => $formnewphotolb),TRUE);
		
    	$tableblog = $this->load->view('admin/blog/_tableblog',array('allblog' => $this->mblog->get_all_blog_with_photo()),TRUE);
        
        $admin_content = $this->load->view('admin/blog/_blogidx',array(
        	'addblog' => $addblog,
        	'tableblog' => $tableblog),TRUE);

        $user_name = $this->muser->get_user_name_header();
        $stock = $this->mitem->check_all_items_stock();
        $lookbook_header = $this->mlookbook->get_lookbook_header();
        
        $data['header'] = $this->load->view('shared/header',array('user_name' => $user_name,'stock' => $stock, 'lookbook_header' => $lookbook_header, 'blog_header' =>$this->mblog->get_all_blog_show()),TRUE);	
    	$data['footer'] = $this->load->view('shared/footer','',TRUE);
        $data['content'] = $this->load->view('admin/index',array('admin_content' => $admin_content),TRUE);
    
        $this->load->view('front',$data);
    }
    
    public function input_blog(){
    	$blog['name'] = $this->input->post('name');
    	$blog['date_added'] = date('Y-m-d H:i:s');
    	$blog['show'] = 1;
    	
    	if($this->mblog->insert_blog($blog)){
    		$blog_just_add = $this->mblog->get_newest_blog_id();
    		$blog = $this->mblog->get_blog_by_id($blog_just_add);
    		$oldmask = umask(0);
    		mkdir('assets/img/blog/'.$blog_just_add, 0777, TRUE);
    		umask($oldmask);
    		$formdataprimblog = $this->load->view('admin/blog/_formdataprimblog',array('id' => $blog_just_add,'blog' => $blog),TRUE);
    		$fotoblog = $this->load->view('admin/blog/_photosblog',array('photos' => $this->mblog->get_all_blog_photos($blog_just_add)),TRUE);
    		$formfotoblog = $this->load->view('admin/blog/_formfotoblog',array('id' => $blog_just_add,'blog' => $blog, 'fotoblog' => $fotoblog),TRUE);
    		$json['status'] = 1;
    		$json['id_blog'] = $blog_just_add;
    		$json['msg'] = "Blog berhasil ditambahkan";
    		$json['dtprim'] = $formdataprimblog;
    		$json['foto'] = $formfotoblog;
    		$json['status']=1;
    	}
    	else{
			$json['status'] = 0;
		}
    	$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }
    
    public function edit_blog(){
        $id = $this->input->get('id');
		$blog = $this->mblog->get_blog_by_id($id);
    	
		if($blog){
			$editblog = $this->load->view('admin/blog/_editblog',array('blog' => $blog),TRUE);
    		$formdataprimblog = $this->load->view('admin/blog/_formdataprimblog',array('id' => $id,'blog' => $blog),TRUE);
    		$fotoblog = $this->load->view('admin/blog/_photosblog',array('photos' => $this->mblog->get_all_blog_photos($id)),TRUE);
    		$formfotoblog = $this->load->view('admin/blog/_formfotoblog',array('id' => $id,'blog' => $blog, 'fotoblog' => $fotoblog),TRUE);
    		
    		$json['status'] = 1;
            $json['html'] = $editblog;
            $json['dtprim'] = $formdataprimblog;
    		$json['foto'] = $formfotoblog;
		}else{
			$json['status'] = 0;
		}
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}
	
	public function load_table_blog(){
    	$tableblog = $this->load->view('admin/blog/_tableblog',array('allblog' => $this->mblog->get_all_blog_with_photo()),TRUE);
    	echo $tableblog.'<div style="clear:both"></div>';
    }
    
    public function update_video(){
    	$idblog = $this->uri->segment(3);
    	$blog['video'] = $this->input->post('video');
    	if($this->mblog->update_blog($blog,$idblog)){
    		$json['status']=1;
    		$json['video']= $this->input->post('video');
    	}else{
			$json['status'] = 0;
		}
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }
    
    public function update_name(){
    	$idblog = $this->uri->segment(3);
    	$blog['name'] = $this->input->post('name_edit');
    	if($this->mblog->update_blog($blog,$idblog)){
    		$json['status']=1;
    		$json['name']=$this->input->post('name_edit');
    	}else{
			$json['status'] = 0;
		}
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }
    
    public function update_show(){
    	$idblog = $this->uri->segment(3);
    	$blog['show'] = $this->input->post('show');
    	if($this->mblog->update_blog($blog,$idblog)){
    		$json['status']=1;
    	}else{
			$json['status'] = 0;
		}
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }
    
    public function update_profpic(){
    	if($_FILES){
        	$idblog = $this->uri->segment(3);
        	$upload_path = 'img/blog/'.$idblog.'/';

        	$config = $this->upload_config($upload_path,'');
        	
        	$this->load->library('upload', $config); //Meload library upload dengan config dari $config
        	if($this->mblog->delete_old_pp($idblog)){
				if ($this->upload->do_upload("photo_profil")){
					$data_photo = $this->upload->data();
					$photoname = $data_photo['file_name'];
					$target_folder = 'assets/'.$upload_path;
					$photolocation = base_url().$target_folder.$photoname;
				
					//make thumbnail
					$this->make_photo_thumb($photoname,$photolocation,$target_folder,272,'_thumbnail.jpg');
				
					//insert photo db
				
					$blog['photo_profil'] = $target_folder.$photoname;
					if($this->mblog->update_blog($blog,$idblog)){
						$json['status']=1;
						$json['pp']= $photolocation;
						$this->output->set_content_type('application/json')
						 ->set_output(json_encode($json));
					}
            	}
            	//echo "Berhasil gan";
        	}
        	else{echo "Gagal gan";}
        }
        else{echo "Pilih Gambar!";}
    }
    
    public function delete_blog(){
        if($this->mblog->delete_blog()){
        	$id= $this->input->post('id');
        	$dir= 'assets/img/blog/'.$id.'/';
        	
        	if(delete_files($dir, true)&&rmdir($dir)){
    			$json['status'] = 1;
    		}
    		else{
    			$json['status'] = 0;
    		}
    	}
    	else{
    		$json['status'] = 0;
    	}
    	$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}
	
    
    public function delete_profpic(){
    	$idblog = $this->input->post('item_id');
    	if($this->mblog->delete_old_pp($idblog)){
    		$blog['photo_profil'] = '';
    		if($this->mblog->update_blog($blog,$idblog)){
				$json['status']=1;
				$this->output->set_content_type('application/json')
				 ->set_output(json_encode($json));
			}
    	}
    }
    
    public function delete_photo_blog(){
		$id = $this->input->post('id');
        $photo = $this->mblog->get_photo_blog_by_id($id);
        $pname = $photo->name;
        if(unlink($pname)&&unlink($pname."_thumbnail.jpg")){
        	if($this->mblog->delete_photo_blog($id)){
        		$json['status'] = 1;
        	}else{
        		$json['status'] = 0;
        	}
        	$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
        }
	}
    
    public function upload_photo_blog(){
    	if($_FILES){
        	$idblog = $this->uri->segment(3);
        	$upload_path = 'img/blog/'.$idblog.'/';

        	$config = $this->upload_config($upload_path,'');
        	
        	$this->load->library('upload', $config); //Meload library upload dengan config dari $config
			if ($this->upload->do_multi_upload("photoblog")){
				$photos = $this->upload->get_multi_upload_data();
				foreach($photos as $photo){
					$data_photo = $photo;
					$photoname = $data_photo['file_name'];
					$target_folder = 'assets/'.$upload_path;
					$photolocation = base_url().$target_folder.$photoname;
			
					//make thumbnail
					$this->make_photo_thumb($photoname,$photolocation,$target_folder,272,'_thumbnail.jpg');
			
					//insert photo db
					$photo_blog['name'] = $target_folder.$photoname;
					$photo_blog['blog_id'] = $idblog;
					if($this->mblog->insert_photo_blog($photo_blog)){
					}
				}
				$fotoblog = $this->load->view('admin/blog/_photosblog',array('id' => $idblog,'photos' => $this->mblog->get_all_blog_photos($idblog)),TRUE);
				$json['fotoblog']=$fotoblog;
				$json['status']=1;
				$this->output->set_content_type('application/json')
									 ->set_output(json_encode($json));
			}
			//echo "Berhasil gan";
        	
        	else{echo "Gagal gan";}
        }
        else{echo "Pilih Gambar!";}
    }
    
    /* PESANAN
	-------------------------------------------------- */
    public function purchase()
    {
    	$data['title'] = "Admin Pesanan";
    	
    	$allpurchase = $this->mcart->get_all_purcahse_with_user_cart();
    	$i=0;
    	foreach($allpurchase as $prc){
    		$allpurchase[$i]['ShipAdr']=$this->muser->get_address_by_id($prc['Info']->shipping_adr);
    		$i++;
    	}
    	
    	$tablepurchasetd = $this->load->view('admin/purchase/_tablepurchase_td',array('allpurchase' => $allpurchase, 'filter'=>'', 'uid'=>''),TRUE);
    	$tablepurchase = $this->load->view('admin/purchase/_tablepurchase',array('tablepurchasetd' => $tablepurchasetd),TRUE);
        
        $admin_content = $this->load->view('admin/purchase/_purchaseidx',array(
        	'tablepurchase' => $tablepurchase),TRUE);

        $user_name = $this->muser->get_user_name_header();
        $stock = $this->mitem->check_all_items_stock();
        $lookbook_header = $this->mlookbook->get_lookbook_header();
        
        $data['header'] = $this->load->view('shared/header',array('user_name' => $user_name,'stock' => $stock, 'lookbook_header' => $lookbook_header, 'blog_header' =>$this->mblog->get_all_blog_show()),TRUE);	
    	$data['footer'] = $this->load->view('shared/footer','',TRUE);
        $data['content'] = $this->load->view('admin/index',array('admin_content' => $admin_content),TRUE);
    
        $this->load->view('front',$data);
    }
    
    public function update_status_purchase(){
    	$id = $this->uri->segment(3);
    	$purchase['status'] = $this->input->post('status');
    	$purchase['note'] = $this->input->post('note');
    	if($this->mcart->update_status_purchase($purchase,$id)){
    		if(strstr(base_url(),'://localhost')){
    			$json['status']=1;
    			$json['uid']=$this->input->post('uid');
    			$json['id']=$id;
    		}
    		else{
    			$prc = $this->mcart->get_purchase_with_cart_and_user_by_id($id);
    			if($this->send_email($prc)){
    				$json['status']=1;
    				$json['uid']=$this->input->post('uid');
    				$json['id']=$id;
    			}else{$json['status'] = 0;}
    		}
    		
    		//$json['id']=$id;
    		//$json['status_prc']= $this->input->post('status');
    	}else{
			$json['status'] = 0;
		}
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }
    
    private function send_email($prc){
        //$this->load->library('email');
        $eng_stat=$this->mcart->change_eng_status($prc->status);
        $config = $this->muser->config_email();
        $this->load->library('email',$config);
        $this->email->from('order@dync-store.com', 'DYNC');
        $this->email->to($prc->username);
        $subject = 'Status Update #'.$prc->number.' : '.$eng_stat;
        $message = $this->update_status_message($prc->email_lang,$prc,$eng_stat);
        $this->email->subject($subject);
        $this->email->message($message);
        return $this->email->send();
    }
    
    private function update_status_message($lang,$prc,$eng_stat){
    	$msg = "Dear ".$prc->name.",<br><br>";
    	if($prc->note){$note="<br><br>".$prc->note;}else{$note="";}
		if($lang=="English"){
			$msg = $msg.
					"Your order:<br>".
					"Order No. : ".$prc->number.
					"<br><br>"."has been updated to the following status: <b>".$eng_stat."</b>".$note.
					"<br><br>"."To view your order:"."<br>".
					base_url()."user/detail_purchase/".$prc->number;
		}
		else{
			$msg = 	$msg.
					"Pesanan anda:<br>".
					"Order No. : ".$prc->number.
					"<br><br>"."telah diperbarui untuk status sebagai berikut: <b>".$prc->status."</b>".$note.
					"<br><br>"."Untuk melihat pesanan anda:"."<br>".
					base_url()."user/detail_purchase/".$prc->number;
		}
		$sign = $this->muser->get_misc();
		$msg = $msg."<br><br>".nl2br($sign->signature);
		return $msg;
    }
    
    public function delete_purchase(){
        $id= $this->input->post('id');
        $cart_id= $this->input->post('cart_id');
        if($this->mcart->delete_purchase($id, $cart_id)){
        	$json['status'] = 1;
    	}
    	else{
    		$json['status'] = 0;
    	}
    	$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}
	
	public function delete_confirmation(){
        $id= $this->input->post('id');
        if($this->mcart->delete_confirmation($id)){
        	$json['status'] = 1;
    	}
    	else{
    		$json['status'] = 0;
    	}
    	$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}
	
	public function search_purchase(){
		$filter = $this->uri->segment(3);
		$query = $this->input->get('query');
		$allpurchase = $this->mcart->get_all_purcahse_search_with_user_cart($query);
		$i=0;
    	foreach($allpurchase as $prc){
    		$allpurchase[$i]['ShipAdr']=$this->muser->get_address_by_id($prc['Info']->shipping_adr);
    		$i++;
    	}
		if($allpurchase){
			$json['status'] = 1;
    		$tablepurchasetd = $this->load->view('admin/purchase/_tablepurchase_td',array('allpurchase' => $allpurchase, 'filter'=>$filter),TRUE);
            $json['html'] = $tablepurchasetd;
		}else{
			$json['status'] = 0;
		}
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}
	
	public function order_purchase_by(){
    	$filter = $this->uri->segment(3);
    	$atr = $this->uri->segment(4);
    	$kind = $this->uri->segment(5);
    	$allpurchase = $this->mcart->get_all_purcahse_order_with_user_cart($atr, $kind);
    	$i=0;
    	foreach($allpurchase as $prc){
    		$allpurchase[$i]['ShipAdr']=$this->muser->get_address_by_id($prc['Info']->shipping_adr);
    		$i++;
    	}
    	$tablepurchasetd = $this->load->view('admin/purchase/_tablepurchase_td',array('allpurchase' => $allpurchase, 'filter'=>$filter),TRUE);
    	echo $tablepurchasetd;
    }
	
	public function load_all_purchase(){
    	$uid = $this->uri->segment(4);
    	if($uid){
    		$allpurchase = $this->mcart->get_user_all_purcahse_with_user_cart($uid);
    	}
    	else{
    		$allpurchase = $this->mcart->get_all_purcahse_with_user_cart();	
    	}
    	$i=0;
    	foreach($allpurchase as $prc){
    		$allpurchase[$i]['ShipAdr']=$this->muser->get_address_by_id($prc['Info']->shipping_adr);
    		$i++;
    	}
    	$filter = $this->uri->segment(3);
    	$tablepurchasetd = $this->load->view('admin/purchase/_tablepurchase_td',array('allpurchase' => $allpurchase, 'filter'=>$filter, 'uid'=>$uid),TRUE);
    	echo $tablepurchasetd;
    }
    
    public function detail_purchase()
    {
    	$num = $this->uri->segment(3);
    	$data['title'] = "Pesanan - ".$num;
        
        $user_name = $this->muser->get_user_name_header();
        $stock = $this->mitem->check_all_items_stock();
        $lookbook_header = $this->mlookbook->get_lookbook_header();
        $user = $this->session->userdata('user');
        
        $prc = $this->mcart->get_purchase_detail_by_number($num);
        $cart_items_det = $prc['CartItems'];
        $tableprc_dtl = $this->load->view('customer/purchase/_tableprc_dtl',array('cart_items' => $cart_items_det, 'prc_info'=>$prc['Info']),TRUE);
        
        $cust_content = $this->load->view('customer/purchase/_detailpurchase',array(
        	'prc_info' => $prc['Info'],
        	'status_order' => $prc['EngStat'],
        	'tableprc_dtl' => $tableprc_dtl,
        	'adr_ship' =>$this->muser->get_address_by_id($prc['Info']->shipping_adr)
        	//'adr_pay' =>$this->muser->get_address_by_id($prc['Info']->billing_adr)
        	),TRUE);
        
        $data['header'] = $this->load->view('shared/header',array('user_name' => $user_name,'stock' => $stock, 'lookbook_header' => $lookbook_header, 'blog_header' =>$this->mblog->get_all_blog_show()),TRUE);	
    	$data['footer'] = $this->load->view('shared/footer','',TRUE);
        $data['content'] = $this->load->view('admin/index',array('admin_content' => $cust_content),TRUE);
    
        $this->load->view('front',$data);
    }
    
    /* PELANGGAN
	-------------------------------------------------- */
    public function customer()
    {
    	$data['title'] = "Admin Pelanggan";
    	
    	$allcustomer = $this->muser->get_all_customer();
    	
    	$tablecustomertd = $this->load->view('admin/customer/_tablecustomer_td',array('allcustomer' => $allcustomer),TRUE);
    	$tablecustomer = $this->load->view('admin/customer/_tablecustomer',array('tablecustomertd' => $tablecustomertd),TRUE);
        
        $admin_content = $this->load->view('admin/customer/_customeridx',array(
        	'tablecustomer' => $tablecustomer),TRUE);

        $user_name = $this->muser->get_user_name_header();
        $stock = $this->mitem->check_all_items_stock();
        $lookbook_header = $this->mlookbook->get_lookbook_header();
        
        $data['header'] = $this->load->view('shared/header',array('user_name' => $user_name,'stock' => $stock, 'lookbook_header' => $lookbook_header, 'blog_header' =>$this->mblog->get_all_blog_show()),TRUE);	
    	$data['footer'] = $this->load->view('shared/footer','',TRUE);
        $data['content'] = $this->load->view('admin/index',array('admin_content' => $admin_content),TRUE);
    
        $this->load->view('front',$data);
    }
    
    public function load_all_customer(){
    	$allcustomer = $this->muser->get_all_customer();
    	$tablecustomertd = $this->load->view('admin/customer/_tablecustomer_td',array('allcustomer' => $allcustomer),TRUE);
    	
    	echo $tablecustomertd;
    }
    
    public function order_customer_by(){
    	$atr = $this->uri->segment(3);
    	$kind = $this->uri->segment(4);
    	$allcustomer = $this->muser->get_all_customer_order($atr, $kind);
    	$tablecustomertd = $this->load->view('admin/customer/_tablecustomer_td',array('allcustomer' => $allcustomer),TRUE);
    	
    	echo $tablecustomertd;
    }
    
    public function search_customer(){
		$query = $this->input->get('query');
		$allcustomer = $this->muser->get_all_customer_search($query);
		if($allcustomer){
			$json['status'] = 1;
    		$tablecustomertd = $this->load->view('admin/customer/_tablecustomer_td',array('allcustomer' => $allcustomer),TRUE);
    		$json['html'] = $tablecustomertd;
		}else{
			$json['status'] = 0;
		}
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}
    
    public function detail_customer()
    {
    	$uid = $this->uri->segment(3);
    	$data['title'] = "Pelanggan - ".$uid;
        
        $user_name = $this->muser->get_user_name_header();
        $stock = $this->mitem->check_all_items_stock();
        $lookbook_header = $this->mlookbook->get_lookbook_header();
        
        $user = $this->muser->get_user_detail($uid);
        $allpurchase = $this->mcart->get_user_all_purcahse_with_user_cart($uid);
        $i=0;
    	foreach($allpurchase as $prc){
    		$allpurchase[$i]['ShipAdr']=$this->muser->get_address_by_id($prc['Info']->shipping_adr);
    		$i++;
    	}
    	
    	$tablepurchasetd = $this->load->view('admin/purchase/_tablepurchase_td',array('allpurchase' => $allpurchase, 'filter'=>'', 'uid'=>$uid),TRUE);
        
        $admin_content = $this->load->view('admin/customer/_detailcustomer',array(
        	'user'=>$user,
        	'tablepurchasetd'=>$tablepurchasetd
        	),TRUE);
        
        $data['header'] = $this->load->view('shared/header',array('user_name' => $user_name,'stock' => $stock, 'lookbook_header' => $lookbook_header, 'blog_header' =>$this->mblog->get_all_blog_show()),TRUE);	
    	$data['footer'] = $this->load->view('shared/footer','',TRUE);
        $data['content'] = $this->load->view('admin/index',array('admin_content' => $admin_content),TRUE);
    
        $this->load->view('front',$data);
    }
    
    public function delete_customer(){
        $id= $this->input->post('id');
        $this->mcart->delete_all_user_cart($id);
        if($this->muser->delete_customer($id)){
        	$json['status'] = 1;
    	}
    	else{
    		$json['status'] = 0;
    	}
    	$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}
	
	/* SUMMARY
	-------------------------------------------------- */
    public function summary()
    {
    	$data['title'] = "Admin Summary";
    
        $user_name = $this->muser->get_user_name_header();
        $stock = $this->mitem->check_all_items_stock();
        $lookbook_header = $this->mlookbook->get_lookbook_header();
        
        $purchase = $this->mcart->get_all_purcahse_with_user_cart();
        $cart_items = $this->mcart->get_cart_item_was_saled_this_year($purchase);
        $sale_stat = $this->mcart->get_sale_stat($cart_items);
        $admin_content = $this->load->view('admin/summary/_summaryidx',array(
        	'purchase' => $purchase,'cart_items' => $cart_items, 'sale_stat'=>$sale_stat),TRUE);
        
        $data['header'] = $this->load->view('shared/header',array('user_name' => $user_name,'stock' => $stock, 'lookbook_header' => $lookbook_header, 'blog_header' =>$this->mblog->get_all_blog_show()),TRUE);	
    	$data['footer'] = $this->load->view('shared/footer','',TRUE);
        $data['content'] = $this->load->view('admin/index',array('admin_content' => $admin_content),TRUE);
    
        $this->load->view('front',$data);
    }
    
    public function get_stat(){
    	$s_date = DateTime::createFromFormat('d/m/Y', $this->input->post('s_date'))->format('Y-m-d');
    	$e_date = DateTime::createFromFormat('d/m/Y', $this->input->post('e_date'))->format('Y-m-d');
    	
    	$purchase = $this->mcart->get_all_purcahse_with_user_cart_between($s_date,$e_date);
    	$cart_items = $this->mcart->get_cart_item_was_saled($purchase);
    	$pur_status=$this->mcart->get_purchase_status($purchase);
    	$ci_stat = $this->mcart->get_cart_item_stat($cart_items);
    	$statsummary = $this->load->view('admin/summary/_statsummary',array('purchase' => $purchase,'cart_items' => $cart_items, 'pur_status'=>$pur_status, 'ci_stat'=>$ci_stat),TRUE);
    	
		$json['status'] = 1;
		$json['stat'] = $statsummary;
		
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }
    
    public function get_stat_today(){
    	$s_date = date('Y-m-d');;
    	$e_date = date('Y-m-d');;
    	
    	$purchase = $this->mcart->get_all_purcahse_with_user_cart_between($s_date,$e_date);
    	$cart_items = $this->mcart->get_cart_item_was_saled($purchase);
    	$pur_status=$this->mcart->get_purchase_status($purchase);
    	$ci_stat = $this->mcart->get_cart_item_stat($cart_items);
    	$statsummary = $this->load->view('admin/summary/_statsummary',array('purchase' => $purchase,'cart_items' => $cart_items, 'pur_status'=>$pur_status, 'ci_stat'=>$ci_stat),TRUE);
    	
		echo $statsummary;
    }
    
    /* GUIDE
	-------------------------------------------------- */
	public function guide()
    {
    	$data['title'] = "Admin User Guide";
    	
    	//$formnewphotolb = $this->load->view('admin/lookbook/_formnewphotolb',array('tablephotolookbook'=>'','form'=>'new', 'lb_id' =>'', 'lb_gender' => $this->uri->segment(3)),TRUE);
    	$addguide = $this->load->view('admin/guide/_addguide',array(),TRUE);
		
    	$tableguidetd = $this->load->view('admin/guide/_tableguide_td',array('allguide' => $this->mguide->get_all_guide()),TRUE);
    	$tableguide = $this->load->view('admin/guide/_tableguide',array('tableguidetd' => $tableguidetd),TRUE);
        
        $admin_content = $this->load->view('admin/guide/_guideidx',array(
        	'addguide' => $addguide,
        	'tableguide' => $tableguide),TRUE);

        $user_name = $this->muser->get_user_name_header();
        $stock = $this->mitem->check_all_items_stock();
        $lookbook_header = $this->mlookbook->get_lookbook_header();
        
        $data['header'] = $this->load->view('shared/header',array('user_name' => $user_name,'stock' => $stock, 'lookbook_header' => $lookbook_header, 'blog_header' =>$this->mblog->get_all_blog_show()),TRUE);	
    	$data['footer'] = $this->load->view('shared/footer','',TRUE);
        $data['content'] = $this->load->view('admin/index',array('admin_content' => $admin_content),TRUE);
    
        $this->load->view('front',$data);
    }
    
    public function input_guide(){
    	
		$guide['title'] = $this->input->post('title');
		$guide['desc_guide'] = $this->input->post('desc');
		$guide['group'] = $this->input->post('group');
		$guide['how_to'] = $this->input->post('how_to');
		if($this->mguide->insert_guide($guide)){
			$json['status']= 1;
		}else{
			$json['status']= 0;
		}
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }
    
    public function update_guide(){
    	$id = $this->uri->segment(3);
		$guide['title'] = $this->input->post('title');
		$guide['desc_guide'] = $this->input->post('desc');
		$guide['group'] = $this->input->post('group');
		$guide['how_to'] = $this->input->post('how_to');
		if($this->mguide->update_guide($guide,$id)){
			$json['status']= 1;
		}else{
			$json['status']= 0;
		}
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }
    
    public function edit_guide(){
        $id = $this->input->get('id');
		$guide = $this->mguide->get_guide_by_id($id);
		if($guide){
			$json['status'] = 1;
    		$editguide = $this->load->view('admin/guide/_editguide',array('guide' => $guide),TRUE);
            $json['html'] = $editguide;
		}else{
			$json['status'] = 0;
		}
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}
    
    public function load_table_guide(){
    	$group = $this->uri->segment(3);
    	$tableguidetd = $this->load->view('admin/guide/_tableguide_td',array('allguide' => $this->mguide->get_all_guide_by_group($group)),TRUE);
    	echo $tableguidetd;
    }
    
    public function delete_guide(){
        $id= $this->input->post('id');
        if($this->mguide->delete_guide($id)){
        	$json['status'] = 1;
    	}
    	else{
    		$json['status'] = 0;
    	}
    	$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}
	
	public function search_guide(){
		$group = $this->uri->segment(3);
		$query = $this->input->get('query');
		$allguide = $this->mguide->get_all_guide_search($group,$query);
		if($allguide){
			$json['status'] = 1;
			$tableguidetd = $this->load->view('admin/guide/_tableguide_td',array('allguide' => $allguide),TRUE);
            $json['html'] = $tableguidetd;
		}else{
			$json['status'] = 0;
		}
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}
    
    /* ELSE
	-------------------------------------------------- */
    public function account()
    {
        $data['title'] = "Account Info";
        
        $user_name = $this->muser->get_user_name_header();
        $stock = $this->mitem->check_all_items_stock();
        $lookbook_header = $this->mlookbook->get_lookbook_header();
        $inf_usr = $this->muser->get_user_login();
        $admin_content = $this->load->view('admin/account/_accountinfo',array(
        	'user' => $inf_usr, 'misc' =>$this->muser->get_misc()
        	),TRUE);
        
        $data['header'] = $this->load->view('shared/header',array('user_name' => $user_name,'stock' => $stock, 'lookbook_header' => $lookbook_header, 'blog_header' =>$this->mblog->get_all_blog_show()),TRUE);	
    	$data['footer'] = $this->load->view('shared/footer','',TRUE);
        $data['content'] = $this->load->view('admin/index',array('admin_content' => $admin_content),TRUE);
    
        $this->load->view('front',$data);   
    }
    
    public function reset_admin_password(){
    	$user['password'] = md5('');
        
        if($this->muser->update_user($user)){
        	$json['status']=1;
        }
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }
    
    private function upload_config($upload_path,$file_name){
    	$config['upload_path'] = 'assets/'.$upload_path; //Menyetting direktori tempat file disimpan
        $config['allowed_types'] = 'jpg|jpeg|png|JPG'; //Tipe file yang diperbolehkan
        $config['max_size'] = '10000000000';
        $config['overwrite'] = FALSE;
        if($file_name){
        	$config['file_name'] = $file_name;
        	$config['overwrite'] = TRUE;
        }
        return $config;
    }
    private function make_photo_thumb($image_name, $image_location, $target_folder, $w_thumb, $ext_thumb_name){
        $thumbnail = $target_folder.$image_name.$ext_thumb_name;  // Set the thumbnail name
        // Get new sizes
        $upload_image = $image_location;
        list($width, $height) = getimagesize($upload_image);
        $newwidth = $w_thumb;
        $newheight = $w_thumb*$height/$width;
        
        // Load the images
        $thumb = imagecreatetruecolor($newwidth, $newheight);
        
        $stype = explode(".", $image_name);
        $stype = $stype[count($stype)-1];
        switch($stype) {
            case 'gif':
                $source = imagecreatefromgif($upload_image);
                break;
            case 'jpg':
                $source = imagecreatefromjpeg($upload_image);
                break;
            case 'jpeg':
                $source = imagecreatefromjpeg($upload_image);
                break;
            case 'JPG':
                $source = imagecreatefromjpeg($upload_image);
                break;    
            case 'png':
                $source = imagecreatefrompng($upload_image);
                break;
        }
        // Resize the $thumb image.
        imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        
        // Save the new file to the location specified by $thumbnail
        imagejpeg($thumb, $thumbnail, 80);
    }
}