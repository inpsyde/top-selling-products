<?php # -*- coding: utf-8 -*-

namespace Inpsyde\TopSellingProducts\Filter;

use Inpsyde\TopSellingProducts\Common\Filter;

/**
 * Query arguments filter implementation using a tax query with given taxonomy and term.
 *
 * @package Inpsyde\TopSellingProducts\Filter
 * @since   1.0.0
 */
class TopSellerTerm implements Filter {

	/**
	 * @var string
	 */
	private $taxonomy;

	/**
	 * @var string
	 */
	private $term;

	/**
	 * Constructor. Sets up the properties.
	 *
	 * @since 1.0.0
	 *
	 * @param string $taxonomy Taxonomy name.
	 * @param string $term     Term name.
	 */
	public function __construct( $taxonomy, $term ) {

		$this->taxonomy = (string) $taxonomy;

		$this->term = (string) $term;
	}

	/**
	 * Adds a tax query with the defined taxonomy and term to the given query arguments.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args Query arguments.
	 *
	 * @return array Filtered query arguments.
	 */
	public function filter_args( array $args ) {

		if ( ! taxonomy_exists( $this->taxonomy ) ) {
			return $args;
		}

		if ( ! term_exists( $this->term, $this->taxonomy ) ) {
			return $args;
		}

		$tax_query = [
			[
				'taxonomy' => $this->taxonomy,
				'field'    => 'slug',
				'terms'    => $this->term,
			],
		];
		if ( ! empty( $args['tax_query'] ) ) {
			$tax_query[] = [ $args['tax_query'] ];

			$tax_query['relation'] = 'AND';
		}

		$args['tax_query'] = $tax_query;

		return $args;
	}
}
