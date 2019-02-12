<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Oces extends CI_Controller {


	public function index()
	{
		// echo "my custom home";

		$this->load->view('home');
	}

	public function candidates()
	{
		// echo "my custom home";

		$this->load->view('candidates');
	}

	public function admin()
	{
		// echo "my custom home";

		$this->load->view('admin');
	}

	public function rules()
	{
		// echo "my custom home";

		$this->load->view('rules');
	}

	public function admin_panel()
	{
		// echo "my custom home";

		$this->load->view('admin_panel');
	}
}
