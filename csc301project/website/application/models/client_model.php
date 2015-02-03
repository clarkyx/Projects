<?php
class Client_model extends CI_Model
{
	function get_from_name($name) {
		$this->db->where('agency', $name);
		$query = $this->db->get('client');
		if ($query && $query->num_rows() > 0)
			return $query->row(0, 'Client');
		else
			return null;
	}

	function get_from_id($id) {
		$this->db->where('id', $id);
		$query = $this->db->get('client');
		if ($query && $query->num_rows() > 0)
			return $query->row(0, 'Client');
		else
			return null;
	}
	
    function gett_from_email($email) {
        $this->db->where('email',$email);
        $query = $this->db->get('client');
        if ($query && $query->num_rows() > 0)
            return $query->row(0,'Client');
        else
            return null;
    }

	function get_clients() {
		$clients = array();
		$query = $this->db->query("SELECT * FROM client;");

		foreach ($query->result('Client') as $row) {
			$clients[$row->id] = $row->agency;
		}

		return $clients;
	}

	function insert($client) {
		return $this->db->insert('client', $client);
	}

	function update_address($client) {
		$this->db->where('id', $client->id);
		return $this->db->update('client', array('address' => $client->address));
	}
        
        function update_client_info($client){
            $this->db->where('id', $client->id);
            return $this->db->update('client', 
                    array('address' => $client->address,
                        'program' => $client->program,
                        'category' => $client->category,
                        'manager' => $client->manager,
                        'manager_position' => $client->manager_position,
                        'facilitator' => $client->facilitator,
                        'facilitator_position' => $client->facilitator_position,
                        'phone' => $client->phone,
                        'fax' => $client->fax,
                        'email'=> $client->email,
                        'agreement_status' => $client->agreement_status,
                        'insurance_status' => $client->insurance_status));
           

        }

	function get_exclusive($name) {
		$sql = "SELECT * FROM client WHERE login=? FOR UPDATE";
		$query = $this->db->query($sql, array($name));
		if ($query && $query->num_rows() > 0)
			return $query->row(0, 'Client');
		else
			return null;
	}
        
    //Shows all clients
    function display_all_clients() {
        $query = $this->db->select('*')->from('client')->get();
        return $query->result();
    }
    
    //TO DO: delete users properly
    function delete_client($id){
    	$this->db->delete('user', array('clientid' => $id));
        $this->db->delete('client', array('id' => $id));
        
    }
}
?>
