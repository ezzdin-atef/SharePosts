<?php
  class Users extends Controller {
    public function __construct() {
      $this->userModel = $this->model('User');
    }

    public function register() {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $data = [
          'name' => trim($_POST['name']),
          'email' => trim($_POST['email']),
          'password' => trim($_POST['password']),
          'confirm_password' => trim($_POST['confirm-password']),
          'name_err' => '',
          'email_err' => '',
          'password_err' => '',
          'confirm_password_err' => '',
        ];

        if (empty($data['name'])) {
          $data['name_err'] = 'Please fill your name';
        }
        if (empty($data['email'])) {
          $data['email_err'] = 'Please fill your email';
        } else {
          if ($this->userModel->findUserByEmail($data['email'])) {
            $data['email_err'] = 'This email exist';
          }
        }
        if (empty($data['password'])) {
          $data['password_err'] = 'Please fill your password';
        } elseif (strlen($data['password']) < 5) {
          $data['password_err'] = 'Please your password should be more than 5 characters';
        }
        if (empty($data['confirm_password'])) {
          $data['confirm_password_err'] = 'Please fill your confirm password field';
        } elseif ($data['confirm_password'] != $data['password']) {
          $data['confirm_password_err'] = 'Password doesn\'t match';
        }

        if (empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
          $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

          if($this->userModel->register($data)) {
            flash('regiser-success', 'You Register Successfully');
            redirect('users/login');
          }
        } else {
          $this->view('users/register', $data);
        }

        
      } else {
        $data = [
          'name' => '',
          'email' => '',
          'password' => '',
          'confirm_password' => '',
          'name_err' => '',
          'email_err' => '',
          'password_err' => '',
          'confirm_password_err' => '',
        ];

        $this->view('users/register', $data);
      }
    }


    public function login() {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $data = [
          'email' => trim($_POST['email']),
          'password' => trim($_POST['password']),
          'email_err' => '',
          'password_err' => '',
        ];

        if (empty($data['email'])) {
          $data['email_err'] = 'Please fill your eamil';
        } else {
          if ($this->userModel->findUserByEmail($data['email'])) {
            
          } else {
            $data['email_err'] = 'This email doesn\'t exist';
          }
        }
        if (empty($data['password'])) {
          $data['password_err'] = 'Please fill your password';
        }

        if (empty($data['email_err']) && empty($data['password_err'])) {
          $loggedin = $this->userModel->login($_POST['email'], $_POST['password']);
          if ($loggedin) {
            $this->createUserSession($loggedin);
          } else {
            $data['password_err'] = 'The Password incorrect';
            $this->view('users/login', $data);
          }
        } else {
          $this->view('users/login', $data);
        }

      } else {
        $data = [
          'email' => '',
          'password' => '',
          'email_err' => '',
          'password_err' => '',
        ];

        $this->view('users/login', $data);
      }
    }

    public function createUserSession($user) {
      $_SESSION['user_id'] = $user->id;
      $_SESSION['email'] = $user->email;
      $_SESSION['name'] = $user->name;
      redirect('posts');
    }

    public function logout() {
      unset($_SESSION['user_id']);
      unset($_SESSION['email']);
      unset($_SESSION['name']);
      session_destroy();
      redirect('users/login');
    }



  }











?>