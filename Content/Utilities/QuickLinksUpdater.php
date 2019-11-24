<?php

namespace WpComponents\Content\Utilities;

class QuickLinksUpdater {
    private $customPostType;
    private $views;
    private $taxonomyMap;

    public function __construct($customPostType, $views, $taxonomyMap) {
        $this->customPostType = $customPostType;
        $this->views = $views;
        $this->taxonomyMap = $taxonomyMap;
    }

    public function updateQuickLinks() {
        $selected = '';
        $classSelected = '';

        $taxonomies = array_filter(get_object_taxonomies($this->customPostType), function($tax){
            return strpos($tax, 'tax_') !== false;
        });

        foreach ($taxonomies as $taxonomy) {
            $terms = get_terms(['taxonomy' => $taxonomy, 'hide_empty' => false]);
            if (isset($_GET[$taxonomy])) {
                $selected = $_GET[$taxonomy];
            }

            foreach ($terms as $term) {
                $args = [
                    'post_type' => $this->customPostType,
                    'tax_query' => [
                        [
                            'taxonomy' => $taxonomy,
                            'field' => 'id',
                            'terms' => $term->term_id,
                        ],
                    ],
                    'nopaging' => true,
                ];

                $query = new \WP_Query($args);
                if ($selected == $term->slug) {
                    $classSelected = 'current';
                } else {
                    $classSelected = '';
                }

                switch ($this->taxonomyMap[$taxonomy]->getQuickLinkType()) {
                    case Taxonomy::INLINE:
                        $this->views[$term->slug] = $this->htmlLink(
                            $classSelected,
                            $this->href($this->customPostType, $taxonomy, $term->slug),
                            $term->name,
                            $query->post_count
                        );
                        break;
                    case Taxonomy::DROPDOWN:
                        if(!array_key_exists('c-dropdown-menu', $this->views)) {
                            $this->views['c-dropdown-menu'] = [];
                        }
                        $href = $this->href($this->customPostType, $taxonomy, $term->slug);
                        $this->views['c-dropdown-menu'][] =
                            [
                                "value" => $href,
                                "label" => $term->name . "({$query->post_count})",
                                "slug" => $term->slug,
                            ];
                        break;
                    case Taxonomy::NONE:
                        return $this->views;
                }


            }
        }

        unset($this->views['publish']);

        if(array_key_exists('c-dropdown-menu', $this->views)) {
            $optionsHTML = "<select onchange='location = this.value'>";
            $selected = 'all';
            if(array_key_exists($taxonomy, $_REQUEST)) {
                $selected = $_REQUEST[$taxonomy];
            }
            foreach($this->views['c-dropdown-menu'] as $option) {
                if($selected === $option['slug']) {
                    $optionsHTML .= "<option value='{$option['value']}' selected>{$option['label']}</option>";
                } else {
                    $optionsHTML .= "<option value='{$option['value']}'>{$option['label']}</option>";
                }
            }
            $optionsHTML .= "</select>";

            $this->views['c-dropdown-menu'] = $optionsHTML;
        }

        return $this->views;
    }

    private function href($customPost, $taxonomy, $slug) {
        return sprintf('edit.php?post_type=%s&%s=%s',
            $customPost, $taxonomy, $slug);
    }

    private function htmlLink($class, $href, $label, $count) {
        return sprintf('<a class="%s" href="%s">%s <span class="count">(%d)</span></a>',
            $class, $href, $label, $count);
    }
}

?>
