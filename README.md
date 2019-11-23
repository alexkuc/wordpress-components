### Introduction

This repository contains a number of custom components for WordPress which can be re-used across different WordPress solutions. Here's a quick summary of the provided components:

- Custom Post Types and Taxonomies
- SubSubSub Menu and Taxonomy Terms 
- Radio Buttons for Taxonomies
- Pseudo-Router
- Settings
- Templates

These components assume you are familiar with developing on WordPress and you have a good grasp of OOP using PHP. The documentation of usage is provided by means of practical examples which show how to use these components in real life. All of these components require autoloading via PSR-4. Also, templates component requires [Symfony's Templating Component](https://symfony.com/doc/current/components/templating.html).

These components are not how-to guide or a tutorial but rather a collection of custom written code for WordPress which may (or may not) be useful for your needs.

### Custom Post Types and Taxonomies 

Content component allows a clean way to register large number of custom post types and taxonomies by means of OOP coding. By registering each post type or taxonomy via a separate class, you have neatly group them together per logical domain or choose any other arbitary ordering.

### SubSubSub Menu and Taxonomy Terms

You can modify how taxonomy terms are displayed in the subsubsub (quick links) menu. There are 3 available options:

- none
- inline (default WordPress behaviour)
- dropdown

Additional credit for subsubsub component goes to [@dev-cyprium](https://github.com/dev-cyprium) who assisted with writing it.

### Radio Buttons for Taxonomies

You can set radio buttons for taxonomies through [this plugin](https://wordpress.org/plugins/radio-buttons-for-taxonomies/). While you can choose which taxonomies should have radio buttons for its terms using GUI, using this component you can create declarative configuration. The benefit is two-fold:

1) create persistent configuration to avoid accidentally changing the setting
2) declarative configuration allows to create "code as documentation"

### Pseudo-Router

This is a pseudo-router for WordPress. It is called *pseudo* as it does not map to classes as a conventional router would. None the less, this pseudo-router allows to neatly organize your WordPress template sections in an arbitary manner without any restrictions imposed by the WordPress.

### Settings

Settings is not a component per se but it shows how you can configure the WordPress theme using OOP style.

### Templates

Templates component is based on [Symfony's Templating Component](https://symfony.com/doc/current/components/templating.html). It is a custom implementation as it uses [Custom Template Enigne](https://symfony.com/doc/current/components/templating.html#creating-a-custom-engine) and a Custom File Loader (custom PHP class).
