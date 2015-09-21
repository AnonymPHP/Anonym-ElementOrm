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

        $this->getBase()->setTable( $this->findConnectedTable());
        $this->setOrm($this->getBase());
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

        $class = get_called_class();
        return $this->resolveClassName($class);
    }


    /**
     * resolve the class name
     *
     * @param string $name
     * @return mixed
     */
    private function resolveClassName($name = '')
    {
        $explodeClass = explode('\\', $name);
        return end($explodeClass);
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
        $this->setOrm($this->getBase()->setTable($table));
        return $this;
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
