<?php

declare(strict_types=1);

namespace Framework;

use ReflectionClass, ReflectionNamedType;
use Framework\Exceptions\containerException;

class Container
{
    private array $definitions = [];
    private array $resolved = [];

    public function addDefinitions(array $newDefinitions)
    {
        // * 9.  Store the new Definition here
        $this->definitions = [...$this->definitions, ...$newDefinitions];
    }



    public function resolve(string $className)
    {
        // * 25. use the PHP reflectionclass for this section e.g if the user request is '/' the homecontroller class
        $reflectionClass = new ReflectionClass($className);

        // * 26. if the class is not instantiable (abstract class)
        if (!$reflectionClass->isInstantiable()) {
            throw new containerException("class {$className} is not Instantiable");
        }

        // * 27. invoke the getconstructor method of the reflection class if it has a constructor
        $constructor = $reflectionClass->getConstructor();

        // * 28. if it does not have a constructor
        if (!$constructor) {
            return new $className;
        }

        // * 29. if the class has a constructor get the parameters as array
        $params = $constructor->getParameters();

        // * 30. count if how many parameters are there if there are none, creat a new instance of the class
        if (count($params) === 0) {
            return new $className;
        }

        $dependencies = [];

        // * 31. loop thru each parameter of the class constructor e.g 
        foreach ($params as $param) {
            $name = $param->getname(); // * for homecontroller class, the param name is view
            $type = $param->getType(); // * for homecontroller class, the type name is TemplateEngine class
            // * 32. if type is not declared
            if (!$type) {
                throw new containerException("Failed to resolve class {$className}");
            }
            // * 33. if the type is not an instance of reflectionNamedType or is a built in PHP type
            if (!$type instanceof ReflectionNamedType || $type->isBuiltin()) {
                throw new containerException(("failed to validate"));
            }
            // * 34. invoke the get method of the container class and store the return value to dependencies array
            $dependencies[] = $this->get($type->getName());
        }
        // * 41. return the instance of a class with the instantiated classes as dependencies e.g (reflectionclass = homecontrollerClass) (dependencies = templateEngine/view)
        return $reflectionClass->newInstanceArgs($dependencies);
    }

    public function get(string $id)
    {
        // * 35. check if the passed class match with a definition in the definitions array e.g TemplateEngine
        if (!array_key_exists($id, $this->definitions)) {
            throw new containerException("Class ID does not exist in container");
        }
        // * 36. if it matched with a definition, check if there is already a class instantiated based on the resolved array
        if (array_key_exists($id, $this->resolved)) {
            return $this->resolved[$id];
        }

        // * 37. if not, store the function in a factory variable 
        $factory = $this->definitions[$id];
        // * 38. this dependency variable will store the invoked factory function
        $dependency = $factory();
        // * 39. store the dependency created in the resolved array with the id as key 
        $this->resolved[$id] = $dependency;
        // * 40. return the dependency
        return $dependency;
    }
}
