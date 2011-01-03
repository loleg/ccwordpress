<?php 

// "Single" template will always, by definition, have a single post.
// I'm quite sure this will not change, except on opposites day, perhaps.
if ( have_posts() )  {
    the_post(); 
} else {
    require (TEMPLATEPATH . '/404.php');
    exit();
}

get_header();

// check worldwide categories
in_category(18) ? $is_worldwide_upcoming = true : $is_worldwide_upcoming = false;
in_category(19) ? $is_worldwide_in_progress = true : $is_worldwide_in_progress = false;
in_category(20) ? $is_worldwide_completed = true : $is_worldwide_completed = false;
//in_category(21) ? $is_worldwide = true : $is_worldwide = false;

foreach ( get_the_category() as $cat ) {
    if ( $cat->category_parent == 21 ) {
        $jurisdiction_name = $cat->cat_name;
        $jurisdiction_code = $cat->category_nicename;
    }
}

$api_url = "http://api.creativecommons.org/rest/dev/license/standard/jurisdiction/";

if ( $is_worldwide_completed ) {
    $jurisdiction_dom = new DOMDocument();
    $jurisdiction_dom->loadXML( file_get_contents($api_url . $jurisdiction_code) );

    $jurisdiction_dom_root = $jurisdiction_dom->documentElement;
    $jurisdiction_site = $jurisdiction_dom_root->getAttribute('local_url'); 
    $license_elements = $jurisdiction_dom->getElementsByTagName('license');
    $licenses = array();

    for ( $i=0; $i < $license_elements->length; $i++ ) {
        $license_url = $license_elements->item($i)->getAttribute('url');
        $license_name = $license_elements->item($i)->getAttribute('name');
        preg_match('/licenses\/(.*)\/\d\.\d/', $license_url, $matches);
        $licenses[$matches[1]]['url'] = $license_url;
        $licenses[$matches[1]]['name'] = $license_name;
    }
    ksort($licenses);
}

$home_settings = get_settings('home');

echo <<<HTML

<div id="title" class="container_16">
            <h3 class="category">
                <a href="{$home_settings}/international">
                    CC Affiliate Network
                </a>
            </h3>
HTML;

$the_title = get_the_title();
$the_ID = get_the_ID();

if ( $jurisdiction_code != '' ) {
    echo <<<HTML
            <h2 class="grid_16">
                <img src="/images/international/{$jurisdiction_code}.png" alt="{$jurisdiction_code} flag" class="flag" /> 
                $the_title
            </h2>
        </div>
HTML;
}

echo <<<HTML
</div>

<div id="content">
	<div class="container_16">
		<div class="grid_12" id="post-{$this_ID}">
HTML;

$jurisdiction_site_url_parts = parse_url($jurisdiction_site);

if ( $jurisdiction_site && $jurisdiction_site_url_parts['host'] != 'creativecommons.org' ) {
    echo <<<HTML
        <div class="licensebox">
					Visit the <a href="{$jurisdiction_site}">jurisdiction's website</a> and <a href="http://wiki.creativecommons.org/$jurisdiction_name">wiki page</a>.
        </div>
HTML;
}

if ( $is_worldwide_completed ) {
		echo <<<HTML
		
				<p>
					The Creative Commons $jurisdiction_name license suite is available in the following version. <a href='/choose/?jurisdiction=$jurisdiction_code'>License your work</a> under these licenses, or <a href='/choose'>choose</a> the international licenses. <a href='http://wiki.creativecommons.org/FAQ#Should_I_choose_an_international_license_or_a_ported_license.3F'>More info</a>.
				</p> 
			</div>
		</div>
		<div class="alt">
			<div class="container_16">
				<div class="grid_12">
						<ul>
HTML;

    foreach ( $licenses as $license ) {
        echo "          <li><a href='{$license['url']}'>{$license['name']}</a></li>\n";
    }

    echo <<<HTML
						</ul>

				</div>
			</div>
		</div>
		<div class="container_16">
			<div class="grid_12">
            <p>
							Many thanks to all who contributed to the localization of the
							license suite.
            </p>
HTML;
}

the_content();

dynamic_sidebar('Single Post');

echo <<<HTML
		</div>
	</div>
</div>
HTML;

get_footer();

?>
