<?php

use Phalcon\Mvc\Controller;

class LoginController extends Controller
{
 
	public function indexAction() {
		if(isset($_POST['email'])){

			if (!filter_var($this->request->getPost("email"), FILTER_VALIDATE_EMAIL)) {
				echo $this->view->getPartial('login/index', ['message' => "Invalid Email"]);
				exit;
			} else {
				# check if email exists
				$user = new Users();

		        $user = Users::findFirst(array(
		            "(email = :email:) AND password = :password:",
		            'bind' => array('email' => $this->request->getPost('email'), 'password' => $this->request->getPost('password'))
		        ));
		        if ($user != false) {
			        /*$this->session->set('auth', array(
			            'id' => $user->id,
			            'name' => $user->name
			        ));*/
		            echo $this->view->getPartial('login/index', ['message' => "Welcome ".$user->name]);
		            exit;
		/*                return $this->dispatcher->forward(
		                [
		                    "controller" => "invoices",
		                    "action"     => "index",
		                ]
		            );*/
		        } else {
					echo $this->view->getPartial('login/index', ['message' => "Invalid Username/Password"]);
					exit;
				}
			}
			echo $this->view->getPartial('login/index', ['message' => "Successful Login"]);
		}
	}

}