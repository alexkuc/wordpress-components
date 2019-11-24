### TL;DR

This is a collection of re-usable custom-written WordPress components. To get started, follow these steps:

1. copy repository into `wp-content/themes/`
2. activate theme `WP Components`
3. start exploring

>Ps. if you get an error regarding missing files/classes, you need to create classmap for PSR-4 autoloader. See [here](https://getcomposer.org/doc/03-cli.md#dump-autoload-dumpautoload-) how to do it

### Introduction

This repository contains several custom components for WordPress which can be re-used across different WordPress solutions. Here's a quick summary of the provided components:

- Custom Post Types and Taxonomies
- SubSubSub Menu and Taxonomy Terms 
- Radio Buttons for Taxonomies
- Pseudo-Router
- Settings
- Templates

These components assume you are familiar with developing on WordPress and you have a good grasp of OOP using PHP. The documentation is provided through practical examples which show how to use these components in real life. All of these components require autoloading via PSR-4. Also, templates component requires [Symfony's Templating Component](https://symfony.com/doc/current/components/templating.html).

>Ps. if you get an error regarding missing files/classes, you need to create classmap for PSR-4 autoloader. See [here](https://getcomposer.org/doc/03-cli.md#dump-autoload-dumpautoload-) how to do it

Some of the components are interlinked and have never been used in complete isolation. While it is possible to separate components, I would highly advise against that as you may run into unexpected bugs and/or behaviours. If you require the only partial feature, I recommend copying files for interlinked components and using only functionality which you require.

Loading/activation of the components takes place in the file `functions.php` which essentially creates instances of components' classes. There is no hard-coded way of loading/activating components so you are free to create your implementation.

These components are not a how-to guide or a tutorial but rather a collection of custom-written code for WordPress which may (or may not) be useful for your needs. As such, this repository does *not* cover basics of WordPress or OOP in PHP.

### Content - Custom Post Types and Taxonomies 

Content component for custom post types and taxonomies allows a clean way to register a large number of custom post types and taxonomies using OOP code. By registering each post type or taxonomy via a separate class, you have neatly grouped them per logical domain or you are free to choose any other arbitrary grouping.

To understand how to register custom post types, refer to folder `Content/PostTypes` which contains live examples. Refer to abstract class `PostType` (located in `Content/Utilities/PostType.php`) for a complete list of available arguments. As you can see, they are the same as you would use for function [`register_post_type`](https://developer.wordpress.org/reference/functions/register_post_type/).

Registering custom taxonomies and their terms are similar to custom post types. Refer to folder `Content/Taxonomies` for live examples. For a full list of available arguments, refer to abstract class `Taxonomy` (located in `Content/Utilities/Taxonomy.php`). The arguments are the same as you would use for function [`register_taxonomy`](https://developer.wordpress.org/reference/functions/register_taxonomy/).

Additional credit for this component goes to [@dev-cyprium](https://github.com/dev-cyprium) who assisted with writing it.

### Content - SubSubSub Menu and Taxonomy Terms

You can modify how taxonomy terms are displayed in the subsubsub menu (quick links). There are 3 available options:

- inline (default WordPress behaviour)

![quicklinks - inline](Screenshots/quicklinks%20-%20inline.png)

- dropdown

![quicklinks - dropdown](Screenshots/quicklinks%20-%20dropdown.png)

- none

![quicklinks - none](Screenshots/quicklinks%20-%20none.png)

If no value is specified, argument defaults to `INLINE` which is the same as the default WordPress behaviour.

>Known limitation: when using [WPML plugin](https://wpml.org/), subsubsub menu is altered only for the English language; this should be relatively trivial to fix it but unfortunately, I do not have the time for that at the moment; PR is welcome!

Additional credit for this component goes to [@dev-cyprium](https://github.com/dev-cyprium) who assisted with writing it.

### Content - Radio Buttons for Taxonomies

![radio buttons for taxonomies](Screenshots/radio%20buttons%20for%20taxonomies.png)

You can set radio buttons for taxonomies through [this plugin](https://wordpress.org/plugins/radio-buttons-for-taxonomies/). While you can choose which taxonomies should have radio buttons for its terms using GUI, using this component you can create a declarative configuration. The benefit is two-fold:

1) create a persistent configuration to avoid accidentally changing the setting
2) declarative configuration allows creating "code as documentation"

This component makes sense once you use it in conjunction with subsubsub menu component (dropdown value) which prevents assigning more than one taxonomy term to a post. This makes sense from the UI/UX point of view as when you have a dropdown menu, you expect to select only one value per selection. For a working example, see custom taxonomy class `AboutUs` (located in `Content/Taxonomies/AboutUs.php`).

### Pseudo-Router

This is a pseudo-router for WordPress. It is called *pseudo* as it does not map to classes as a conventional router would. Instead, it relies on `$GLOBALS['wp_query']` to determine which path to load. None the less, this pseudo-router allows to neatly organize your WordPress template sections arbitrarily without any restrictions imposed by WordPress.

### Settings

Settings is not a component per se but it shows how you can configure the WordPress theme OOP style. Have a look at the following files in the `Settings` folder:

| File | Purpose |
| --- | --- |
| Menus.php | Hides certain admin menus |
| PostTypesTaxonomies.php | See `Content` headings |
| ScriptsStyles.php | Enqueues stylesheets and scripts\* |
| ThemeSupport.php | Add theme-specific features to WordPress |

>\*Special note: notice how css attribute `integrity` is added via `DOM` instead of [`str_replace`](https://www.php.net/manual/en/function.str-replace.php) or similar string function

### Templates

Templates component is based on [Symfony's Templating Component](https://symfony.com/doc/current/components/templating.html). It is a custom implementation as it uses [Custom Template Enigne](https://symfony.com/doc/current/components/templating.html#creating-a-custom-engine) and a Custom File Loader (see `Templates/Utilities/CustomFileLoader.php`). 

Using pseudo-router (see earlier section), templates can be organised and structured arbitrarily. In other words, you can organise templates in any way without having to follow [WordPress prescribed structure](https://developer.wordpress.org/themes/basics/organizing-theme-files/#theme-folder-and-file-structure). See file `index.php` and `Templates` folder for live examples.

Pseudo-router has special *default* route which acts as a catch-all in case it fails to resolve a mapped path. Additionally, you can create an arbitrary path as shown in the example of `specific pages` in the file `index.php`.

In a nutshell, routes simply return a path, which gets rendered by [Symfony's Templating Component](https://symfony.com/doc/current/components/templating.html). Current implementation follows convention `<folder_name/file_name>`. Note that the `.php` extension is appended automatically if it is missing as the assumption is made that you are loading PHP file. For live examples, see the content of folder `Templates/sections`. Folder `Templates/structure` provide HTML skeleton for templates to follow [DRY style](https://en.wikipedia.org/wiki/Don%27t_repeat_yourself) for templates.

See `Templates/sections/example` template to see how to render dynamic data and how to create default values for such data. For more information, refer [here](https://symfony.com/doc/current/components/templating.html#usage). Also, there is a rudimentary sitemap which is available under `Templates/sections/sitemap` folder which is another example on how to render dynamic data. This example shows you how to create [WP loops](https://developer.wordpress.org/themes/basics/the-loop/) using these custom templates.
