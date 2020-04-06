<?php
  class Post {
    private $db;

    public function __construct() {
      $this->db = new Database();
    }

    public function getPosts() {
      $this->db->query('SELECT posts.*, users.name FROM posts INNER JOIN users ON posts.user_id = users.id ORDER BY posts.id DESC');

      $result = $this->db->resultSet();

      return $result;
    }

    public function addPost($data) {
      $this->db->query('INSERT INTO posts(user_id, title, body) VALUES(:userid, :title, :body)');
      $this->db->bind(':userid', $_SESSION['user_id']);
      $this->db->bind(':title', $data['title']);
      $this->db->bind(':body', $data['body']);

      if ($this->db->execute()) {
        return true;
      } else {
        return false;
      }
    }
    
    public function updatePost($data) {
      $this->db->query('UPDATE posts SET title = :title, body = :body WHERE id = :id');
      $this->db->bind(':title', $data['title']);
      $this->db->bind(':body', $data['body']);
      $this->db->bind(':id', $data['id']);

      if ($this->db->execute()) {
        return true;
      } else {
        return false;
      }
    }
    
    public function deletePost($id) {
      $this->db->query('DELETE FROM posts WHERE id = :id');
      $this->db->bind(':id', $id);

      if ($this->db->execute()) {
        return true;
      } else {
        return false;
      }
    }

    public function getPostById($id) {
      $this->db->query('SELECT posts.*, users.name FROM posts INNER JOIN users ON posts.user_id = users.id WHERE posts.id = :id ORDER BY posts.id DESC');
      $this->db->bind(':id', $id);

      $result = $this->db->single();

      return $result;
    }

  }


?>