<?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die (__('Please do not load this page directly. Thanks!', 'cc5'));

        if (!empty($post->post_password)) { // if there's a password
            if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
				?>

				<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.', 'cc5'); ?><p>

				<?php
				return;
            }
        }

		/* This variable is for alternating comment background */
		$oddcomment = 'alt';
?>

<!-- You can start editing here. -->

<?php if ($comments) : ?>
	<h3 id="comments"><?php comments_number(__('No Responses', 'cc5'), __('One Response', 'cc5'), __('% Responses', 'cc5')); ?> <?php echo _e('to', 'cc5'); ?> &#8220;<?php the_title(); ?>&#8221;</h3> 

	<div class="commentlist">

	<?php foreach ($comments as $comment) : ?>

		<div class="comment <?php echo $oddcomment; ?>" id="comment-<?php comment_ID() ?>">
			<h4><?php comment_author_link() ?></h4>
			<?php if ($comment->comment_approved == '0') : ?>
			<em>&mdash; <?php _e('Your comment is awaiting moderation.', 'cc5'); ?></em>
			<br />
			<?php endif; ?>

			<small class="commentmetadata"><a href="#comment-<?php comment_ID() ?>" title=""><?php comment_date('F jS, Y') ?> <?php echo _x('at', 'time', 'cc5');?> <?php comment_time() ?></a> <?php edit_comment_link('e','',''); ?></small>

			<?php comment_text() ?>

		</div>

	<?php /* Changes every other comment to a different class */
		if ('alt' == $oddcomment) $oddcomment = '';
		else $oddcomment = 'alt';
	?>

	<?php endforeach; /* end for each comment */ ?>

	</div>

 <?php else : // this is displayed if there are no comments so far ?>

  <?php if ('open' == $post->comment_status) : ?> 
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->

	<?php endif; ?>
<?php endif; ?>


<?php if ('open' == $post->comment_status) : ?>

<h3 id="respond"><?php _e('Leave a Comment', 'cc5'); ?></h3>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.', 'cc5'), get_option('siteurl') . 'wp-login.php?redirect_to=' . the_permalink()) ?></p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( $user_ID ) : ?>

<p><?php printf(__('Logged in as <a href="%s">%s</a>.', 'cc5'), get_option('siteurl') . '/wp-admin/profile.php', $user_identity); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account', 'cc5'); ?>"><?php _e('Logout &raquo;', 'cc5'); ?></a></p>

<?php else : ?>

<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
<label for="author"><small><?php _e('Name', 'cc5'); ?> <?php if ($req) _e('(required)', 'cc5'); ?></small></label></p>

<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
<label for="email"><small><?php _e('Mail (will not be published)', 'cc5'); ?> <?php if ($req) _e('(required)', 'cc5'); ?></small></label></p>

<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
<label for="url"><small><?php _e('Website', 'cc5'); ?></small></label></p>

<p><input type="text" name="openid_identifier" id="openid_identifier" /><label for="openid_identifier"><small><?php _e('OpenID URL', 'cc5'); ?></small></label></p>

<p><small><?php _e('Name and Mail are not required fields if you authenticate your comment with OpenID.', 'cc5'); ?></small></p>

<?php endif; ?>

<!--<p><small><strong>XHTML:</strong> You can use these tags: <?php echo allowed_tags(); ?></small></p>-->

<p><textarea name="comment" id="comment" cols="60" rows="12" tabindex="4"></textarea></p>

<p><input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" />
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
</p>

<p><small><?php _e('Your first comments will be held for moderation, until your email address is approved.', 'cc5'); ?></small></p>

<?php do_action('comment_form', $post->ID); ?>

</form>

<?php endif; // If registration required and not logged in ?>

<?php endif; // if you delete this the sky will fall on your head ?>

