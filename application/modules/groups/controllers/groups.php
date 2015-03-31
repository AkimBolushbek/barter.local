<?php

class Groups extends MX_Controller {

    private $module = 'groups';
    private $module_name = 'Группы пользователей';

    public function __construct() {
        parent::__construct();
        $this->load->model('groups_model');
        $this->model = $this->groups_model;
    }

    public function index() {
        $this->load->helper('url');
        if (!$this->session->userdata('logged')) {
            redirect('admin/login');
        } else {
            redirect('admin/main');
        }
    }

    public function view($for_front = false, $url = false) {
        $data['module_name'] = $this->module_name;
        $data['module'] = $this->module;

        if (!$for_front) {
                $data['entries'] = $this->groups_model->get();
            $this->load->view($this->module, $data);
        }
    }

    public function edit($id = null) {
        global $object;
        $object = 'group';//blog
        $data['title'] = 'Административная панель';
        $entry = $this->model->get_group($id);
        $data['entry'] = $entry;
        $data['module_name'] = $this->module_name;
        $data['module'] = $this->module;

        if ($this->input->post('do') == $this->module . 'Edit') {

            $this->form_validation->set_rules('name', 'email', 'required');
            $this->form_validation->set_rules('description', 'description', 'required');

            $this->form_validation->set_error_delimiters('<span class="label label-danger">', '</span>');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('edit', $data);
            }
            else{
                $this->groups_model->update($id);
                $arr = array(
                    'error' => '<div class="alert alert-success" role="alert"><strong>Успех! </strong>Запись была успешно обновлена!</div>'
                );
                $this->session->set_userdata($arr);
                redirect('admin/' . $this->module . '/edit/' . $entry['id']);
            }
        }
        else {

            $this->load->view('edit', $data);
        }
    }

    public function add()
    {
        global $object;
        $object = 'groups';
        $data['title'] = 'Административная панель';
        $data['module_name'] = $this->module_name;
        $data['module'] = $this->module;

        if ($this->input->post('do') == $this->module . 'Add') {
            $this->form_validation->set_rules('name', 'Название', 'required|trim|xss_clean');
            $this->form_validation->set_rules('description', 'Описание', 'trim|xss_clean');
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('add', $data);
            }
            else {
                $arr = array(
                    'error' => '<div class="alert alert-success" role="alert"><strong>Успех! </strong>Запись была успешно добавлена!</div>'
                );
                $this->session->set_userdata($arr);
                $insert_id = $this->groups_model->set();
                redirect('admin/' . $this->module . '/edit/' . $insert_id);
            }
        }
        else
        {
            $this->load->view('add', $data);
        }
    }

    public function delete($id) {
        $this->groups_model->delete($id);
        redirect('admin/' . $this->module);
    }


}
