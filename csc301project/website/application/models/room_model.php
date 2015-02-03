<?php
class Room_model extends CI_Model {
    
    // Get a room's record from the 'room' table using its name as a key
    function get($name) {
        $this->db->where('name', $name);
        $query = $this->db->get('room');
        if ($query && $query->num_rows() > 0)
            return $query->row(0,'Room');
        else
            return null;
    }
    
    // Get a room's record from the 'room' table using its id as a key
    function getFromId($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('room');
        if ($query && $query->num_rows() > 0)
            return $query->row(0,'Room');
        else
            return null;
    }
    
    // Get an array of Rooms that meet the given minimum capacity
    // Results are sorted by ascending (0, 1, ...) capacity
    // Returns null if there are no matching rooms
    function getByMinCapacity($min_capacity) {
        $this->db->where('capacity >=', $min_capacity);
        $this->db->order_by('capacity', 'asc');
        $query = $this->db->get('room');
        if ($query && $query->num_rows() > 0)
            return $query->result('Room');
        else
            return null;
    }
    
    // Get an array of Rooms that meet the given maximum capacity
    // Results are sorted in descending (9, 8, ...) capacity
    // Returns null if there are no matching rooms
    function getByMaxCapacity($max_capacity) {
        $this->db->where('capacity <=', $max_capacity);
        $this->db->order_by('capacity', 'desc');
        $query = $this->db->get('room');
        if ($query && $query->num_rows() > 0)
            return $query->result('Room');
        else
            return null;
    }
    
    // Get an array of Rooms that meet the given minimum and maximum capacity
    // Results are sorted in ascending (0, 1, ...) capacity
    // Returns null if there are no matching rooms
    function getByCapacity($min_capacity, $max_capacity) {
        $this->db->where('capacity >=', $min_capacity);
        $this->db->where('capacity <=', $max_capacity);
        $this->db->order_by('capacity', 'asc');
        $query = $this->db->get('room');
        if ($query && $query->num_rows() > 0)
            return $query->result('Room');
        else
            return null;
    }
    
	/*
	 * Get all the rooms and return an array of id => name
	 */
	function get_rooms() {
		$rooms = array();
		$query = $this->db->query("SELECT * FROM room;");

		foreach ($query->result('Room') as $row) {
			$rooms[$row->id] = $row->name;
		}

		return $rooms;
	}

    // Insert a new room into the 'room' table
    function insert($room) {
        return $this->db->insert('room',$room);
    }
    
    // Update the capacity of an existing room
    function updateCapacity($room) {
        $this->db->where('id', $room->id);
        return $this->db->update('room', array('capacity'=>$room->capacity));
    }
    
    // Exclusive lookup of a room by name
    function getExclusive($name) {
        $sql = "select * from room where name=? for update";
        $query = $this->db->query($sql, array($name));
        if ($query && $query->num_rows() > 0)
            return $query->row(0,'Room');
        else
            return null;
    }
    
    // Show all rooms
    function displayAllRooms() {
        $query = $this->db->select('*')->from('room')->get();
        return $query->result();
    }
    
    // Delete a room based on name
    function deleteUser($name){
        $this->db->where('name', $name);
        $this->db->delete('room');
    }
}

/* End of file room_model.php */
/* Location: ./application/models/room_model.php */
