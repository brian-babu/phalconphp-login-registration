<?php

use Phalcon\Mvc\Controller;

class SignupController extends Controller {
 
	public function indexAction() {
		$this->session->start();
        $auth = $this->session->get('auth');
        if($auth!=null){
			$this->response->redirect("login/index");
        }
	}

	public function registerAction() {
		$error=0;
		$user = new Users();
		
		if($this->request->getPost("password")!=$this->request->getPost("password2")) {
			$error++;
			echo $this->view->getPartial('signup/index', ['message' => "Too bad! Your Passwords didn't match!"]);
		}
		// Store and check for errors
		if($error==0){
			 
			if (!filter_var($this->request->getPost("email"), FILTER_VALIDATE_EMAIL)) {
				echo $this->view->getPartial('signup/index', ['message' => "Invalid Email"]);
				exit;
			} else {
				# check if email exists
				$users = $user->find("email='".$this->request->getPost("email")."'");
				if(count($users)>0){
					echo $this->view->getPartial('signup/index', ['message' => "Email Already Exists"]);
					exit;
				}
			}

$user->password = password_hash($this->request->getPost("password"),PASSWORD_DEFAULT);
$user->name = $this->request->getPost("name");
$user->email = $this->request->getPost("email");
$success = $user->save();

			if ($success) {

				echo $this->view->getPartial('signup/index', ['message' => "Thanks for registering!"]);
			} else {
				echo "Sorry, the following problems were generated: ";
				foreach ($user->getMessages() as $message) {
					echo $message->getMessage(), "<br/>";
				}
			}

		}
	}

}
