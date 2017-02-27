<?php
/**
 * Plugin Name: Internet Project Club Officers Info
 * Description: A plugin for retrieving information about Anderson Clubs Officers
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

function ip_club_officers($post_object) {
  if (is_page('leadership')) {
    $html .= '<div class="wrap">';
    $html .= '<h2>Club Officers Info</h2><br />';
    $html .= '<table id="ip-club-officers-ajax-table">
      <thead>
        <tr>
          <th></th>
		  <th></th>
		  <th></th>
        </tr>
      </thead>
      <tbody>';
    $html .= '</tbody></table>';
    $html .= '</div>';
    echo $html;
  ?>
    <script type="text/javascript" >
    jQuery(document).ready(function($) {
		var clubId = 4;
		var url = "http://localhost:5050/api/ClubsWS" + "/" + clubId + "/Officers";
        $.ajax({
		  method: "GET",
  	      url: url,
	      contentType: 'application/json'
        })
        .done(function( data ) {
          console.log('Successful AJAX Call! /// Return Data: ' + data);
		  var numCols = 3;
		  var numRowCompleted = Math.floor(data.length / numCols);
		  var cellsInIncompleteRow = data.length %  numCols;
		  for (var i = 0; i < numRowCompleted; i++) {
			$('#ip-club-officers-ajax-table').append('<tr>');
			for (var j = 0; j < numCols; j++) {
				var item = data[i * numCols + j];
				$('#ip-club-officers-ajax-table').append('<td>' + item.firstName + "</br>" + item.lastName + "</br>" + item.email + "</br>" + item.program + '</td>');
			}
			$('#ip-club-officers-ajax-table').append('</tr>');
		  }
		  if (cellsInIncompleteRow > 0) {
			$('#ip-club-officers-ajax-table').append('<tr>');
			for (var i = 0; i < cellsInIncompleteRow; i++) {
				var item = data[numRowCompleted * numCols + i];
				$('#ip-club-officers-ajax-table').append('<td>' + item.firstName + "</br>" + item.lastName + "</br>" + item.email + "</br>" + item.program + '</td>');
			}
			$('#ip-club-officers-ajax-table').append('</tr>');
		  }
        })
        .fail(function( data ) {
          console.log('Failed AJAX Call :( /// Return Data: ' + data);
        });
    });
    </script>
  <?php
  }
}

add_action('the_post', 'ip_club_officers');
?>