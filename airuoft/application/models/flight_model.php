<?php
class Flight_model extends CI_Model {

	function get_flights()
	{
		// Find all flights
		$query = $this->db->query("select c1.name as 'from', c2.name as 'to', t.time, f.date, f.available
								from flight f, timetable t, campus c1, campus c2
								where f.timetable_id = t.id and
								      t.leavingfrom = c1.id and
								      t.goingto = c2.id;");
		return $query;	
	}  
	
	function getMatchingFlights($departureCampus, $departureDate) {
		// Find all available flights
		$query = $this->db->query("select c1.name as 'from', c2.name as 'to', t.time, f.date, f.available, f.id
								from flight f, timetable t, campus c1, campus c2
								where f.timetable_id = t.id and
								      t.leavingfrom = c1.id and
								      t.goingto = c2.id and c1.id = '" . $departureCampus . "' and f.date ='" . $departureDate . "';");
		return $query;
	}
	
	function getSeats($flightId) {
		// Find available seats
		$query = $this->db->query("select t.seat
								from ticket t
								where t.flight_id='" . $flightId . "';");
		return $query;
	}

	function populate() {
		// Populate database
		for ($i=1; $i < 15; $i++) {
			for ($j=1; $j < 9; $j++) {
				$this->db->query("insert into flight (timetable_id, date, available) 
						          values ($j,adddate(current_date(), interval $i day),3)");
			}
		}
		
		
	}
	
	function savePayment($first, $last, $ccno, $edate, $flight, $seat) {
		// Save payment information
		$this->db->query("insert into ticket (first, last, creditcardnumber, creditcardexpiration, flight_id, seat) values ('{$first}', '{$last}', '{$ccno}', '{$edate}', '{$flight}', '{$seat}');");
		$this->db->query("update flight set available = available -1 where id = '{$flight}'");
	}
	
	function getTickets() {
		// Get all ticktes
		$query = $this->db->query("select t.id as 'id', f.date as 'flight_date', t.seat, t.first, t.last, t.creditcardnumber, t.creditcardexpiration from flight f, ticket t
								where t.flight_id = f.id;");
		return $query;	
	}

	function delete() {
		// Delete flight table
		$this->db->query("delete from flight");
	}
	
	
}