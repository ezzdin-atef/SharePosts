<?php
  class Pages extends Controller {
    public function __construct() {
      # code ...
    }

    public function index() {
      if (isLoggedIn()) {
        redirect('posts');
      }
      $data = [
        'title' => 'Homepage',
        'description' => 'Simple Social Netword Build By PHP MVC',
    ];
      $this->view('pages/index', $data);
    }

    public function about() {
      $data = [
        'title' => 'About',
        'description' => 'This is SharePosts App Made With PHP MVC',
      ];
      $this->view('pages/about', $data);
    }
  }