<?php
/**
 * Plugin Name: Internet Project Club Past Events Info
 * Description: A plugin for retrieving information about past events (last 10) of an specific Anderson Club
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

function ip_club_past_events($post_object) {
  if (is_page('past-events')) {
    $html .= '<div class="wrap">';
    $html .= '<div id="ip-club-past-events-ajax-list"><h2>Recent Past Club Events Info</h2></div>';
    echo $html;
  ?>
    <script type="text/javascript" >
    jQuery(document).ready(function($) {
		var clubId = 1;
		var url = "http://localhost:5050/api/ClubsWS/" + clubId + "/PastEvents";
        $.ajax({
		  method: "GET",
  	      url: url,
	      contentType: 'application/json'
        })
        .done(function( data ) {
          console.log('Successful AJAX Call! /// Return Data: ' + data);
		  
		  for (var i = 0; i < data.length; i++) {
			var item = data[i];
			var openTo;
			if (item.isPublic) {
				openTo = 'Everyone';
			}
			else {
				openTo = item.clubs;
			}
			var html = 
				'<div class="row"> \
					<div class="col"> \
						<div class="panel panel-primary"> \
							<div class="panel-heading"> \
								<h3 class="panel-title">' + item.title + '</h3> \
							</div> \
							<div class="panel-body"> \
								<dl class="list-unlisted"> \
									<dt>Date: ' + item.date + '</dt>\
									<dt>Time: ' + item.startsAt + ' to ' + item.endsAt + '</dt>\
									<dt>Location: ' + item.location + '</dt> \
									<dt>Description: ' + item.description + '</dt> \
									<dt>Open to: ' + openTo + '</dt> \
									<dt>Food: ' + item.food + '</dt> \
									<dt>Contact: ' + item.contact + '</dt> \
									<dt>Price: ' + item.price + '</dt> \
								</dl> \
							</div> \
						</div> \
					</div> \
				</div>';
			$('#ip-club-past-events-ajax-list').append(html);
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

add_action('the_post', 'ip_club_past_events');
?>