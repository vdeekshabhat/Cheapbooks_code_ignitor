	<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class cheapbook extends CI_Controller {

		/**
		 * Index Page for this controller.
		 *
		 * Maps to the following URL
		 * 		http://example.com/index.php/welcome
		 *	- or -
		 * 		http://example.com/index.php/welcome/index
		 *	- or -
		 * Since this controller is set as the default controller in
		 * config/routes.php, it's displayed at http://example.com/
		 *
		 * So any other public methods not prefixed with an underscore will
		 * map to /index.php/welcome/<method_name>
		 * @see https://codeigniter.com/user_guide/general/urls.html
		 */
		public function index()
		{
			$this->load->view('layout/header');
			$this->load->view('Page1');
			$this->load->view('layout/footer');
		}

		public function Page2()
		{
			$this->load->view('layout/header');
			$this->load->view('Page2');
			$this->load->view('layout/footer');
		}

		public function Page3()
		{
			$this->load->view('layout/header');
			$this->load->view('Page3');
			$this->load->view('layout/footer');
		}

		public function Page4()
		{
			$this->load->view('layout/header');
			$this->load->view('Page4');
			$this->load->view('layout/footer');
		}


		public function CheckLogin() {
			$this->load->model('api');
			$username = $this->input->post("username");
			$password = $this->input->post("password");
			$data = $this->api->CheckLogin($username, $password);
			echo json_encode($data);
			
			
		}
			public function SearchByAuthor() {
			$this->load->model('api');
			$text = $this->input->post("text");
			$data = $this->api->SearchByAuthor($text);
			echo json_encode($data);
			
		}
			public function SearchByTitle() {
			$this->load->model('api');
			$text = $this->input->post("text");
			$data = $this->api->SearchByTitle($text);
			echo json_encode($data);
			
		}
			public function AddToCart() {
			$this->load->model('api');
			$isbn = $this->input->post("isbn");
			$data = $this->api->AddToCart($isbn);
			echo $data;
			
			}
			public function cart_count(){
			$this->load->model('api');
			$id = $this->input->post("id");
			$data = $this->api->cart_count($id);
			echo $data;
			}
			public function cartContent(){
				$this->load->model('api');
				$data = $this->api->cartContent();
				echo $data;
			}
			public function newuser(){
				$this->load->model('api');
				$data = $this->api->newuser();
				echo $data;
			}
			public function Buy(){
				$this->load->model('api');
				$data = $this->api->Buy();
				echo $data;
			}
		public function logout(){
	    	$this->session->unset_userdata('user_session');
	        $this->session->sess_destroy();
	        return true;
	    }
	}
