<?php

use Phalcon\Mvc\Controller;

class LogoutController extends Controller {

	public function indexAction() {
		$this->session->start();
		$this->session->destroy();
		$this->response->redirect("login/index");
	}

}
