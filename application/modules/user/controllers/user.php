<?php

class User extends MX_Controller {

    var $min_username = 4;
    var $max_username = 20;
    var $min_password = 4;
    var $max_password = 20;

    private $module = 'user';
    private $module_name = 'Пользователи';

    public function __construct() {
        parent::__construct();

        $this->load->library('DX_Auth');
        //$this->load->model('user_model');
        //$this->model = $this->user_model;
    }



    public function index()
    {
        $this->load->helper('url');
        $this->login();
    }

    function login()
    {
        if ( ! $this->dx_auth->is_logged_in())
        {
            $val = $this->form_validation;
            $val->set_rules('username', 'Username', 'trim|required');
            $val->set_rules('password', 'Password', 'trim|required');
            $val->set_rules('remember', 'Remember me', 'integer');

            if ($this->dx_auth->is_max_login_attempts_exceeded())
            {
                $val->set_rules('captcha', 'Confirmation Code', 'trim|required|callback_captcha_check');
            }

            if ($val->run() AND $this->dx_auth->login($val->set_value('username'), $val->set_value('password'), $val->set_value('remember')))
            {
                // Redirect to homepage
                redirect('', 'location');
            }
            else
            {
                // Check if the user is failed logged in because user is banned user or not
                if ($this->dx_auth->is_banned())
                {
                    // Redirect to banned uri
                    $this->dx_auth->deny_access('banned');
                }
                else
                {
                    // Default is we don't show captcha until max login attempts eceeded
                    $data['show_captcha'] = FALSE;

                    // Show captcha if login attempts exceed max attempts in config
                    if ($this->dx_auth->is_max_login_attempts_exceeded())
                    {
                        // Create catpcha
                        $this->dx_auth->captcha();

                        // Set view data to show captcha on view file
                        $data['show_captcha'] = TRUE;
                    }

                    // Load login page view
                    $this->load->view($this->dx_auth->login_view, $data);
                }
            }
        }
        else
        {
            $data['auth_message'] = 'You are already logged in.';
            $this->load->view($this->dx_auth->logged_in_view, $data);
        }
    }

    function logout()
    {
        $this->dx_auth->logout();

        $data['auth_message'] = 'You have been logged out.';
        $this->load->view($this->dx_auth->logout_view, $data);
    }

    function register()
    {
        if ( ! $this->dx_auth->is_logged_in() AND $this->dx_auth->allow_registration)
        {
            $val = $this->form_validation;
            $val->set_rules('username', 'Username', 'trim|required|min_length['.$this->min_username.']|max_length['.$this->max_username.']|callback_username_check|alpha_dash');
            $val->set_rules('password', 'Password', 'trim|required|min_length['.$this->min_password.']|max_length['.$this->max_password.']|matches[confirm_password]');
            $val->set_rules('confirm_password', 'Confirm Password', 'trim|required');
            $val->set_rules('email', 'Email', 'trim|required|valid_email|callback_email_check');

            if ($this->dx_auth->captcha_registration)
            {
                $val->set_rules('recaptcha_response_field', 'Confirmation Code', 'trim|required|callback_recaptcha_check');
            }

            if ($val->run() AND $this->dx_auth->register($val->set_value('username'), $val->set_value('password'), $val->set_value('email')))
            {
                if ($this->dx_auth->email_activation)
                {
                    $data['auth_message'] = 'You have successfully registered. Check your email address to activate your account.';
                }
                else
                {
                    $data['auth_message'] = 'You have successfully registered. '.anchor(site_url($this->dx_auth->login_uri), 'Login');
                }
                $this->load->view($this->dx_auth->register_success_view, $data);
            }
            else
            {
                $this->load->view('front/auth/register_form');
            }
        }
        elseif ( ! $this->dx_auth->allow_registration)
        {
            $data['auth_message'] = 'Registration has been disabled.';
            $this->load->view($this->dx_auth->register_disabled_view, $data);
        }
        else
        {
            $data['auth_message'] = 'You have to logout first, before registering.';
            $this->load->view($this->dx_auth->logged_in_view, $data);
        }
    }
    function forgot_password()
    {
        $val = $this->form_validation;
        $val->set_rules('login', 'Username or Email address', 'trim|required');
        if ($val->run() AND $this->dx_auth->forgot_password($val->set_value('login')))
        {
            $data['auth_message'] = 'An email has been sent to your email with instructions with how to activate your new password.';
            $this->load->view($this->dx_auth->forgot_password_success_view, $data);
        }
        else
        {
            $this->load->view($this->dx_auth->forgot_password_view);
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

        $groups = Modules::run('groups/get', '', true);
        $data['groups'] = $groups;

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

        $groups = Modules::run('groups/get', '', true);
        $data['groups'] = $groups;

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

        $groups = Modules::run('groups/get', '', true);
        $data['groups'] = $groups;

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
