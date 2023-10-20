<?php
/**********************************************/
/* Unit Pasukan Pembangunan Aplikasi 
/* Bahagian Teknologi Maklumat
/* Kementerian Dalam Negeri

/* Dibangunkan pada Oktober 2015
/*
/* Ketua Projek 
/*	---> Puan Ibriza Binti Ibrahim F48
/*
/* Penasihat Projek 
/*	---> Puan Izyanie Binti Mustafar F44
/*
/*	
/* Ketua Pengaturcaraan 
/*	---> Mohd Norizi Bin Abd Manah F29
/*			*norizi@gmail.com
/*			*012 2010 335
/*		



/**********************************************/


class Myidentity extends CI_Controller  {

	public function __construct()
    {
                parent::__construct();
                // Your own constructor code
		//$this->load->library("nusoap_lib");
		$this->load->helper("myidentity_helper");
		session_set();
				
    }
/*
	function Myidentity()
	{
		parent::Controller();	
		$this->load->library("nusoap_lib");
		$this->load->helper("myidentity_helper");
		session_set();
	}
	/* */
	function semak_nokp()
	{
		
		
		//check user dah login atau tidak
		$this->lib_general->check_login();
		//senarai modul yang dicapai
		$data['list_assign_modul']  = $this->lib_general->list_assign_modul();
		
		$data['check_menu_modul']  = $this->lib_general->check_menu_modul();

		//insert data ke audit trail
		$this->lib_general->audit_log();	
			
		//senarai modul yang dicapai
		$data['list_menu_assign_modul']  = $this->lib_general->list_assign_modul();	

		//papar mesej bila berjaya 
		$data['flash_success'] = $this->session->flashdata('flash_success');	
			
		//papar mesej bila gagal 
		$data['flash_error'] = $this->session->flashdata('flash_error');		
			
		$this->load->view('myidentity/semak_nokp',$data);
		//$this->load->view('myidentity/semak_nokp');
		//$this->output->enable_profiler(TRUE);
			
	}
	
	
	function semak_nokp_checkJPN()
	{
		//date_default_timezone_set("Asia/Kuala_lumpur");

		$ICNumber = $this->input->post('no_kp');	
		$sess_id_pengguna = $this->session->userdata('sess_id_pengguna');	
		
		$this->db->where('no_kp', $ICNumber);
		$this->db->from('anggota_profil');
		$check = $this->db->count_all_results();
		
		if ($check){
			$this->session->set_flashdata('flash_error','Ralat !.No. Kad Pengenalan pemohon telah wujud');
			
			
			redirect('myidentity/semak_nokp','refresh');
			
		}else{
				
			
				$client = new SoapClient("http://myrela.moha.gov.my/myrela/crsservice.wsdl");
			

				try 
				{
					//$d=mktime(11, 14, 54, 8, 12, 2014);
					$datetime = date("Y-m-d h:i:s");
					//$datetime = date("m/d/Y h:i:s A");
					
					$AgencyCode= "131010";
					$BranchCode= "MYRELA";
					$UserId = $sess_id_pengguna;
					$TransactionCode = "T2";
					$RequestDateTime = $datetime;					 
					$RequestIndicator = "A";
					
						$response = $client->retrieveCitizensData(array(
						"AgencyCode" => $AgencyCode,
						"BranchCode" => $BranchCode,
						"UserId" => $UserId,
						"TransactionCode" => $TransactionCode,
						"RequestDateTime" => $RequestDateTime,
						"ICNumber" => $ICNumber,
						"RequestIndicator" => $RequestIndicator, 
						
						));

						
						$response = get_object_vars($response); 
					
					  $AgencyCode = $response['AgencyCode'];
					  $BranchCode = $response['BranchCode'];
					  $UserId = $response['UserId'];
					  $TransactionCode = $response['TransactionCode'];				  
					  $ReplyIndicator = $response['ReplyIndicator'];
					  $MessageCode = $response['MessageCode'];
					  $Message = $response['Message'];
					  $ResidentialStatus = $response['ResidentialStatus'];
					  $RecordStatus = $response['RecordStatus'];
					  
					  
					   $data['ICNumber'] = $response['ICNumber'];
					   $data['Name']  = $response['Name'];
					   $convert_date = $response['DateOfBirth'];
						$explode = explode("-", $convert_date);
						 $a = $explode[0];
						 $b = $explode[1];
						 $c = $explode[2];
						 
						 $gabung = $c."-".$b."-".$a;  
						
					  $data['DateOfBirth']  = $gabung;
					  //STORE table JPN-MyRELA	
					  $data['AgencyCode']  = $response['AgencyCode'];
					  $data['UserId']  = $response['UserId'];
					  $data['TransactionCode']  = $response['TransactionCode'];
					  $data['ReplyDateTime']  = $response['ReplyDateTime'];
					  $data['ReplyIndicator']  = $response['ReplyIndicator'];
					  $data['MessageCode']  = $response['MessageCode'];
					  
					  $data['PermanentAddress1']  = $response['PermanentAddress1'];
					  $data['PermanentAddress2']  = $response['PermanentAddress2'];
					  $data['PermanentAddress3']  = $response['PermanentAddress3'];
					  $data['PermanentAddressPostcode']  = $response['PermanentAddressPostcode'];
					  $data['PermanentAddressCityCode']  = $response['PermanentAddressCityCode'];
					  $data['PermanentAddressStateCode']  = $response['PermanentAddressStateCode'];
					  
					  $data['PermanentAddressCityDesc']  = $response['PermanentAddressCityDesc'];
					  
					  //alamat 2
					  $data['CorrespondenceAddress1']  = $response['CorrespondenceAddress1'];
					  $data['CorrespondenceAddress2']  = $response['CorrespondenceAddress2'];
					  $data['CorrespondenceAddress3']  = $response['CorrespondenceAddress3'];
					  $data['CorrespondenceAddress4']  = $response['CorrespondenceAddress4'];
					  $data['CorrespondenceAddress5']  = $response['CorrespondenceAddress5'];
					  
					  $data['CorrespondenceAddressPostcode']  = $response['CorrespondenceAddressPostcode'];
					  $data['CorrespondenceAddressCityCode']  = $response['CorrespondenceAddressCityCode'];
					  $data['CorrespondenceAddressCityDescription']  = $response['CorrespondenceAddressCityDescription'];
					  $data['CorrespondenceAddressStateCode']  = $response['CorrespondenceAddressStateCode'];
					  $data['CorrespondenceAddressCountryCode']  = $response['CorrespondenceAddressCountryCode'];
					  $data['CorrespondenceAddressStatus']  = $response['CorrespondenceAddressStatus'];
					  $data['CorrespondenceAddressUpdateDate']  = $response['CorrespondenceAddressUpdateDate'];
					  $data['CorrespondenceAddressUpdateBy']  = $response['CorrespondenceAddressUpdateBy'];
					  
					  $data['Gender']  = $response['Gender'];
					  $data['convert_date']  = $convert_date;
					  
					  $data['Race']  = $response['Race'];
					  $data['Religion']  = $response['Religion'];
					  $data['Message']  = $response['Message'];
					  
					  $data['RecordStatus']  = $response['RecordStatus'];
					  $data['OldICnumber']  = $response['OldICnumber'];
					  $data['ResidentialStatus']  = $response['ResidentialStatus'];
					  $data['EmailAddress']  = $response['EmailAddress'];
					  //$data['MobilePhoneNumber']  = $response['MobilePhoneNumber'];
					  
					  //echo $ReplyIndicator;exit();
					  
					  if($ReplyIndicator =='1' || $ReplyIndicator =='2'){
						 if($ResidentialStatus  =='B' || $ResidentialStatus  =='C'){
							if($RecordStatus   =='2' || $RecordStatus  =='B' || $RecordStatus  =='H' ){
								//Message (‘Individu telah direkodkan meninggal dunia’)
								//echo "Individu telah direkodkan meninggal dunia";
								$this->session->set_flashdata('flash_error', "Individu telah direkodkan meninggal dunia");
								redirect('myidentity/semak_nokp','refresh');
							}else{
									$this->lib_general->check_login();
									//senarai modul yang dicapai
									$data['list_assign_modul']  = $this->lib_general->list_assign_modul();
									
									//dapatkan senarai peranan			
									$this->db->from('adm_peranan_rela');	
									$this->db->order_by('nama_peranan_rela','ASC');			
									$data['list_group'] = $this->db->get('');
									
									$data['list_daerah'] = $this->model_anggota->list_daerah($this->session->userdata('sess_negeri_pengguna'));
									
									$data['list_mukim'] = $this->model_anggota->list_mukim($this->session->userdata('sess_daerah_pengguna'));
									
									//$data['list_daerah'] = $this->model_anggota->list_daerah($id_negeri);
									
									$data['option_country'] = $this->model_anggota->getcountry_edit($this->session->userdata('sess_negeri_pengguna'));
									
									
									$this->db->order_by('keutamaan','ASC');
									$data['list_agama'] = $this->db->get('adm_agama');
									
									$this->db->order_by('keutamaan','ASC');
									$this->db->order_by('bangsa','ASC');		
									$data['list_bangsa'] = $this->db->get('adm_bangsa');
									$data['option_country'] = $this->model_anggota->getcountry();
									
									$this->db->where('rujukan','status_perkahwinan');
									$data['list_rujukan'] = $this->db->get('adm_rujukan');
									
									
									$data['list_insuran'] = $this->db->get('adm_senarai_syarikat_insurans');
									
									$this->db->where('rujukan','jawatan');
									$data['list_jawatan_rela'] = $this->db->get('adm_rujukan');
									
									$this->db->where('rujukan','pangkat_platun');
									$data['list_pangkat_platun'] = $this->db->get('adm_rujukan');
									
									$this->db->where('rujukan','hubungan_insuran');
									$data['list_hubungan'] = $this->db->get('adm_rujukan');
									
									$this->db->where('rujukan','pangkat_rela');
									$data['list_pangkat'] = $this->db->get('adm_rujukan');
									
									
									$data['list_persatuan'] = $this->db->get('adm_senarai_persatuan');
									
									$this->db->order_by('jenis_pekerjaan','ASC');
									$data['list_pekerjaan'] = $this->db->get('adm_jenis_pekerjaan');
									
									$data['list_kepakaran'] = $this->db->get('adm_jenis_kepakaran');
									
									$data['list_kelulusan_tertinggi'] = $this->db->get('adm_kelulusan');
									
									$data['list_media_sosial'] = $this->db->get('adm_anggota_media_sosial');
									
									$data['act']="tambah";
									
									//insert data ke audit trail
									$this->lib_general->audit_log();
									
									//senarai modul yang dicapai
									$data['list_menu_assign_modul']  = $this->lib_general->list_assign_modul();	
									
									$data['check_menu_modul']  = $this->lib_general->check_menu_modul();
						
						
						
						
						
						
						
						
						
								  
									$this->load->view('myidentity/add_anggota_myidentity',$data);
							
							}
							
						 }else{
							//echo $Message;
							$this->session->set_flashdata('flash_error', 'Pemohon bukan warganegara.');
							redirect('myidentity/semak_nokp','refresh');
						 }
					  }else{
					  
					  
						//echo $Message;
						$this->session->set_flashdata('flash_error', $Message);
						redirect('myidentity/semak_nokp','refresh');
					  
						
					}	
	  
				} 
				catch (Exception $e) 
				{
					$error = $e -> getMessage();
					/*do something*/
					//$error = $client->getError();
    					if ($error) {
        				echo "<h2>Error</h2><pre>" . $error . "</pre>";
    					}
				}
				
				//$this->output->enable_profiler(TRUE);
				
			}
	}
	
