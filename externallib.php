<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Web service library functions
 *
 * @package    local_wsgetroles
 * @copyright  2020 corvus albus
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/lib/externallib.php');

/**
 * Web service API definition.
 *
 * @package local_wsgetroles
 * @copyright 2020 corvus albus
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class local_wsgetroles_external extends external_api {

    // Functionset for get_roles() ************************************************************************************************.

    /**
     * Parameter description for get_roles().
     *
     * @return external_function_parameters.
     */
    public static function get_roles_parameters() {
        return new external_function_parameters(
            array(
                'ids' => new external_multiple_structure(
                         new external_value(PARAM_INT, 'roleid')
                            , 'List of roleids. Wrong ids will return an array with "null" for the other role settings.
                                If all three lists (ids, shortnames, names) are empty, return all roles.',
                                        VALUE_DEFAULT, array()),
                'shortnames' => new external_multiple_structure(
                         new external_value(PARAM_TEXT, 'shortname')
                            , 'List of role shortnames. Wrong strings will return an array with "null" for the other role settings.
                                If all three lists (ids, shortnames, names) are empty, return all roles.',
                                        VALUE_DEFAULT, array()),
                'names' => new external_multiple_structure(
                         new external_value(PARAM_TEXT, 'name')
                            , 'List of role names. Wrong strings will return an array with "null" for the other role settings.
                                If all three lists (ids, shortnames, names) are empty, return all roles.',
                                        VALUE_DEFAULT, array()),
            )
        );
    }

    /**
     * Return roleinformation.
     *
     * This function returns roleid, rolename and roleshortname for all roles or for given roles.
     *
     * @param array $ids List of roleids.
     * @param array $shortnames List of role shortnames.
     * @param array $names List of role names.
     * @return array Array of arrays with role informations.
     */
    public static function get_roles($ids = [], $shortnames = [], $names = []) {

        // Validate parameters passed from web service.
        $params = self::validate_parameters(self::get_roles_parameters(), array(
            'ids' => $ids,
            'shortnames' => $shortnames,
            'names' => $names));

        $allroles = get_all_roles();
        $idsfound = array();
        $entriesnotfound = array();

        // Search for appropriate roles. If role found put id to idsfound. If not remember entry in entriesnotfound.
        $allentries = array('id' => $ids, 'name' => $names, 'shortname' => $shortnames);
        foreach ($allentries as $key => $entries) {
            if (!empty($entries)) {
                foreach ($entries as $entry) {
                    $entriesnotfound[] = array('name' => $key, 'value' => $entry);
                    foreach ($allroles as $r) {
                        if ($r->$key == $entry) {
                            $idsfound[] = $r->id;
                            // Entry found. Remove it from $entriesnotfound.
                            array_pop($entriesnotfound);
                            break;
                        }
                    }
                }
            }
        }

        // If all input arrays are empty, return all roles. Collect all role ids in $idsfound.
        if (empty(array_merge($ids, $names, $shortnames))) {
            $idsfound = array_column($allroles, 'id');
        }

        // Collect information of all found roles.
        foreach ($allroles as $r) {
            if (in_array($r->id, $idsfound)) {
                $roles[] = get_object_vars($r);
            }
        }

        // Add entries not found. All array elements despite of the given will be null.
        foreach ($entriesnotfound as $entry) {
            $roles[] = array($entry['name'] => $entry['value']);
        }

        return $roles;
    }

    /**
     * Parameter description for create_sections().
     *
     * @return external_description
     */
    public static function get_roles_returns() {
        return new external_multiple_structure(
                new external_single_structure(
                        array(
                            'id' => new external_value(PARAM_INT, 'role id', VALUE_DEFAULT, null),
                            'name' => new external_value(PARAM_TEXT, 'role name', VALUE_DEFAULT, null),
                            'shortname' => new external_value(PARAM_TEXT, 'role shortname', VALUE_DEFAULT, null),
                            'description' => new external_value(PARAM_TEXT, 'role description', VALUE_DEFAULT, null),
                            'sortorder' => new external_value(PARAM_INT, 'role sort order', VALUE_DEFAULT, null),
                            'archetype' => new external_value(PARAM_TEXT, 'role archetype', VALUE_DEFAULT, null),
                        )
                )
        );
    }
}
