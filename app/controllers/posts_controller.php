<?php

class PostsController extends AppController{
  var $name = 'Posts';

  var $helpers = array('Form');

  function index() {
    $this->set('posts', $this->Post->findAll() );
  }

  function view($id = null) {
    $this->Post->id = $id;
    $this->set('post', $this->Post->read());
  }

  function add() {
    if( !empty( $this->data) ){
      if( $this->Post->save( $this->data ) ){
	$this->Session->setFlash( 'Your post has been saved.' );
	$this->redirect( array('action' => 'index' ) );
      }
    }
  }

  function delete( $id ) {
    $this->Post->del( $id );
    $this->Session->setFlash( 'The post with id: '.$id.' has been deleted.' );
    $this->redirect( array( 'action'=>'index' ) );
  }

  function edit( $id ) {
    $this->Post->id = $id;
    if( empty( $this->data ) ){
      $this->data = $this->Post->read();
    }
    else {
      if( $this->Post->save( $this->data ) ){
	$this->Session->setFlash( 'Your post has been updated' );
	$this->redirect( array( 'action' => 'index' ) );
      }
    }
  }
}

?>