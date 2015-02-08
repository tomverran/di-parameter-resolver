<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 07/02/15
 * Time: 23:26
 */
namespace TomVerran;
use ReflectionParameter;

interface ParameterResolver
{
    /**
     * PARAMETER RESOLVER INTERFACE
     * -----------------------------
     *
     * Given a callable argument this method should return an array of parameters.
     * Typically this will involve the use of a dependency injection container
     * to instantiate any type hinted parameters and fill in default values.
     *
     * @param ReflectionParameter[] $parameters
     * @throws AmbiguousParameterException if a parameter cannot be resolved
     * @return array
     */
    public function resolveParameters( array $parameters );
} 