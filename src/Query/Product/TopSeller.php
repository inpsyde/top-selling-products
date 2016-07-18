<?php # -*- coding: utf-8 -*-

namespace Inpsyde\TopSellingProducts\Query\Product;

use Inpsyde\TopSellingProducts\Common\Filter;
use WP_Query;

/**
 * Filterable pre-configured query implementation.
 *
 * @package Inpsyde\TopSellingProducts\Query\Product
 * @since   1.0.0
 */
class TopSeller extends WP_Query {

	/**
	 * Hook name of the query arguments filter.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	const QUERY_ARGS_FILTER = 'inpsyde_top_selling_products.query_args';

	/**
	 * Constructor. Sets up the properties.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $args   Optional. Query arguments. Defaults to empty array.
	 * @param Filter $filter Optional. Query arguments filter object. Defaults to null.
	 */
	public function __construct( array $args = [], Filter $filter = null ) {

		$args = array_merge( [
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'posts_per_page'      => 12,
			'ignore_sticky_posts' => true,
			'orderby'             => 'modified',
			'no_found_rows'       => true,
		], $args );

		if ( $filter ) {
			$args = $filter->filter_args( $args );
		}

		/**
		 * Filters the query arguments.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args Query arguments.
		 */
		$args = (array) apply_filters( self::QUERY_ARGS_FILTER, $args );

		parent::__construct( $args );
	}
}
