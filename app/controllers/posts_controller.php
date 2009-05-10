<?php

class PostsController extends AppController{
  var $name = 'Posts';

  function index() {
    $this->set('posts', $this->Post->findAll() );
  }

  function view($id = null) {
    $this->Post->id = $id;
    $this->set('post', $this->Post->read());
  }

}

?>