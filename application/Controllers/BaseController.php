<?php
namespace App\Controllers;

/**
 * BaseController Class
 *
 * Абстрактный класс, реализующий базовый функционал контролера
 *
 * @author А.Бричак <brichak.new@gmail.com>
 * @version 1.0
 */

abstract class BaseController
{
    /**
     * Ассоциативный массив - набор переменных, с помощью которого контроллер
     * возвращает результат своей работы
     *
     * @var array
     */
    protected $templateInfo = ['templateNames' => [],
                               'title' => ''];

    /**
     * Строка, указывающая, какое действие должен реализовать контроллер.
     * Передается из роутера
     *
     * @var string
     */
    protected $modelsAction;

    /**
     * Массив аргументов запроса. Передается из роутера
     *
     * @var array
     */
    protected $args;

    /**
     * Создает индексированный массив с наименованиями шаблонов, которые должны
     * быть показаны пользователю после окончания работы контроллера. Созданный
     * массив сохраняет в массиве $templateInfo с ключом 'templateNames'
     *
     * @return void
     */
    protected abstract function getTemplateNames();

    /**
     * В массиве $templateInfo с ключом 'title' указывает строку - title
     * выводимого документа HTML
     *
     * @return void
     */
    protected abstract function getTitle();

    /**
     * Подготавливает промежуточный массив переменных - результат работы контроллера
     *
     * @return array <p>Ассоциативный массив - промежуточный набор переменных,
     * полученных в результате работы контроллера</p>
     */
    protected abstract function getControllerVars();

    /**
     * Подготавливает итоговый массив переменных - результат работы контроллера,
     * в зависимости от полученных входящих параметров
     *
     * @param string $modelsAction Строка, указывающая, какое действие должен
     * реализовать контроллер
     * @param array $args Массив аргументов запроса
     *
     * @return array <p>Ассоциативный массив - итоговый набор переменных,
     * полученных в результате работы контроллера, включающий в себя массив
     * наименований шаблонов и title выводимого документа HTML</p>
     */
    public function index($modelsAction, $args)
    {
        $this->modelsAction = $modelsAction;
        $this->args = $args;

        $this->getTemplateNames();
        $this->getTitle();
        $this->templateInfo = array_merge($this->templateInfo, $this->args);
        if (is_array($this->getControllerVars())) {
            $this->templateInfo = array_merge($this->templateInfo, $this->getControllerVars());
        }
        return $this->templateInfo;
    }
}
