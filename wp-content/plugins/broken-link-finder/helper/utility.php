<?php 

function moblc_relative_to_absolute($rel,$base){
	$parse_base = 	parse_url( $base );
	$scheme 	=	$parse_base['scheme'];
	$host 		= 	$parse_base['host'];
	$path		=	$parse_base['path'];

	if ( strpos( $rel,"//" ) === 0 ) {
	return $scheme . ':' . $rel;
	}

	if ( parse_url( $rel, PHP_URL_SCHEME ) != '' ) {
	return $rel;
	}

	if ( $rel[0] == '#' || $rel[0] == '?' ) {
	return $base . $rel;
	}

	$path = preg_replace( '#/[^/]*$#', '', $path );

	if ( $rel[0] == '/' ) {
	$path = '';
	}
	$abs = "$host$path/$rel";
	$abs = preg_replace( "[(/\.?/)]", "/", $abs );
	$abs = preg_replace( "[\/(?!\.\.)[^\/]+\/(\.\.\/)+]", "/", $abs );

	return $scheme . '://' . $abs;
}

function moblc_is_curl_installed()
{
	if  (in_array  ('curl', get_loaded_extensions()))
		return 1;
	else 
		return 0;
}