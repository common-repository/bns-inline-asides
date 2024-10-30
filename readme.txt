=== BNS Inline Asides ===
Contributors: cais
Donate link: http://buynowshop.com
Tags: posts, pages, content, shortcode, plugin-only
Requires at least: 3.6
Tested up to: 4.9
Stable tag: 1.3.2
License: GNU General Public License v2
License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html

This plugin will allow you to style sections of the post, or page, content with added emphasis by leveraging a style element from the active theme.

== Description ==

Have you ever wanted to add a personal comment into the body of a post or page and have it stand out from the rest of the content?<br />
Have you really wanted to throw a rant in a review because the subject just really got under your skin but you don't want to dramatically disrupt the content?<br />
This plugin will allow you to style sections of the post, or page, content with a shortcode that can add more emphasis by leveraging a style element from the active theme.<br />
These asides can be left open as part of the content flow; or these asides can be closed to leave your readers the option of opening them if they choose to.<br />

== Installation ==

This section describes how to install the plugin and get it working.

1. Go to the "Plugins" menu in the Administration Panels ("dashboard").
2. Click the 'Add New' link.
3. Click the "Upload" link. 
4. Browse for the bns-inline-asides.zip file on your computer; upload; and, install accordingly.
5. Activate.

-- or -

1. Go to the "Plugins" menu in the Administration Panels ("dashboard").
2. Click the 'Add New' link.
3. Search for BNS Inline Asides.
4. Install.
5. Activate.

Please read this article for further assistance: http://wpfirstaid.com/2009/12/plugin-installation/

----

