<?php
class Admin extends CI_Controller
{
    function __construct()
    {
        // Call the Controller constructor
        parent::__construct();
    }
    
    function index()
    {
		// Main flight booking page
		// Set highlighted tab
        $data['highlight'] = 'admin';
        $data['main']      = 'admin/index';
        $this->load->view('template', $data);
    }
    
    function showFlights()
    {
        $data['highlight'] = 'admin';
        // First we load the library and the model
        $this->load->library('table');
        $this->load->model('flight_model');
        
        //Then we call our model's get_flights function
        $flights = $this->flight_model->get_flights();
        
        //If it returns some results we continue
        if ($flights->num_rows() > 0) {
            
            //Prepare the array that will contain the data
            $table = array();
            
            $table[] = array(
                'From',
                'To',
                'Time',
                'Date',
                'Available'
            );
            
            foreach ($flights->result() as $row) {
                //This time we are not only adding a new link, but, in the third parameter of the anchor function we are adding an onclick behaviour to ask the user if he/she really wants to delete the record.
                $table[] = array(
                    $row->from,
                    $row->to,
                    $row->time,
                    $row->date,
                    $row->available
                );
            }
            //Next step is to place our created array into a new array variable, one that we are sending to the view.
            $data['flights'] = $table;
        }
        
        //Now we are prepared to call the view, passing all the necessary variables inside the $data array
        $data['main'] = 'admin/flights';
        $this->load->view('template', $data);
    }
    
    function populate()
    {
        $this->load->model('flight_model');
        $this->flight_model->populate();
        
        //Then we redirect to the index page again
        redirect('', 'refresh');
        
    }
    
    function delete()
    {
        $this->load->model('flight_model');
        $this->flight_model->delete();
        
        //Then we redirect to the index page again
        redirect('', 'refresh');
        
    }
    
    function showTickets()
    {
		// Set highlighted tab
        $data['highlight'] = 'admin';
		//First we load the library and the model
        $this->load->library('table');
        $this->load->model('flight_model');
        
        $tickets = $this->flight_model->getTickets();
        //If it returns some results we continue
        if ($tickets->num_rows() > 0) {
            
            $table = array();
            
			// First add table headers to the array
            $table[] = array(
                'Ticket ID',
                'Flight date',
                'Seat no.',
                'First name',
                'Last name',
                'Credit card no.',
                'Expiration date'
            );
            
			// Add each ticket to the array
            foreach ($tickets->result() as $row) {
                $table[] = array(
                    $row->id,
                    $row->flight_date,
                    $row->seat,
                    $row->first,
                    $row->last,
                    $row->creditcardnumber,
                    $row->creditcardexpiration
                );
            }
            $data['tickets'] = $table;
        }
        
        // Display all ticketes
        $data['main'] = 'admin/showTickets';
        $this->load->view('template', $data);
    }
    
}
