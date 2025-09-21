<?php

namespace App\Core;

use App\Core\Exceptions\ContainerException;
use Psr\Container\ContainerInterface;

/**
 * Container de injeção de dependências simples.
 */
class Container implements ContainerInterface
{
    private array $entries = [];

    public function get(string $id): mixed
    {
        if ($this->has($id)) {
            $entry = $this->entries[$id];
            if (is_callable($entry)) {
                return $entry($this);
            } 
            $id = $entry;
        }
        return $this->resolve($id);
    }

    public function set(string $id, callable|string $concrete): void
    {
        $this->entries[$id] = $concrete;
    }
    
    public function has(string $id): bool
    {
        return isset($this->entries[$id]);
    }

    public function resolve(string $id): mixed
    {
        $reflectionClass = new \ReflectionClass($id);

        if (! $reflectionClass->isInstantiable()) {
            throw new ContainerException("Class $id is not instantiable.");
        }

        $constructor = $reflectionClass->getConstructor();

        if (! $constructor) { return new $id; }

        $parameters = $constructor->getParameters();

        if (! $parameters) { return new $id; }

        $dependencies = array_map(function (\ReflectionParameter $param) use ($id) {
            $name = $param->getName();
            $type = $param->getType();

            if (!$type) {
                throw new ContainerException("Parameter $name in class $id has no type hint.");
            }

            if ($type instanceof \ReflectionUnionType) {
                throw new ContainerException("Parameter $name in class $id has a union type hint, which is not supported.");
            }

            if ($type instanceof \ReflectionNamedType && !$type->isBuiltin()) {
                return $this->get($type->getName());
            }

            throw new ContainerException("Parameter $name in class $id has an unsupported type hint");
        }, $parameters);

        return $reflectionClass->newInstanceArgs($dependencies);
    }
}