# TRBL WP REST API

This plugin exposes endpoints that simplify and add consistency to the variety of post formats that can be returned from the default WordPress REST API. It's meant to be used alongside of WordPress sites that heavily utilize Advanced Custom Fields.

The default WP API sends back posts in a format that departs from the typical `WP_Post` object structure.  But, when using ACF Relationship or Post Object field types, you will be sent nested vanilla `WP_Post` objects within the full REST API response, meaning the consumer of the data needs to be able to handle multiple types of incoming data—_neither of which being ideal formats_, and including a lot of extra data that can bloat response payloads.

## New Endpoints

Endpoints are exposed in three formats:

### Get One - `/wp-json/trbl-rest/v1/[post-type]/[id]`

This endpoint is used to query a single post by post type and post `ID` or entire `path`, including parents or permalink rewrites. This route takes no query parameters and will either return a single matched post or a response coded 404 with an error message. 

`Get One` endpoints are registered for post types assigned to the `enabled_endpoints` option on the `TRBL REST API Settings` page.

For example, to find a page with ID of `2`, you would use `/wp-json/trbl-rest/v1/pages/2`. To find a page with a full path of `/company/leadership`, you would use `/wp-json/trbl-rest/v1/pages/company/leadership`.

### Get Many `/wp-json/trbl-rest/v1/[post-type]`

This route is meant to search a specific post type. As with the `/[post-type]/[id]` endpoint above, endpoints are registered according to the `enabled_endpoints` option.

**Supported query parameters:**

1. `slug` - useful for searching for posts by its individual `post_name`. Example: `slug=home`
1. `term` - accepts an array-notated list of terms with comma-delineated term IDs. Example: `term[project-type]=142,34,123` 
1. `s` - accepts a string to search post title and specific meta values as defined by the theme. `Example: `s=search phrase goes here`
1. `per_page` - specify how many posts should be returned per page. Defaults to 10. Example: `per_page=5`
1. `offset` - specify how many posts should be "skipped over" which is useful to get a specific "page" of results. Example: `offset=10`.
1. `exclude` - identify one or many comma-delineated post IDs to exclude from results. Example: `exclude=1,23,235` 

### Query - `/wp-json/trbl-rest/v1/query`

This is a highly queryable endpoint meant to return data on any post type that is assigned to the `searchable_post_types` option on the `TRBL REST API Settings` page.

**Supported query parameters:**

1. `post-type` - accepts a comma-delineated list of post-types to be queried. Example: `post-type=project,resource,service,post` 
1. `slug` - see above
1. `term` - see above
1. `s` - see above
1. `per_page` - see above
1. `offset` - see above
1. `exclude` - see above

## Filters

There are three filters available to customize this plugin at this time.  

#### Query Arguments - `trbl_rest_api/query_args` 

This filter is handy if you want to customize the `query` interface of the `GetMany` and `Query` endpoints.

It's also helpful if needing to customize what meta values are searched via the `s` query parameter available to the `Query` and `GetMany` endpoints.

Example:

```php
<?php
 
function my_trbl_query_filter( $request, $args ) {

	// Allow ordering results
	if (isset($request['order'])) {
		$args['order'] = $request['order'];
	}

	// Add metaDescription to the values searched by "s" query param
	if ($args['_meta_or_title']) {
		$args['meta_query']['relation'] = 'OR';
		$args['meta_query'][0]['key'] = 'metaDescription';
	}
	
	return $args;
}

add_filter('trbl_rest_api/query_args', 'my_trbl_query_filter', 10, 2);
 
?>
```

#### Full Post Output - `trbl_rest_api/get_full_post` 

You can customize what is output when a full post is retrieved and prepared by this API. 

Example:

```php
<?php
 
function my_trbl_full_post_filter( $post ) {
	$post->customProperty = 'this is cool'; 
	return $post;
}

add_filter('trbl_rest_api/get_full_post', 'my_trbl_full_post_filter', 10, 1);
 
?>
```
#### Essentials Post Output - `trbl_rest_api/get_essentials` 

Similarly to customizing full posts as seen above, you can also customize what is sent in the minimal, essential post output. Posts are sent with only essentials if they are referenced via ACF Relationships or Post Object field types.

Example:

```php
<?php
 
function my_trbl_essentials_post_filter( $post ) {
	$post->customProperty = 'this is cool'; 
	return $post;
}

add_filter('trbl_rest_api/get_essentials', 'my_trbl_essentials_post_filter', 10, 1);
 
?>
```
