# Top Selling Products

[![Latest Stable Version](https://poser.pugx.org/inpsyde/top-selling-products/version)](https://packagist.org/packages/inpsyde/top-selling-products)
[![Project Status](http://opensource.box.com/badges/active.svg)](http://opensource.box.com/badges)
[![Build Status](https://travis-ci.org/inpsyde/top-selling-products.svg?branch=master)](http://travis-ci.org/inpsyde/top-selling-products)
[![Total Downloads](https://poser.pugx.org/inpsyde/top-selling-products/downloads)](https://packagist.org/packages/inpsyde/top-selling-products)
[![License](https://poser.pugx.org/inpsyde/top-selling-products/license)](https://packagist.org/packages/inpsyde/top-selling-products)

> Lightweight package providing a pre-configured, yet filterable `WP_Query` extension for top selling products.

## Introduction

This package comes with a `WP_Query` extension that allows for querying _top selling_ products.
By default, there is **no** definition as to when a product is a top seller, though.
This can either be done by passing according query arguments, or filtering the given or default ones.

## Installation

```
$ composer require inpsyde/top-selling-products:~1.0
```

Run the tests:

```
$ vendor/bin/phpunit
```

### Requirements

This package requires PHP 5.4 or higher.

## Usage

### Filters

#### `inpsyde_top_selling_products.query_args`

This hook allows to filter the query arguments.

**Arguments:**

- `array` `$args`: Query arguments.

```php
<?php

add_filter( 'inpsyde_top_selling_products.query_args' , function( array $args ) {

	// Randomize the results, but exclude posts with specific IDs. 
	return array_merge( $args, [
		'post__not_in' => [ 4, 8, 15, 16, 23, 42 ],
		'orderby'      => 'rand',
	] );
} );
```

## License

Copyright (c) 2016 Inpsyde GmbH, Thorsten Frommen

This code is licensed under this [License](LICENSE).
