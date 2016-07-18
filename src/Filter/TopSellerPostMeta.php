<?php # -*- coding: utf-8 -*-

namespace Inpsyde\TopSellingProducts\Filter;

use Inpsyde\TopSellingProducts\Common\Filter;

/**
 * Query arguments filter implementation using a meta query with given meta name and optional value.
 *
 * @package Inpsyde\TopSellingProducts\Filter
 * @since   1.0.0
 */
class TopSellerPostMeta implements Filter {

	/**
	 * @var string
	 */
	private $meta_key;

	/**
	 * @var string|null
	 */
	private $meta_value;

	/**
	 * Constructor. Sets up the properties.
	 *
	 * @since 1.0.0
	 *
	 * @param string $meta_key   Post meta key.
	 * @param string $meta_value Optional. Post meta value. Defaults to null.
	 */
	public function __construct( $meta_key, $meta_value = null ) {

		$this->meta_key = (string) $meta_key;

		if ( isset( $meta_value ) ) {
			$this->meta_value = (string) $meta_value;
		}
	}

	/**
	 * Adds a meta query with the defined meta key and optional meta value to the given query arguments.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args Query arguments.
	 *
	 * @return array Filtered query arguments.
	 */
	public function filter_args( array $args ) {

		$meta_query = [
			[
				'key' => $this->meta_key,
			],
		];

		if ( null === $this->meta_value ) {
			$meta_query[0]['compare'] = 'EXISTS';
		} else {
			$meta_query[0]['value'] = $this->meta_value;
		}

		if ( ! empty( $args['meta_query'] ) ) {
			$meta_query[] = [ $args['meta_query'] ];

			$meta_query['relation'] = 'AND';
		}

		$args['meta_query'] = $meta_query;

		return $args;
	}
}
