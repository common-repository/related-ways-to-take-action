=== Related Ways to Take Action ===
Contributors: Social Actions, E. Cooper
Donate link: http://www.socialactions.com
Tags: donate, philanthropy, social actions, activism, related, posts, nptech, action, nonprofit, charity, activism, advocacy, npos
Requires at least: 2.6
Tested up to: 2.7
Stable tag: 0.3

The “Related Ways to Take Action” WordPress Plugin makes it super easy to connect your readers to ways to take action based on the content of your posts.

== Description ==

The “Related Ways to Take Action” WordPress Plugin makes it super easy to connect your readers to ways to take action based on the content of your posts.

The Plugin identifies the top three keywords for each post and then searches for related campaigns from from Change.org, GlobalGiving.com, Idealist.org, DonorsChoose.org, Kiva, Care2 and over twenty other social change websites. It then automatically loads the top three campaigns for those keywords at the bottom of each of your posts.

“Related Ways to Take Action” connects your readers to actions based on the stuff you’re already writing about – so you don’t have to do anything else! You’ll also be surprised by the local and global campaigns, petitions, and fundable projects recommended for your posts!

The “Related Ways to Take Action” WordPress Plugin is a project of Social Actions Labs: http://socialactions.com/labs

For more info about the WordPress plugin, please see our project page: http://www.socialactions.com/labs/wordpress-related-actions

For a list of participating social action platforms, please visit: http://socialactions.com/meet-the-platforms

== Screenshots ==

1. This is a screenshot of the Related Ways to Take Action plugin using an example blog post from the Internet. The post discusses Peabody Coal's strain on a natural water supply in Arizona and the fight to stop them. 

== Installation == 

"Related Ways to Take Action" is compatible with all versions of PHP.

"Related Ways to Take Action" follows the WordPress standard for adding and installing plugins:

1. Upload the `related-ways-to-take-action` directory to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

...And that's it. Everything else is handled by the plugin when it's installed.

== Settings and Customizations ==

= Setting Keywords Manually =

The keywords used to pull related actions from the Social Actions Open API are usually automatically derived from the content of your post. However, if you feel your post isn't necessarily pointed enough to provide clear, strong keywords through the plugin, you can override them with the %RA={search terms}% tag.

For example, if your post details new green initiatives coming from local schools and you want to show only environmental related actions, you could put %RA=green environment% anywhere in your post. If you would rather have the plugin decide the keywords (or vice-versa) later, simply remove the tag from your post. The related actions will be updated the next time the plugin updates its cache.

= Blacklisting Actions and Terms =

Through the administration menu (found at Settings->Related Ways to Take Action from Wordpress admin menu), you can blacklist particular words and actions from showing up in the Related Ways to Take Action plugin.

For clarification and examples, please refer to the administration menu.

= Adding or Removing Platforms =

Using the plugin's administration menu (found at Settings->Related Ways to Take Action from Wordpress admin menu), any platform featured on Social Actions can be added or removed with a simple click of the mouse. Don't like Idealist? The Point? You can remove them with a click. Getting them back is just as easy.

= Blocking Certain Actions By Type =

Along with picking and choosing platforms, you can choose to display only the types of actions you want through the administration and settings menu.


== Frequently Asked Questions == 

= Help! My post doesn't show three related actions! =

In order to maintain proper performance on your blog (and be as unobtrusive as possible), if the Social Actions' API doesn't respond in a timely manner, the "Related Ways to Take Action" plugin will essentially turn itself "off" for that particular post, for that particular page view. This sort of thing should occur very rarely.

= This plugin is displaying completely unrelated actions! =

Much like the above question, depending on the circumstances, if Social Actions' Open API doesn't respond favorably, the plugin will react accordingly. Occasionally, that means it will display a previously cached result for that particular post, for that particular page view. This is done purely in the interest in maintaining your blog's proper load times. This sort of display should happen rather rarely, however.

= What if I don't want to display the plugin on a post? =

The "Related Ways to Take Action" plugin can be disabled for a particular post by using the tag %NORA% somewhere within your post. The plugin will recognize and remove the tag while disabling itself for that post.

= The plugin looks different than the screenshot! Help? =

The "Related Ways to Take Action" plugin uses the Wordpress hook wp head (http://codex.wordpress.org/Hook_Reference/wp\_head) to properly link the stylesheet included in its root directory. If the related actions appear to be drastically different on your blog than on other blogs, the wp head hook is probably not being called from your template.

To check, please search for wp head() within your Wordpress template. If it's not to be found, you can either insert it in the proper place within the template or add the CSS in ra style.css to the CSS for your Wordpress blog.

= Ugh. Can I change the display of the plugin? =

Yes! The CSS file used can be found in the root directory of the plugin, ra_style.css. Feel free to edit it to your heart's desire!