<?php

// Get the full URL
function getUrl() {
	$url  = @( $_SERVER["HTTPS"] != 'on' ) ? 'http://'.$_SERVER["SERVER_NAME"] :  'https://'.$_SERVER["SERVER_NAME"];
	$url .= ( $_SERVER["SERVER_PORT"] !== 80 ) ? ":".$_SERVER["SERVER_PORT"] : "";
	$url .= $_SERVER["REQUEST_URI"];
	return $url;
}

// Common vars
$key = 'dddc509eae7e564414b6efa436aaffc1';
$url = getUrl();
@$genre = $_GET['with_genres'];
@$year = $_GET['search_year'];
@$movie_id = $_GET['movie_id'];
@$param_page = $_GET['page'];
@$search_name = $_GET['search_name'];
@$search_name_encoded = rawurlencode($search_name);
@$page = 1;
@$next_page = $page + 1;
@$prev_page = $page - 1;

// If url has no params
if( !strpos($url, '=') ) {
	$url = ''.$url.'?'; // add trailing ?
}

// Pagination URLs
$next = ''.$url.'&page='.$next_page.'';
$prev = ''.$url.'&page='.$prev_page.'';

// If not on 1st page of results
if( !empty($param_page) ) {
	$page = $param_page;
	$next_page = $page + 1;
	$next = preg_replace('/page=[0-9]+/', 'page='.$next_page.'', $url);
	$prev_page = $page - 1;
	$prev = preg_replace('/page=[0-9]+/', 'page='.$prev_page.'', $url);
}

// If person search term has been entered
if( !empty($search_name) ) {

	$api_person = file_get_contents('https://api.themoviedb.org/3/search/person?api_key='.$key.'&language=en-US&query='.$search_name_encoded.'');

	$get_person = json_decode($api_person,true);

	@$person_id = $get_person['results'][0]['id'];
	@$person_name = $get_person['results'][0]['name'];
	@$person_pic = $get_person['results'][0]['profile_path'];

}

if( !empty($movie_id) ) {
	$api_discover = file_get_contents('https://api.themoviedb.org/3/movie/'.$movie_id.'?api_key='.$key.'&language=en-US');
} else {
	@$api_discover = file_get_contents('http://api.themoviedb.org/3/discover/movie?vote_count.gte=100&sort_by=vote_average.desc&language=en-US&with_genres='.$genre.'&page='.$page.'&api_key='.$key.'&with_people='.$person_id.'&primary_release_year='.$year.'');
}

$get_movies = json_decode($api_discover,true);


$genres_foo = array(
	'Action' => '28',
	'Adventure' => '12',
	'Animation' => '16',
	'Comedy' => '35',
	'Crime' => '80',
	'Documentary' => '99',
	'Drama' => '18',
	'Family' => '10751',
	'Fantasy' => '14',
	'History' => '36',
	'Horror' => '27',
	'Music' => '10402',
	'Mystery' => '9648',
	'Romance' => '10749',
	'Science Fiction' => '878',
	'TV Movie' => '10770',
	'Thriller' => '53',
	'War' => '10752',
	'Western' => '37',
);


// Loop through all genres
foreach ($genres_foo as $key=>$val) {
	// If we hit a match
	if( $genre == $val ) {
		$genre_name = $key;
	}
}

?>