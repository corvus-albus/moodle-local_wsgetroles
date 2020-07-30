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
 * Web service definitions for local_wsgetroles
 *
 * @package    local_wsgetroles
 * @copyright  2020 corvus albus
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$functions = array(
    'local_wsgetroles_get_roles' => array(
         'classname' => 'local_wsgetroles_external',
         'methodname' => 'get_roles',
         'classpath' => 'local/wsgetroles/externallib.php',
         'description' => 'Get roles. If you give over empty lists, all roles will be returned.',
         'type' => 'read',
         'capabilities' => '',
    ),
);
