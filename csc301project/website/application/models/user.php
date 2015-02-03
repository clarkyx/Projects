<?php

class User
{
        // User types
        const ADMIN = 1;
        const CLIENT = 2;
        const FRONTDESK = 3;
        const DEV = 4;


        // Class members
        public $id;         // Unique user-id
        public $clientid;   // If this is a client, this is their client-id; otherwise, 0.
        // (multiple users may have the same client-id)
        public $login;      // Unique username used to login to the website
        public $first;      // First name
        public $last;       // Last name
        public $password;   // Hashed password
        public $salt;       // Password salt
        public $email;      // Email address
        public $usertype;  // Type of user; administrator by default


        /*
         * Initializes the password to a random value.
         */
        public function init() {
                $password = mt_rand();
                $this->encrypt_password($password);
                return $password;
        }

        /*
         * Encrypt a clear-text password by hashing it with SHA-512 and a salt.
         */
        public function encrypt_password($password) {
                $this->salt = mt_rand();
                $this->password = hash('sha512', $this->salt . $password);
        }


        // Check to see if a given clear-text password matches this user's password
        public function compare_password($password) {
                if ($this->password == hash('sha512', $this->salt . $password)) {
                        return true;
                }

                return false;
        }

        // Get the full name of this user
        public function get_name() {
                return $this->first . " " . $this->last;
        }
}

/* End of file user.php */
/* Location: ./application/models/user.php */