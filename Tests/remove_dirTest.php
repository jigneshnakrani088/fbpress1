<?php

class remove_dirTest extends PHPUnit_Framework_TestCase {

    protected $remove_dir;
    function testrrmdir()
	{
		$directory = rand(111,11111);
		//-- create dummy directory with a file 
		try{
			mkdir($directory);
			$a=$directory."/a.txt";
			$f=fopen($a,"w");
			fclose($f);
		}catch(Exception $e)
		{
			echo "Exist";
		}
		//-- act to remove dir
        $this->remove_dir = new remove_dir();
    	$actual = $this->remove_dir->rrmdir( $directory );
       	$this->assertEquals( $actual, $actual );
    }
}

?>
