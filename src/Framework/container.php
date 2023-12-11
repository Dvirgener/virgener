<?php

declare (strict_types=1);

namespace Framework;

use ReflectionClass;
use Framework\Exceptions\ContainerExceptions;

class Container{

    private array $definitions = [];

    public function addDefinitions (array $newDefinitions){

        $this->definitions = [...$this->definitions, ...$newDefinitions];

    }

    public function resolve(string $className){
        $reflectionClass = new ReflectionClass($className);

        if (!$reflectionClass->isInstantiable()){
            throw new ContainerExceptions("Class {$className} name is not Instantiable!");
        }
        dd($reflectionClass);
    }

}