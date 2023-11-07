<?php

declare(strict_types=1);

namespace Framework;

use Exception;
use ReflectionClass, ReflectionNamedType;
use Framework\Exceptions\ContainerExceptions;

use function PHPSTORM_META\type;

class Container
{
    private array $definations = [];
    private array $resolved = [];
    public function addDefinations(array $newDefinations)
    {
        //$this->definations = array_merge($this->definations, $newDefinations);
        // upper functionaly can also be done by spread operator
        $this->definations = [...$this->definations, ...$newDefinations];
    }

    public function resolve(string $className)
    {
        $reflectionClass = new ReflectionClass($className);
        if (!$reflectionClass->isInstantiable()) {
            throw new ContainerExceptions("Class {$className} is not instaniable");
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
            $name = $param->getName();
            $type = $param->getType();
            if (!$type) {
                throw new ContainerExceptions("Failed to resolve class {$className} because param {$name} is missing type hint");
            }

            if (!$type instanceof ReflectionNamedType || $type->isBuiltin()) {
                throw new ContainerExceptions("Failed to resolve {$className} because invalid paran name");
            }

            $dependencies[] = $this->get($type->getName());
        }
        return $reflectionClass->newInstanceArgs($dependencies);
    }

    public function get(string $id)
    {
        if (!array_key_exists($id, $this->definations)) {
            throw new ContainerExceptions("Class {$id} does not exist in container");
        }
        if (array_key_exists($id, $this->resolved)) {
            return $this->resolved[$id];
        }
        $factory = $this->definations[$id];
        $dependency = $factory();

        $this->resolved[$id] = $dependency;
        return $dependency;
    }
}
