<?php
  class Posts extends Controller {
    public function __construct() {
      if (!isLoggedIn()) {
        redirect('users/login');
      }

      $this->postModel = $this->model('Post');
    }

    public function index() {
      // Get Post
      $posts = $this->postModel->getPosts();
      $data = [
        'posts' => $posts
      ];
      $this->view('posts/index', $data);
    }

    public function add() {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $data = [
          'title' => trim($_POST['title']),
          'body' => trim($_POST['body']),
          'title_err' => '',
          'body_err' => ''
        ];

        if (empty($data['title'])) {
          $data['title_err'] = 'Please fill the title field';
        }
        if (empty($data['body'])) {
          $data['body_err'] = 'Please fill the body field';
        }

        if (empty($data['title_err']) && empty($data['body_err'])) {
          if ($this->postModel->addPost($data)) {
            flash('post-added', 'Post Added Successfully');
            redirect('posts');
          } else {
            die('There is somthing went wrong :(');
          }
        } else {
          $this->view('posts/add', $data);
        }
        
      } else {
        $data = [
          'title' => '',
          'body' => '',
          'title_err' => '',
          'body_err' => ''
        ];
        $this->view('posts/add', $data);
      }
      
    }


    public function edit($id) {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $data = [
          'id' => $id,
          'title' => trim($_POST['title']),
          'body' => trim($_POST['body']),
          'title_err' => '',
          'body_err' => ''
        ];

        if (empty($data['title'])) {
          $data['title_err'] = 'Please fill the title field';
        }
        if (empty($data['body'])) {
          $data['body_err'] = 'Please fill the body field';
        }

        if (empty($data['title_err']) && empty($data['body_err'])) {
          if ($this->postModel->updatePost($data)) {
            flash('post-added', 'Post Updated Successfully');
            redirect('posts');
          } else {
            die('There is somthing went wrong :(');
          }
        } else {
          $this->view('posts/edit', $data);
        }
        
      } else {
        $post = $this->postModel->getPostById($id);
        if ($_SESSION['user_id'] != $post->user_id) {
          redirect('posts');
        }

        $data = [
          'id' => $id,
          'title' => $post->title,
          'body' => $post->body,
          'title_err' => '',
          'body_err' => ''
        ];
        $this->view('posts/edit', $data);
      }
      
    }


    public function delete($id) {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $post = $this->postModel->getPostById($id);
        if ($_SESSION['user_id'] != $post->user_id) {
          redirect('posts');
        }
        if ($this->postModel->deletePost($id)) {
          flash('post-added', 'Post Deleted Successfully');
          redirect('posts');
        } else {
          die('There is somthing went wrong :(');
        }
      } else {
        redirect('posts');
      }
      
    }

    public function show($id) {
      $data = [
        'post' => $this->postModel->getPostById($id)
      ];
      $this->view('posts/show', $data);
    }
  }