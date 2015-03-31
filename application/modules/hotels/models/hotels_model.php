<?php

class Hotels_model extends CI_Model {

    private $table_name = 'hotels';
    private $images_table = 'hotels_images';
    private $redirect_url = 'hotels';

    public function __construct() {
        $this->load->database();
    }

    public function order($id, $direction) {
        $query = $this->db->get_where($this->table_name, array('id' => $id));
        $category = $query->row_array();
        $order = $category['order'];
        if ($direction == 'up') {
            $order++;
        } elseif ($direction == 'down') {
            $order--;
        }
        $data = array(
            'order' => $order,
        );

        $this->db->where('id', $id);
        $this->db->update($this->table_name, $data);
        redirect('admin/' . $this->redirect_url);
    }

    public function get($id = null, $for_front = false) {
        if (!$for_front) {
            if ($id) {
                $query = $this->db->get_where($this->table_name, array('id' => $id));

                return $query->row_array();
            }
            $this->db->order_by('order', 'desc');
            $query = $this->db->get($this->table_name);
            if (count($query->result_array()) > 0) {
                return $query->result_array();
            } else {
                return false;
            }
        } else {
            if ($id) {
               // $query = $this->db->get_where($this->table_name, array('id' => $id, 'active' => 'on'));
                $this->db->select('*');
                $this->db->from($this->table_name);
                $this->db->where('id', $id);
                $this->db->where('active', 'on');
                $query = $this->db->get();
                $data =  $query->row_array();

                $this->db->select('sh.*, s.text,s.image');
                $this->db->from('services_hotel as sh');
                $this->db->where('hotel_id', $id);
                $this->db->join('services as s', 's.id=sh.service_id');
                $query = $this->db->get();
                $data['services'] = $query->result_array();
                foreach ($data['services'] as &$item) {
                    $item['elems'] = explode(',',  $item['elems']);
                }
                return $data;
            }
            $this->db->order_by('order', 'desc');
            $query = $this->db->get_where($this->table_name, array('active' => 'on'));
            if (count($query->result_array()) > 0) {
                return $query->result_array();
            } else {
                return false;
            }
        }
    }

    public function images_insert($image, $id) {
        $data = array(
            'image' => $image,
            'order' => 0,
            'hotel_id' => $id
        );

        return $this->db->insert($this->images_table, $data);
    }

    public function get_images($id) {
        $query = $this->db->get_where($this->images_table, array('hotel_id' => $id));
        return $query->result_array();
    }

    public function delete_images($id) {
        $this->db->delete($this->images_table, array('hotel_id' => $id));
    }

    public function get_image($id) {
        $query = $this->db->get_where($this->images_table, array('id' => $id));
        return $query->row_array();
    }

    public function delete_image($id) {
        $this->db->delete($this->images_table, array('id' => $id));
    }

    public function set($image) {

        $data = array(
            'name' => $this->input->post('name'),
            'status' => $this->input->post('status'),
            'site' => $this->input->post('site'),
            'phone' => $this->input->post('phone'),
            'fax' => $this->input->post('fax'),
            'email' => $this->input->post('email'),
            'rooms' => $this->input->post('rooms'),
            'distoport' => $this->input->post('distoport'),
            'beachl' => $this->input->post('beachl'),
            'image' => $image,
            'text' => $this->input->post('text'),
            'coords' => 0,
            'active' => $this->input->post('active')
        );

        $this->db->insert($this->table_name, $data);
        return $this->db->insert_id();
    }

    public function delete($id) {
        $this->db->delete($this->table_name, array('id' => $id));
    }

    public function update($id, $image = null) {
        if (!$image) {
            $data = array(
                'name' => $this->input->post('name'),
                'status' => $this->input->post('status'),
                'site' => $this->input->post('site'),
                'phone' => $this->input->post('phone'),
                'fax' => $this->input->post('fax'),
                'email' => $this->input->post('email'),
                'rooms' => $this->input->post('rooms'),
                'distoport' => $this->input->post('distoport'),
                'beachl' => $this->input->post('beachl'),
                'text' => $this->input->post('text'),
                'coords' => 0,
                'active' => $this->input->post('active')
            );
            $this->db->where('id', $id);
            $this->db->update($this->table_name, $data);
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'status' => $this->input->post('status'),
                'site' => $this->input->post('site'),
                'phone' => $this->input->post('phone'),
                'fax' => $this->input->post('fax'),
                'email' => $this->input->post('email'),
                'rooms' => $this->input->post('rooms'),
                'distoport' => $this->input->post('distoport'),
                'beachl' => $this->input->post('beachl'),
                'image' => $image,
                'text' => $this->input->post('text'),
                'coords' => 0,
                'active' => $this->input->post('active')
            );

            $this->db->where('id', $id);
            $this->db->update($this->table_name, $data);
        }
    }

    public function get_services($hotel_id){

        $this->db->select('*');
        $this->db->from('services');
        $services = $this->db->get();
        $services = $services->result_array();
        foreach ($services as &$item) {
            $this->db->select('elems');
            $this->db->from('services_hotel');
            $this->db->where('hotel_id', $hotel_id);
            $this->db->where('service_id', $item['id']);
            $elems = $this->db->get();
            $elems = $elems->result_array();
            if(!empty($elems)){
             $item['elems'] = $elems[0]['elems'];
             $item['checked'] = TRUE;
            }
        }
        return $services;
    }

    public function add_services($data){
        $this->db->select('*');
        $this->db->from('services_hotel');
        $this->db->where('hotel_id', $data['hotel_id']);
        $this->db->where('service_id', $data['service_id']);
        $query = $this->db->get();
        $query = $query->result_array();
        if(empty($query)){
             $this->db->insert('services_hotel', $data);
        }
       
    }
    public function delete_services($hotel_id, $service_id){
        $this->db->query("DELETE FROM `services_hotel` WHERE `service_id` = $service_id AND `hotel_id` = $hotel_id");
    }

    public function get_hotel_service($hotel_id,$service_id){
        $this->db->select('*');
        $this->db->from('services_hotel');
        $this->db->where('hotel_id', $hotel_id);
        $this->db->where('service_id', $service_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function update_tags($hotel_id, $service_id, $tags){
        $data = array('elems' => $tags);
        $this->db->where('hotel_id', $hotel_id);
        $this->db->where('service_id', $service_id);
        $this->db->update('services_hotel', $data);
    }

}
