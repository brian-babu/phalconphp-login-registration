<?php

use Phalcon\Mvc\Controller;
use Phalcon\Validation\Validator\Email as EmailValidator;

class SignupController extends Controller
{
 
	public function indexAction()
	{

	}

	public function registerAction()
	{
		$error=0;
		$user = new Users();
		
		if($this->request->getPost("password")!=$this->request->getPost("password2")) {
			$error++;
			echo $this->view->getPartial('signup/index', ['message' => "too bad! Your Passwords didn't match!"]);
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

			$success = $user->save(
				$this->request->getPost(),
				array('name', 'email', 'password')
			);

			if ($success) {
				echo $this->view->getPartial('signup/index', ['message' => "Thanks for registering!"]);
			} else {
				echo "Sorry, the following problems were generated: ";
				foreach ($user->getMessages() as $message) {
					echo $message->getMessage(), "<br/>";
				}
			}

		}


		$this->view->disable();
	}

}
