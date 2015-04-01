<?php

class Users_model extends CI_Model {

    private $table_name = 'users';
    public function __construct() {
        $this->load->database();
    }


    public function get($id = null, $for_front = false) {
        if (!$for_front) {
            if ($id) {
                $query = $this->db->get_where($this->table_name, array('id' => $id));

                return $query->row_array();
            }
            $query = $this->db->get($this->table_name);
            if (count($query->result_array()) > 0) {
                return $query->result_array();
            } else {
                return false;
            }
        }
    }

    public function get_users($id = null) {
        if ($id) {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row_array();
        }
        $query = $this->db->get($this->table_name);
        if (count($query->result_array()) > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function set() {
        date_default_timezone_set('Asia/Bishkek');
        if ($this->input->post('date')) {
            $date = date('Y-m-d H:i:s', strtotime($this->input->post('date')));
        } else {
            $date = date('Y-m-d H:i:s', time());
        }
        $data = array(
            'username' => $this->input->post('username'),
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
            'company' => $this->input->post('company'),
            'group_id' => $this->input->post('group_id'),
            'created_on' => $date
        );



        $this->db->insert($this->table_name, $data);
        return $this->db->insert_id();
    }

    public function delete($id) {
        $this->db->delete($this->table_name, array('id' => $id));
    }

    public function update($id) {

            $data = array(
                'username' => $this->input->post('username'),
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'company' => $this->input->post('company'),
                'group_id' => $this->input->post('group_id'),
            );

            $this->db->where('id', $id);
            $this->db->update($this->table_name, $data);
            $this->db->where('id', $id);
            $this->db->update($this->table_name, $data);
    }

    public function login($identity, $password, $remember=FALSE)
    {


        //$this->trigger_events('pre_login');

        if (empty($identity) )//|| empty($password))
        {
            $this->set_error('login_unsuccessful');
            return FALSE;
        }

        $this->trigger_events('extra_where');

        $query = $this->db->select($this->identity_column . ', username, email, id, password, active, last_login')
            ->where($this->identity_column, $identity)
            ->limit(1)
            ->order_by('id', 'desc')
            ->get($this->tables['users']);

        if($this->is_time_locked_out($identity))
        {
            //Hash something anyway, just to take up time
            $this->hash_password($password);

          //  $this->trigger_events('post_login_unsuccessful');
            $this->set_error('login_timeout');

            return FALSE;
        }

        if ($query->num_rows() === 1)
        {
            $user = $query->row();

            $password = $this->hash_password_db($user->id, $password);

            if ($password === TRUE)
            {
                if ($user->active == 0)
                {
                    $this->trigger_events('post_login_unsuccessful');
                    $this->set_error('login_unsuccessful_not_active');

                    return FALSE;
                }

                $this->set_session($user);

                $this->update_last_login($user->id);

                $this->clear_login_attempts($identity);

                if ($remember && $this->config->item('remember_users', 'ion_auth'))
                {
                    $this->remember_user($user->id);
                }

                $this->trigger_events(array('post_login', 'post_login_successful'));
                $this->set_message('login_successful');

                return TRUE;
            }
        }

        //Hash something anyway, just to take up time
        $this->hash_password($password);

        $this->increase_login_attempts($identity);

        $this->trigger_events('post_login_unsuccessful');
        $this->set_error('login_unsuccessful');

        return FALSE;
    }



    public function register($username, $password, $email, $additional_data = array(), $groups = array())
    {
        $this->trigger_events('pre_register');

        $manual_activation = $this->config->item('manual_activation', 'ion_auth');

        if ($this->identity_column == 'email' && $this->email_check($email)) {
            $this->set_error('account_creation_duplicate_email');
            return FALSE;
        } elseif ($this->identity_column == 'username' && $this->username_check($username)) {
            $this->set_error('account_creation_duplicate_username');
            return FALSE;
        } elseif (!$this->config->item('default_group', 'ion_auth') && empty($groups)) {
            $this->set_error('account_creation_missing_default_group');
            return FALSE;
        }

        //check if the default set in config exists in database
        $query = $this->db->get_where($this->tables['groups'], array('name' => $this->config->item('default_group', 'ion_auth')), 1)->row();
        if (!isset($query->id) && empty($groups)) {
            $this->set_error('account_creation_invalid_default_group');
            return FALSE;
        }

        //capture default group details
        $default_group = $query;

        // If username is taken, use username1 or username2, etc.
        if ($this->identity_column != 'username') {
            $original_username = $username;
            for ($i = 0; $this->username_check($username); $i++) {
                if ($i > 0) {
                    $username = $original_username . $i;
                }
            }
        }

        // IP Address
        $ip_address = $this->_prepare_ip($this->input->ip_address());
        $salt = $this->store_salt ? $this->salt() : FALSE;
        $password = $this->hash_password($password, $salt);

        // Users table.
        $data = array(
            'username' => $username,
            'password' => $password,
            'email' => $email,
            'ip_address' => $ip_address,
            'created_on' => time(),
            'active' => ($manual_activation === false ? 1 : 0)
        );

        if ($this->store_salt) {
            $data['salt'] = $salt;
        }

        //filter out any data passed that doesnt have a matching column in the users table
        //and merge the set user data and the additional data
        $user_data = array_merge($this->_filter_data($this->tables['users'], $additional_data), $data);

        $this->trigger_events('extra_set');

        $this->db->insert($this->tables['users'], $user_data);

        $id = $this->db->insert_id();

        //add in groups array if it doesn't exits and stop adding into default group if default group ids are set
        if (isset($default_group->id) && empty($groups)) {
            $groups[] = $default_group->id;
        }

        if (!empty($groups)) {
            //add to groups
            foreach ($groups as $group) {
                $this->add_to_group($group, $id);
            }
        }

        $this->trigger_events('post_register');

        return (isset($id)) ? $id : FALSE;
    }


    public function set_hook($event, $name, $class, $method, $arguments)
    {
        $this->_ion_hooks->{$event}[$name] = new stdClass;
        $this->_ion_hooks->{$event}[$name]->class     = $class;
        $this->_ion_hooks->{$event}[$name]->method    = $method;
        $this->_ion_hooks->{$event}[$name]->arguments = $arguments;
    }
}
