<?php
namespace App\Controllers;
use App\Models\{User, Phone};

/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:31
 */

Class ProfileController Extends PageController
{
    protected function getTemplateNames()
    {
        $this->templateInfo['templateNames'] = ['head', 'navbar', 'leftcolumn', 'middleprofile', 'rightcolumn', 'footer'];
    }
    protected function getTitle()
    {
        switch ($this->modelsAction) {
            case "actionShow":
                $this->templateInfo['title'] = 'Профиль';
                break;
            case "actionEdit":
                $this->templateInfo['title'] = 'Редактирование профиля';
                break;
            case "actionInput":
                $this->templateInfo['title'] = 'Добавление телефона';
                break;
        }
    }
    protected function getControllerVars()
    {
        $userId = User::checkLogged();

        switch ($this->modelsAction) {
            case "actionShow":
                $result = ['submitAction' => 'edit',
                           'submitValue' => 'Редактировать',
                           'submitPhoneAction' => 'input',
                           'submitPhoneValue' => 'Добавить',
                           'allowEdit' => 'disabled'];
                $userPhones = Phone::getByCondition(['userId' => $userId]);
                return array_merge($result, parent::getControllerVars(), ["userPhones" => $userPhones]);
            case "actionEdit":
                $result = ['submitAction' => 'update',
                           'submitValue' => 'Подтвердить',
                           'submitPhoneAction' => 'input',
                           'submitPhoneValue' => 'Добавить',
                           'allowEdit' => 'enabled'];
                $userPhones = Phone::getByCondition(['userId' => $userId]);
                return array_merge($result, parent::getControllerVars(), ["userPhones" => $userPhones]);
            case "actionInput":
                $result = ['submitAction' => 'edit',
                            'submitValue' => 'Редактировать',
                            'submitPhoneAction' => 'insert',
                            'submitPhoneValue' => 'OK',
                            'allowEdit' => 'disabled'];
                $userPhones = Phone::getByCondition(['userId' => $userId]);
                return array_merge($result, parent::getControllerVars(), ["userPhones" => $userPhones]);
            case "actionUpdate":
                $user = User::getByID($userId);
                foreach ($_POST as $field => $value) {
                    $user->{$field} = $value;
                }
                $user->update();
                header('Location: /profile/show/');
                break;
            case "actionInsert":
                $newPhone = new Phone();
                $newPhone->userId = $userId;
                $newPhone->phone = $_POST['newPhone'];
                $newPhone->insert();
                header('Location: /profile/show/');
                break;
            case "actionDelete":
                Phone::delete($_POST['phoneID']);
                header('Location: /profile/show/');
                break;
        }
    }
}
