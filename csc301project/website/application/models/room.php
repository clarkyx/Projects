<?php

class Room
{
	// Class members
	public $id;         // Unique room-id
	public $name;       // Room name, eg. 'Office 12' or 'BA 1190'
	public $capacity;   // Capacity of the room

	/*
	 * Get a string that describes this room's attributes (for developer use)
	 */
	public function stat() {
		return "Room #"    . $this->id 
			. ", Named '" . $this->name
			. "', Max. "  . $this->capacity;
	}
}

/* End of file room.php */
/* Location: ./application/models/room.php */
