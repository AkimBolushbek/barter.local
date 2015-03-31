<?php

class Tours_model extends CI_Model {

    private $table_name = 'tours';
    private $primary_key = 'id';
    private $images_table = 'tours_images';
    private $redirect_url = 'tours';

    public function __construct() {
        $this->load->database();
    }

    public function order($id, $direction) {
        $query = $this->db->get_where($this->table_name, array($this->primary_key => $id));
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

        $this->db->where($this->primary_key, $id);
        $this->db->update($this->table_name, $data);
        redirect('admin/' . $this->redirect_url);
    }

    public function get($id = null, $for_front = false) {
        if (!$for_front) {
            if ($id) {
                $query = $this->db->get_where($this->table_name, array($this->primary_key => $id));

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
                $query = $this->db->get_where($this->table_name, array($this->primary_key => $id, 'active' => 'on'));

                return $query->row_array();
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

    public function get_by_url($url) {
        $query = $this->db->get_where($this->table_name, array('active' => 'on', 'url' => $url));
        return $query->row_array();
    }

    public function images_insert($image, $id) {
        $data = array(
            'image' => $image,
            'order' => 0,
            'tour_id' => $id
        );

        return $this->db->insert($this->images_table, $data);
    }

    public function get_images($id) {
        $query = $this->db->get_where($this->images_table, array('tour_id' => $id));
        return $query->result_array();
    }

    public function delete_images($id) {
        $this->db->delete($this->images_table, array('tour_id' => $id));
    }

    public function get_image($id) {
        $query = $this->db->get_where($this->images_table, array($this->primary_key => $id));
        return $query->row_array();
    }

    public function delete_image($id) {
        $this->db->delete($this->images_table, array($this->primary_key => $id));
    }

    public function set($image) {

        $data = array(
            'name' => $this->input->post('name'),
            'flightout' => $this->input->post('flightout'),
            'priceperone' => $this->input->post('priceperone'),
            'country' => $this->input->post('country'),
            'url' => $this->input->post('url'),
            'price' => $this->input->post('price'),
            'datefrom' => date('Y-m-d h:i:s', strtotime($this->input->post('datefrom'))),
            'duration' => $this->input->post('duration'),
            'dateto' => date('Y-m-d h:i:s', strtotime($this->input->post('dateto'))),
            'placement' => $this->input->post('placement'),
            'feed' => $this->input->post('feed'),
            'room' => $this->input->post('room'),
            'outflight' => $this->input->post('outflight'),
            'backflight' => $this->input->post('backflight'),
            'priceinc' => $this->input->post('priceinc'),
            'label' => $this->input->post('label'),
            'valid' => $this->input->post('valid'),
            'title' => $this->input->post('title'),
            'metatitle' => $this->input->post('metatitle'),
            'keyw' => $this->input->post('keyw'),
            'desc' => $this->input->post('desc'),
            'hotel_id' => $this->input->post('hotel'),
            'type' => $this->input->post('type'),
            'active' => $this->input->post('active'),
            'image' => $image
        );

        $this->db->insert($this->table_name, $data);
        return $this->db->insert_id();
    }

    public function delete($id) {
        if (!$this->session->userdata('logged')) {
            redirect('admin/login');
        }
        $this->db->delete($this->table_name, array($this->primary_key => $id));
    }

    public function update($id, $image = null) {
        if (!$image) {
            $data = array(
                'name' => $this->input->post('name'),
                'url' => $this->input->post('url'),
                'flightout' => $this->input->post('flightout'),
                'priceperone' => $this->input->post('priceperone'),
                'country' => $this->input->post('country'),
                'price' => $this->input->post('price'),
                'datefrom' => date('Y-m-d h:i:s', strtotime($this->input->post('datefrom'))),
                'duration' => $this->input->post('duration'),
                'dateto' => date('Y-m-d h:i:s', strtotime($this->input->post('dateto'))),
                'placement' => $this->input->post('placement'),
                'feed' => $this->input->post('feed'),
                'room' => $this->input->post('room'),
                'outflight' => $this->input->post('outflight'),
                'backflight' => $this->input->post('backflight'),
                'priceinc' => $this->input->post('priceinc'),
                'label' => $this->input->post('label'),
                'valid' => $this->input->post('valid'),
                'title' => $this->input->post('title'),
                'metatitle' => $this->input->post('metatitle'),
                'keyw' => $this->input->post('keyw'),
                'desc' => $this->input->post('desc'),
                'hotel_id' => $this->input->post('hotel'),
                'type' => $this->input->post('type'),
                'active' => $this->input->post('active')
            );
            $this->db->where($this->primary_key, $id);
            $this->db->update($this->table_name, $data);
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'url' => $this->input->post('url'),
                'flightout' => $this->input->post('flightout'),
                'priceperone' => $this->input->post('priceperone'),
                'country' => $this->input->post('country'),
                'price' => $this->input->post('price'),
                'datefrom' => date('Y-m-d h:i:s', strtotime($this->input->post('datefrom'))),
                'duration' => $this->input->post('duration'),
                'dateto' => date('Y-m-d h:i:s', strtotime($this->input->post('dateto'))),
                'placement' => $this->input->post('placement'),
                'feed' => $this->input->post('feed'),
                'room' => $this->input->post('room'),
                'outflight' => $this->input->post('outflight'),
                'backflight' => $this->input->post('backflight'),
                'priceinc' => $this->input->post('priceinc'),
                'label' => $this->input->post('label'),
                'valid' => $this->input->post('valid'),
                'title' => $this->input->post('title'),
                'metatitle' => $this->input->post('metatitle'),
                'keyw' => $this->input->post('keyw'),
                'desc' => $this->input->post('desc'),
                'active' => $this->input->post('active'),
                'hotel_id' => $this->input->post('hotel'),
                'type' => $this->input->post('type'),
                'image' => $image
            );

            $this->db->where($this->primary_key, $id);
            $this->db->update($this->table_name, $data);
        }
    }

}
