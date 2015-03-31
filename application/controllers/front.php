<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Front extends MX_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function main() {
//        $this->lang->load('translations', $this->uri->segment(1));
        $data['title'] = 'TravelShop';
        $this->load->view('auth/index', $data);
    }

    public function about() {
        $data['title'] = 'О нас';
        $this->load->view('templates/metahead', $data);
        $this->load->view('templates/head', $data);
        $this->load->view('templates/slider', $data);
        $this->load->view('pages/about', $data);
        $this->load->view('templates/contacts', $data);
        $this->load->view('templates/footer', $data);
    }

    public function contacts() {
        $data['title'] = 'Контаты';
        $contacts = Modules::run('contacts/get');
        $data['contacts'] = $contacts;
        $this->load->view('templates/metahead', $data);
        $this->load->view('templates/head', $data);
        $this->load->view('templates/slider', $data);
        $this->load->view('templates/none_reservation', $data);
        $this->load->view('pages/contacts', $data);
        $this->load->view('templates/footer', $data);
    }

    public function allreviews() {
        $data['title'] = 'Отзывы';
        $contacts = Modules::run('contacts/get');
        $data['contacts'] = $contacts;
        $this->load->view('templates/metahead', $data);
        $this->load->view('templates/head', $data);
        $this->load->view('templates/slider', $data);
        $this->load->view('templates/none_reservation', $data);
        $this->load->view('pages/allreviews', $data);
        $this->load->view('templates/footer', $data);
    }

    public function tours() {
        $data['title'] = 'Туры за рубеж';
        $this->load->view('templates/metahead', $data);
        $this->load->view('templates/head', $data);
        $this->load->view('pages/tours', $data);
        $this->load->view('templates/contacts', $data);
        $this->load->view('templates/footer', $data);
    }

    public function tour($url) {
        $tour = Modules::run('tours/get_by_url', $url);
        $hotel = Modules::run('hotels/get', $tour['hotel_id'], true);
        $tour_images = Modules::run('tours/get_images', $tour['id'], true);
        $hotel_images = Modules::run('hotels/get_images', $hotel['id'], true);
        $data['keyw'] = $tour['keyw'];
        $data['desc'] = $tour['desc'];
        if ($tour) {
            $data['title'] = $tour['name'];
            $data['url'] = $url;
            $data['entry'] = $tour;
            $data['tour_images'] = $tour_images;
            $data['hotel_images'] = $hotel_images;
            if ($tour['hotel_id']) {
                $data['hotel'] = $hotel;
            } else {
                $data['hotel'] = 'Нет';
            }
            $this->load->view('templates/metahead', $data);
            $this->load->view('templates/head', $data);
            $this->load->view('pages/tour', $data);
            $this->load->view('templates/contacts', $data);
            $this->load->view('templates/footer', $data);
        } else {
            show_404();
        }
    }

    public function vises() {
        $data['title'] = 'Визовые услуги';
        $this->load->view('templates/metahead', $data);
        $this->load->view('templates/head', $data);
        $this->load->view('templates/none_reservation', $data);
        $this->load->view('pages/vises', $data);
        $this->load->view('templates/contacts', $data);
        $this->load->view('templates/footer', $data);
    }

    public function belay() {
        $data['title'] = 'Медицинаская страховка';
        $this->load->view('templates/metahead', $data);
        $this->load->view('templates/head', $data);
        $this->load->view('templates/slider', $data);
        $this->load->view('templates/none_reservation', $data);
        $this->load->view('pages/belay', $data);
        $this->load->view('templates/contacts', $data);
        $this->load->view('templates/footer', $data);
    }

    public function reservation() {
        $data['title'] = 'Онлайн бронирование';
        $this->load->view('templates/metahead', $data);
        $this->load->view('templates/head', $data);
        $this->load->view('templates/slider', $data);
        $this->load->view('templates/reservation', $data);
        $this->load->view('pages/reservation', $data);
        $this->load->view('templates/contacts', $data);
        $this->load->view('templates/footer', $data);
    }

    public function blog() {
        $data['title'] = 'Блог';
        $this->load->view('templates/metahead', $data);
        $this->load->view('templates/head', $data);
        $this->load->view('templates/slider', $data);
        $this->load->view('templates/none_reservation', $data);
        $this->load->view('pages/blog', $data);
        $this->load->view('templates/contacts', $data);
        $this->load->view('templates/footer', $data);
    }

    public function post($url) {
        $post = Modules::run('blog/get_by_url', $url);
        $data['entry'] = $post;
        $data['title'] = 'Блог - ' . $post['name'];
        $data['url'] = $url;
        $this->load->view('templates/metahead', $data);
        $this->load->view('templates/head', $data);
        $this->load->view('templates/slider', $data);
        $this->load->view('templates/none_reservation', $data);
        $this->load->view('pages/post', $data);
        $this->load->view('templates/contacts', $data);
        $this->load->view('templates/footer', $data);
    }

    public function news() {
        $data['title'] = 'Новости';
        $this->load->view('templates/metahead', $data);
        $this->load->view('templates/head', $data);
        $this->load->view('templates/slider', $data);
        $this->load->view('templates/none_reservation', $data);
        $this->load->view('pages/news', $data);
        $this->load->view('templates/contacts', $data);
        $this->load->view('templates/footer', $data);
    }

    public function onenew($url) {
        $new = Modules::run('news/get_by_url', $url);
        $data['entry'] = $new;
        $data['title'] = 'Новости - ' . $new['name'];
        $data['url'] = $url;
        $this->load->view('templates/metahead', $data);
        $this->load->view('templates/head', $data);
        $this->load->view('templates/slider', $data);
        $this->load->view('templates/none_reservation', $data);
        $this->load->view('pages/new', $data);
        $this->load->view('templates/contacts', $data);
        $this->load->view('templates/footer', $data);
    }

}
