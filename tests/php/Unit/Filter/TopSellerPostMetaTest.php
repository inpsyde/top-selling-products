<?php # -*- coding: utf-8 -*-

namespace Inpsyde\TopSellingProducts\Tests\Unit\Filter;

use Inpsyde\TopSellingProducts\Filter\TopSellerPostMeta as Testee;
use Inpsyde\TopSellingProducts\Tests\TestCase;

/**
 * Test case for the top seller post meta filter class.
 *
 * @package Inpsyde\TopSellingProducts\Tests\Unit\Filter
 * @since   1.0.0
 */
class TopSellerPostMetaTest extends TestCase {

	/**
	 * Tests filtering query arguments.
	 *
	 * @since  1.0.0
	 *
	 * @covers Inpsyde\TopSellingProducts\Filter\TopSellerPostMeta::__construct()
	 * @covers Inpsyde\TopSellingProducts\Filter\TopSellerPostMeta::filter_args()
	 *
	 * @return void
	 */
	public function test_filtering_args() {

		$args = [
			'some' => 'random',
			'args' => 'here',
		];

		$meta_key = 'some_meta_key';

		$expected_args = [
			'some'       => 'random',
			'args'       => 'here',
			'meta_query' => [
				[
					'key'     => $meta_key,
					'compare' => 'EXISTS',
				],
			],
		];

		$this->assertSame( $expected_args, ( new Testee( $meta_key ) )->filter_args( $args ) );
	}

	/**
	 * Tests filtering query arguments with a given meta value.
	 *
	 * @since  1.0.0
	 *
	 * @covers Inpsyde\TopSellingProducts\Filter\TopSellerPostMeta::__construct()
	 * @covers Inpsyde\TopSellingProducts\Filter\TopSellerPostMeta::filter_args()
	 *
	 * @return void
	 */
	public function test_filtering_args_with_meta_value() {

		$args = [
			'some' => 'random',
			'args' => 'here',
		];

		$meta_key = 'some_meta_key';

		$meta_value = 'some_meta_value';

		$expected_args = [
			'some'       => 'random',
			'args'       => 'here',
			'meta_query' => [
				[
					'key'   => $meta_key,
					'value' => $meta_value,
				],
			],
		];

		$this->assertSame( $expected_args, ( new Testee( $meta_key, $meta_value ) )->filter_args( $args ) );
	}

	/**
	 * Tests filtering query arguments that come with a meta query already.
	 *
	 * @since  1.0.0
	 *
	 * @covers Inpsyde\TopSellingProducts\Filter\TopSellerPostMeta::__construct()
	 * @covers Inpsyde\TopSellingProducts\Filter\TopSellerPostMeta::filter_args()
	 *
	 * @return void
	 */
	public function test_filtering_args_with_existing_meta_query() {

		$meta_query = [ 'some', 'meta', 'query' ];

		$args = [
			'some'       => 'random',
			'args'       => 'here',
			'meta_query' => $meta_query,
		];

		$meta_key = 'some_meta_key';

		$expected_args = [
			'some'       => 'random',
			'args'       => 'here',
			'meta_query' => [
				[
					'key'     => $meta_key,
					'compare' => 'EXISTS',
				],
				[ $meta_query ],
				'relation' => 'AND',
			],
		];

		$this->assertSame( $expected_args, ( new Testee( $meta_key ) )->filter_args( $args ) );
	}

	/**
	 * Tests filtering query arguments that come with a meta query already with a given meta value.
	 *
	 * @since  1.0.0
	 *
	 * @covers Inpsyde\TopSellingProducts\Filter\TopSellerPostMeta::__construct()
	 * @covers Inpsyde\TopSellingProducts\Filter\TopSellerPostMeta::filter_args()
	 *
	 * @return void
	 */
	public function test_filtering_args_with_existing_meta_query_and_meta_value() {

		$meta_query = [ 'some', 'meta', 'query' ];

		$args = [
			'some'       => 'random',
			'args'       => 'here',
			'meta_query' => $meta_query,
		];

		$meta_key = 'some_meta_key';

		$meta_value = 'some_meta_value';

		$expected_args = [
			'some'       => 'random',
			'args'       => 'here',
			'meta_query' => [
				[
					'key'   => $meta_key,
					'value' => $meta_value,
				],
				[ $meta_query ],
				'relation' => 'AND',
			],
		];

		$this->assertSame( $expected_args, ( new Testee( $meta_key, $meta_value ) )->filter_args( $args ) );
	}
}
