<?php

/* Related Actions Wordpress Plugin
 * Copyright 2008  Social Actions  (email : peter@socialactions.com)
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * 
 * 
 * @author      Social Actions <peter[at]socialactions[dot]com>
 * @author      E. Cooper <smirkingsisyphus[at]gmail[dot]com>
 * @copyright   2008 Social Actions
 * @license     http://www.gnu.org/licenses/gpl-3.0.html
 * @link        http://www.socialactions.com/labs
 * 
 */


/*
 * Function called by WP to display related actions at bottom of post.
 * Only displays if post is single.
 *
 * @params string $content Post body to add related actions output to bottom of
 * @returns string $content returns modified content
 */
function ra_display($content) {
	global $post;

 	if ( is_single() && !raIgnore( $content ) ) {
 		list( $content, $override ) = raOverride( $content );
 		return $content . raGetRelated( $post, $override );
 	} else if ( raIgnore( $content ) ) {
 		$content = raIgnore( $content );
 	}
 	
 	return $content;
}

/*
 * Function called by WP to add link to style sheet in head of document
 *
 * @returns bool 
 */
function ra_get_style() {

 echo '<link rel="stylesheet" href="' . get_bloginfo('wpurl') . '/wp-content/plugins/related-ways-to-take-action/ra_style.css" type="text/css" media="screen" />';

}

/*
 * Activates WP plugin
 *
 * @returns bool
 */
function ra_activate() {
	global $wpdb;
	

	$raOptions = array ( 'actionLimit' => 3,
							'keywordLimit' => 3,
							'postTitleWeight' => 1.2,
							'postTagWeight' => 1.4,
							'postContentWeight' => 1,
							'postHotWeight' => 1.3,
							'maxCacheAge' => 12,
							'includeTitle' => true,
							'includeTag' => true,
							'includeContent' => true,
							'action_exclude_types' => "",
							'action_sites' => "830666864,772821349,1041101928,519819829,757797673,685918349,583316495,116435787,1061711813,496066117,994130381,844796856,285985636,1016384319,908406582,464798105,434467939,968133144,1039924068,517402238,919955905,606949681,984299787,599250674,19965212,152672700,809868311,502551104,29079428,850833553,714501136,270224883,499168571,252497774,661916800,906305602,357620952,828647226,353675617",
							'action_exclude_terms' => "",
							'no_random' => "false" );
	
	
	foreach ($raOptions as $option => $val) {
		if ( get_option( 'ra_'.$option ) ) {
			update_option( 'ra_'.$option, $val );
		} else {
			add_option( 'ra_'.$option, $val );
		}
	}
	
	if ( raInit() )
	 	return true;
	
	return false;	
}

function ra_admin_menu() {
	add_options_page('Related Ways to Take Action', 'Related Ways to Take Action', 8, 'related-ways-to-take-action/options.php');
}

/*
 * Creates or updates table used for caching results and wordlists
 *
 * @returns bool
 */
function raInit() {
	global $wpdb;
	
	$sql = 	"CREATE TABLE actions_cache (
			 	cache_id INT NOT NULL AUTO_INCREMENT ,
				post_id INT NOT NULL ,
				cached_result LONGTEXT NOT NULL ,
				last_update TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
				UNIQUE KEY cache_id (cache_id))";
	
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   
   if ( dbDelta($sql) )
   	return true;
   	
   return false;

}


/*
 * Workhorse of plugin. Calls on various external frameworks to recall results 
 * from cache, or define keywords and request results from DC API
 *
 * @params object $wpPost WP post to get related content for
 * @returns string $results raw html of related content for post
 */
