=== User Role Editor Pro ===
Contributors: Vladimir Garagulya (https://www.role-editor.com)
Tags: user, role, editor, security, access, permission, capability
Requires at least: 4.4
Tested up to: 5.7.2
Stable tag: 4.60
Requires PHP: 5.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

User Role Editor Pro WordPress plugin makes user roles and capabilities changing easy. Edit/add/delete WordPress user roles and capabilities.

== Description ==

User Role Editor Pro WordPress plugin allows you to change user roles and capabilities easy.
Just turn on check boxes of capabilities you wish to add to the selected role and click "Update" button to save your changes. That's done. 
Add new roles and customize its capabilities according to your needs, from scratch of as a copy of other existing role. 
Unnecessary self-made role can be deleted if there are no users whom such role is assigned.
Role assigned every new created user by default may be changed too.
Capabilities could be assigned on per user basis. Multiple roles could be assigned to user simultaneously.
You can add new capabilities and remove unnecessary capabilities which could be left from uninstalled plugins.
Multi-site support is provided.

== Installation ==

Installation procedure:

1. Deactivate plugin if you have the previous version installed.
2. Extract "user-role-editor-pro.zip" archive content to the "/wp-content/plugins/user-role-editor-pro" directory.
3. Activate "User Role Editor Pro" plugin via 'Plugins' menu in WordPress admin menu. 
4. Go to the "Settings"-"User Role Editor" and adjust plugin options according to your needs. For WordPress multisite URE options page is located under Network Admin Settings menu.
5. Go to the "Users"-"User Role Editor" menu item and change WordPress roles and capabilities according to your needs.

In case you have a free version of User Role Editor installed: 
Pro version includes its own copy of a free version (or the core of a User Role Editor). So you should deactivate free version and can remove it before installing of a Pro version. 
The only thing that you should remember is that both versions (free and Pro) use the same place to store their settings data. 
So if you delete free version via WordPress Plugins Delete link, plugin will delete automatically its settings data. Changes made to the roles will stay unchanged.
You will have to configure lost part of the settings at the User Role Editor Pro Settings page again after that.
Right decision in this case is to delete free version folder (user-role-editor) after deactivation via FTP, not via WordPress.

== Changelog ==

= [4.60] 28.06.2021 =
* Core version: 4.60
* Fix: WP Multisite: User lost granted roles after click "Users->Capabilities->Update Network". 
* New: Edit posts/pages/custom post types restrictions add-on: new custom filters were added: 'ure_post_edit_access_restricted_taxonomies', 'ure_post_edit_access_allowed_terms', 'ure_post_edit_access_terms_to_exclude'.
* Update: Edit posts/pages/custom post types restrictions add-on: 
*   - It is compatible now with "Admin Columns" and "Advanced Custom Fields" plugins. "Admin columns" plugin did not showed "Advanced Custom Fields" managed column values, when URE applied edit restrictions. URE excludes now from edit restrictions ACF plugins custom post types 'acf-field-group' and 'acf-field'.
*   - It is compatible now with "Contact Form 7" plugin. You can restrict access to the CF7 plugin records the same way as to any other custom post type.
* Core version was updated to version 4.60
* New: Notification box was replaced with one based on the [jpillora/nofifyjs](https://notifyjs.jpillora.com/) jQuery plugin. It does not move down page content. It disappears automatically after 5 seconds. Click on it to remove it manually.
* Fix: "Add capability" shows warning styled notification when needed (invalid characters, etc.) instead of a successful one.
* Fix: Capabilities group uncheck and revert selection is blocked for the administrator role to exclude accident deletion of permissions from administrator role.

= [4.59.4] 12.05.2021 =
* Core version: 4.59.1
* New: Multisite: it's possible to leave selected roles for selected subsites unchanged after "Update Network" applied.  Add filter 'ure_network_update_leave_roles' and  
  return from it the array like this one - array( (int) blog_id => array('role_id1', 'role_id2', ... );
* Update: Posts/pages, custom post types edit restrictions add-on: child posts auto access takes into account all existing hierarchical post types, not only pages as earlier.
  Use 'ure_auto_access_children_for_hierarchical_post_types' filter in order to change this. It takes the single input parameter $hierarchical_post_types - the list of existing public hierarchical post types.
* Core version was updated to version 4.59.1
* New: Multisite: When update role at the main site with "Apply to all sites" option and PHP constant URE_MULTISITE_DIRECT_UPDATE === 1 (update roles directly in database, not via WordPress API), 
  URE overwrites all subsite roles with roles from the main site. It's possible now to leave selected role(s) for selected subsite(s) unchanged: add filter 'ure_network_update_leave_roles' and  
  return from it the array like this one - array( (int) blog_id => array('role_id1', 'role_id2', ... );
* Update: "Other roles" section is available now only for users with 'promote_users' capability.
* Update: Notice at the top of URE page about action result is not removed automatically after 7 seconds as earlier.
* Update: 'ure_sort_wp_roles_list' filter accepts these values for the single input parameter: false - leave roles list as it is; true or 'id' - sort roles list by role ID; 'name' - sort roles by role name in the alphabetical order.


Full list of changes is available in changelog.txt file.
