<?php /* Template Name: CustomPageT1 */ ?>
 
<?php get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>

    <?php $event_start_date = get_post_meta( get_the_ID(), '_event_start_date', true); ?>
    <?php $event_end_date = get_post_meta( get_the_ID(), '_event_end_date', true); ?>

    <div id="loop-container" class="loop-container">
        <div class="page type-page status-publish hentry entry">
	        <article>
				<div class="post-container">
                <div class="post-header">
                    <h1 class="post-title"><?php the_title(); ?></h1>
                </div>
                <div class="post-content">
                    <div class="event_top_wrapper">
                        <?php if ( is_user_logged_in() ) { ?>
                            <div class="event_top_left">
                            </div>
                            <div class="event_top_right">
                                <a href="<?php echo get_edit_post_link( get_the_ID() ); ?>">Edit Event</a>
                            </div>
                        <?php } ?>
                    </div>
                    Author :
                    <?php the_author(); ?>
                    <br>
                    Other Pepoles :
                    <?php $users = get_post_meta( get_the_ID(), '_event_other_user', true );
                    foreach($users as $user_id){
                        if ( get_current_user_id() != $user_id ) {
                            $data = get_user_meta ( $user_id );
                            echo $data['first_name'][0];
                            echo " ";
                            echo $data['last_name'][0];
                            echo "<br>";
                        }
                    } ?>
                    <br>
                    <?php $time_start = explode('T', $event_start_date); ?>
                    Date start and time : 
                    <br>
                    <?php echo $time_start[0]; ?>
                    <br>
                    <?php echo $time_start[1]; ?>
                    <?php $time_start = explode('T', $event_end_date); ?>
                    <br>
                    <br>
                    Date End and time :
                    <br>
                    <?php echo $time_start[0]; ?>
                    <br>
                    <?php echo $time_start[1]; ?>
                    <br>
                    Details
                    <?php the_content(); ?>
                </div>
            </article>
        </div>
    </div>

	<?php endwhile; // end of the loop. ?>

<?php get_footer();