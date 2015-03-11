# somc-fedev

A WordPress plugin widget that provides a responsive sortable and expandable/collapsible page list. 

The widget displays a list of **all** child pages of the page it is placed on. The plugin loads all needed (database) data ones (on the initial page load). Using this data sorting, expanding and collapsing is then handled by javascript and css transisions on the client side. 

# Dependencies 
This plugin widget has a indirect dependency on the Bootstrap 3 library via the worldpress devdmbootsrap3 theme (that provides the Boostrap html, css, js framework). 
To remove this dependency the plugin's css file needs to be extended to handle the responsive features provided by bootstrap (ie media queries) and the javascript part of the module would need to include the bootstrap provided collaps.js functionality.   

# Images showing the widget in action

List collapsed and sorted by title in ascending order, also as required title's truncated at 20 characters (on mose over the ful title will be shown in a tooltip) 

![](https://github.com/karma4u101/somc-fedev/blob/master/doc-img/kwlist1.png) 

List expanded in one level in one bransh, after list has been sorted in descending order.

![](https://github.com/karma4u101/somc-fedev/blob/master/doc-img/kwlist2.png) 

List expanded in two levels.

![](https://github.com/karma4u101/somc-fedev/blob/master/doc-img/kwlist3.png)   
