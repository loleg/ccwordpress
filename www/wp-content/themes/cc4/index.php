<?php get_header(); ?>

    <div id="body">

      <div id="content">
        <div id="main-content">
		 <?php /* echo cc_current_feature();*/ ?>
		<div style="margin-right: 1.5em; margin-bottom: 1.5em;">
 			<div id="campaign08">
   				<div class="campaign-block">
	 				<h2>Help Build<br/>The Commons</h2>
	 				<div id="join-today">
	   					<a href="http://support.creativecommons.org/">Join Today</a>
	 				</div>
   				</div>
			</div>
			<div id="campaign-hint">
				Join Jesse Dylan in <a href="http://support.creativecommons.org/">supporting CC</a>. Watch his new video about us, <a href="/asharedculture/">A Shared Culture</a>.
			</div>
			<div id="campaign-matching">
				<a href="http://support.creativecommons.org/join">Donate</a> by November 3rd and have the value of your gift doubled thanks to <a href="http://safecreative.org/">Safe Creative</a>.
			</div>
   			<div id="campaign">  
				<div class="progress" onclick="window.location='http://support.creativecommons.org';">
					<span>&nbsp;</span>
				</div>
				<div class="results"><a href="http://support.creativecommons.org/"><?php cc_progress_total() ?> / $500,000 by Dec 31</a></div>
   			</div>
		</div>

	<div class="block hero" id="title">
            
            <div id="blurb"><?= cc_intro_blurb() ?></div>
            
          </div>
	  <div id="alpha" class="content-box">
            <h4><a href='/weblog'>CC News</a></h4>
<?php // Get the latest 5 posts that aren't in the worldwide category. ?>
<?php 
  while (have_posts()) { 
    the_post(); 
    
    static $count = 0;
    if ($count == "5") { break; } else {
      if (!in_category(1) && !is_single()) { continue; }?>
    
            <div class="block blogged" id="post-<?php the_ID(); ?>">
              <h1 class="title">
                <a href="<?php the_permalink() ?>">
                  <?php if (in_category(4) || in_category(7)) { ?>Featured Commoner: <?php } ?>
                  <?php the_title(); ?>
                </a>
              </h1>
              <h4 class="meta"><?php the_author() ?>, <?php the_time('F jS, Y')?></h4>
              <?php the_content("Read More..."); ?>
              <?php edit_post_link('Edit', '', ' |'); ?> <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?>
            </div>
<?php $count++; } }?>
            <ul class="archives">
	    <!-- START nkinkade mods -->
            <!--<li><h3><a href="/weblog/archive">Weblog Archives</a></h3></li>-->
            <li><h3><a href="/weblog">Weblog Archives</a></h3></li>
	    <!-- END nkinkade mods -->
	    <li><h3><a href="/weblog/rss">RSS Feed</a></h3></li></ul>
	    </div>
	    <div id="beta" class="content-box">
	     <h4><a href='http://planet.creativecommons.org/jurisdictions/'>Jurisdiction News</a></h4>
	     <?php cc_build_external_feed('Planet CC'); ?>
	     <div style="margin-left: 1ex;"><a href="http://planet.creativecommons.org/jurisdictions/">[More jurisdiction news]</a></div>
	    </div>
          </div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
