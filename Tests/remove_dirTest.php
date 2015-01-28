
<?php

class remove_dirTest extends PHPUnit_Framework_TestCase {

    protected $remove_dir;

    protected function setUp() {
        $this->remove_dir = new remove_dir();
    }

    function testrrmdir( $dir = null ) {
        $actual = $this->remove_dir->rrmdir( $directory );
        $this->assertEquals( $actual, $actual );
    }

    protected function tearDown() {
        unset( $this->remove_dir );
    }

}

?>
