<?php # -*- coding: utf-8 -*-

namespace Inpsyde\TopSellingProducts\Tests\Unit\Query\Product;

use Brain\Monkey;
use Inpsyde\TopSellingProducts\Query\Product\TopSeller as Testee;
use Inpsyde\TopSellingProducts\Tests\TestCase;
use Mockery;

/**
 * Test case for the top seller query class.
 *
 * @package Inpsyde\TopSellingProducts\Tests\Unit\Query\Product
 * @since   1.0.0
 */
class TopSellerTest extends TestCase {

	/**
	 * Tests an object with the expected arguments is instantiated.
	 *
	 * @since  1.0.0
	 *
	 * @covers Inpsyde\TopSellingProducts\Query\Product\TopSeller::__construct()
	 *
	 * @return void
	 */
	public function test_construction() {

		Monkey::filters()
			->expectApplied( Testee::QUERY_ARGS_FILTER )
			->once()
			->with( [
				'post_type'           => 'product',
				'post_status'         => 'publish',
				'posts_per_page'      => 12,
				'ignore_sticky_posts' => true,
				'orderby'             => 'modified',
				'no_found_rows'       => true,
			] );

		$testee = new Testee();

		$this->assertTrue( is_subclass_of( $testee, 'WP_Query' ) );
	}

	/**
	 * Tests an object with the expected arguments is instantiated.
	 *
	 * @since  1.0.0
	 *
	 * @covers Inpsyde\TopSellingProducts\Query\Product\TopSeller::__construct()
	 *
	 * @return void
	 */
	public function test_construction_with_args() {

		Monkey::filters()
			->expectApplied( Testee::QUERY_ARGS_FILTER )
			->once()
			->with( [
				'post_type'           => 'other',
				'post_status'         => 'publish',
				'posts_per_page'      => 12,
				'ignore_sticky_posts' => true,
				'orderby'             => 'modified',
				'no_found_rows'       => true,
				'extra'               => 'value',
			] );

		new Testee( [
			'post_type' => 'other',
			'extra'     => 'value',
		] );
	}

	/**
	 * Tests an object with the expected arguments is instantiated, and the given filter is being used.
	 *
	 * @since  1.0.0
	 *
	 * @covers Inpsyde\TopSellingProducts\Query\Product\TopSeller::__construct()
	 *
	 * @return void
	 */
	public function test_construction_with_filter() {

		$filtered_args = [ 'some', 'filtered', 'args' ];

		$filter = Mockery::mock( 'Inpsyde\TopSellingProducts\Common\Filter' );
		$filter->shouldReceive( 'filter_args' )
			->once()
			->with( [
				'post_type'           => 'product',
				'post_status'         => 'publish',
				'posts_per_page'      => 12,
				'ignore_sticky_posts' => true,
				'orderby'             => 'modified',
				'no_found_rows'       => true,
			] )
			->andReturn( $filtered_args );

		Monkey::filters()
			->expectApplied( Testee::QUERY_ARGS_FILTER )
			->once()
			->with( $filtered_args );

		new Testee( [], $filter );
	}
}
