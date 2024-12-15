<?php declare( strict_types=1 );

namespace lloc\MslsTests;

use Brain\Monkey\Functions;
use lloc\Msls\MslsOptionsQueryAuthor;
use lloc\Msls\MslsSqlCacher;

final class TestMslsOptionsQueryAuthor extends MslsUnitTestCase {

	private function MslsOptionsQueryAuthorFactory( int $author_id ): MslsOptionsQueryAuthor {
		Functions\expect( 'get_option' )->once()->andReturn( array() );
		Functions\expect( 'get_queried_object_id' )->once()->andReturn( $author_id );

		$sql_cacher = \Mockery::mock( MslsSqlCacher::class );
		$sql_cacher->shouldReceive( 'prepare' )->andReturn( 'SQL Query String' );
		$sql_cacher->shouldReceive( 'get_var' )->andReturn( random_int( 1, 10 ) );

		return new MslsOptionsQueryAuthor( $sql_cacher );
	}

	public function test_has_value_true(): void {
		$this->assertTrue( $this->MslsOptionsQueryAuthorFactory( 17 )->has_value( 'de_DE' ) );
	}

	public function test_has_value_false(): void {
		$this->assertFalse( $this->MslsOptionsQueryAuthorFactory( 0 )->has_value( 'de_DE' ) );
	}

	public function test_get_current_link_method(): void {
		Functions\expect( 'get_author_posts_url' )->once()->andReturn( 'https://msls.co/queried-author' );

		$this->assertEquals( 'https://msls.co/queried-author', $this->MslsOptionsQueryAuthorFactory( 42 )->get_current_link() );
	}
}
