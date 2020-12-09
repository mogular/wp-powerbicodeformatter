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
``[mcode theme=dark lineWidth=90 width=600px ]let a = 1 in a[/mcode]

= DAX code (PowerBI, PowerPivot) =
``[daxcode width=600px region=US]EVALUATE myTable[/daxcode]

All shortcode attributes are optional.

For API documentations see:

[PowerQueryFormatter](https://www.powerqueryformatter.com/api)

[DAXFormatter](https://www.sqlbi.com/blog/marco/2014/02/24/how-to-pass-a-dax-query-to-dax-formatter/)


The formatted results for unchanged code are cached (for 30 days) via WordPress transients.

PowerBI is a registered trademark of Microsoft.



== Changelog == 
= 1.0.0 =
Initial release
