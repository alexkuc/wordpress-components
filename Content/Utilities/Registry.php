<?php

namespace WpComponents\Content\Utilities;

require_once __DIR__ . '/QuickLinksUpdater.php';

/**
 * This class should be a Singleton
 */
class Registry {
    /**
     * Track registered post types for this application
     * @var PostType[]
     */
    private $registeredPosts;

    /**
     * The registered taxonomies
     * @var Taxonomy[]
     */
    private $registeredTaxonomies;

    private static $instance;

    /**
     * Singleton pattern
     * @return Registry
     */
    public static function instance(): Registry {
        if (self::$instance == null) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public function passAlongToWP() {
        if (isset($this->registeredTaxonomies)) {
            $taxonomiesMap = [];
            foreach ($this->registeredTaxonomies as $taxonomy) {
                $taxonomiesMap[$taxonomy->getKey()] = $taxonomy;
            }
        }
        if (isset($this->registeredPosts)) {
            foreach ($this->registeredPosts as $customPost) {
                $cpt = $customPost->getPostTypeKey();
                register_post_type($cpt, $customPost->getWPArguments());
                $this->dependTaxonomies($customPost->getWPArguments(), $cpt, $taxonomiesMap);
            }
        }
    }

    public function registerQuickLinks() {
        if (isset($this->registeredPosts)) {
            foreach ($this->registeredPosts as $customPost) {
                $cpt = $customPost->getPostTypeKey();
                add_filter("views_edit-$cpt", function ($view) use ($cpt) {
                    $taxonomiesMap = [];
                    foreach ($this->registeredTaxonomies as $taxonomy) {
                        $taxonomiesMap[$taxonomy->getKey()] = $taxonomy;
                    }
                    $updater = new QuickLinksUpdater($cpt, $view, $taxonomiesMap);
                    return $updater->updateQuickLinks();
                });
            }
        }
    }

    /**
     * Add a new post type to WP
     */
    public function addPostType(PostType $customPostType): void{
        Validator::validateString($customPostType->getPostTypeKey(), 'post-type');
        $this->registeredPosts[] = $customPostType;
    }

    public function addTaxonomy(Taxonomy $taxonomy): void{
        Validator::validateString($taxonomy->getKey(), 'taxonomy');
        $this->registeredTaxonomies[] = $taxonomy;
    }

    private function registerTaxonmyTerms(string $taxonomy, array $taxonomiesMap): void {
        $taxonomyInstance = $taxonomiesMap[$taxonomy];
        foreach($taxonomyInstance->getTerms() as $term) {
            if(!term_exists($term, $taxonomy)) {
                $check = wp_insert_term($term, $taxonomy);
                if(is_wp_error($check)) {
                    throw new Error("[FATAL]: Something very bad went wrong" . json_encode($check));
                }
            }
        }
    }

    private function dependTaxonomies($wpPostBuilderArgs, $postKey, $taxonomiesMap) {
        if (isset($wpPostBuilderArgs['taxonomies'])) {
            foreach ($wpPostBuilderArgs['taxonomies'] as $taxonomy) {
                if (taxonomy_exists($taxonomy)) {
                    register_taxonomy_for_object_type($taxonomy, $postKey);
                } else {
                    if (!array_key_exists($taxonomy, $taxonomiesMap)) {
                        throw new Error("[FATAL] The $taxonomy key is not registered in this WP application!");
                    }
                    $taxInst = $taxonomiesMap[$taxonomy];
                    register_taxonomy($taxonomy, [$postKey], $taxInst->getWPArguments());
                    if ($taxInst->getWPArguments()['radio_buttons']) {
                        (new RadioButtonsTax($taxonomy))->enable();
                    } else {
                        (new RadioButtonsTax($taxonomy))->disable();
                    }
                    register_taxonomy_for_object_type($taxonomy, $postKey);
                    $this->registerTaxonmyTerms($taxonomy, $taxonomiesMap);
                }
            }
        }
    }
}

?>
