<?php

namespace App\Factory;

class Factory
{
    public static function getInstance($class, array $parameters = array())
    {
        if (empty($parameters)) {
            return new $class();
        }

        //return new $class(...$parameters);
        $input = '';
        foreach ($parameters as $id => $parameter) {
            $input .= sprintf('$parameters[%s],', $id);
        }

        $input = rtrim($input, ',');
        $results = eval(sprintf('return new %s(%s);', $class, $input));

        return $results;
    }
}