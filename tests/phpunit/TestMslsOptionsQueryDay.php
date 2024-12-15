<?php declare( strict_types=1 );

namespace lloc\MslsTests;

use Brain\Monkey\Functions;
use lloc\Msls\MslsOptionsQueryDay;
use lloc\Msls\MslsSqlCacher;

final class TestMslsOptionsQueryDay extends MslsUnitTestCase {

	private function MslsOptionsQueryDayFactory( int $year, int $monthnum, int $day ): MslsOptionsQueryDay {
		parent::setUp();

		Functions\expect( 'get_option' )->once()->andReturn( array() );
		Functions\expect( 'get_query_var' )->times( 3 )->andReturn( $year, $monthnum, $day );

		$sql_cacher = \Mockery::mock( MslsSqlCacher::class );
		$sql_cacher->shouldReceive( 'prepare' )->andReturn( 'SQL Query String' );
		$sql_cacher->shouldReceive( 'get_var' )->andReturn( random_int( 1, 10 ) );

		return new MslsOptionsQueryDay( $sql_cacher );
	}

	public function test_has_value_true(): void {
		$this->assertTrue( $this->MslsOptionsQueryDayFactory( 1998, 12, 31 )->has_value( 'de_DE' ) );
	}

	public function test_has_value(): void {
		$this->assertFalse( $this->MslsOptionsQueryDayFactory( 0, 0, 0 )->has_value( 'de_DE' ) );
	}

	public function test_get_current_link(): void {
		Functions\expect( 'get_day_link' )->once()->andReturn( 'https://msls.co/queried-day' );

		$this->assertEquals( 'https://msls.co/queried-day', $this->MslsOptionsQueryDayFactory( 2015, 07, 02 )->get_current_link() );
	}
}
