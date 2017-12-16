<?php

class Pages extends Controller {
	// private $postModel;

	public function __construct() {
		// Load model here
		// $this->postModel = $this->model('Post');
	}

	public function index() {
		$data['title'] = 'Welcome to PHPMVC Framework';
		$this->view('pages/index', $data);
	}
}
