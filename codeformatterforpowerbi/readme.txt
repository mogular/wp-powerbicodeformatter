=== Code formatter for PowerBI ===
Contributors: mogular
Tags: code, powerbi, dax, m, powerquery
Requires at least: 4.0
Tested up to: 5.6
Requires PHP: 7.2
Stable tag: 1.0.0
License: Apache License, Version 2.0
License URI: http://www.apache.org/licenses/LICENSE-2.0

Use this plugin to format your Power BI Codes (DAX and M) via simple shorttags

== Description ==

WordPress plugin for formatting and beautifying of DAX and M code
(as used in PowerQuery, PowerBI and Excel PowerPivot)

= M code (PowerQuery) =
``[mcode theme=dark linewidth=90 width=600px ]let a = 1 in a[/mcode]

= DAX code (PowerBI, PowerPivot) =
``[daxcode width=600px region=US]EVALUATE myTable[/daxcode]

All shortcode attributes are optional.

The plugin formats your code, by sending it to the following free services and showing the result on your site.
The formatted results for unchanged code are cached (for 30 days) via WordPress transients.

- M code is formatted by [PowerQueryFormatter](https://www.powerqueryformatter.com)
[Terms of use](https://www.powerqueryformatter.com/api)
[API Documentation](https://www.powerqueryformatter.com/api)

- DAX code is formatted by [DAXFormatter](https://www.daxformatter.com)
[Terms of use](https://www.daxformatter.com) (scroll down to "Terms of use")
[API Documention](https://www.sqlbi.com/blog/marco/2014/02/24/how-to-pass-a-dax-query-to-dax-formatter/)

By using the plugin (and therefore using the services of [DAXFormatter](https://www.daxformatter.com) and [PowerQueryFormatter](https://www.powerqueryformatter.com)) you agree to their terms of use (see links above).

Power BI is a registered trademark of Microsoft Corp.

== Frequently Asked Questions ==
= I need a feature the plugin does not provide =
This plugin is open source. Please provide a pull request or create an issue on the [github repository](https://github.com/mogular/wp-powerbicodeformatter).


== Changelog == 
= 1.0.0 =
Initial release
