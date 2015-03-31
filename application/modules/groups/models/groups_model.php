<?php

class Groups_model extends CI_Model {


    private $table_name = 'groups';
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
                $query = $this->db->get($this->table_name);

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
    //get group by ID
    public function get_group($id = null) {
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



    //insert database new group
    public function set() {
        $data = array(
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),

        );
        $this->db->insert($this->table_name, $data);
        return $this->db->insert_id();
    }

    //delete groups
    public function delete($id) {
        $this->db->delete($this->table_name, array('id' => $id));
    }

    //update groups
    public function update($id, $image = null) {
        if (!$image) {
            $data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
            );
            $this->db->where('id', $id);
            $this->db->update($this->table_name, $data);
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
            );

            $this->db->where('id', $id);
            $this->db->update($this->table_name, $data);
        }
    }

}
