<?php
/*
 * TODO: Add a new form for editing a client (should load the old values and
 *       then allow changing the values and update the database after updating). It
 *       should also validate that all the values are valid. (ALMOST)
 *
 */
class Account extends CI_Controller
{
	function __construct() {
		// Call the Controller constructor
		parent::__construct();
		$this->load->library('session');
	}

	public function _remap($method, $params = array()) {
		// enforce access control to protected functions

		$user = $this->session->userdata('user');

		$client = array(
			'logout'
		);

		$admin = array(
			'form_new_user',
			'form_new_client',
			'form_edit_user',
			'edit_user',
			'delete_user',
			'form_edit_client',
			'change_user',
			'create_new_user',
			'create_new_client',
			'delete_client'
		);

		/* Check if the user is logged in */
		if (in_array($method, array_merge($client, $admin)) && !$user) {

			redirect('account/index', 'refresh');
		} else if (in_array($method, $admin) && $user) {

			/* Check if the user is an admin */
			if ($user->usertype != User::ADMIN)
				redirect('main/index', 'refresh');
		}

		return call_user_func_array(array($this, $method), $params);
	}

	function index() {
		$this->load->view('account/login');
	}

	/*
	 * Loads the main form for making a new user.
	 */
	function form_new_user() {
		$this->load->model('client_model');
		$data['clients'] = $this->client_model->display_all_clients();
		$data['title'] = 'Storefront Calendar';
		$data['main'] = 'account/new_user';
		$data['scripts'] = 'account/scripts';
		$data['styles'] = 'account/styles';


		$this->load->view('template', $data);
	}

	/*
	 * Loads the main form for making a new client.
	 */
	function form_new_client() {

		$data['title'] = 'Storefront Calendar';
		$data['main'] = 'account/new_client';
		$data['scripts'] = 'account/scripts';
		$data['styles'] = 'account/styles';


		$this->load->view('template', $data);
	}

	function form_edit_user() {
		$this->load->library('form_validation');
		$this->load->model('user_model');
		$this->load->model("client_model");

		$data['title'] = 'Storefront Calendar';
		$data['main'] = 'account/edit_user';
		$data['scripts'] = 'account/scripts';
		$data['styles'] = 'account/styles';

		$data['query'] = $this->user_model->display_all_users();
		$data['clients'] = $this->client_model->display_all_clients();
		$data['user'] = new User();

		$this->load->view('template', $data);
	}

	/*
	 * Loads the main form for making a new client.
	 */
	function form_edit_client() {
		$this->load->model('client_model');

		$message = $this->session->flashdata('message');
		if (isset($message))
			$data['message'] = $message;

		$data['title'] = 'Storefront Calendar';
		$data['main'] = 'account/edit_client';
		$data['scripts'] = 'account/scripts';
		$data['styles'] = 'account/styles';

		$data['clients'] = $this->client_model->display_all_clients();
		$data['client'] = new Client();

		$this->load->view('template', $data);
	}

	/*
	 * Loads the main form for updating your password.
	 */
	function form_update_password() {
		$data['title'] = 'Storefront Calendar';
		$data['main'] = 'account/update_password';
		$data['scripts'] = 'account/scripts';
		$data['styles'] = 'account/styles';
		$this->load->view('template', $data);
	}
	/*
	 * Loads the main form for recovering your lost password with your email
	 * that you are associated with.
	 *
	 * TODO: The emailing system should be setup.
	 */
	function form_recover_password() {
		$this->load->view('account/recover_password');
	}

