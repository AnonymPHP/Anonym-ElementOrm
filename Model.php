<?php
/**
 * This file belongs to the AnoynmFramework
 *
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
 * @see http://gemframework.com
 *
 * Thanks for using
 */

namespace Anonym\Components\Element;
use  Anonym\Components\Database\Base;
use Anonym\Facades\App;

class Model
{

    /**
     * the instance of database
     *
     * @var Base
     */
    protected $base;

    /**
     * the instance of orm
     *
     * @var Element
     */
    protected $orm;
    /**
     *  create a new instance and register database instance
     */
    public function __construct(){
        $this->setBase(App::make('database.base'));
        $this->table($this->findConnectedTable());
    }

    /**
     * @return Element
     */
    public function getOrm()
    {
        return $this->orm;
    }

    /**
     * @param Element $orm
     * @return Model
     */
    public function setOrm(Element $orm)
    {
        $this->orm = $orm;
        return $this;
    }

    /**
     * find user called table
     *
     * @return mixed
     */
    private function findConnectedTable(){
        $vars = get_class_vars(self::class);

        if (isset($vars['table'])) {
            return $vars['table'];
        }
    }




    /**
     * @return Base
     */
    public function getBase()
    {
        return $this->base;
    }

    /**
     * @param Base $base
     * @return Model
     */
    public function setBase(Base $base)
    {
        $this->base = $base;
        return $this;
    }

    /**
     * change called class
     *
     * @param stirng $table
     * @return $this
     */
    public function table($table){

        $element = (new Element(
            $this->getBase()->setConnectedTable($table)
        ))->setTable($table);

        $this->setOrm($element);
        return $this;
    }

    /**
     * call method in orm if cant find in this class
     *
     * @param string $method
     * @param array $args
     * @return mixed
     */
    public static function __callStatic($method, $args){

        $app = new static();

        return call_user_func_array([$app->getOrm(), $method ], $args);
    }
    /**
     * call method in orm if cant find in this class
     *
     * @param string $method
     * @param array $args
     * @return mixed
     */
    public function __call($method, $args){
        return call_user_func_array([$this->getOrm(), $method ], $args);
    }
}
