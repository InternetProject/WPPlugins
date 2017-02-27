<?php
/**
 * Plugin Name: Internet Project Club Info
 * Description: A plugin for retrieving general information about Anderson Clubs
 * Version: 1.0
 * Author: Gustavo Panez
 * License: GPLv2
 *
 * Copyright 2017  Internet Project
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

function ip_club_info($post_object) {
  if (is_page('about-page')) {
    $html .= '<div class="wrap">';
    $html .= '<h2>Club Info</h2><br />';
    $html .= '<table id="ip-club-info-ajax-table">
      <thead>
        <tr>
          <th>Club Name</th>
          <th>Club Description</th>
	  	  <th>Club Email</th>
		  <th>Nickname</th>
        </tr>
      </thead>
      <tbody>';
    $html .= '</tbody></table>';
    $html .= '</div>';
    echo $html;
  ?>
    <script type="text/javascript" >
    jQuery(document).ready(function($) {
		var clubId = 5;
		var url = "http://localhost:5050/api/ClubsWS/" + clubId;
        $.ajax({
		  method: "GET",
  	      url: url,
	      contentType: 'application/json'
        })
        .done(function( data ) {
          console.log('Successful AJAX Call! /// Return Data: ' + data);
		  $('#ip-club-info-ajax-table').append('<tr><td>' + data.name + '</td><td>' + data.description + '</td><td>' + data.email + '</td><td>' + data.nickname + '</td></tr>');
        })
        .fail(function( data ) {
          console.log('Failed AJAX Call :( /// Return Data: ' + data);
        });
    });
    </script>
  <?php
  }
}

add_action('the_post', 'ip_club_info');
?>