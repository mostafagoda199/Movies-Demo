<?php

namespace App\Domain\DTO;

use ReflectionClass;
use ReflectionProperty;

abstract class DataTransferObject
{
    /**
     * DataTransferObject constructor.
     * @param array $parameters
     * @auther Mustafa Goda
     */
    public function __construct(array $parameters = [])
    {
        $class = new ReflectionClass(static::class);
        foreach ($class->getProperties(ReflectionProperty::IS_PUBLIC) as $reflectionProperty) {
            $property = $reflectionProperty->getName();
            $this->{$property} = $parameters[$property];
        }
    }

    /**
     * @param $request
     * @return static
     * @auther Mustafa Goda
     */
    abstract public static function fromRequest($request) : self;
}