function raGetRelated( $wpPost, $override="" ) {

	if ( !$wpPost )
		return;

	$raCache = new raWordPressCache( "actions_cache", $wpPost->ID );			
	
   if ( $raCache->exists() && $raCache->lastUpdate() <= intval( get_option( 'ra_maxCacheAge' ) ) )
   	return $raCache->getCache();	
	
	//Get black and white lists for keyword generation
	$ignore = raGetWordList( 'ignore.txt', -1 );
	$hot =  raGetWordList ( 'hot.txt', -2 );	
	
	//Begin generating keywords	
	$keywords = new raKeywords( $ignore, $hot, intval( get_option( 'ra_postHotWeight' ) ) );
	$areas = raGetIncludedAreas();

	if (!$areas)
		return;
				
	foreach ( $areas as $area => $weight ) {
		$keywords->addKeywords( raGetAreaText( $area ), $weight );
	}
		
	$request = new raRequest( 'http', 'json' );
	$request->setRequestURI( 'http://search.socialactions.com/actions.json?' );
	
	if ( $override ) {
		$queries = array( array( 'q' => "$override", 'created' => 'all', 'match' => 'all', 'order' => 'relevance', 'limit' => 10, 'sites' => get_option('ra_action_sites'), 'exclude_action_types' => get_option('ra_action_exclude_types') ),
								array( 'q' => "$override", 'created' => 'all', 'match' => 'any', 'order' => 'relevance', 'limit' => 10, 'sites' => get_option('ra_action_sites'), 'exclude_action_types' => get_option('ra_action_exclude_types') ) );
	} else {
		$postKeywords = explode( ", ", $keywords->makeList(', ', get_option( 'ra_keywordLimit' ) ) );
		$queries = array( array( 'q' => "$postKeywords[0] $postKeywords[1] $postKeywords[2]", 'created' => 'all', 'match' => 'all', 'order' => 'relevance', 'limit' => 10, 'sites' => get_option('ra_action_sites'), 'exclude_action_types' => get_option('ra_action_exclude_types') ),
							array( 'q' => "$postKeywords[0] $postKeywords[1]", 'created' => 'all', 'match' => 'all', 'order' => 'relevance', 'limit' => 10, 'sites' => get_option('ra_action_sites'), 'exclude_action_types' => get_option('ra_action_exclude_types') ),
							array( 'q' => "$postKeywords[0] $postKeywords[2]", 'created' => 'all', 'match' => 'all', 'order' => 'relevance', 'limit' => 10, 'sites' => get_option('ra_action_sites'), 'exclude_action_types' => get_option('ra_action_exclude_types') ),
							array( 'q' => "$postKeywords[1] $postKeywords[2]", 'created' => 'all', 'match' => 'all', 'order' => 'relevance', 'limit' => 10, 'sites' => get_option('ra_action_sites'), 'exclude_action_types' => get_option('ra_action_exclude_types') ),
							array( 'q' => "$postKeywords[0] $postKeywords[1] $postKeywords[2]", 'created' => '30', 'match' => 'any', 'order' => 'relevance', 'limit' => 10, 'sites' => get_option('ra_action_sites'), 'exclude_action_types' => get_option('ra_action_exclude_types') ) );		
	}	

	$results = array();	
	$titles = array();
	
	foreach ( $queries as $query ) {
		$request->formQuery( $query );							
		if ( !$request->doRequest() ) {
			continue;
		}
			
		$rawResults = $request->decodeResponse();
		$excludes = explode( ",", get_option( "ra_action_exclude_terms" ) );	

		if ( !$rawResults ) continue;	
	
		foreach ( $rawResults as $rawResult ) {
			$result = $rawResult->action;

			$hit = 0;
			if ( count( $excludes ) > 0 ) {		
				foreach ( $excludes as $e ) {
					$e = trim($e);
			
					if ( $e ) {
						$m = "/" . preg_quote( $e ) . "/i";
						if ( preg_match( $m, $result->title ) )
							$hit = 1;
					}		
				}
			}		
		
			if ( !$hit && !in_array( $result->title, $titles ) ) {
				$titles[] = $result->title; 
				$results[] = $result;
			}
			
			if ( count( $results ) == 3 )
				break; 			
		}
		
		if ( count( $results ) > 2 )
			break; 
	}
	
	unset( $titles );	
	
	$results = raListActions( $results );
	
	if ( !$results ) {
		if ( !get_option( "ra_no_random" ) ) 
			return $raCache->getRandomCache();
		
		return "";	
	}	
	
	if ( $raCache->exists() ) {
		$raCache->updateCache( $results );
	} else {
		$raCache->addCache( $results );
	}
	
	return $results;
}			

