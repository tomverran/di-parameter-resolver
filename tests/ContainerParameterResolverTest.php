<?php
use TomVerran\AmbiguousParameterException;
use TomVerran\ContainerParameterResolver;

/**
 * Created by PhpStorm.
 * User: tom
 * Date: 07/02/15
 * Time: 23:42
 */

class ContainerParameterResolverTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ContainerParameterResolver
     */
    private $resolver;

    /**
     * Create a clean resolver for each test
     */
    public function setUp()
    {
        $myDodgyContainer = new \tomverran\di\Injector();
        $this->resolver = new ContainerParameterResolver( $myDodgyContainer );
    }

    /**
     * the simplest case,
     * do things work with no params?
     */
    public function testNoArgsFunction()
    {
        $this->assertEmpty( $this->resolver->resolveParameters( [] ) );
    }

    /**
     * With one default argument we should get back that argument
     */
    public function testWithDefaultArgument()
    {
        $params = ( new ReflectionFunction( function( $hello="world" ) {} ) )->getParameters();
        $this->assertEquals( ["world"], $this->resolver->resolveParameters( $params ) );
    }

    /**
     * This test is a bit dodgy as it calls the container
     * but yes, test that type hinted methods result in actual objects
     */
    public function testWithTypeHint()
    {
        $params = ( new ReflectionFunction( function( StdClass $hello ) {} ) )->getParameters();
        $resolved = $this->resolver->resolveParameters( $params );
        $this->assertInstanceOf(StdClass::class, array_shift( $resolved ) );
    }

    /**
     * Make sure ambiguous parameters get chucked back
     * @throws \TomVerran\AmbiguousParameterException
     */
    public function testUnResolvableParameters()
    {
        $this->setExpectedException( AmbiguousParameterException::class );
        $params = ( new ReflectionFunction( function( $hello ) {} ) )->getParameters();
        $this->resolver->resolveParameters( $params );
    }
} 