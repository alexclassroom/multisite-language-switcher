<?php declare( strict_types=1 );

namespace lloc\MslsTests;

use lloc\Msls\MslsLanguageArray;

final class TestMslsLanguageArray extends MslsUnitTestCase {

	private function MslsLanguageArrayFactory(): MslsLanguageArray {
		$arr = array(
			'fr_FR' => 0, // not ok, value 0 is not ok as blog_id
			'it'    => 1,
			'de_DE' => 2,
			'x'     => 3, // not ok, minlength of string is 2
		);

		return new MslsLanguageArray( $arr );
	}

	public function test_get_val(): void {
		$obj = $this->MslsLanguageArrayFactory();

		$this->assertEquals( 1, $obj->get_val( 'it' ) );
		$this->assertEquals( 0, $obj->get_val( 'fr_FR' ) );
	}

	public function test_get_arr(): void {
		$obj = $this->MslsLanguageArrayFactory();

		$this->assertEquals(
			array(
				'it'    => 1,
				'de_DE' => 2,
			),
			$obj->get_arr()
		);
		$this->assertEquals( array( 'it' => 1 ), $obj->get_arr( 'de_DE' ) );
	}

	public function test_set(): void {
		$obj = $this->MslsLanguageArrayFactory();

		$this->assertEquals(
			array(
				'it'    => 1,
				'de_DE' => 2,
			),
			$obj->get_arr()
		);
		$obj->set( 'fr_FR', 3 );
		$this->assertEquals(
			array(
				'it'    => 1,
				'de_DE' => 2,
				'fr_FR' => 3,
			),
			$obj->get_arr()
		);
	}
}
