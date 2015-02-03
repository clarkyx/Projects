<?php
class Main extends CI_Controller
{
    
    function __construct()
    {
        // Call the Controller constructor
        parent::__construct();
    }
    
    function index()
    {
		// Set highlighted tab
        $data['highlight'] = 'booking';
        $data['main']      = 'main/index';
		// Load view
        $this->load->view('template', $data);
    }
    
    function matchingFlights()
    {
		// Set highlighted tab
        $data['highlight'] = 'booking';
		// Obtain user inputs
        $departureDate     = $this->input->post('departure-date');
        $departureCampus   = $this->input->post('departure-campus');
		// Load library
        $this->load->library('table');
        $this->load->model('flight_model');
        
		// Find matching flights with user input
        $flights = $this->flight_model->getMatchingFlights($departureCampus, $departureDate);
        if ($flights->num_rows() > 0) {
            
            $table = array();
            
			// First add table headers to the array
            $table[] = array(
                'From',
                'To',
                'Time',
                'Date',
                'Available',
                '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
            );
            
			// Next add each flight data to the array
            foreach ($flights->result() as $row) {
                $bookButton = 'Unavailable';
                if ($row->available > 0) {
                    $bookButton = '<button type="button" onclick="book(' . $row->id . ')" style="width:100%;">Book</button>';
                }
                $table[] = array(
                    $row->from,
                    $row->to,
                    $row->time,
                    $row->date,
                    $row->available,
                    $bookButton
                );
            }
			// Allow view to access flight data
            $data['flights'] = $table;
        }
		// Show flight data
        $data['main'] = 'main/matchingFlights';
        $this->load->view('template', $data);
    }
    
    function bookSeat()
    {
		// Set hightlighted tab
        $data['highlight'] = 'booking';
		// Obtain user inputs
        $get = $this->uri->uri_to_assoc();
		// Load library
        $this->load->library('table');
        $this->load->model('flight_model');
        
		// Obtain available seat information
        $flights = $this->flight_model->getSeats($get['id']);
		// Initial mark all seats as available
        $seat1   = true;
        $seat2   = true;
        $seat3   = true;
        
		// If found any rows
        if ($flights->num_rows() > 0) {
			// If the seat is reserved set seat status as false
            foreach ($flights->result() as $row) {
                if ($row->seat == '1') {
                    $seat1 = false;
                } else if ($row->seat == '2') {
                    $seat2 = false;
                } else if ($row->seat == '3') {
                    $seat3 = false;
                }
            }
        }
		// Allow view to access available seat information
        $data['seats']  = array(
            $seat1,
            $seat2,
            $seat3
        );
        $data['flight'] = $get['id'];
        $data['main']   = 'main/bookSeat';
        $this->load->view('template', $data);
    }
    
    function payment()
    {
		// Set highlighted tab
        $data['highlight'] = 'booking';
		// Obtain user inputs
        $data['flight']    = $this->input->post('flight');
        $data['seat']      = $this->input->post('seat');
        $data['main']      = 'main/payment';
		// Show payment form
        $this->load->view('template', $data);
    }
    
    function summary()
    {
		// Set hightlighted tab
        $data['highlight'] = 'booking';
		// Add payment information
        $data['flight']    = $this->input->post('flight');
        $data['seat']      = $this->input->post('seat');
        $data['first']     = $this->input->post('first-name');
        $data['last']      = $this->input->post('last-name');
        $data['cno']       = $this->input->post('credit-card-number');
        $data['edate']     = $this->input->post('expiration-date');
        
		// Save payment information
        $this->load->model('flight_model');
        $this->flight_model->savePayment($data['first'], $data['last'], $data['cno'], $data['edate'], $data['flight'], $data['seat']);
        
        $data['main'] = 'main/summary';
        $this->load->view('template', $data);
    }
}
