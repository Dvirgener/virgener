<?php

declare(strict_types=1);

namespace Framework;

use ReflectionClass, ReflectionNamedType;
use Framework\Exceptions\containerException;

class Container
{
    private array $definitions = [];

    public function addDefinitions(array $newDefinitions)
    {
        // * 5  Store the new Definition here
        $this->definitions = [...$this->definitions, ...$newDefinitions];
    }



    public function resolve(string $className)
    {
        // * 15 use the PHP reflectionclass for this section
        $reflectionClass = new ReflectionClass($className);

        // * 16 if the class is not instantiable (abstract class)
        if (!$reflectionClass->isInstantiable()) {
            throw new containerException("class {$className} is not Instantiable");
        }

        // * 17 invoke the getconstructor method of the reflection class if it has a constructor
        $constructor = $reflectionClass->getConstructor();

        // * 18 if it does not have a constructor
        if (!$constructor) {
            return new $className;
        }

        // * 19 if the class has a constructor get the parameters as array
        $params = $constructor->getParameters();

        // * 20 count if how many parameters are there if there are none, creat a new instance of the class
        if (count($params) === 0) {
            return new $className;
        }

        $dependencies = [];

        // * 21 loop thru each parameter of the class constructor
        foreach ($params as $param) {
            $name = $param->getname();
            $type = $param->getType();

            // * 22 if type is not declared
            if (!$type) {
                throw new containerException("Failed to resolve class {$className}");
            }

            // * 23 if the type is not an instance of reflectionNamedType or is a built in PHP type
            if (!$type instanceof ReflectionNamedType || $type->isBuiltin()) {
                throw new containerException(("failed to validate"));
            }

            // * 24 invoke the get method of the container class
            // dd($type->getName());
            $dependencies[] = $this->get($type->getName());
        }



        return $reflectionClass->newInstanceArgs($dependencies);
    }

    public function get(string $id)
    {

        if (!array_key_exists($id, $this->definitions)) {
            throw new containerException("Class ID does not exist in container");
        }
        $factory = $this->definitions[$id];

        $dependency = $factory();


        return $dependency;
    }
}
