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
                    Details
                    <?php the_content(); ?>
                    Author :
                    <?php the_author(); ?>
                    <br>
                    Other Pepoles :
                    <?php $users = get_users( array( 'fields' => array( 'ID' ) ) );
                    foreach($users as $user_id){
                        $user_meta = get_user_meta( $user_id->ID, '_event_from_other', true);
                        if ( $user_meta ) {
                            foreach( $user_meta as $post_id ) {
                                if ($post_id == $post->ID) {
                                    if ( get_current_user_id() != $user_id->ID ||  get_current_user_id() == $user_id->ID ) {
                                        $data = get_user_meta ( $user_id->ID );
                                        echo $data['first_name'][0];
                                        echo " ";
                                        echo $data['last_name'][0];
                                        echo "<br>";
                                    }
                                }
                            }
                        }
                    } ?>
                    Date start : 
                    <?php echo $event_start_date; ?>
                    <br>
                    Date End :
                    <?php echo $event_end_date; ?>
                </div>
            </article>
        </div>
    </div>

	<?php endwhile; // end of the loop. ?>

<?php get_footer();