	function semak_nokp_warganegara()
	{
		
		
		//check user dah login atau tidak
		$this->lib_general->check_login();
		//senarai modul yang dicapai
		$data['list_assign_modul']  = $this->lib_general->list_assign_modul();
		
		$data['check_menu_modul']  = $this->lib_general->check_menu_modul();

		//insert data ke audit trail
		$this->lib_general->audit_log();	
			
		//senarai modul yang dicapai
		$data['list_menu_assign_modul']  = $this->lib_general->list_assign_modul();	

		//papar mesej bila berjaya 
		$data['flash_success'] = $this->session->flashdata('flash_success');	
			
		//papar mesej bila gagal 
		$data['flash_error'] = $this->session->flashdata('flash_error');		
			
		$this->load->view('myidentity/semak_nokp_warganegara',$data);
		//$this->load->view('myidentity/semak_nokp');
		//$this->output->enable_profiler(TRUE);
			
	}
	
	function semak_nokp_checkJPN_warganegara()
	{
		//date_default_timezone_set("Asia/Kuala_lumpur");

		$ICNumber = $this->input->post('no_kp');	
		$sess_id_pengguna = $this->session->userdata('sess_id_pengguna');	
		
		$this->db->where('no_kp', $ICNumber);
		$this->db->from('anggota_profil');
		$check = $this->db->count_all_results();
		
		//if ($check){
		//	$this->session->set_flashdata('flash_error','Ralat !.No. Kad Pengenalan pemohon telah menjadi Ahli');
			
			
		//	redirect('myidentity/semak_nokp_warganegara_result','refresh');
			
		//}else{
				
			
				$client = new SoapClient("http://myrela.moha.gov.my/myrela/crsservice.wsdl");
			

				try 
				{
					//$d=mktime(11, 14, 54, 8, 12, 2014);
					$datetime = date("Y-m-d h:i:s");
					//$datetime = date("m/d/Y h:i:s A");
					
					$AgencyCode= "131010";
					$BranchCode= "MYRELA";
					$UserId = $sess_id_pengguna;
					$TransactionCode = "T2";
					$RequestDateTime = $datetime;					 
					$RequestIndicator = "A";
					
						$response = $client->retrieveCitizensData(array(
						"AgencyCode" => $AgencyCode,
						"BranchCode" => $BranchCode,
						"UserId" => $UserId,
						"TransactionCode" => $TransactionCode,
						"RequestDateTime" => $RequestDateTime,
						"ICNumber" => $ICNumber,
						"RequestIndicator" => $RequestIndicator, 
						
						));

						
						$response = get_object_vars($response); 
					
					  $AgencyCode = $response['AgencyCode'];
					  $BranchCode = $response['BranchCode'];
					  $UserId = $response['UserId'];
					  $TransactionCode = $response['TransactionCode'];				  
					  $ReplyIndicator = $response['ReplyIndicator'];
					  $MessageCode = $response['MessageCode'];
					  $Message = $response['Message'];
					  $ResidentialStatus = $response['ResidentialStatus'];
					  $RecordStatus = $response['RecordStatus'];
					  
					  
					   $data['ICNumber'] = $response['ICNumber'];
					   $data['Name']  = $response['Name'];
					   $convert_date = $response['DateOfBirth'];
						$explode = explode("-", $convert_date);
						 $a = $explode[0];
						 $b = $explode[1];
						 $c = $explode[2];
						 
						 $gabung = $c."-".$b."-".$a;  
						
						 $data['DateOfBirth']  = $gabung;
				 
					  $data['PermanentAddress1']  = $response['PermanentAddress1'];
					  $data['PermanentAddress2']  = $response['PermanentAddress2'];
					  $data['PermanentAddress3']  = $response['PermanentAddress3'];
					  $data['PermanentAddressPostcode']  = $response['PermanentAddressPostcode'];
					  
					  $data['CorrespondenceAddress1']  = $response['CorrespondenceAddress1'];
					  $data['CorrespondenceAddress2']  = $response['CorrespondenceAddress2'];
					  $data['CorrespondenceAddress3']  = $response['CorrespondenceAddress3'];
					  $data['CorrespondenceAddressPostcode']  = $response['CorrespondenceAddressPostcode'];
					  $data['ResidentialStatus']  = $response['ResidentialStatus'];
					  $data['DateOfDeath']  = $response['DateOfDeath'];
					  $data['EmailAddress']  = $response['EmailAddress'];					   
					  $data['MobilePhoneNumber']  = $response['MobilePhoneNumber'];
					  
					  $data['Gender']  = $response['Gender'];
					  $data['Race']  = $response['Race'];
					  $data['Religion']  = $response['Religion'];
					  $data['RecordStatus']  = $response['RecordStatus'];
					  //echo $ReplyIndicator;exit();
					  
					  
					  
					  $data['list_assign_modul']  = $this->lib_general->list_assign_modul();
									
									//dapatkan senarai peranan			
									$this->db->from('adm_peranan_rela');	
									$this->db->order_by('nama_peranan_rela','ASC');			
									$data['list_group'] = $this->db->get('');
									
									$data['list_daerah'] = $this->model_anggota->list_daerah($this->session->userdata('sess_negeri_pengguna'));
									
									$data['list_mukim'] = $this->model_anggota->list_mukim($this->session->userdata('sess_daerah_pengguna'));
									
									//$data['list_daerah'] = $this->model_anggota->list_daerah($id_negeri);
									
									$data['option_country'] = $this->model_anggota->getcountry_edit($this->session->userdata('sess_negeri_pengguna'));
									
									
									$this->db->order_by('keutamaan','ASC');
									$data['list_agama'] = $this->db->get('adm_agama');
									
									$this->db->order_by('keutamaan','ASC');
									$this->db->order_by('bangsa','ASC');		
									$data['list_bangsa'] = $this->db->get('adm_bangsa');
									$data['option_country'] = $this->model_anggota->getcountry();
									
									$this->db->where('rujukan','status_perkahwinan');
									$data['list_rujukan'] = $this->db->get('adm_rujukan');
									
									
									$data['list_insuran'] = $this->db->get('adm_senarai_syarikat_insurans');
									
									$this->db->where('rujukan','jawatan');
									$data['list_jawatan_rela'] = $this->db->get('adm_rujukan');
									
									$this->db->where('rujukan','pangkat_platun');
									$data['list_pangkat_platun'] = $this->db->get('adm_rujukan');
									
									$this->db->where('rujukan','hubungan_insuran');
									$data['list_hubungan'] = $this->db->get('adm_rujukan');
									
									$this->db->where('rujukan','pangkat_rela');
									$data['list_pangkat'] = $this->db->get('adm_rujukan');
									
									
									$data['list_persatuan'] = $this->db->get('adm_senarai_persatuan');
									
									$this->db->order_by('jenis_pekerjaan','ASC');
									$data['list_pekerjaan'] = $this->db->get('adm_jenis_pekerjaan');
									
									$data['list_kepakaran'] = $this->db->get('adm_jenis_kepakaran');
									
									$data['list_kelulusan_tertinggi'] = $this->db->get('adm_kelulusan');
									
									$data['list_media_sosial'] = $this->db->get('adm_anggota_media_sosial');
									
									$data['act']="tambah";
									
									//insert data ke audit trail
									$this->lib_general->audit_log();
									
									//senarai modul yang dicapai
									$data['list_menu_assign_modul']  = $this->lib_general->list_assign_modul();	
									
									$data['check_menu_modul']  = $this->lib_general->check_menu_modul();
					  
					  if($ReplyIndicator =='1' || $ReplyIndicator =='2'){
						 if($ResidentialStatus  =='B' || $ResidentialStatus  =='C'){
							if($RecordStatus   =='2' || $RecordStatus  =='B' || $RecordStatus  =='H' ){
								//Message (‘Individu telah direkodkan meninggal dunia’)
								//echo "Individu telah direkodkan meninggal dunia";
								$this->session->set_flashdata('flash_error', "Individu telah direkodkan meninggal dunia");
								$this->load->view('myidentity/semak_nokp_warganegara_result',$data);
							}else{
									$this->lib_general->check_login();
									//senarai modul yang dicapai
									
						
						
						
						
						
						
						
						
						
								  
									$this->load->view('myidentity/semak_nokp_warganegara_result',$data);
							
							}
							
						 }else{
							//echo $Message;
							$this->session->set_flashdata('flash_error', 'Pemohon bukan warganegara.');
							$this->load->view('myidentity/semak_nokp_warganegara_result',$data);
						 }
					  }else{
					  
					  
						//echo $Message;
						$this->session->set_flashdata('flash_error', $Message);
						redirect('myidentity/semak_nokp_warganegara',$data);
					  
						
					}	
	  
				} 
				catch (Exception $e) 
				{
					$a = $e -> getMessage();
					/*do something*/
					$this->session->set_flashdata('flash_error', $a);
					redirect('myidentity/semak_nokp_warganegara','refresh');
				}
				
				//$this->output->enable_profiler(TRUE);
				
			//}
	}
	
	
	