	/*
	 * Checks the login credentials as stored in the database.
	 *
	 * Runs server-side validation. TODO: Add error messages so the user 
	 * understands and knows when they have entered the right or wrong 
	 * credentials.
	 */
	function login() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('account/login');
		} else {
			$login = $this->input->post('username');
			$password = $this->input->post('password');

			$this->load->model('user_model');

			$user = $this->user_model->get($login);

			if (isset($user) && $user->compare_password($password)) {
				$data = array('user' => $user);
				$this->session->set_userdata($data);
				$data['user'] = $user;
				//to easily retrive the login id later
				//$this->session->set_userdata("login", $user->login);

				redirect('main/index', 'refresh'); //redirect to the main application page
			} else {
				redirect('account/index', 'refresh');
			}
		}
	}

	/*
	 * Logs out the current user by unsetting the user class.
	 */
	function logout() {
		$this->session->unset_userdata('user');
		redirect('account/index', 'refresh');
	}

	/*
	 * The functionality for the form in order to create a new user. It checks 
	 * the validation of the form and creates a new instance of a User and
	 * stores it in the database.
	 */
	function create_new_user() {
		$this->load->model('client_model');
		$this->load->library('form_validation');

		if ($this->form_validation->run() == FALSE) {
			$data['clients'] = $this->client_model->display_all_clients();
			$data['title'] = 'Storefront Calendar';
			$data['main'] = 'account/new_user';
			$data['scripts'] = 'account/scripts';
			$data['styles'] = 'account/styles';

			$this->load->view('template', $data);
			
		} else {
			$user = new User();

			$user->login = $this->input->post('username');
			$user->first = $this->input->post('first');
			$user->last = $this->input->post('last');
			$password = $user-> init();
			$user->email = $this->input->post('email');
			$user->clientid = intval($this->input->post("agency"));
			$user->usertype = intval($this->input->post("type"));

			$this->load->model('user_model');
			
			$this->user_model->auto_email($user->email, "Welcome to Storefront", 
											"Welcome to Storefront $user->login: 
								your password is $password, please remember it");

			$this->user_model->insert($user);

			$this->session->set_flashdata('message', "The new user " .
				$user->first . " " . $user->last .
				" has been made!");
			redirect('main/index', 'refresh'); //redirect to the main application page
		}
	}

	/*
	 * Update the password of the current logged in user.
	 */
	function update_password() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('prev', 'prev', '');
		$this->form_validation->set_rules('new', 'new', '');

		if ($this->form_validation->run() == FALSE) {
			echo "wtf";
			$data['title'] = 'Storefront Calendar';
			$data['main'] = 'account/update_password';
			$data['scripts'] = 'account/scripts';
			$data['styles'] = 'account/styles';
			$this->load->view('template', $data);
		} 
		else{
			$user = $this->session->userdata('user');

			$old_password = $this->input->post('prev');
			$new_password = $this->input->post('new');
			
			if ($user->compare_password($old_password)) {
				$user->encrypt_password($new_password);
				$this->load->model('user_model');
				$this->user_model->update_password($user);
				$this->user_model->auto_email($user->email, "new password", 
											"your new password is $new_password	, please remember it");		

				$data = array('user' => $user);
				$this->session->set_userdata($data);
				$data['user'] = $user;
				redirect('main/index', 'refresh'); //redirect to the main application page
			}
			else {	
				$data['title'] = 'Storefront Calendar';
				$data['main'] = 'account/update_password';
				$data['scripts'] = 'account/scripts';
				$data['styles'] = 'account/styles';
				$data['message'] = "Wrong password";
		 
				$this->load->view('template', $data);
			}
		}
	}

	/*
	 * Recover the password by using the emailing system.
	 */
	function recover_password() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'email', 'required|valid_email|max_length[120]');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('account/recover_password');
		} else {
			$email = $this->input->post('email');
			$this->load->model('user_model');
			$user = $this->user_model->get_from_email($email);


			if (isset($user)) {
				$password = $user->init();
				$this->user_model->update_password($user);	
				$this->user_model->auto_email($user->email, "new password", 
											"your new password is $password, please remember it");	
				$this->index();
			} else {
				$data['errorMsg'] = "No record exists for this email!";
				$this->load->view('account/recover_password', $data);
			}
		}
	}

	/*
	 * Remove specific user and all infos that related to this user
	 */
	function delete_user() {
		$login = $this->input->post('login');
		$this->load->model('user_model');
		$this->load->model('client_model');

		$data['title'] = 'Storefront Calendar';
		$data['main'] = 'account/edit_user';
		$data['scripts'] = 'account/scripts';
		$data['styles'] = 'account/styles';
		$data['query'] = $this->user_model->display_all_users();
		$data['clients'] = $this->client_model->display_all_clients();


		$user = $this->session->userdata('user');
		$currentlogin = $user->login;

		if ($currentlogin == $login) {
			$data['user'] = $user;
			$data['message'] = 'You cannot delete yourself';
			$this->load->view('template', $data);
		} else {
			$this->user_model->delete_user($login);
			$data['user'] = new User();
			$data['message'] = "The user " . $login . " has been deleted!";
			$this->load->view('template', $data);
		}
	}

	function change_user() {
		$login = $this->input->post('category');

		$this->load->model('user_model');
		$this->load->model('client_model');
		$user = $this->user_model->get($login);

		$data['user'] = $user;
		$data['query'] = $this->user_model->display_all_users();
		$data['clients'] = $this->client_model->display_all_clients();

		$data['title'] = 'Storefront Calendar';
		$data['main'] = 'account/edit_user';
		$data['scripts'] = 'account/scripts';
		$data['styles'] = 'account/styles';


		$this->load->view('template', $data);
	}

	/* Edit the user's information */
	function edit_user() {

		$this->load->model('user_model');
		$this->load->model("client_model");

		$data['title'] = 'Storefront Calendar';
		$data['main'] = 'account/edit_user';
		$data['scripts'] = 'account/scripts';
		$data['styles'] = 'account/styles';

		$login = $this->input->post('login');
		$user = $this->user_model->get($login);

		$this->load->library('form_validation');
		$this->form_validation->set_rules('first', 'First', 'required|max_length[20]');
		$this->form_validation->set_rules('last', 'Last', 'required|max_length[20]');
		$this->form_validation->set_rules('email', 'Email', "required|valid_email|max_length[120]|callback_email_check");

		if ($this->form_validation->run() == FALSE) {
			$data['user'] = $user;
			$data['query'] = $this->user_model->display_all_users();
			$data['clients'] = $this->client_model->display_all_clients();
			$this->load->view('template', $data);

		} else {

			$first = $this->input->post('first');
			$last = $this->input->post('last');
			$email = $this->input->post('email');
			$client_id = intval($this->input->post('agency'));
			$user_type = intval($this->input->post('type'));

			$user->first = $first;
			$user->last = $last;
			$user->email = $email;
			$user->clientid = $client_id;
			$user->usertype = $user_type;

			//TO DO : update only one function for efficiency
			$this->user_model->update_email($user);
			$this->user_model->update_name($user);
			$this->user_model->update_usertype($user);
			$this->user_model->update_clientid($user);

			$data['message'] = "The client " . $user->login . " has been updated!";

			$data['user'] = $user;
			$data['query'] = $this->user_model->display_all_users();
			$data['clients'] = $this->client_model->display_all_clients();

			$this->load->view('template', $data);
		}

	}

	/*
	 * Check the given email is already exist in database or not
	 */
	public function email_check($email) {

		$login = $this->input->post('login');

		$this->load->model("user_model");
		$user = $this->user_model->get($login);

		if ($user->email != $email) {
			if ($this->user_model->get_from_email($email)) {
				return TRUE;
			} else {
				$this->form_validation->set_message("email_check", "The email already exists");
				return FALSE;
			}
		}
	}

	
	function create_new_client() {
		$this->load->library('form_validation');

		if ($this->form_validation->run() == FALSE) {
			$this->form_new_client();
		} else {
			$client = new Client();

			//Sorry for inconsistency between client's parameters and input's names but I'll try to change it soon. 
			$client->agency = $this->input->post('partnername');
			$client->program = $this->input->post('programname');
			$client->manager = $this->input->post('manager');
			$client->manager_position = $this->input->post('managerposition');
			$client->facilitator = $this->input->post('programfc');
			$client->facilitator_position = $this->input->post('fcposition');
			$client->address = $this->input->post('address');
			$client->phone = $this->input->post('phone');
			$client->fax = $this->input->post('fax');
			$client->email = $this->input->post('email');
			$client->agreement_status = $this->input->post('agreement_status');
			$client->insurance_status = $this->input->post('insurance');
			$client->category = $this->input->post('category');

		
			$this->load->model('client_model');

			$this->client_model->insert($client);

			$this->session->set_flashdata('message', "The new client " .
				$client->agency .
				" has been made!");
			redirect('main/index', 'refresh'); //redirect to the main application page
		}
	}

	/*
	 * Update client's data according to choosen client
	 */
	function change_client(){
		$this->load->model('client_model');

		$message = $this->session->flashdata('message');
		if (isset($message))
			$data['message'] = $message;
		$data['title'] = 'Storefront Calendar';
		$data['main'] = 'account/edit_client';
		$data['scripts'] = 'account/scripts';
		$data['styles'] = 'account/styles';


		$id = $this->input->post('agency');
		$data['clients'] = $this->client_model->display_all_clients();
		$data['client'] =  $this->client_model->get_from_id($id);

		$this->load->view('template', $data);
	}

	/*
	 * Create a new client and add it to the database. Very simplified version
	 * of a client for now.
	 */
	function edit_client() {
		$this->load->model('client_model');


		$data['title'] = 'Storefront Calendar';
		$data['main'] = 'account/edit_client';
		$data['scripts'] = 'account/scripts';
		$data['styles'] = 'account/styles';

		$id = $this->input->post('id');
		$client = $this->client_model->get_from_id($id);

		$this->load->library('form_validation');

		if ($this->form_validation->run() == FALSE) {

			$data['clients'] = $this->client_model->display_all_clients();
			$data['client'] = $client;

			$this->load->view('template', $data);
		} else {
			$client->program = $this->input->post('programname');
			$client->manager = $this->input->post('manager');
			$client->manager_position = $this->input->post('managerposition');
			$client->facilitator = $this->input->post('programfc');
			$client->facilitator_position = $this->input->post('fcposition');
			$client->address = $this->input->post('address');
			$client->phone = $this->input->post('phone');
			$client->fax = $this->input->post('fax');
			$client->email = $this->input->post('email');
			$client->agreement_status = $this->input->post('agreement_status');
			$client->insurance_status = $this->input->post('insurance');
			$client->category = $this->input->post('category');
			
			$this->client_model->update_client_info($client);
			
			$data['message'] =  "The client " . $client->agency . " has been updated!";
			$data['clients'] = $this->client_model->display_all_clients();
			$data['client'] = $client;

			$this->load->view('template', $data); 
		}
	}


	/*
	 * delete clients from database
	 * TO DO: delete all the connected users as well
	 */
	function delete_client(){
		$this->load->model('client_model');
		$this->load->model('user_model');

		$data['title'] = 'Storefront Calendar';
		$data['main'] = 'account/edit_client';
		$data['scripts'] = 'account/scripts';
		$data['styles'] = 'account/styles';
		


		$current_user = $this->session->userdata('user'); 
		$client_id = $this->input->post('id');
		$client = $this->client_model->get_from_id($client_id);

		if ($current_user->id == $client_id) {
			$data['clients'] = $this->client_model->display_all_clients();
			$data['message'] = "You cannot delete yourself!";
			$data['client'] = $client;
			$this->load->view('template', $data); 
		}
		else {
			$this->client_model->delete_client($client_id);
			$data['clients'] = $this->client_model->display_all_clients();
			$data['message'] = "The client " . $client->agency . " has been deleted!";
			$data['client'] = new Client();
			$this->load->view('template', $data); 
		}
	}
}

/* End of file account.php */
/* Location: ./application/controllers/account.php */
