<?php

/*
 * The phone number will be in the format x{11,} (11+ numbers). Have utility 
 * functions that can format to
 *   +1 (800) 416 5555
 *   +1 (800) 416-5555
 *
 * TODO: format phone function, format address function, etc...
 */
class Client
{
        public $id;
	public $agency;
	public $program;
        public $category;
	public $manager;
	public $manager_position;
	public $facilitator;
	public $facilitator_position;
        public $address;
	public $phone;
	public $fax;
	public $email;
	public $agreement_status;
	public $insurance_status;


        // Encrypt a clear-text password by hashing it with SHA-512 and a salt
        public function encrypt_password($password) {
                $this->salt = mt_rand();
                $this->password = hash('sha512', $this->salt . $password);
        }


        // Initializes the password to a random value
        public function init() {
                $password = mt_rand();
                $this->encrypt_password($password);
                return $password;
        }

        // Check to see if a given clear-text password matches this user's password
        public function compare_password($password) {
                if ($this->password == hash('sha512', $this->salt . $password)) {
                        return true;
                }
                return false;
        }
}

/* End of file client.php */
/* Location: ./application/models/client.php */