<?php get_header(); ?>
<?php $sidebar = $woo_options['woo_sidebar']; ?>
    
    <div id="content" class="col-full">
		<div id="main" <?php if($sidebar  == "true") { ?> class="col-left" <?php }?>>
            
		<?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<div id="breadcrumb"><p>','</p></div>'); } ?>
		<?php if (have_posts()) : $count = 0; ?>
        
            <?php if (is_category()) { ?>
        	<span class="archive_header"><span class="cat"><?php _e('Рубрика', 'woothemes'); ?> | <?php echo single_cat_title(); ?></span> <span class="fr catrss"><?php $cat_obj = $wp_query->get_queried_object(); $cat_id = $cat_obj->cat_ID; echo '<a href="'; get_category_rss_link(true, $cat, ''); echo '">'; _e("RSS-лента этой рубрики", "woothemes"); echo '</a>'; ?></span></span>        
        
            <?php } elseif (is_day()) { ?>
            <span class="archive_header"><?php _e('Архивы', 'woothemes'); ?> | <?php the_time(get_option('date_format')); ?></span>

            <?php } elseif (is_month()) { ?>
            <span class="archive_header"><?php _e('Архивы', 'woothemes'); ?> | <?php the_time('F Y'); ?></span>

            <?php } elseif (is_year()) { ?>
            <span class="archive_header"><?php _e('Архивы', 'woothemes'); ?> | <?php the_time('Y'); ?></span>

            <?php } elseif (is_author()) { ?>
            <span class="archive_header"><?php _e('Архив автора', 'woothemes'); ?></span>

            <?php } elseif (is_tag()) { ?>
            <span class="archive_header"><?php _e('Метка:', 'woothemes'); ?> <?php echo single_tag_title('', true); ?></span>
            
            <?php } ?>
            <div class="fix"></div>
        
        <?php while (have_posts()) : the_post(); $count++; ?>
                                                                    
            <!-- Post Starts -->
            <div class="post">
            
            	<div class="post-meta col-left">
            	
            		<?php woo_post_meta(); ?>
            	
            	</div><!-- /.meta -->
            	
            	<div class="middle col-left">
                
                	<h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                	
                	<?php woo_image('width=519&height='.$woo_options['woo_thumb_h'].'&class=thumbnail main-image '.$woo_options['woo_thumb_align']); ?> 
                	
                	<div class="entry">
                	    <?php if ( $woo_options['woo_post_content'] == "content" ) the_content(__('Далее...', 'woothemes')); else the_excerpt(); ?>
                	</div>
					
                	<div class="post-more">      
                		<?php if ( $woo_options['woo_post_content'] == "excerpt" ) { ?>
                	    <span class="read-more"><a href="<?php the_permalink() ?>" title="<?php _e('Читать полностью','woothemes'); ?>"><?php _e('Continue Reading','woothemes'); ?></a></span>
                	    <?php } ?>
                	</div>
                	
                </div><!-- /.middle -->
                
                <?php if($sidebar == "false") { ?>
                
                	<div class="related col-left">
                	
                		<h3><?php _e('Больше в этой рубрике','woothemes'); ?></h3>
                		<?php
                	 	$cats = strip_tags( get_the_category_list(',') ); 
                		$cats = explode(',',$cats);

                		if(!empty($cats)){
                			$cat_ids = array();
                			foreach ($cats as $cat) {
                				$term_data = get_term_by('name', $cat, 'category'); 
                				$cat_ids[] = $term_data->term_id;
                			}
                		}
                		//print_r($cat_ids);
                		$cats = implode(',',$cat_ids);
                		
                		$more_posts = query_posts(array(
                			'posts_per_page' => $woo_options['woo_more_from_count'],
                			'post__not_in' => array(get_the_id()),
                			'category__and' => $cat_ids)
                			);
                		
                		if (have_posts()) :?>
                		<ul><li>
                			<?php
        					while (have_posts()) : the_post(); $count++; ?>
                			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                					<span class="related-title"><?php the_title(); ?></span>
                					<span><?php the_time(get_option('date_format')); ?></span>
                			</a>
                			<?php
                			endwhile;
                			?>
                		</li></ul>
                		<?php
                		endif;
                		wp_reset_query();
                		?>
                	
                	</div><!-- /.related -->
                	
                <?php } ?>
                
                <div class="fix"></div>
                                     
            </div><!-- /.post -->
            
        <?php endwhile; else: ?>
        
            <div class="post not-found">
                <h2 class="title"><?php _e('Ошибка 404. Ничего не найдено!', 'woothemes') ?></h2>
                <p><?php _e('Если вам не удалось ничего найти, вы можете посмотреть в меню, или воспользоваться формой поиска.', 'woothemes') ?></p>
            </div><!-- /.post -->
        
        <?php endif; ?>  
    
			<?php woo_pagenav(); ?>
                
		</div><!-- /#main -->

        <?php if($sidebar == "true") { get_sidebar(); } ?>

    </div><!-- /#content -->
		
<?php get_footer(); ?>