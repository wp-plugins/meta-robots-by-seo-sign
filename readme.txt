=== MetaRobots by SEO-Sign ===
Contributors: Artem Pilipets
Donate link: http://www.seo-sign.com/p/simple-ways-to-manage-meta-robots-tag.html
Tags: robots.txt, meta robots, crawlers, editor, google, robots, search, seo, spiders
Requires at least: 3.0.1
Tested up to: 4.1
Stable tag: 4.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin allows you to control “robots” meta tag and “robots.txt” file from the control panel.

== Description ==

Manage prohibitions meta robots and robots.txt file from the control panel using the commands in the format of robots.txt

PHP script parses commands from the metarobots.txt file and creates relevant tags.

= Currently script supports following commands: =


 - Disallow:	
name="robots" content="noindex, nofollow"	
Blocks content from crawling for the search engine.

 - Index:		
name="robots" content="index, nofollow"		
Allows crawling, forbids follow the links.

 - Follow:		
name="robots" content="noindex, follow"
Forbids crawling, allows forbids follow the links.

 - Noarchiv:	
name="robots" content="noarchive"		
Do not show a link to the cached copy.

 - Nosnippet:	
name="robots" content="nosnippet"		
Do not create a snippet.

 - Noodp:		
name="robots" content="noodp"			
Do not use the description from DMOZ for snippet.

 - Notranslate:	
name="robots" content="notranslate"		
Do not offer page translation.

 - Noimageindex:	
name="robots" content="noimageindex"		
Do not crawl the image on the page.

== Screenshots ==
1. Meta Robots settings page