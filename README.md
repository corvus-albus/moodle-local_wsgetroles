Moodle WebService Get Roles (wsgetroles)
====================================================

This local plugin allows you to get moodles roles via REST API. There is no possibility to get role ids directly via rest api, 
though there are two core functions demanding for role id: core_role_assign_roles and core_role_unassign_roles.

The function local_wsgetroles_get_roles is added to the rest api. You can give over lists of roleids, rolenames and/or roleshortnames and get the associated roleinformations (id, name, shortname, description, sortorder, archetype). If the given id, name, shortname has no corresponding role, roleinfomations will be "null" despite of the search entry. 
If you give over empty lists all roles will be returned.

Some example calls to the webservice function:

* Get all roles:
https://yoursite.com/webservice/rest/server.php?wstoken=yOurT0k3n&moodlewsrestformat=json&wsfunction=local_wsgetroles_get_roles

* Get roles with id=1, id=2 or shortname=editingteacher:
  https://yoursite.com/webservice/rest/server.php?wstoken=yOurT0k3n&moodlewsrestformat=json&wsfunction=local_wsgetroles_get_roles&ids[0]=1&ids[1]=2&shortnames[0]=editingteacher

* Get role with name=Teacher:
  https://yoursite.com/webservice/rest/server.php?wstoken=yOurT0k3n&moodlewsrestformat=json&wsfunction=local_wsgetroles_get_roles&names[0]=Teacher 


Configuration
-------------
No configuration needed, just install the plugin. Keep in mind to add the functions to the rest-service.

Usage
-----
Use functions over Rest API.

Requirements
------------
- Moodle 3.3 or later

Installation
------------
Copy the wsgetroles folder into your /local directory. Add the functions to your rest-service. 

Author
------
Corvus Albus