= Usage =
This plugin makes use of WordPress Shortcode API (additional information can be found in the codex here: http://codex.wordpress.org/Shortcode_API)

The basic shortcode usage is `[aside]CONTENT[/aside]`. The default values of the shortcode are type: aside; and, status: open.

* `[aside]CONTENT[/aside] = [aside type="aside" status="open"]CONTENT[/aside]`

To use the `[aside]` shortcode and have it initially "closed" any status other than "open" will work as the plugin will change the status to "closed" if it is not equal to "open".

The pre-defined aside types currently included:

* Note - uses the theme element's default text color on a Light Grey background
* Rant - uses black text on a red background with a non-repeating flame graphic
* Changelog - sets the font to monospace, reminiscent of type written notes
* Footnote - uses lower-case roman numerals when the items are written using an (HTML) ordered list
* Nota Bene (NB) - italicizes the text within the aside
* Black text on a transparent background with a non-repeating hat graphic
* Correction - Black text on a transparent background with a non-repeating checkbox graphic
* Update - Black text on a transparent background with a non-repeating circular arrow graphic

See the frequently asked questions section for how to add your own custom type.

== Frequently Asked Questions ==

= Are there any GDPR relevant concerns when using this plugin? =
We are not aware of any concerns as they pertain to the GDPR.

= Why doesn't the "Rant" type work with the "H" tags? =
Not all possible combinations of existing BNS Inline Aside types have been set as defaults.
Please feel free to add the bns-inline-asides-custom-stylesheet.css option and create your own combinations ...
... and let us know about them. We would be very happy to consider adding them as defaults.

= How can I style the plugin output? =
To add your own custom aside type styles you might consider creating a new stylesheet in this plugin's folder using the name: bnsia-custom-types.css

The plugin will create a class name from the custom aside type you use in your shortcode. For example, `[aside type="bacon"]` will generate these classes you can style:

* .open-aside.bacon
* .close-aside.bacon
* .bnsia.aside.bacon
* blockquote.aside.bacon

This method can also be used to over-write the Pre-Defined Aside Types styles as the bnsia-custom-types.css file loads after the main stylesheet.

The bnsia-custom-types.css stylesheet should not be over-written by updates.

= How do I use the 'show' and 'hide' parameters? =
If you do not want to use the default 'show' and 'hide' parameters, you can change them to your own preference in each instance of the shortcode. If you want your aside type to be dynamically inserted into the message simply use the `%s` placeholder in your custom message.

Here are some examples:

* `[aside type="bacon" show="Want to see my <em>%s</em>?" status="closed"]`
* `[aside type="soup" hide="No %s for you!"]`


== Screenshots ==
1. Sample using pre-defined aside Note (open).
2. Sample using pre-defined aside Note (closed).
3. Sample using pre-defined aside Rant (closed).
4. Sample using pre-defined aside Rant (open).

== Other Notes ==

= Copyright 2011-2018  Edward Caissie  (email : edward.caissie@gmail.com) =

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License version 2,
  as published by the Free Software Foundation.

  You may NOT assume that you can use any other version of the GPL.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

  The license for this software can also likely be found here:
  http://www.gnu.org/licenses/gpl-2.0.html
  
= Acknowledgements =

  Credits for jQuery assistance: Trevor Mills www.topquarkproductions.ca

= Screenshots Source Content =
Sample content taken from the "Readability" post of the Theme Unit Test data found here: http://codex.wordpress.org/Theme_Unit_Test used with the default Twenty Ten Theme.

== Upgrade Notice ==
Please stay current with your WordPress installation, your active theme, and your plugins.

== Changelog ==
= 1.3.2 =
* Released July 2018
* Set return value as string (and remove forcing $element to array).

= 1.3.1 =
* Released July 2018
* Minor updates to text strings, copyright dates, and variable designation

= 1.3 =
* Released May 2015
* Added `BNS Inline Asides Update Message` function
* Added i18n support
* Added default and English (Canada) translation files
* Updated copyright years
* Minor code clean-up

= 1.2 =
* Released November 2014
* Added sanity checks for `BNS_CUSTOM_*` define statements
* Added `_x` i18n implementation to `show` and `hide` default messages
* Replaced `BNS_Inline_Asides::replace_spaces` with `sanitize_html_class` functionality
* Renamed `BNSIA_Scripts_and_Styles` to `scripts_and_styles`
* Updated `readme.txt` to note additional default types of asides

= 1.1 =
* Released May 2014
* Moved custom CSS folder location to `/wp-content/bns-customs/`
* Move JavaScript enqueue to footer
* Updated required version to 3.6 due to use of optional filter variable in `shortcode_atts`
* Updated WordPress version compatibility
* Updated copyright years

= 1.0.3 =
* Released December 2013
* Code reformatting to better reflect WordPress Coding Standards (see https://gist.github.com/Cais/8023722)
* Added functional option to put `bnsia-custom-types.css` in `/wp-content/` folder
* Code reductions (see `replace_spaces` usage)
* Inline documentation updates

= 1.0.2 =
* Released August 2013
* Added new aside type: Update
* Added dynamic filter parameter to shortcode attributes

= 1.0.1 =
* Released July 2013
* Added new aside type: Correction

= 1.0 =
* Released <:3()~~~ 2013
* Added code block termination comments
* Added 'hat.png' image for "Hat Tip" type
* Added missing `bnsia` class to theme elements other than default
* Added style definitions for "Hat Tip" type
* Minor documentation improvements
* Moved stylesheet into its own directory
* Moved images into their own directory
* Moved JavaScripts into its own directory
* Refactored $bnsia_element to simply $element
* Removed direct jQuery enqueue (called as a dependency of 'bnsia-script.js')
* Removed unused style definitions
* Use an array of elements rather than a convoluted if statement to sort out if an accepted container is being used

= 0.9 =
* Released January 2013
* Removed Jetpack counter-measures hack
* Moved JavaScript from inline to its own enqueued file
* Implemented `wp_localize_script` to maintain the dynamic element

= 0.8.1 =
* Released December 2012
* Added Jetpack hack for single view conflict

= 0.8 =
* Released November 2012
* Add `element` shortcode attribute to allow the use of specific HTML tags
* Corrected documentation typos
* Implemented HTML tags: aside, blockquote, code, h1 through h6, pre, and q;
* Removed `load_plugin_textdomain` as redundant
* Removed `p` CSS related elements and properties
* Removed `blockquote` `background: none` property
* Updated the 'readme' FAQ section to reference the new functionality

= 0.7 =
* Implement OOP style class coding
* Internal documentation updates and improve code formatting
* Add Type: Footnote
* Add Type: Nota Bene (can also use the more common short-form NB)

= 0.6.2 =
* confirmed compatible with WordPress 3.4
* inline documentation updates
* added "changelog" styles

= 0.6 =
* released November 2011
* confirmed compatible with WordPress version 3.3
* added PHPDoc style documentation
* added `BNS Inline Asides TextDomain` i18n support
* added `BNS Theme Element` to set CSS element to be used
* added `bnsia` class (to be used as default)
* removed `is_admin` check from enqueue action function (not needed)
* removed 'span' support; going forward with block display elements only

= 0.5 =
* released June 2011
* re-wrote the enqueue stylesheets code to be more correct

= 0.4.1 =
* enqueued stylesheets
* released May 23, 2011

= 0.4 =
* verified to work with WordPress version 3.2-beta1 
* re-wrote the BNSIA_PATH define statement
* re-wrote the stylesheet paths to use BNSIA_PATH
* released May 23, 2011 

= 0.3 =
* verified to work with WordPress version 3.1.2
* added new parameters to allow end-user to define 'show' and 'hide' messages
* released: May 7, 2011

= 0.2 =
* add the 'span' element
* fix readme markup issues

= 0.1 =
* Initial Release.
* Released: February 20, 2011