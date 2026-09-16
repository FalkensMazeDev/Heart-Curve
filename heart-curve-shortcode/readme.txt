=== Heart Curve Shortcode ===
Contributors: gregwhitehead
Tags: shortcode, canvas, math, svg, curve
Requires at least: 5.0
Tested up to: 6.6
Stable tag: 1.0.0
License: GPLv2 or later

Renders the implicit "heart curve" (x^2+y^2-1)^3 - x^2*y^3 = 0, filled solid, anywhere via a shortcode.

== Description ==

Drop this plugin in, activate it, and place the shortcode on any post, page, or widget:

    [heart_curve]

The curve is drawn on an HTML5 <canvas> by evaluating the implicit equation at every pixel and filling the region where the expression is <= 0 (the interior of the heart). No external libraries, no build step.

== Shortcode Attributes ==

    [heart_curve width="400" height="400" color="#e60000" background="transparent" range="1.6"]

* width / height — canvas size in pixels. Default 400 x 400.
* color — fill color for the heart, any hex value (e.g. "#e60000" or "#e00"). Default red.
* background — CSS color behind the curve, or "transparent". Default transparent.
* range — half-width of the math coordinate window shown (-range to +range on both axes). Default 1.6, which comfortably frames the whole curve. Increase to zoom out, decrease to zoom in.

You can use the shortcode multiple times on one page with different attributes — each canvas draws independently.

== Installation ==

1. Upload the `heart-curve-shortcode` folder to `/wp-content/plugins/`.
2. Activate the plugin through the "Plugins" menu in WordPress.
3. Add `[heart_curve]` to any post or page.

== Changelog ==

= 1.0.0 =
* Initial release.
