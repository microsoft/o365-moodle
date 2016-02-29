<?php

namespace local_o365\tests;

trait testableobjecttrait {
        /**
         * Magic method run protected/private methods.
         *
         * @param string $name The called method name.
         * @param array $arguments Array of arguments.
         */
        public function __call($name, $arguments) {
                if (method_exists($this, $name)) {
                        return call_user_func_array([$this, $name], $arguments);
                }
        }

        /**
         * Magic method run protected/private static methods.
         *
         * @param string $name The called method name.
         * @param array $arguments Array of arguments.
         */
        public static function __callStatic($name, $arguments) {
                $class = get_called_class();
                if (method_exists($class, $name)) {
                        return forward_static_call_array([$class, $name], $arguments);
                }
        }

        /**
         * Magic isset function inspect protected/private properties.
         *
         * @param string $name The name of the property.
         * @return bool Whether the property is set.
         */
        public function __isset($name) {
                return (isset($this->$name)) ? true : false;
        }

        /**
         * Magic unset function to unset protected/private properties.
         *
         * @param string $name The name property to unset.
         */
        public function __unset($name) {
                if (isset($this->$name)) {
                        unset($this->$name);
                }
        }

        /**
         * Get the value of a protected/private property.
         *
         * @param string $name The name of the property.
         * @return mixed The value.
         */
        public function __get($name) {
                return (isset($this->$name)) ? $this->$name : false;
        }

        /**
         * Set the value of a protected/private property.
         *
         * @param string $name The name of the property.
         * @param mixed $val The value to set.
         */
        public function __set($name, $val) {
                $this->$name = $val;
        }
}
