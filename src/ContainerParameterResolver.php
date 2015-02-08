<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 07/02/15
 * Time: 23:28
 */

namespace TomVerran;
use Interop\Container\ContainerInterface;
use ReflectionParameter;

/**
 * This implementation of the ParameterResolver interface
 * uses a ContainerInterface to instantiate any object parameters.
 *
 * Ideally dependency injection containers would provide their own parameter resolvers
 * to ensure that the behaviour is consistent - e.g. any proprietary docblock annotations are used
 *
 * Class ContainerParameterResolver
 * @package TomVerran
 */
class ContainerParameterResolver implements ParameterResolver
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Construct this class
     * @param ContainerInterface $container
     */
    public function __construct( ContainerInterface $container )
    {
        $this->container = $container;
    }

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
    public function resolveParameters( array $parameters )
    {
        $arguments = [];
        foreach ( $parameters as $parameter ) {

            if ( $parameter->getClass() ) {
                $arguments[] = $this->container->get( $parameter->getClass() );
            } else if ( $parameter->isDefaultValueAvailable() ) {
                $arguments[] = $parameter->getDefaultValue();
            } else {
                throw new AmbiguousParameterException;
            }
        }

        return $arguments;
    }
}