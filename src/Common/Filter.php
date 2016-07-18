<?php # -*- coding: utf-8 -*-

namespace Inpsyde\TopSellingProducts\Common;

/**
 * Interface for all query arguments filter implementations.
 *
 * @package Inpsyde\TopSellingProducts\Common
 * @since   1.0.0
 */
interface Filter {

	/**
	 * Filters the given query arguments to make is specific to top selling products only.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args Query arguments.
	 *
	 * @return array Filtered query arguments.
	 */
	public function filter_args( array $args );
}
