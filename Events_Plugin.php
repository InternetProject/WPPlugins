<?php
/**
 * Plugin Name: Events Plugin
 * Plugin URI: http://dobsondev.com
 * Description: A plugin for testing how AJAX calls work with WordPress
 * Version: 0.666
 * Author: Rob Gibson
 * Author URI: http://dobsondev.com/
 * License: GPLv2
 *
 * Copyright 2014  Vital Effect  (email : admin@vitaleffect.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */


/*
 * Enqueue scripts and styles
 */
function events_plugin_style_scripts() {
  wp_enqueue_style( 'events-plugin-ajax-tester-css', plugins_url( 'events-plugin-ajax-tester.css', __FILE__ ) );
}
add_action( 'admin_enqueue_scripts', 'events_plugin_style_scripts' );

/*
 * Create the admin menu item
 */
function events_plugin_ajax_tester_create_admin_page() {
  add_menu_page( 'AJAX Tester', 'AJAX Tester', 'edit_pages', 'events_plugin_ajax_tester_admin/ve-admin.php', 'events_plugin_ajax_tester_admin_page', 'dashicons-clipboard', 49 );
}
add_action( 'admin_menu', 'events_plugin_ajax_tester_create_admin_page' );

/*
 *
 */
function events_plugin_ajax_tester_admin_page() {
  $html = '<div class="wrap">';
  $html .= '<h2>Events Plugin AJAX Tester</h2><br />';
  $html .= '<table id="events-plugin-ajax-table">
    <thead>
      <tr>
        <th>Option ID</th>
        <th>Option Name</th>
        <th>Option Value</th>
        <th>Autoload</th>
      </tr>
    </thead>
    <tbody>';
  $html .= '</tbody></table>';
  $html .= '<input type="text" size="4" id="events-plugin-ajax-option-id" />';
  $html .= '<button id="events-plugin-ajax-button">Get Option</button>';
  $html .= '</div>';
  echo $html;
}

/*
 * The JavaScript for our AJAX call
 */
function events_plugin_ajax_tester_ajax_script() {
  ?>
  <script type="text/javascript" >
  jQuery(document).ready(function($) {

    $( '#events-plugin-ajax-button' ).click( function() {
      var id = $( '#events-plugin-ajax-option-id' ).val();
      $.ajax({
		method: "GET",
		/**api connection. Need to update to events*/
    url: "http://localhost:5543/api/EventsWS",
        //data: { 'ElementName': 'Oxygen' },
		//contentType: 'text/plain'
		contentType: 'application/json'
      })
      .done(function( data ) {
        console.log('Successful AJAX Call! /// Return Data: ' + data);
        //data = JSON.parse( data );
        //$( '#dobsondev-ajax-table' ).append('<tr><td>' + data.option_id + '</td><td>' + data.option_name + '</td><td>' + data.option_value + '</td><td>' + data.autoload + '</td></tr>');
		//$( '#dobsondev-ajax-table' ).append(data);
      })
      .fail(function( data ) {
        console.log('Failed AJAX Call :( /// Return Data: ' + data);
      });
    });

  });
  </script>
  <?php
}
add_action( 'admin_footer', 'events_plugin_ajax_tester_ajax_script' );

function gibson_test($post_object) {
  if (is_page('sample-page')) {
	$html = 'In Sample Page';
  }
  $html .= '<div class="wrap">';
  $html .= '<h2>Gibson Test</h2><br />';
  $html .= '<table id="gibson-ajax-table">
    <thead>
      <tr>
        <th>Event Date/Time</th>
        <th>Event Location</th>
        <th>Event Description</th>
      </tr>
    </thead>
    <tbody>';
  $html .= '</tbody></table>';
  $html .= '</div>';
  echo $html;
  ?>
  <script type="text/javascript" >
  jQuery(document).ready(function($) {
      $.ajax({
		method: "GET",
		//need to update api url here as well
    url: "http://localhost:5543/api/EventsWS",
        data: { 'id': '0' },
		//contentType: 'text/plain'
		contentType: 'application/json'
      })
      .done(function( data ) {
        console.log('Successful AJAX Call! /// Return Data: ' + data);
        //data = JSON.parse(data);
		$( '#gibson-ajax-table' ).append('<tr><td>' + data.startsat + '</td><td>' + data.location + '</td><td>' + data.description + '</td></tr>');
      })
      .fail(function( data ) {
        console.log('Failed AJAX Call :( /// Return Data: ' + data);
      });

  });
  </script>
  <?php
}

add_action( 'the_post', 'gibson_test' );
?>