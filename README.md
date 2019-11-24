### Introduction

This repository contains a number of custom components for WordPress which can be re-used across different WordPress solutions. Here's a quick summary of the provided components:

- Custom Post Types and Taxonomies
- SubSubSub Menu and Taxonomy Terms 
- Radio Buttons for Taxonomies
- Pseudo-Router
- Settings
- Templates

These components assume you are familiar with developing on WordPress and you have a good grasp of OOP using PHP. The documentation of usage is provided by means of practical examples which show how to use these components in real life. All of these components require autoloading via PSR-4. Also, templates component requires [Symfony's Templating Component](https://symfony.com/doc/current/components/templating.html).

Some of the components are interlinked and have never been used in complete isolation. While it is possible to separate components, I would highly advise against that as you may run into unexpected bugs and/or behaviours. If you require only partial feature, I recommend copying files for all components and using only functionality which you require.

Loading/activation of the components take place in the file `Settings/PostTypesTaxonomies.php`. This file (its classes) should be called from `functions.php` file which has always to be in the root of theme (WordPress limitation). Refer to existing `functions.php` file for a practical example.

These components are not how-to guide or a tutorial but rather a collection of custom written code for WordPress which may (or may not) be useful for your needs.

### Content - Custom Post Types and Taxonomies 

Content component allows a clean way to register large number of custom post types and taxonomies by means of OOP coding. By registering each post type or taxonomy via a separate class, you have neatly group them together per logical domain or choose any other arbitary ordering.

To understand how to register custom post types, refer to folder `Content/PostTypes` which contains live examples. Refer to abstract class `PostType` for a complete list of available arguments. As you can see, they are exactly the same as you would use for [`register_post_type`](https://developer.wordpress.org/reference/functions/register_post_type/).

Registering custom taxonomies and their terms is similar to custom post types. Refer to folder `Content/Taxonomies` for live examples. For a full list of available arguments, refer to abstract class `Taxonomy`. The arguments are exactly the same as you would use [`register_taxonomy`](https://developer.wordpress.org/reference/functions/register_taxonomy/).

### Content - SubSubSub Menu and Taxonomy Terms

You can modify how taxonomy terms are displayed in the subsubsub (quick links) menu. There are 3 available options:

- inline (default WordPress behaviour)

![quicklinks - inline](Screenshots/quicklinks%20-%20inline.png)

- dropdown

![quicklinks - dropdown](Screenshots/quicklinks%20-%20dropdown.png)

- none

![quicklinks - none](Screenshots/quicklinks%20-%20none.png)

If no value is specified, argument defaults to `INLINE` which is the same as the default WordPress behaviour.

Additional credit for subsubsub component goes to [@dev-cyprium](https://github.com/dev-cyprium) who assisted with writing it.

>Known limitation: when use [WPML plugin](https://wpml.org/), subsubsub menu is altered only for English language; this should be relatively trivial to fix it but unfortunately, I do not have the time for that at the moment

### Content - Radio Buttons for Taxonomies

You can set radio buttons for taxonomies through [this plugin](https://wordpress.org/plugins/radio-buttons-for-taxonomies/). While you can choose which taxonomies should have radio buttons for its terms using GUI, using this component you can create declarative configuration. The benefit is two-fold:

1) create persistent configuration to avoid accidentally changing the setting
2) declarative configuration allows to create "code as documentation"

![radio buttons for taxonomies](Screenshots/radio%20buttons%20for%20taxonomies.png)

This component makes sense once you use it in conjunction with subsubsub menu, dropdown style which prevents assigning more than one taxonomy term to a post. This makes sense for UI/UX point of view as when you have a dropdown menu, you expect to select only one value per selection. For a working example, see custom taxonomy class `AboutUs`.

### Pseudo-Router

This is a pseudo-router for WordPress. It is called *pseudo* as it does not map to classes as a conventional router would. None the less, this pseudo-router allows to neatly organize your WordPress template sections in an arbitary manner without any restrictions imposed by the WordPress.

### Settings

Settings is not a component per se but it shows how you can configure the WordPress theme using OOP style.

### Templates

Templates component is based on [Symfony's Templating Component](https://symfony.com/doc/current/components/templating.html). It is a custom implementation as it uses [Custom Template Enigne](https://symfony.com/doc/current/components/templating.html#creating-a-custom-engine) and a Custom File Loader (custom PHP class).
