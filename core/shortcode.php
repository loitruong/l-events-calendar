<?php 
    function lec_calendar_shortcode($attr){
    	  $category = '';
    	  $topCalendar = '';
    	  $color = '';
	      if (isset($attr['category'])) {
	    	$category = $attr['category'];
	      }
		  if (isset($attr['displayimage'])) {
		  	$displayImage = $attr['displayimage'];
		  	if((boolean)$displayImage){
		  		$topCalendar = '<div class="top-calendar">
		  	    		<div class="preloader">
		  	    			<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" viewBox="0 0 500 500" xml:space="preserve" enable-background="new 0 0 500 500"><path d="M250 0c14 0 24 10 24 24v94c0 14-10 25-24 25s-25-11-25-25V24C225 10 236 0 250 0z" fill="#010002"/><path d="M137 53l55 76c12 16 0 39-20 39 -8 0-14-3-19-10L98 82c-8-11-6-26 5-34S129 42 137 53z" fill="#010002"/><path d="M28 204c-13-4-20-18-16-31s18-20 31-16l89 29c13 4 20 18 16 31 -3 10-14 17-24 17 -3 0-4-1-7-2L28 204z" fill="#010002"/><path d="M148 283c4 13-3 27-16 31l-89 29c-3 1-5 1-8 1 -10 0-20-7-23-17 -4-13 3-27 16-31l89-29C130 263 144 270 148 283z" fill="#010002"/><path d="M187 337c11 8 13 23 5 34l-55 76c-5 7-12 10-20 10 -20 0-31-23-19-39l55-76C161 331 176 329 187 337z" fill="#010002"/><path d="M250 357c14 0 24 11 24 25v93c0 14-10 25-24 25s-25-11-25-25v-93C225 368 236 357 250 357z" fill="#010002"/><path d="M347 342l55 76c12 16 0 39-20 39 -8 0-14-3-19-10l-55-76c-8-11-6-26 5-34S339 331 347 342z" fill="#010002"/><path d="M472 296c13 4 20 18 16 31 -3 10-14 17-24 17 -3 0-4 0-7-1l-89-29c-13-4-20-18-16-31s18-20 31-16L472 296z" fill="#010002"/><path d="M352 217c-4-13 3-27 16-31l89-29c13-4 27 3 31 16s-3 27-16 31l-89 28c-3 1-5 2-8 2C365 234 355 227 352 217z" fill="#010002"/><path d="M327 168c-20 0-31-23-19-39l55-76c8-11 23-13 34-5s13 23 5 34l-55 76C342 165 335 168 327 168z" fill="#010002"/></svg>
		  	    		</div>
		  	    	</div>';
		  	}
		  }
		  if (isset($attr['calendarcolor'])) {
		  	$color = $attr['calendarcolor'];
		  }


          return '
          	  <style>
				#loicalendar,#loicalendar .calendar-row .calendar-column .column-date.currentDate{border-color:'. $color .'}#loicalendar .calendar-nav,#loicalendar .calendar-row .calendar-column .column-date.currentDate{color:'. $color .'}#loicalendar .calendar-nav svg,#loicalendar .calendar-row .view-all-events.active svg,#loicalendar .top-calendar .preloader svg, #loicalendar .top-calendar .preloader svg path{fill:'. $color .'}#loicalendar .loiModal .close{background-color:'. $color .'}#loicalendar .loiModal .close:active,#loicalendar .loiModal .close:focus,#loicalendar .loiModal .close:hover{background-color:#fff;color:'. $color .'}
          	  </style>
		      <div id="loicalendar" category="'. $category .'" imagePath="'. plugins_url( '../img/', __FILE__ ) .'">
		      	<div class="binders">
		      		<img src="'.  plugins_url( '../img/binder.png', __FILE__ ) . '" alt="" width="37" height="33">
		      		<img src="'.  plugins_url( '../img/binder.png', __FILE__ ) . '" alt="" width="37" height="33">
		      		<img src="'.  plugins_url( '../img/binder.png', __FILE__ ) . '" alt="" width="37" height="33">
		      		<img src="'.  plugins_url( '../img/binder.png', __FILE__ ) . '" alt="" width="37" height="33">
		      		<img src="'.  plugins_url( '../img/binder.png', __FILE__ ) . '" alt="" width="37" height="33">
		      		<img src="'.  plugins_url( '../img/binder.png', __FILE__ ) . '" alt="" width="37" height="33">
		      		<img src="'.  plugins_url( '../img/binder.png', __FILE__ ) . '" alt="" width="37" height="33">
		      		<img src="'.  plugins_url( '../img/binder.png', __FILE__ ) . '" alt="" width="37" height="33">
		      		<img src="'.  plugins_url( '../img/binder.png', __FILE__ ) . '" alt="" width="37" height="33">
		      		<img src="'.  plugins_url( '../img/binder.png', __FILE__ ) . '" alt="" width="37" height="33">
		      		<img src="'.  plugins_url( '../img/binder.png', __FILE__ ) . '" alt="" width="37" height="33">
		      		<img src="'.  plugins_url( '../img/binder.png', __FILE__ ) . '" alt="" width="37" height="33">
		      		<img src="'.  plugins_url( '../img/binder.png', __FILE__ ) . '" alt="" width="37" height="33">
		      		<img src="'.  plugins_url( '../img/binder.png', __FILE__ ) . '" alt="" width="37" height="33">
		      		<img src="'.  plugins_url( '../img/binder.png', __FILE__ ) . '" alt="" width="37" height="33">
		      		<img src="'.  plugins_url( '../img/binder.png', __FILE__ ) . '" alt="" width="37" height="33">
		      		<img src="'.  plugins_url( '../img/binder.png', __FILE__ ) . '" alt="" width="37" height="33">
		      		<img src="'.  plugins_url( '../img/binder.png', __FILE__ ) . '" alt="" width="37" height="33">
		      		<img src="'.  plugins_url( '../img/binder.png', __FILE__ ) . '" alt="" width="37" height="33">
		      		<img src="'.  plugins_url( '../img/binder.png', __FILE__ ) . '" alt="" width="37" height="33">
		      		<img src="'.  plugins_url( '../img/binder.png', __FILE__ ) . '" alt="" width="37" height="33">
		      		<img src="'.  plugins_url( '../img/binder.png', __FILE__ ) . '" alt="" width="37" height="33">
		      		<img src="'.  plugins_url( '../img/binder.png', __FILE__ ) . '" alt="" width="37" height="33">
		      		<img src="'.  plugins_url( '../img/binder.png', __FILE__ ) . '" alt="" width="37" height="33">
		      		<img src="'.  plugins_url( '../img/binder.png', __FILE__ ) . '" alt="" width="37" height="33">
		      		<img src="'.  plugins_url( '../img/binder.png', __FILE__ ) . '" alt="" width="37" height="33">
		      		<img src="'.  plugins_url( '../img/binder.png', __FILE__ ) . '" alt="" width="37" height="33">
		      		<img src="'.  plugins_url( '../img/binder.png', __FILE__ ) . '" alt="" width="37" height="33">
		      		<img src="'.  plugins_url( '../img/binder.png', __FILE__ ) . '" alt="" width="37" height="33">
		      		<img src="'.  plugins_url( '../img/binder.png', __FILE__ ) . '" alt="" width="37" height="33">
		      		<img src="'.  plugins_url( '../img/binder.png', __FILE__ ) . '" alt="" width="37" height="33">
		      		<img src="'.  plugins_url( '../img/binder.png', __FILE__ ) . '" alt="" width="37" height="33">
		      		<img src="'.  plugins_url( '../img/binder.png', __FILE__ ) . '" alt="" width="37" height="33">
		      		<img src="'.  plugins_url( '../img/binder.png', __FILE__ ) . '" alt="" width="37" height="33">
		      		<img src="'.  plugins_url( '../img/binder.png', __FILE__ ) . '" alt="" width="37" height="33">
		      		<img src="'.  plugins_url( '../img/binder.png', __FILE__ ) . '" alt="" width="37" height="33">
		      	</div>
		      	'. $topCalendar .'
		      	<div class="calendar-nav">
		      		<span class="prev-month">
		      			<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" width="44.24" height="44.24" viewBox="0 0 44.24 44.24" xml:space="preserve" enable-background="new 0 0 44.238 44.238"><path d="M22.12 44.24C9.92 44.24 0 34.32 0 22.12S9.92 0 22.12 0s22.12 9.92 22.12 22.12S34.31 44.24 22.12 44.24zM22.12 1.5C10.75 1.5 1.5 10.75 1.5 22.12c0 11.37 9.25 20.62 20.62 20.62s20.62-9.25 20.62-20.62C42.74 10.75 33.49 1.5 22.12 1.5z"/><path d="M24.67 29.88c-0.19 0-0.38-0.07-0.53-0.22l-7.33-7.33c-0.29-0.29-0.29-0.77 0-1.06l7.33-7.33c0.29-0.29 0.77-0.29 1.06 0s0.29 0.77 0 1.06L18.4 21.8l6.8 6.81c0.29 0.29 0.29 0.77 0 1.06C25.05 29.81 24.86 29.88 24.67 29.88z"/></svg>
		      		</span>
		      		<div class="current-month"></div>
		      		<span class="next-month">
		      			<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" width="44.24" height="44.24" viewBox="0 0 44.24 44.24" xml:space="preserve" enable-background="new 0 0 44.236 44.236"><path d="M22.12 44.24C9.92 44.24 0 34.31 0 22.12S9.92 0 22.12 0s22.12 9.92 22.12 22.12S34.31 44.24 22.12 44.24zM22.12 1.5C10.75 1.5 1.5 10.75 1.5 22.12c0 11.37 9.25 20.62 20.62 20.62 11.37 0 20.62-9.25 20.62-20.62C42.74 10.75 33.49 1.5 22.12 1.5z"/><path d="M19.34 29.88c-0.19 0-0.38-0.07-0.53-0.22 -0.29-0.29-0.29-0.77 0-1.06l6.8-6.8 -6.8-6.8c-0.29-0.29-0.29-0.77 0-1.06 0.29-0.29 0.77-0.29 1.06 0l7.33 7.33c0.29 0.29 0.29 0.77 0 1.06l-7.32 7.33C19.73 29.81 19.53 29.88 19.34 29.88z"/></svg>
		      		</span>
		      	</div>
		      	<div class="calendar-layout">
		      		<div class="calendar-row-header">
		      			<div class="calendar-column">
		      				Sun
		      			</div>
		      			<div class="calendar-column">
		      				Mon
		      			</div>
		      			<div class="calendar-column">
		      				Tue
		      			</div>
		      			<div class="calendar-column">
		      				Wed
		      			</div>
		      			<div class="calendar-column">
		      				Thu
		      			</div>
		      			<div class="calendar-column">
		      				Fri
		      			</div>
		      			<div class="calendar-column">
		      				Sat
		      			</div>
		      		</div>
		      	</div>
		      	<div class="loiModal">
		      		<div class="close">X</div>
			      	<div class="event-list">
			      		<div class="header">Aug 12 2015</div>
			      		<div class="content">
			      		</div>
			      	</div>
			      	<div class="layoutbackground"></div>
		      	</div>
		      </div>
          ';
    }
    add_shortcode( 'l-events-calendar', 'lec_calendar_shortcode');


?>