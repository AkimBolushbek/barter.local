<?php

class Users_model extends CI_Model {

    private $table_name = 'users';
    private $images_table = 'users_images';
    private $redirect_url = 'users';

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
        } else {
            if ($id) {
                $query = $this->db->get_where($this->table_name, array('id' => $id, 'active' => 'on'));

                return $query->row_array();
            }
            $this->db->order_by('order', 'desc');
            $this->db->order_by('date', 'desc');
            $query = $this->db->get_where($this->table_name, array('active' => 'on'));
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

    public function set($image) {
        date_default_timezone_set('Asia/Bishkek');
        if ($this->input->post('date')) {
            $date = date('Y-m-d H:i:s', strtotime($this->input->post('date')));
        } else {
            $date = date('Y-m-d H:i:s', time());
        }
        $data = array(
            'name' => $this->input->post('name'),
            'url' => $this->input->post('url'),
            'title' => $this->input->post('title'),
            'desc' => $this->input->post('desc'),
            'keyw' => $this->input->post('keyw'),
            'text' => $this->input->post('text'),
            'date' => $date,
            'active' => $this->input->post('active'),
            'image' => $image
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
                'phone' => $this->input->post('phone')
            );
            $this->db->where('id', $id);
            $this->db->update($this->table_name, $data);
            $this->db->where('id', $id);
            $this->db->update($this->table_name, $data);
    }

}
