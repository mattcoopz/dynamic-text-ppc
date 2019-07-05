=== Dynamic Text PPC ===
Contributors: mattcoopz
Tags: ppc,dynamic text,adwords
Requires at least: 5.0
Tested up to: 5.2.1
License: GPL2

A plugin to get a parameter passed to a landing page from an advertising campaign. Then to take that parameter and output it as a formatted text block.

== Description ==
A plugin to get a parameter passed to a landing page from an advertising campaign. Then to take that parameter and output it as a formatted text block. This then allows for dynamic landing page copy to be implemented for various campaigns across various platforms

== Installation ==
Upload to your wordpress site via the built in admin section of the site and activate.

== How to use ==
You can pass all sorts of parameters including:

findthisparameter: So you an set the parameter name per page or per campaign

pre_term: The text in front of your dynamic text

post_term: The text at the end of your dynamic text

backup_term: This is the text you want to show if there isn’t a parameter there

style_class: Put in your custom class that you want to use to style the dynamic text

which_tag: You decide what tag you want to use with your dynamic text. e.g. h1, p, strong

For example:
[display_keyword_ppc backup_term="Some other term backup" pre_term="In front of" post_term="get behind" style_class="dynamic_text_style" which_tag="h1" findthisparameter="titleparam"]

[display_keyword_ppc backup_term="Some other term backup" findthisparameter="titleparam"]