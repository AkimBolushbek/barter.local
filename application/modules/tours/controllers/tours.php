<?php

class Tours extends MX_Controller {

    private $module = 'tours';
    private $module_name = 'Туры';

    public function __construct() {
        parent::__construct();
        $this->load->model('tours_model');
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
            if (!$url) {
                $data['entries'] = $this->tours_model->get();
                $this->load->view('tours', $data);
            } else {
                $data['entry'] = $this->tours_model->get_by_url($url);
                $this->load->view('front/tour', $data);
            }
        } else {
            if (!$url) {

                $data['entries'] = $this->tours_model->get('', true);
                $this->load->view('front/tours', $data);
            } else {
                //$data['entry'] = $this->tours_model->get_by_url($url);
                $this->load->view('front/tour', $data);
            }
        }
    }

    public function buy($id) {
        if ($this->input->post('do') == 'buy') {
            $data['id'] = $id;
            $this->load->view('front/buy_form', $data);
        } else {
            
        }
    }

    public function get_by_url($url) {
        return $this->tours_model->get_by_url($url);
    }

    public function get_by_id($id) {
        return $this->tours_model->get($id);
    }

    public function edit($id = null) {
        $entry = $this->tours_model->get($id);
        $data['entry'] = $entry;
        $data['module_name'] = $this->module_name;
        $data['module'] = $this->module;
        $hotels = Modules::run('hotels/get', '', true);
        $data['hotels'] = $hotels;

        if ($this->input->post('do') == $this->module . 'Edit') {
            $this->form_validation->set_rules('name', 'Название', 'trim|required|xss_clean');
            $this->form_validation->set_rules('url', 'ЧПУ', 'trim|required|xss_clean');
            $this->form_validation->set_rules('country', 'Страна, город', 'trim|required|xss_clean');
            $this->form_validation->set_rules('price', 'Стоимость', 'trim|required|xss_clean');
            $this->form_validation->set_rules('datefrom', 'Дата с', 'trim|required|xss_clean');
            $this->form_validation->set_rules('duration', 'Продолжительность', 'trim|required|xss_clean');
            $this->form_validation->set_rules('dateto', 'Дата по', 'trim|required|xss_clean');
            $this->form_validation->set_rules('hotel', 'Отель', 'trim|required|xss_clean');
            $this->form_validation->set_rules('type', 'Тип отеля', 'trim|required|xss_clean');
            $this->form_validation->set_rules('placement', 'Размещение', 'trim|required|xss_clean');
            $this->form_validation->set_rules('feed', 'Питание', 'trim|xss_clean');
            $this->form_validation->set_rules('room', 'Номер', 'trim|required|xss_clean');
            $this->form_validation->set_rules('outflight', 'Рейс туда', 'trim|required|xss_clean');
            $this->form_validation->set_rules('backflight', 'Рейс обратно', 'trim|required|xss_clean');
            $this->form_validation->set_rules('priceinc', 'В стоимость тура включено', 'trim|required|xss_clean');
            $this->form_validation->set_rules('label', 'Надпись', 'trim|xss_clean');
            $this->form_validation->set_rules('active', 'Активен', 'trim|xss_clean');
            $this->form_validation->set_rules('title', 'Title', 'trim|xss_clean');
            $this->form_validation->set_rules('metatitle', 'Meta title', 'trim|xss_clean');
            $this->form_validation->set_rules('desc', 'Мета рписание', 'trim|xss_clean');
            $this->form_validation->set_rules('keyw', 'Ключевые слова', 'trim|xss_clean');
            $this->form_validation->set_rules('active', 'Активность', 'trim|xss_clean');

            $this->form_validation->set_error_delimiters('<span class="label label-danger">', '</span>');
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('edit', $data);
            } else {
                $config['upload_path'] = './images/' . $this->module;
                $config['allowed_types'] = 'gif|jpg|png|jpeg|JPG|JPEG';
                $config['max_size'] = '5120';
                $config['encrypt_name'] = true;

                $this->load->library('upload', $config);

                $image_data = $this->upload->data();
                if ($_FILES['image']['name'] == '') {
                    $this->tours_model->update($id);
                    $arr = array(
                        'error' => '<div class="alert alert-success" role="alert"><strong>Успех! </strong>Запись успешно обновлена!</div>'
                    );
                    $this->session->set_userdata($arr);
                    redirect('admin/' . $this->module . '/edit/' . $entry['id']);
                } else {
                    if (!$this->upload->do_upload('image')) {
                        $this->session->set_userdata('error', $this->upload->display_errors('<span class="label label-danger">', '</span>'));
                        $this->tours_model->update($id);
                        redirect('admin/' . $this->module . '/edit/' . $entry['id']);
                    } else {
                        $entry = $this->tours_model->get($id);
                        if (file_exists('images/' . $this->module . '/' . $entry['image'])) {
                            unlink('images/' . $this->module . '/' . $entry['image']);
                            $image_data = $this->upload->data();
                            $this->tours_model->update($id, $image_data['file_name']);
                            $arr = array(
                                'error' => '<div class="alert alert-success" role="alert"><strong>Успех! </strong>Запись была успешно обновлена!</div>'
                            );
                            $this->session->set_userdata($arr);
                            redirect('admin/' . $this->module . '/edit/' . $entry['id']);
                        } else {
                            $image_data = $this->upload->data();
                            $this->tours_model->update($id, $image_data['file_name']);
                            $arr = array(
                                'error' => '<div class="alert alert-success" role="alert"><strong>Успех! </strong>Запись была успешно обновлена!</div>'
                            );
                            $this->session->set_userdata($arr);
                            redirect('admin/' . $this->module . '/edit/' . $entry['id']);
                        }
                    }
                }
            }
        } else {
            $this->load->view('edit', $data);
        }
    }

    public function check_url($url) {
        if ($this->tours_model->get_by_url($url)) {
            $this->form_validation->set_message('check_url', 'Такой ЧПУ уже занят!');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function add() {
        $data['module_name'] = $this->module_name;
        $data['module'] = $this->module;
        $hotels = Modules::run('hotels/get', '', true);
        $data['hotels'] = $hotels;
        if ($this->input->post('do') == $this->module . 'Add') {
            $this->form_validation->set_rules('name', 'Название', 'trim|required|xss_clean');
            $this->form_validation->set_rules('country', 'Страна, город', 'trim|required|xss_clean');
            $this->form_validation->set_rules('url', 'ЧПУ', 'trim|required|xss_clean');
            $this->form_validation->set_rules('price', 'Стоимость', 'trim|required|xss_clean');
            $this->form_validation->set_rules('datefrom', 'Дата с', 'trim|required|xss_clean');
            $this->form_validation->set_rules('duration', 'Продолжительность', 'trim|required|xss_clean');
            $this->form_validation->set_rules('dateto', 'Дата по', 'trim|required|xss_clean');
            $this->form_validation->set_rules('hotel', 'Отель', 'trim|required|xss_clean');
            $this->form_validation->set_rules('type', 'Тип отеля', 'trim|required|xss_clean');
            $this->form_validation->set_rules('placement', 'Размещение', 'trim|required|xss_clean');
            $this->form_validation->set_rules('feed', 'Питание', 'trim|xss_clean');
            $this->form_validation->set_rules('room', 'Номер', 'trim|required|xss_clean');
            $this->form_validation->set_rules('outflight', 'Рейс туда', 'trim|required|xss_clean');
            $this->form_validation->set_rules('backflight', 'Рейс обратно', 'trim|required|xss_clean');
            $this->form_validation->set_rules('priceinc', 'В стоимость тура включено', 'trim|required|xss_clean');
            $this->form_validation->set_rules('label', 'Надпись', 'trim|xss_clean');
            $this->form_validation->set_rules('active', 'Активен', 'trim|xss_clean');
            $this->form_validation->set_rules('title', 'Title', 'trim|xss_clean');
            $this->form_validation->set_rules('metatitle', 'Meta title', 'trim|xss_clean');
            $this->form_validation->set_rules('desc', 'Мета рписание', 'trim|xss_clean');
            $this->form_validation->set_rules('keyw', 'Ключевые слова', 'trim|xss_clean');
            $this->form_validation->set_rules('active', 'Активность', 'trim|xss_clean');

            $this->form_validation->set_error_delimiters('<span class="label label-danger">', '</span>');
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('add', $data);
            } else {
                $config['upload_path'] = './images/' . $this->module;
                $config['allowed_types'] = 'gif|jpg|png|jpeg|JPG|JPEG';
                $config['max_size'] = '5120';
                $config['encrypt_name'] = true;

                $this->load->library('upload', $config);

                $image_data = $this->upload->data();
                if (!$this->upload->do_upload('image')) {
                    $this->session->set_userdata('error', $this->upload->display_errors('<span class="label label-danger">', '</span>'));
                    redirect('admin/' . $this->module . '/add');
                } else {
                    $image_data = $this->upload->data();
                    $arr = array(
                        'error' => '<div class="alert alert-success" role="alert"><strong>Успех! </strong>Запись была успешно добавлена!</div>'
                    );
                    $this->session->set_userdata($arr);
                    $insert_id = $this->tours_model->set($image_data['file_name']);
                    redirect('admin/' . $this->module . '/edit/' . $insert_id);
                }
            }
        } else {
            $this->load->view('add', $data);
        }
    }

    public function delete($id) {
        if (!$this->session->userdata('logged')) {
            redirect('admin/login');
        }
        $entry = $this->tours_model->get($id);
        if (count($entry) > 0) {
            if (file_exists('images/' . $this->module . '/' . $entry['image'])) {
                $this->tours_model->delete($id);
                unlink('images/' . $this->module . '/' . $entry['image']);
                $images = $this->tours_model->get_images($id);
                foreach ($images as $img) {
                    if (file_exists('images/' . $this->module . '/' . $img['image'])) {
                        unlink('images/' . $this->module . '/' . $img['image']);
                        $this->tours_model->delete_images($id);
                    } else {
                        die('Картинок не найдено');
                    }
                }
                redirect('admin/' . $this->module);
            } else {
                $this->tours_model->delete($id);
                redirect('admin/' . $this->module);
            }
        } else {
            die('Ошибка! Такой записи в базе не существует!');
        }
    }

    public function images_upload($hotel_id) {
        if (!$this->session->userdata('logged')) {
            redirect('admin/login');
        }
        if (!($_FILES)) {
            die("Не выбрано ни одной картинки!");
        }
        if ($_FILES['file']['name']) {
            foreach ($_FILES['file']['name'] as $k => $f) {
                if (!$_FILES['file']['error'][$k]) {
                    $blacklist = array(".php", ".phtml", ".php3", ".php4", ".html", ".htm", ".asp", ".aspx");
                    foreach ($blacklist as $item)
                        if (preg_match("/$item\$/i", $_FILES['file']['name'][$k]))
                            die("Недопустимый формат файла");
                    if (is_uploaded_file($_FILES['file']['tmp_name'][$k])) {
                        $namef = time() . "_" . md5(uniqid()) . "." . preg_replace("/.*?\./", '', $_FILES['file']['name'][$k]);
                        ;
                        $uploadfile = "images/" . $this->module . "/" . $namef;
                        if (!move_uploaded_file($_FILES['file']['tmp_name'][$k], $uploadfile)) {
                            die("Error");
                        } else {
                            $image = $namef;
                            $this->tours_model->images_insert($image, $hotel_id);
                            echo 'Файл "' . $_FILES['file']['name'][$k] . '" успешно загружен
';
                        }
                    }
                }
            }
        }
    }

    public function get_images($id, $front = false) {
        if ($front) {
            return $this->tours_model->get_images($id);
        } else {
            $pimages = $this->tours_model->get_images($id);

            if (!$pimages) {
                echo '<div class="alert alert-danger" role="alert">Миниатюр не найдено!</div>';
            }
            ?>
            <div class="row images">
                <?php
                foreach ($pimages as $pimage):
                    ?>
                    <div id="image_<?= $pimage['id'] ?>" style="width:200px;" class="col-xs-6 col-md-3">
                        <a class="thumbnail">
                            <button id="<?= $pimage['id'] ?>" type="button" class="close image_del">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                            <img class="img-rounded" src="/images/<?= $this->module . '/' . $pimage['image'] ?>" alt="...">
                        </a>
                    </div>
                    <?php
                endforeach;
                ?>
            </div>
            <?php
        }
    }

    public function image_delete() {
        if (!$this->session->userdata('logged')) {
            alert('Авторизуйтесь!');
            die();
        }
        $id = $this->input->post('id');
        $image = $this->tours_model->get_image($id);
        if (count($image) > 0) {
            if (file_exists('images/' . $this->module . '/' . $image['image'])) {
                $this->tours_model->delete_image($id);
                unlink('images/' . $this->module . '/' . $image['image']);
            } else {
                $this->tours_model->delete_image($id);
            }
        } else {
            die('Такой картинки не существует!');
        }
    }

    public function up($id) {
        $this->tours_model->order($id, 'up');
    }

    public function down($id) {
        $this->tours_model->order($id, 'down');
    }

}
