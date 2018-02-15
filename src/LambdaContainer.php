<?php
// Lightweight class to register lamda functions to a global container.
// Lamda functions could typically be used to construct objects complete with dependencies ready for DI

final class LambdaContainer
{
    private static $registry = array();

    public static function register($name, $lambda)
    {
        if (!class_exists($name) || !is_callable($lambda)) {
            throw new \InvalidArgumentException('Invalid arguments in call to Container::register');
        }
        self::$registry[$name] = $lambda;
    }

    public static function get($name)
    {
        if (!class_exists($name)) {
            throw new \InvalidArgumentException('Invalid class in call to Container::get');
        }

        if (!array_key_exists($name, self::$registry)) {
            throw new \Exception($name . ' has not been registered');
        }
        $lambda = self::$registry[$name];
        return $lambda();
    }

    public static function clear($name)
    {
        if(isset(self::$registry[$name])) {
            unset(self::$registry[$name]);
        }
    }
}
