<?php
    /**
     * Bu Dosya AnonymFramework'e ait bir dosyadır.
     *
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @see http://gemframework.com
     *
     */

    namespace Anonym\Components\Facade;

    use Anonym\Components\Element\Element as ElementOrm;

    /**
     * Class Element
     * @package Anonym\Components\Facade
     */
    class Element
    {
        const TABLE = 'table';

        /**
         * Sınıfı başlatır
         */
        public function __construct()
        {
            $this->orm = new ElementOrm();
            $this->orm->setTable($this->findCalledClassTableVariable());
        }

        /**
         * Hangi sınıftan çağrıldığını arar
         *
         * @return mixed
         */
        private function findCalledClassTableVariable()
        {
            $class = get_called_class();
            $vars = get_class_vars($class);
            if (isset($vars[self::TABLE])) {
                return $vars[self::TABLE];
            }
        }

        /**
         * Static kullanım desteği
         *
         * @param       $method
         * @param array $params
         * @return mixed
         */
        public static function __callStatic($method, $params = [])
        {
            $instance = new static();

            return call_user_func_array([$instance->orm, $method], $params);
        }
    }
