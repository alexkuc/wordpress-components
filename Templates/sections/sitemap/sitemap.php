<?php

$view->extend('structure/layout');

$view['slots']->set('title', 'Sitemap');

?>

<div class="container sitemap">
    <div class="row">
        <div class="col-lg-9">
            <article class="px-3">
                <h1 class="display-4 pt-3">
                    Sitemap
                </h1>
                <div class="py-2"></div>
                <section class="sect-page-text mx-auto custom-sect-page">
                </section>
                <div class="py-2"></div>
                <section class="sect-forms">
                    <?php
                        echo '<ul class="cpt_list">';
                        foreach( get_post_types( array('public' => true) ) as $post_type ) {
                            if ( in_array( $post_type, array('post','page','attachment') ) )
                               continue;

                            $pt = get_post_type_object( $post_type );

                            echo '<li class="pt"><h4>'.$pt->labels->name.'</h4></li>';

                            $taxonomy = isset($pt->taxonomies) ? $pt->taxonomies : array();

                            $tax_query = array();

                            if(!empty($taxonomy)){
                                $tax_query = array(array(
                                    'taxonomy' => $taxonomy[0],
                                    'field' => 'term_id',
                                    'operator' => 'NOT IN',
                                    'terms' => get_terms($taxonomy[0], array(
                                        'fields' => 'ids'
                                    ))
                                ));
                            }

                            // posts not having any catagory assigned
                            $_posts_WithoutTerms = new WP_Query(array(
                                'post_type'         => $pt->name,
                                'tax_query' => $tax_query
                            ));

                            if($_posts_WithoutTerms->have_posts()){

                                echo '<h6>Posts:</h6>';
                                echo '<ul class="posts_list">';

                                foreach ($_posts_WithoutTerms->posts as $key => $value) {
                                    # code...
                                    echo '<li><a href="'.get_permalink( $value->ID ).'">'.get_the_title( $value->ID ).'</a></li>';
                                }
                                echo '</ul>';
                            }


                            if(!empty($taxonomy)){
                               echo '<h6>Sections:</h6>';
                               echo '<ul class="tax_list">';
                               foreach ($taxonomy as $key => $value) {
                                # code...
                                $terms = get_terms([
                                    'taxonomy' => $value,
                                    'hide_empty' => false
                                ]);

                                foreach ($terms as $key_t => $term) {
                                    $term_link = get_term_link( $term );
                                    $_have_posts = false;

                                    echo '<li class="taxonomy">';
                                    echo '<a href="'.esc_url( $term_link ).'"><span class="tax_name sub-content">'.$term->name.'</span></a>';

                                    // posts having this catagory assigned
                                    wp_reset_query();
                                    $args = array('post_type' => $pt->name,
                                        'tax_query' => array(
                                            array(
                                                'taxonomy' => $value,
                                                'field' => 'slug',
                                                'terms' => $term->slug,
                                            ),
                                        ),
                                     );

                                    $_posts = new WP_Query($args);
                                    if($_posts->have_posts()) {
                                        $_have_posts = true;
                                    }

                                    if($_have_posts) {
                                        echo '<ul>';
                                    }

                                    if($_have_posts) {
                                        while($_posts->have_posts()){
                                            $post = $_posts->next_post();
                                            echo '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
                                        }
                                    }

                                    if($_have_posts) {
                                        echo '</ul>';
                                    }
                                    echo '</li>';
                                }
                            }
                            echo '</ul>';
                          }
                        }
                        echo '</ul>';
                        ?>
                </section>
            </article>
        </div>
    </div>
</div>
