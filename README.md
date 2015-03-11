# somc-fedev

A WordPress plugin widget that provides a responsive sortable and expanable/colapsable page list view. 

The widget displays a list of **all** child pages of the page it is placed on. The plugin loads all needed (database) data ones (on the initial page load). Using this data sorting, expanding and collapsing is then handled by javascript and css transisions on the client side. 

![](https://github.com/karma4u101/somc-fedev/blob/master/doc-img/kwlist1.png) ![](https://github.com/karma4u101/somc-fedev/blob/master/doc-img/kwlist2.png) ![](https://github.com/karma4u101/somc-fedev/blob/master/doc-img/kwlist3.png)   

# Dependencies 
This worldpress plugin Widget has a indirect dependency on the Bootstrap 3 library via the worldpress devdmbootsrap3 theme (that provides the Boostrap html, css, js framework). 
To remove this dependency the plugin's css file needs to be extended to handle the resposive features provided by bootstrap (ie media querys) and the javascript part of the module would need to include the bootstrap provided collaps.js functionality.   