	function semak_nokp_checkJPN_online($ICNumber)
	{
		//date_default_timezone_set("Asia/Kuala_lumpur");

		//$ICNumber = $this->input->post('no_kp');	
		$sess_id_pengguna = $this->session->userdata('sess_id_pengguna');	
		
		$this->db->where('no_kp', $ICNumber);
		$this->db->from('anggota_profil');
		$check = $this->db->count_all_results();
		
		if ($check){
			$this->session->set_flashdata('flash_error','Ralat !.No. Kad Pengenalan pemohon telah wujud');
			
									$date_current=date('Y-m-d');
									$data = array(			
				
										'status_permohonan' => 0,
										'check_date' => $date_current,
										'note'=> 'No. Kad Pengenalan pemohon telah wujud'
										
									);				
							
									$this->db->where('no_kp',$ICNumber);
									$this->db->update('anggota_profil_online', $data);
									
							redirect('anggota/list_permohonan_online','refresh');
			
		}else{
				
			
				$client = new SoapClient("http://myrela.moha.gov.my/myrela/crsservice.wsdl");
			

				try 
				{
					//$d=mktime(11, 14, 54, 8, 12, 2014);
					$datetime = date("Y-m-d h:i:s");
					//$datetime = date("m/d/Y h:i:s A");
					
					$AgencyCode= "131010";
					$BranchCode= "MYRELA";
					$UserId = $sess_id_pengguna;
					$TransactionCode = "T2";
					$RequestDateTime = $datetime;					 
					$RequestIndicator = "A";
					
						$response = $client->retrieveCitizensData(array(
						"AgencyCode" => $AgencyCode,
						"BranchCode" => $BranchCode,
						"UserId" => $UserId,
						"TransactionCode" => $TransactionCode,
						"RequestDateTime" => $RequestDateTime,
						"ICNumber" => $ICNumber,
						"RequestIndicator" => $RequestIndicator, 
						
						));

						
						$response = get_object_vars($response); 
					
					  $AgencyCode = $response['AgencyCode'];
					  $BranchCode = $response['BranchCode'];
					  $UserId = $response['UserId'];
					  $TransactionCode = $response['TransactionCode'];				  
					  $ReplyIndicator = $response['ReplyIndicator'];
					  $MessageCode = $response['MessageCode'];
					  $Message = $response['Message'];
					  $ResidentialStatus = $response['ResidentialStatus'];
					  $RecordStatus = $response['RecordStatus'];
					  
					  
					   $data['ICNumber'] = $response['ICNumber'];
					   $data['Name']  = $response['Name'];
					   $convert_date = $response['DateOfBirth'];
						$explode = explode("-", $convert_date);
						 $a = $explode[0];
						 $b = $explode[1];
						 $c = $explode[2];
						 
						 $gabung = $c."-".$b."-".$a;  
						
					  $data['DateOfBirth']  = $gabung;
					  //STORE table JPN-MyRELA	
					  $data['AgencyCode']  = $response['AgencyCode'];
					  $data['UserId']  = $response['UserId'];
					  $data['TransactionCode']  = $response['TransactionCode'];
					  $data['ReplyDateTime']  = $response['ReplyDateTime'];
					  $data['ReplyIndicator']  = $response['ReplyIndicator'];
					  $data['MessageCode']  = $response['MessageCode'];
					  
					  $data['PermanentAddress1']  = $response['PermanentAddress1'];
					  $data['PermanentAddress2']  = $response['PermanentAddress2'];
					  $data['PermanentAddress3']  = $response['PermanentAddress3'];
					  $data['PermanentAddressPostcode']  = $response['PermanentAddressPostcode'];
					  $data['PermanentAddressCityCode']  = $response['PermanentAddressCityCode'];
					  $data['PermanentAddressStateCode']  = $response['PermanentAddressStateCode'];
					  
					  $data['PermanentAddressCityDesc']  = $response['PermanentAddressCityDesc'];
					  
					  //alamat 2
					  $data['CorrespondenceAddress1']  = $response['CorrespondenceAddress1'];
					  $data['CorrespondenceAddress2']  = $response['CorrespondenceAddress2'];
					  $data['CorrespondenceAddress3']  = $response['CorrespondenceAddress3'];
					  $data['CorrespondenceAddress4']  = $response['CorrespondenceAddress4'];
					  $data['CorrespondenceAddress5']  = $response['CorrespondenceAddress5'];
					  
					  $data['CorrespondenceAddressPostcode']  = $response['CorrespondenceAddressPostcode'];
					  $data['CorrespondenceAddressCityCode']  = $response['CorrespondenceAddressCityCode'];
					  $data['CorrespondenceAddressCityDescription']  = $response['CorrespondenceAddressCityDescription'];
					  $data['CorrespondenceAddressStateCode']  = $response['CorrespondenceAddressStateCode'];
					  $data['CorrespondenceAddressCountryCode']  = $response['CorrespondenceAddressCountryCode'];
					  $data['CorrespondenceAddressStatus']  = $response['CorrespondenceAddressStatus'];
					  $data['CorrespondenceAddressUpdateDate']  = $response['CorrespondenceAddressUpdateDate'];
					  $data['CorrespondenceAddressUpdateBy']  = $response['CorrespondenceAddressUpdateBy'];
					  
					  $data['Gender']  = $response['Gender'];
					  $data['convert_date']  = $convert_date;
					  
					  $data['Race']  = $response['Race'];
					  $data['Religion']  = $response['Religion'];
					  $data['Message']  = $response['Message'];
					  
					  $data['RecordStatus']  = $response['RecordStatus'];
					  $data['OldICnumber']  = $response['OldICnumber'];
					  $data['ResidentialStatus']  = $response['ResidentialStatus'];
					  $data['EmailAddress']  = $response['EmailAddress'];
					  $data['MobilePhoneNumber']  = $response['MobilePhoneNumber'];
					  
					  //echo $ReplyIndicator;exit();
					  
					  if($ReplyIndicator =='1' || $ReplyIndicator =='2'){
						 if($ResidentialStatus  =='B' || $ResidentialStatus  =='C'){
							if($RecordStatus   =='2' || $RecordStatus  =='B' || $RecordStatus  =='H' ){
								//Message (‘Individu telah direkodkan meninggal dunia’)
								//echo "Individu telah direkodkan meninggal dunia";
								$this->session->set_flashdata('flash_error', "Individu telah direkodkan meninggal dunia");
								
									$date_current=date('Y-m-d');

									$data = array(			
				
										'status_permohonan' => 0,
										'check_date' => $date_current,
										'note'=> 'Individu telah direkodkan meninggal dunia'
										
									);				
							
									$this->db->where('no_kp',$ICNumber);
									$this->db->update('anggota_profil_online', $data);
									
									
								redirect('anggota/list_permohonan_online','refresh');
								
							}else{
									
									$this->session->set_flashdata('flash_success', "Semakan data dengan JPN berjaya !.");
									
									
									$date_current=date('Y-m-d');
									$namaJPN = $response['Name'];
									$data = array(			
				
										
										'check_jpn' => '2',
										'nama_jpn' => $namaJPN,
										'tarikh_check_jpn' => $date_current,
										
										
									);				
							
									$this->db->where('no_kp',$ICNumber);
									$this->db->update('anggota_profil_online', $data);
									
									redirect('anggota/list_permohonan_online','refresh');
							
							}
							
						 }else{
							//echo $Message;
							$this->session->set_flashdata('flash_error', 'Pemohon bukan warganegara.');
							
									$date_current=date('Y-m-d');
									$data = array(			
				
										'status_permohonan' => 0,
										'check_date' => $date_current,
										'note'=> 'Pemohon bukan warganegara.'
										
									);				
							
									$this->db->where('no_kp',$ICNumber);
									$this->db->update('anggota_profil_online', $data);
							
							redirect('anggota/list_permohonan_online','refresh');
							
						 }
					  }else{
					  
					  
						//echo $Message;
						$this->session->set_flashdata('flash_error', $Message);
						
									$date_current=date('Y-m-d');
									$data = array(			
				
										'status_permohonan' => 0,
										'check_date' => $date_current,
										'note'=> $Message
										
									);				
							
									$this->db->where('no_kp',$ICNumber);
									$this->db->update('anggota_profil_online', $data);
						
						redirect('anggota/list_permohonan_online','refresh');
					  
						
					}	
	  
				} 
				catch (Exception $e) 
				{
					$e -> getMessage();
					/*do something*/
				}
				
				
				
			}
			
			//$this->output->enable_profiler(TRUE);
	}

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
