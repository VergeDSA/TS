<?php
namespace App\Controllers;
use App\Models\Users;
use Libs\Framework\View;

class UserController
{
    /**
     * Action for page "Registration"
     */
    public $errors = [];
    
    public function actionRegister()
    {
        $name = false;
        $email = false;
        $password = false;
        $result = false;
        

        if (isset($_POST['submit'])) {

            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];


            if (!Users::checkName($name)) {
                $this->errors['name'] = 'Имя не должно быть короче 2-х символов';
            }
            if (!Users::checkEmail($email)) {
                $this->errors['email'] = 'Неправильный email';
            }
            if (!Users::checkPassword($password)) {
                $this->errors['password'] = 'Пароль не должен быть короче 6-ти символов';
            }
            if (Users::checkEmailExists($email)) {
                $this->errors['email'] = 'Такой email уже используется';
            }

            if ($this->errors == false) {

                $result = Users::register($name, $email, $password);

                if($result){
                	$to = substr(htmlspecialchars(trim($email)), 0, 1000);
                    $subject = 'Регистрация на портале';
              $message = '
                <html>
                    <head>
                        <title>'.$subject.'</title>
                    </head>
                    <body>
                        <strong>'.$name.' </strong>'.'<br>
                        Спасибо за регистрацию на нашем портале                    
                    </body>
                </html>'; 
  
           $headers  = 'MIME-Version: 1.0' . "\r\n";
           $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
          
                     mail($to, $subject, $message, $headers);
				}

               $userId = Users::checkUserData($email, $password);

                if ($userId == false) {
                    $this->errors['password'] = 'Неправильные данные для входа на сайт';
                } else {
                    Users::auth($userId);
                }
                header("Location: /");
                die;
            }
        }
        $this->render('/user/register');
    }

    /**
     * Action for page "Login"
     */
    public function actionLogin()
    {
        $email = false;
        $password = false;

        if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            if (!Users::checkEmail($email)) {
                $this->errors['email'] = 'Неправильный email';
            }
            if (!Users::checkPassword($password)) {
                $this->errors['password'] = 'Пароль не должен быть короче 6-ти символов';
            }

            $userId = Users::checkUserData($email, $password);

            if ($userId == false) {
                $this->errors['password'] = 'Неправильные данные для входа на сайт';
            } else {
                Users::auth($userId);

                header("Location: /");
                die;
            }
        }
        $this->render('/user/login');
    }

    /**
     * Delete user information from the session
     */
    public function actionLogout()
    {
        session_start();
        unset($_SESSION["user"]);
        header("Location: /");
        die;
    }
    public function render($path)
    {
        $view = new View();
        $view->assign('errors', $this->errors);
        $view->display($path);
    }
}
