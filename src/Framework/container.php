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

        $this->definitions = [...$this->definitions, ...$newDefinitions];
    }

    public function resolve(string $className)
    {
        $reflectionClass = new ReflectionClass($className);

        if (!$reflectionClass->isInstantiable()) {
            throw new containerException("class {$className} is not Instantiable");
        }

        $constructor = $reflectionClass->getConstructor();

        if (!$constructor) {
            return new $className;
        }

        $params = $constructor->getParameters();

        if (count($params) === 0) {
            return new $className;
        }

        $dependencies = [];

        foreach ($params as $param) {
            $name = $param->getname();
            $type = $param->getType();

            if (!$type) {
                throw new containerException("Failed to resolve class {$className}");
            }

            if (!$type instanceof ReflectionNamedType || $type->isBuiltin()) {
                throw new containerException(("failed to validate"));
            }

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
