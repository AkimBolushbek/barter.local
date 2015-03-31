<?php

class Users extends MX_Controller {

    private $module = 'users';
    private $module_name = 'Пользователи';

    public function __construct() {
        parent::__construct();
        $this->load->model('users_model');
        $this->model = $this->users_model;
    }

    public function index() {
        $this->load->helper('url');
    }


    public function login() {
        $this->load->helper('url');
        $this->load->view('front/login');

        $this->form_validation->set_rules('username', 'Логин', 'required');
        $this->form_validation->set_rules('password', 'Пароль', 'required');

        if ($this->form_validation->run() == true)
        {
            //check to see if the user is logging in
            //check for "remember me"
            $remember = (bool) $this->input->post('remember');


            if ($this->model->login($this->input->post('username'), $this->input->post('password'), $remember))
            {
                echo 'asfasf';

                $this->session->set_flashdata('message', $this->module->messages());
                redirect('/', 'welcome');
            }
            else
            {
                //if the login was un-successful
                //redirect them back to the login page
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('auth/login', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
            }
        }
        else
        {
            //the user is not logging in so display the login page
            //set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->data['identity'] = array('name' => 'identity',
                'id' => 'identity',
                'type' => 'text',
                'value' => $this->form_validation->set_value('identity'),
            );
            $this->data['password'] = array('name' => 'password',
                'id' => 'password',
                'type' => 'password',
            );

            //$this->_render_page('auth/login', $this->data);
        }
    }

    function create_user()
    {
        $this->data['title'] = "Create User";
/*
        if (!$this->module->logged_in() || !$this->module->is_admin())
        {
            redirect('auth', 'refresh');
        }*/

        $tables = $this->config->item('tables','ion_auth');

        //validate form input
        $this->form_validation->set_rules('username','User Name', 'required');
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'email', 'required|valid_email|is_unique['.$tables['users'].'.email]');
        $this->form_validation->set_rules('phone', 'email', 'required');
        $this->form_validation->set_rules('company', 'company', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[' . 3 . ']|max_length[' . 10 . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', 'Confirm', 'required');

        if ($this->form_validation->run() == true)
        {
            $username = strtolower('username');
            $email    = strtolower($this->input->post('email'));
            $password = $this->input->post('password');

            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name'  => $this->input->post('last_name'),
                'company'    => $this->input->post('company'),
                'phone'      => $this->input->post('phone'),
            );
        }
        if ($this->form_validation->run() == true && $this->module->register($username, $password, $email, $additional_data))
        {
            //check to see if we are creating the user
            //redirect them back to the admin page
            $this->session->set_flashdata('message', $this->module->messages());
            redirect("auth", 'refresh');
        }
        else
        {
            //display the create user form
            //set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->module->errors() ? $this->module->errors() : $this->session->flashdata('message')));

            $this->data['username'] = array(
                'name'  => 'username',
                'id'    => 'username',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('username'),
            );

            $this->data['first_name'] = array(
                'name'  => 'first_name',
                'id'    => 'first_name',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('first_name'),
            );
            $this->data['last_name'] = array(
                'name'  => 'last_name',
                'id'    => 'last_name',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('last_name'),
            );
            $this->data['email'] = array(
                'name'  => 'email',
                'id'    => 'email',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('email'),
            );
            $this->data['company'] = array(
                'name'  => 'company',
                'id'    => 'company',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('company'),
            );
            $this->data['phone'] = array(
                'name'  => 'phone',
                'id'    => 'phone',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('phone'),
            );
            $this->data['password'] = array(
                'name'  => 'password',
                'id'    => 'password',
                'type'  => 'password',
                'value' => $this->form_validation->set_value('password'),
            );
            $this->data['password_confirm'] = array(
                'name'  => 'password_confirm',
                'id'    => 'password_confirm',
                'type'  => 'password',
                'value' => $this->form_validation->set_value('password_confirm'),
            );

            $this->_render_page('users/create_user', $this->data);
        }
    }






    public function view($for_front = false, $url = false) {
        $data['module_name'] = $this->module_name;
        $data['module'] = $this->module;
        if (!$for_front) {
            if ($url) {
                $data['entries'] = $this->model->get_by_url($url);
            } else {
                $data['entries'] = $this->model->get();
                $this->load->view($this->module, $data);
            }
        } else {
            if ($url) {
                $data['entries'] = $this->model->get_by_url($url);
                $this->load->view('front/new', $data);
            } else {
                $data['entries'] = $this->model->get('', true);
                $this->load->view('front/' . $this->module, $data);
            }
        }
    }

    public function get_by_url($url) {
        return $this->model->get_by_url($url);
    }

    public function get3news_for_front() {
        return $this->model->get3news_for_front();
    }


    public function edit($id = null) {
        global $object;
        $object = 'user';//blog
        $data['title'] = 'Административная панель';
        $entry = $this->model->get_users($id);
        $data['entry'] = $entry;
        $data['module_name'] = $this->module_name;
        $data['module'] = $this->module;

        //echo $entry['username']; die();

        if ($this->input->post('do') == $this->module . 'Edit') {
            $this->form_validation->set_rules('email', 'email', 'required|e-mail');
            $this->form_validation->set_rules('first_name', 'First Name', '');
            $this->form_validation->set_rules('last_name', 'Last Name', '');
            $this->form_validation->set_rules('phone', 'Phone', '');

            $this->form_validation->set_error_delimiters('<span class="label label-danger">', '</span>');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('edit', $data);
            }
            else{
                $this->users_model->update($id);
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

    public function check_url($url) {
        if ($this->model->get_by_url($url)) {
            $this->form_validation->set_message('check_url', 'Такой ЧПУ уже занят!');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function add()
    {
        global $object;
        $object = 'blog';
        $data['title'] = 'Административная панель';
        $data['module_name'] = $this->module_name;
        $data['module'] = $this->module;
        if ($this->input->post('do') == $this->module . 'Add') {
            $this->form_validation->set_rules('username', 'Логин', 'required|trim|xss_clean');
            $this->form_validation->set_rules('firs_name', 'Имя', 'trim|xss_clean');
            $this->form_validation->set_rules('last_name', 'Фамилия', 'trim|xss_clean');
            $this->form_validation->set_rules('email', 'email', 'trim|xss_clean');
            $this->form_validation->set_rules('phone', 'Телефон', 'trim|xss_clean');
            $this->form_validation->set_rules('company', 'Компания', 'trim|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('add', $data);
            }
            else {
                $arr = array(
                    'error' => '<div class="alert alert-success" role="alert"><strong>Успех! </strong>Запись была успешно добавлена!</div>'
                );
                $this->session->set_userdata($arr);
                $insert_id = $this->users_model->set();
                redirect('admin/' . $this->module . '/edit/' . $insert_id);
            }
        }

        else
        {
                $this->load->view('add', $data);
        }


    }

    public function delete($id) {
        $entry = $this->model->get($id);
        if (count($entry) > 0) {
            if (file_exists('images/' . $this->module . '/' . $entry['image'])) {
                $this->model->delete($id);
                unlink('images/' . $this->module . '/' . $entry['image']);
                redirect('admin/' . $this->module);
            } else {
                $this->model->delete($id);
                redirect('admin/' . $this->module);
            }
        } else {
            die('Ошибка! Такой записи в базе не существует!');
        }
    }

    public function up($id) {
        $this->model->order($id, 'up');
    }

    public function down($id) {
        $this->model->order($id, 'down');
    }

}
