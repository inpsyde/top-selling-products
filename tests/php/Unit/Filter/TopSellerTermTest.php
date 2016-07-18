<?php # -*- coding: utf-8 -*-

namespace Inpsyde\TopSellingProducts\Tests\Unit\Filter;

use Brain\Monkey;
use Inpsyde\TopSellingProducts\Filter\TopSellerTerm as Testee;
use Inpsyde\TopSellingProducts\Tests\TestCase;

/**
 * Test case for the top seller term filter class.
 *
 * @package Inpsyde\TopSellingProducts\Tests\Unit\Filter
 * @since   1.0.0
 */
class TopSellerTermTest extends TestCase {

	/**
	 * Tests filtering query arguments fails silently if the filter was instantiated with an invalid taxonomy.
	 *
	 * @since  1.0.0
	 *
	 * @covers Inpsyde\TopSellingProducts\Filter\TopSellerTerm::__construct()
	 * @covers Inpsyde\TopSellingProducts\Filter\TopSellerTerm::filter_args()
	 *
	 * @return void
	 */
	public function test_filtering_args_fails_silently_in_case_of_invalid_taxonomy() {

		$args = [ 'some', 'args', 'here' ];

		Monkey::functions()
			->when( 'taxonomy_exists' )
			->justReturn( false );

		$this->assertSame( $args, ( new Testee( null, null ) )->filter_args( $args ) );
	}

	/**
	 * Tests filtering query arguments fails silently if the filter was instantiated with an invalid term.
	 *
	 * @since  1.0.0
	 *
	 * @covers Inpsyde\TopSellingProducts\Filter\TopSellerTerm::__construct()
	 * @covers Inpsyde\TopSellingProducts\Filter\TopSellerTerm::filter_args()
	 *
	 * @return void
	 */
	public function test_filtering_args_fails_silently_in_case_of_invalid_term() {

		$args = [ 'some', 'args', 'here' ];

		Monkey::functions()
			->when( 'taxonomy_exists' )
			->justReturn( true );

		Monkey::functions()
			->when( 'term_exists' )
			->justReturn( false );

		$this->assertSame( $args, ( new Testee( null, null ) )->filter_args( $args ) );
	}

	/**
	 * Tests filtering query arguments.
	 *
	 * @since  1.0.0
	 *
	 * @covers Inpsyde\TopSellingProducts\Filter\TopSellerTerm::__construct()
	 * @covers Inpsyde\TopSellingProducts\Filter\TopSellerTerm::filter_args()
	 *
	 * @return void
	 */
	public function test_filtering_args() {

		$args = [
			'some' => 'random',
			'args' => 'here',
		];

		Monkey::functions()
			->when( 'taxonomy_exists' )
			->justReturn( true );

		Monkey::functions()
			->when( 'term_exists' )
			->justReturn( true );

		$taxonomy = 'some_taxonomy_here';

		$term = 'some_term_here';

		$expected_args = [
			'some'      => 'random',
			'args'      => 'here',
			'tax_query' => [
				[
					'taxonomy' => $taxonomy,
					'field'    => 'slug',
					'terms'    => $term,
				],
			],
		];

		$this->assertSame( $expected_args, ( new Testee( $taxonomy, $term ) )->filter_args( $args ) );
	}

	/**
	 * Tests filtering query arguments that come with a tax query already.
	 *
	 * @since  1.0.0
	 *
	 * @covers Inpsyde\TopSellingProducts\Filter\TopSellerTerm::__construct()
	 * @covers Inpsyde\TopSellingProducts\Filter\TopSellerTerm::filter_args()
	 *
	 * @return void
	 */
	public function test_filtering_args_with_existing_tax_query() {

		$tax_query = [ 'some', 'tax', 'query' ];

		$args = [
			'some'      => 'random',
			'args'      => 'here',
			'tax_query' => $tax_query,
		];

		Monkey::functions()
			->when( 'taxonomy_exists' )
			->justReturn( true );

		Monkey::functions()
			->when( 'term_exists' )
			->justReturn( true );

		$taxonomy = 'some_taxonomy_here';

		$term = 'some_term_here';

		$expected_args = [
			'some'      => 'random',
			'args'      => 'here',
			'tax_query' => [
				[
					'taxonomy' => $taxonomy,
					'field'    => 'slug',
					'terms'    => $term,
				],
				[ $tax_query ],
				'relation' => 'AND',
			],
		];

		$this->assertSame( $expected_args, ( new Testee( $taxonomy, $term ) )->filter_args( $args ) );
	}
}
