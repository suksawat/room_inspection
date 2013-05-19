<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user_service extends CI_Controller {
	public function index()
	{
		$this->load->view('welcome_message');
	}
	
	public function do_login()
	{
	
		$this->form_validation->set_rules('username',  "Username", 'trim|required');
		$this->form_validation->set_rules('password',  "Password", 'trim|required');
		
				
			$html ="<data>";
				
				if ($this->form_validation->run() == FALSE)
				{
					
						
						if(isset($_POST["username"]))
						{
						$html.=  validation_errors('<error>', '</error>'); 
						}
						else {
							
							$html .= "<error>No send post Value.</error>";
						}
					
				}
				else
				{
					
					$password = md5($_POST["password"]);
					
					$user_rows = $this->db->query("select * from users where username='$username' and password = '$password'")->result_array();
					
					if(count($user_rows))
					{
						$user = $user_rows[0];
						$html = "<user_id>".$user["username"]."</user_id>";
						$html = "<username>".$user["firstname"]."</username>";
						$html = "<firstname>".$user["lastname"]."</lastname>";
						$html = "<position>".$user["position"]."</position>";
						$html = "<email>".$user["email"]."</email>";
						
						
					}
					else {
						
						$html .= "<error>Username & Password not mat</error>";
					}					
				
				}					
		$html .="</data>";
		header('Content-type: text/xml');
		echo $html;			
	}
	
}

