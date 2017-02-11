<?php

use Phalcon\Mvc\Controller;

class LoginController extends Controller {

	
	public function indexAction() {
		$this->session->start();
        $auth = $this->session->get('auth');
        if($auth!=null){
			echo $this->view->getPartial('login/index', ['message' => "Welcome ".$auth['name']." | <a href='".$this->url->get('logout')."'>Logout</a>"]);
			exit;
        }

		if(isset($_POST['email'])){

			if (!filter_var($this->request->getPost("email"), FILTER_VALIDATE_EMAIL)) {
				echo $this->view->getPartial('login/index', ['message' => "Invalid Email"]);
				exit;
			} else {
				# check if email exists
				$user = new Users();

		        $userinfo = Users::findFirst(array(
		            "(email = :email:)",
		            'bind' => array('email' => $this->request->getPost('email'))
		        ));
		        if($userinfo!=false){
					if (password_verify($this->request->getPost("password"),$userinfo->password)) { // $user->password is the hash

				        $this->session->set('auth', array(
				            'id' => $userinfo->id,
				            'name' => $userinfo->name,
				            'email' => $userinfo->email
				        ));
				        $this->response->redirect("login/index");
			        } else {
						echo $this->view->getPartial('login/index', ['message' => "Invalid Username/Password"]);
						exit;
					}
				}
			}
			echo $this->view->getPartial('login/index', ['message' => "Successful Login"]);
		}
	}

}