/*
 * Gets content area and weightings for keyword generation. Without admin
 *
 * interface, mostly worthless function.
 * @returns array $areas assoc array of content area and its weighting
 */
function raGetIncludedAreas() {

	$areas = array();	
	
	if ( get_option( 'ra_includeTitle' ) )
		$areas['title'] = get_option( 'ra_postTitleWeight' );
		
	if ( get_option( 'ra_includeTag' ) )
		$areas['tag'] = get_option( 'ra_postTagWeight' );
	
	if ( get_option( 'ra_includeContent' ) )
		$areas['content'] = get_option( 'ra_postContentWeight' );
		
 	return $areas;
}

/*
 * Finds and returns text of a given area, like tags, title, or post body
 *
 * @params string $area a given area's name
 * @returns string text of a given area
 */
function raGetAreaText( $area ) {
	global $post;

	switch ($area) {
		case 'content':
			return $post->post_content;
			break;
		case 'title':
			return $post->post_title;
			break;
		case 'tag':
			$tags = wp_get_post_tags( $post->ID );
			if ( count($tags) < 1 ) 
				return "";
			foreach ($tags as $tag) {
				$postTags .= $tag->name . " ";
			}
			
			return $postTags;
			break;
	}
}

/*
 * Formats JSON-decoded response from API into a HTML <ul></ul>
 * 
 * @params array $results multi-dimensional array of results from API
 * @returns string $html raw html of related content
 */
function raListActions( $results )  {

	if ( !$results )
		 return false;

	$html = "<div class='raWrapper'>";
	$html .= "<span class='raHeader'>Related Ways to Take Action:</span>\n";
			
	foreach ( $results as $result ) {
		$url = $result->url;
		$urlTitle = ""; //htmlentities( $result->description );
		
		if ( strlen( $result->title >= 85 ) ) {
			$linkText = substr( $result->title, 0, 82 ) . "...";
		} else {
			$linkText = $result->title;
		}
		
		
		$actions[] = "<li><a href='$url' target='_blank' title='$urlTitle'>$linkText</a><br/>$result->description</li>\n";
	}
	
	$html .= "<ul>" . implode("\n", $actions) . "</ul>\n";
	$html .= "<span class='raTagLine'>Powered by <a href='http://www.socialactions.com'>Social Actions</a></span>";
	$html .= "</div>\n"; 
	return $html;
}

function raGetWordList( $listName, $postID ) {
	$wlCache = new raWordPressCache( "actions_cache", $postID );
	
	if ( $wlCache->isValidCache( 24 ) ) {
		return $wlCache->getCache();
	} else {
		$wlReq = new raRequest( 'httpfile', 'txt' );
		$wlReq->setRequestURI( 'http://www.socialactions.com/~wp/lists/' );
		$wlReq->formQuery( $listName );		
				
		
		if ( !$wlReq->doRequest() ) {
			if ( $wlCache->exists() )
				return $wlCache->getCache();
			return array();		
		}
		
		$list = $wlReq->decodeResponse();
		
		if ( $wlCache->exists() ) {
			$wlCache->updateCache( $list, true );
		} else {
			$wlCache->addCache( $list );
		}			
		
		return $list;
	}
		 	
}

/*
 * Filter function used to not display related content on a given page
 *
 * @params string $content text content of a given blog post
 * @returns string $content parsed text to remove tag if present
 */
function raIgnore( $content ) {
	
	if ( preg_match( "/%NORA%/i", $content ) ) {
		$content = preg_replace( "/%NORA%/i", "", $content );
		return $content;
	}
	return false;
}

function raOverride( $content ) {
	$keywords = "";

	if ( preg_match( "/%RA=(.+)?%/i", $content ) ) {
		preg_match( "/%RA=(.+)?%/i", $content, $keywords );
		$content = preg_replace( "/%RA=(.+)?%/i", "", $content );

		return array( $content, $keywords[1] );
	}
	return array( $content, $keywords );

} 			
?>
