<?php
namespace TomVerran;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Interop\Container\Exception\NotFoundException;

class MockContainer implements ContainerInterface
{
    private $mappings = [];

    /**
     * Construct this mock container
     * @param $mappings
     */
    public function __construct( $mappings )
    {
        $this->mappings = $mappings;
    }

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @throws \Exception
     * @return mixed Entry.
     */
    public function get( $id )
    {
        if ( !$this->has( $id ) ) {
            throw new \Exception( 'No mapping for ' . $id );
        }
        return new $this->mappings[$id];
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return boolean
     */
    public function has( $id )
    {
        return isset( $this->mappings[$id] );
    }
}