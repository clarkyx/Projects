<?php
/*
 * TODO: Add validation for the email and ensure that the email is valid.
 * TODO: Add a new form for adding a client.(DONE)
 * TODO: Add a new form for editing a client (should load the old values and
 *       then allow changing the values and update the database after updating). It
 *       should also validate that all the values are valid. (ALMOST)
 *
 */

class Space extends CI_Controller
{
	function __construct() {
		// Call the Controller constructor
		parent::__construct();
		$this->load->library('session');
	}


	function form_room_information(){

		$this->load->model("room_model");

		$data['title'] = 'Storefront Calendar';
		$data['main'] = 'room/view_rooms';
		$data['styles'] = 'room/styles';



		$this->load->view('template', $data);
	}

	function change_room(){

		$id = $this->input->post("choosen_room");
		$this->load->model("room_model");

		$room = $this->room_model->getFromId($id);;

		$data['title'] = 'Storefront Calendar';
		$data['main'] = 'room/show_rooms';
		$data['selectedRoom'] = $room;
		$data['rooms'] = $this->room_model->displayAllRooms();
		$data['styles'] = 'account/styles';


		$this->load->view('template', $data);

	}

	function room_info($id){
		$this->load->model("room_model");
		$room = $this->room_model->getFromId($id);
		$str = "<h1>$room->name</h1>" . "<br>" . "$room->description" . "<br>" . "<br><h4>$room->notes</h4>";
		//$str = "This is nonsense!!";
		echo $str;
		//return $str;
	}

}