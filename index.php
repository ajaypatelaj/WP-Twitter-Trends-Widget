<?php
/*
Plugin name: WP Twitter Trends
Plugin URI: http://geekslabs.com/wp-twitter-trends
Description: A widget to show twitter trends by region.
Version: 1.0
Author: ajaypatel_aj
Author URI: http://ajayy.com 
*/

 
/** 
 * Register the Widget 
 */

add_action( 'widgets_init', 'TwitterTrendsWidgetInit' );
function TwitterTrendsWidgetInit() {
  register_widget( 'TwitterTrendsWidget' );
}


/**
 * Adds TwitterTrendsWidget widget.
 */

class TwitterTrendsWidget extends WP_Widget {
  function TwitterTrendsWidget() {
    parent::WP_Widget( false, $region = 'Twitter Trends Widget' );
  }

  /**
   * Register widget with WordPress.
   */
    public function __construct() {
      parent::__construct(
        'twittertrendswidget', // Base ID
        'TwitterTrendsWidget', // Name
        array( 'description' => __( 'Twitter Trends Widget', 'text_domain' ), ) // Args
      );
    } // End constructor  

  /**
   * Front-end display of widget.
   *
   * @see WP_Widget::widget()
   *
   * @param array $args Widget arguments.
   * @param array $instance Saved values from WordPress transient API.
   */
  function widget( $args, $instance ) {
    extract( $args );    
    $title = apply_filters( 'widget_title', $instance['title'] );
      $region = apply_filters( 'widget_region', $instance['region'] ); // Selected region (Ex. India )
    $expiration = apply_filters( 'widget_expiration', $instance['expiration'] ); // Catch time 
    $display = apply_filters( 'widget_display', $instance['display'] ); // No trends to disply 
    
    echo $before_widget;
    
    if ($title) 
    echo $before_title . $title . $after_title; ?>

    <div class="my_textbox">
      <?php
      $trends = twitter_trends($region,$expiration);
      echo '<ol>';
      for ($i=0; $i < $display; $i++){ 
        echo '<li><a href='.$trends[0]['trends'][$i]['url'].' target="_blank">'.$trends[0]['trends'][$i]['name'].'</a></li>';
      }
      echo '</ol>';       
      ?>
    </div>

     <?php
       echo $after_widget;
  }

  /**
   * Sanitize widget form values as they are saved.
   *
   * @see WP_Widget::update()
   *
   * @param array $new_instance Values just sent to be saved.
   * @param array $old_instance Previously saved values from database.
   *
   * @return array Updated safe values to be saved.
   */
  function update( $new_instance, $old_instance ) {

    $instance = array();

    $instance['title'] = strip_tags( $new_instance['title'] );
    $instance['region'] = strip_tags( $new_instance['region'] );
    $instance['expiration'] = strip_tags( $new_instance['expiration'] );
    $instance['display'] = strip_tags( $new_instance['display'] );
    
    delete_transient( 'twitter_trends' );
    return $instance;    
  }

  /**
   * Back-end widget form.
   *
   * @see WP_Widget::form()
   *
   * @param array $instance Previously saved values from database.
   */
  function form( $instance ) {
    $title = esc_attr( $instance['title'] );
    $region = esc_attr( $instance['region'] );
    $expiration = esc_attr( $instance['expiration'] );
    $display = esc_attr( $instance['display'] );
    ?>

    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?>
      <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
      </label>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'region' ); ?>"><?php _e( 'Select Region:' ); ?>
      <select class="widefat" name="<?php echo $this->get_field_name( 'region' ); ?>">
        <option value="23424975" <?=$region == '23424975' ? ' selected="selected"' : '';?>>United Kingdom</option>
        <option value="2450022" <?=$region == '2450022' ? ' selected="selected"' : '';?>>Miami</option>
        <option value="1118129" <?=$region == '1118129' ? ' selected="selected"' : '';?>>Sendai</option>
        <option value="23424908" <?=$region == '23424908' ? ' selected="selected"' : '';?>>Nigeria</option>
        <option value="2458833" <?=$region == '2458833' ? ' selected="selected"' : '';?>>New Orleans</option>
        <option value="2295420" <?=$region == '2295420' ? ' selected="selected"' : '';?>>Bangalore</option>
        <option value="15015370" <?=$region == '15015370' ? ' selected="selected"' : '';?>>Osaka</option>
        <option value="638242" <?=$region == '638242' ? ' selected="selected"' : '';?>>Berlin</option>
        <option value="23424942" <?=$region == '23424942' ? ' selected="selected"' : '';?>>South Africa</option>
        <option value="2487610" <?=$region == '2487610' ? ' selected="selected"' : '';?>>Salt Lake City</option>
        <option value="23424909" <?=$region == '23424909' ? ' selected="selected"' : '';?>>Netherlands</option>
        <option value="23424775" <?=$region == '23424775' ? ' selected="selected"' : '';?>>Canada</option>
        <option value="1047378" <?=$region == '1047378' ? ' selected="selected"' : '';?>>Jakarta</option>
        <option value="2383660" <?=$region == '2383660' ? ' selected="selected"' : '';?>>Columbus</option>
        <option value="1" <?=$region == '1' ? ' selected="selected"' : '';?>>Worldwide</option>
        <option value="2477058" <?=$region == '2477058' ? ' selected="selected"' : '';?>>Providence</option>
        <option value="23424977" <?=$region == '23424977' ? ' selected="selected"' : '';?>>United States</option>
        <option value="15015372" <?=$region == '15015372' ? ' selected="selected"' : '';?>>Kyoto</option>
        <option value="2379574" <?=$region == '2379574' ? ' selected="selected"' : '';?>>Chicago</option>
        <option value="395269" <?=$region == '395269' ? ' selected="selected"' : '';?>>Caracas</option>
        <option value="1154781" <?=$region == '1154781' ? ' selected="selected"' : '';?>>Kuala Lumpur</option>
        <option value="2424766" <?=$region == '2424766' ? ' selected="selected"' : '';?>>Houston</option>
        <option value="395270" <?=$region == '395270' ? ' selected="selected"' : '';?>>Maracaibo</option></option>
        <option value="2514815" <?=$region == '2514815' ? ' selected="selected"' : '';?>>Washington</option>
        <option value="2475687" <?=$region == '2475687' ? ' selected="selected"' : '';?>>Portland</option>
        <option value="2486340" <?=$region == '2486340' ? ' selected="selected"' : '';?>>Sacramento</option>
        <option value="1047180" <?=$region == '1047180' ? ' selected="selected"' : '';?>>Bandung</option>
        <option value="2428184" <?=$region == '2428184' ? ' selected="selected"' : '';?>>Jackson</option>
        <option value="2449323" <?=$region == '2449323' ? ' selected="selected"' : '';?>>Memphis</option>
        <option value="2295424" <?=$region == '2295424' ? ' selected="selected"' : '';?>>Chennai</option>
        <option value="23424846" <?=$region == '23424846' ? ' selected="selected"' : '';?>>Indonesia</option>
        <option value="20070458" <?=$region == '20070458' ? ' selected="selected"' : '';?>>Delhi</option>
        <option value="2343732" <?=$region == '2343732' ? ' selected="selected"' : '';?>>Ankara</option>
        <option value="615702" <?=$region == '615702' ? ' selected="selected"' : '';?>>Paris</option>
        <option value="395272" <?=$region == '395272' ? ' selected="selected"' : '';?>>Valencia</option>
        <option value="2503863" <?=$region == '2503863' ? ' selected="selected"' : '';?>>Tampa</option>
        <option value="23424747" <?=$region == '23424747' ? ' selected="selected"' : '';?>>Argentina</option>
        <option value="1118370" <?=$region == '1118370' ? ' selected="selected"' : '';?>>Tokyo</option>
        <option value="23424948" <?=$region == '23424948' ? ' selected="selected"' : '';?>>Singapore</option>
        <option value="23424982" <?=$region == '23424982' ? ' selected="selected"' : '';?>>Venezuela</option>
        <option value="2122265" <?=$region == '2122265' ? ' selected="selected"' : '';?>>Moscow</option>
        <option value="23424848" <?=$region == '23424848' ? ' selected="selected"' : '';?>>India</option>
        <option value="23424748" <?=$region == '23424748' ? ' selected="selected"' : '';?>>Australia</option>
        <option value="2357536" <?=$region == '2357536' ? ' selected="selected"' : '';?>>Austin</option>
        <option value="468739" <?=$region == '468739' ? ' selected="selected"' : '';?>>Buenos Aires</option>
        <option value="23424916" <?=$region == '23424916' ? ' selected="selected"' : '';?>>New Zealand</option>
        <option value="23424782" <?=$region == '23424782' ? ' selected="selected"' : '';?>>Chile</option>
        <option value="1117099" <?=$region == '1117099' ? ' selected="selected"' : '';?>>Fukuoka</option>
        <option value="23424950" <?=$region == '23424950' ? ' selected="selected"' : '';?>>Spain</option>
        <option value="76456" <?=$region == '76456' ? ' selected="selected"' : '';?>>Santo 76456</option>
        <option value="2486982" <?=$region == '2486982' ? ' selected="selected"' : '';?>>St. Louis</option>
        <option value="753692" <?=$region == '753692' ? ' selected="selected"' : '';?>>Barcelona</option>
        <option value="1199477" <?=$region == '1199477' ? ' selected="selected"' : '';?>>Manila</option>
        <option value="23424919" <?=$region == '23424919' ? ' selected="selected"' : '';?>>Peru</option>
        <option value="2478307" <?=$region == '2478307' ? ' selected="selected"' : '';?>>Raleigh</option>
        <option value="2388929" <?=$region == '2388929' ? ' selected="selected"' : '';?>>DallasFt. Worth</option>
        <option value="1105779" <?=$region == '1105779' ? ' selected="selected"' : '';?>>Sydney</option>
        <option value="23424819" <?=$region == '23424819' ? ' selected="selected"' : '';?>>France</option>
        <option value="28218" <?=$region == '28218' ? ' selected="selected"' : '';?>>Manchester</option>
        <option value="2487889" <?=$region == '2487889' ? ' selected="selected"' : '';?>>San Diego</option>
        <option value="23424853" <?=$region == '23424853' ? ' selected="selected"' : '';?>>Italy</option>
        <option value="2487956" <?=$region == '2487956' ? ' selected="selected"' : '';?>>San Francisco</option>
        <option value="2452078" <?=$region == '2452078' ? ' selected="selected"' : '';?>>Minneapolis</option>
        <option value="23424954" <?=$region == '23424954' ? ' selected="selected"' : '';?>>Sweden</option>
        <option value="1118108" <?=$region == '1118108' ? ' selected="selected"' : '';?>>Sapporo</option>
        <option value="2457170" <?=$region == '2457170' ? ' selected="selected"' : '';?>>Nashville</option>
        <option value="23424787" <?=$region == '23424787' ? ' selected="selected"' : '';?>>Colombia</option>
        <option value="2458410" <?=$region == '2458410' ? ' selected="selected"' : '';?>>New Haven</option>
        <option value="134047" <?=$region == '134047' ? ' selected="selected"' : '';?>>Monterrey</option>
        <option value="1199682" <?=$region == '1199682' ? ' selected="selected"' : '';?>>Quezon City</option>
        <option value="23424922" <?=$region == '23424922' ? ' selected="selected"' : '';?>>Pakistan</option>
        <option value="727232" <?=$region == '727232' ? ' selected="selected"' : '';?>>Amsterdam</option>
        <option value="2459115" <?=$region == '2459115' ? ' selected="selected"' : '';?>>New York</option>
        <option value="2122541" <?=$region == '2122541' ? ' selected="selected"' : '';?>>Novosibirsk</option>
        <option value="2436704" <?=$region == '2436704' ? ' selected="selected"' : '';?>>Las Vegas</option>
        <option value="1154726" <?=$region == '1154726' ? ' selected="selected"' : '';?>>Klang</option>
        <option value="23424856" <?=$region == '23424856' ? ' selected="selected"' : '';?>>Japan</option>
        <option value="2460389" <?=$region == '2460389' ? ' selected="selected"' : '';?>>Norfolk</option>
        <option value="2295402" <?=$region == '2295402' ? ' selected="selected"' : '';?>>Ahmedabad</option>
        <option value="2391279" <?=$region == '2391279' ? ' selected="selected"' : '';?>>Denver</option>
        <option value="2380358" <?=$region == '2380358' ? ' selected="selected"' : '';?>>Cincinnati</option>
        <option value="2418046" <?=$region == '2418046' ? ' selected="selected"' : '';?>>Harrisburg</option>
        <option value="906057" <?=$region == '906057' ? ' selected="selected"' : '';?>>Stockholm</option>
        <option value="368148" <?=$region == '368148' ? ' selected="selected"' : '';?>>BogotÃƒÆ’Ã‚Â¡</option>
        <option value="2359991" <?=$region == '2359991' ? ' selected="selected"' : '';?>>Baton Rouge</option>
        <option value="3534" <?=$region == '3534' ? ' selected="selected"' : '';?>>Montreal</option>
        <option value="455819" <?=$region == '455819' ? ' selected="selected"' : '';?>>BrasÃƒÆ’Ã‚Â­lia</option>
        <option value="2358820" <?=$region == '2358820' ? ' selected="selected"' : '';?>>Baltimore</option>
        <option value="2480894" <?=$region == '2480894' ? ' selected="selected"' : '';?>>Richmond</option>
        <option value="468382" <?=$region == '468382' ? ' selected="selected"' : '';?>>Barquisimeto</option>
        <option value="349859" <?=$region == '349859' ? ' selected="selected"' : '';?>>Santiago</option>
        <option value="1030077" <?=$region == '1030077' ? ' selected="selected"' : '';?>>Bekasi</option>
        <option value="2487796" <?=$region == '2487796' ? ' selected="selected"' : '';?>>San Antonio</option>
        <option value="2473224" <?=$region == '2473224' ? ' selected="selected"' : '';?>>Pittsburgh</option>
        <option value="2466256" <?=$region == '2466256' ? ' selected="selected"' : '';?>>Orlando</option>
        <option value="21125" <?=$region == '21125' ? ' selected="selected"' : '';?>>Glasgow</option>
        <option value="2391585" <?=$region == '2391585' ? ' selected="selected"' : '';?>>Detroit</option>
        <option value="560743" <?=$region == '560743' ? ' selected="selected"' : '';?>>Dublin</option>
        <option value="1044316" <?=$region == '1044316' ? ' selected="selected"' : '';?>>Surabaya</option>
        <option value="2344116" <?=$region == '2344116' ? ' selected="selected"' : '';?>>Istanbul</option>
        <option value="23424829" <?=$region == '23424829' ? ' selected="selected"' : '';?>>Germany</option>
        <option value="1118285" <?=$region == '1118285' ? ' selected="selected"' : '';?>>Takamatsu</option>
        <option value="2344117" <?=$region == '2344117' ? ' selected="selected"' : '';?>>Izmir</option>
        <option value="1117817" <?=$region == '1117817' ? ' selected="selected"' : '';?>>Nagoya</option>
        <option value="2471217" <?=$region == '2471217' ? ' selected="selected"' : '';?>>Philadelphia</option>
        <option value="656958" <?=$region == '656958' ? ' selected="selected"' : '';?>>Hamburg</option>
        <option value="2503713" <?=$region == '2503713' ? ' selected="selected"' : '';?>>Tallahassee</option>
        <option value="2414469" <?=$region == '2414469' ? ' selected="selected"' : '';?>>Greensboro</option>
        <option value="676757" <?=$region == '676757' ? ' selected="selected"' : '';?>>Munich</option>
        <option value="455825" <?=$region == '455825' ? ' selected="selected"' : '';?>>Rio de Janeiro</option>
        <option value="2427032" <?=$region == '2427032' ? ' selected="selected"' : '';?>>Indianapolis</option>
        <option value="2451822" <?=$region == '2451822' ? ' selected="selected"' : '';?>>Milwaukee</option>
        <option value="2295411" <?=$region == '2295411' ? ' selected="selected"' : '';?>>Mumbai</option>
        <option value="726874" <?=$region == '726874' ? ' selected="selected"' : '';?>>Den Haag</option>
        <option value="9807" <?=$region == '9807' ? ' selected="selected"' : '';?>>Vancouver</option>
        <option value="2345896" <?=$region == '2345896' ? ' selected="selected"' : '';?>>Okinawa</option>
        <option value="455826" <?=$region == '455826' ? ' selected="selected"' : '';?>>Salvador</option>
        <option value="418440" <?=$region == '418440' ? ' selected="selected"' : '';?>>Lima</option>
        <option value="23424900" <?=$region == '23424900' ? ' selected="selected"' : '';?>>Mexico</option>
        <option value="23424800" <?=$region == '23424800' ? ' selected="selected"' : '';?>>Dominican Republic</option>
        <option value="23424934" <?=$region == '23424934' ? ' selected="selected"' : '';?>>Philippines</option>
        <option value="455827" <?=$region == '455827' ? ' selected="selected"' : '';?>>SÃƒÆ’Ã‚Â£o Paulo</option>
        <option value="23424834" <?=$region == '23424834' ? ' selected="selected"' : '';?>>Guatemala</option>
        <option value="23424901" <?=$region == '23424901' ? ' selected="selected"' : '';?>>Malaysia</option>
        <option value="2378426" <?=$region == '2378426' ? ' selected="selected"' : '';?>>Charlotte</option>
        <option value="12723" <?=$region == '12723' ? ' selected="selected"' : '';?>>Birmingham</option>
        <option value="2490383" <?=$region == '2490383' ? ' selected="selected"' : '';?>>Seattle</option>
        <option value="23424801" <?=$region == '23424801' ? ' selected="selected"' : '';?>>Ecuador</option>
        <option value="2381475" <?=$region == '2381475' ? ' selected="selected"' : '';?>>Cleveland</option>
        <option value="23424768" <?=$region == '23424768' ? ' selected="selected"' : '';?>>Brazil</option>
        <option value="23424969" <?=$region == '23424969' ? ' selected="selected"' : '';?>>Turkey</option>
        <option value="766273" <?=$region == '766273' ? ' selected="selected"' : '';?>>Madrid</option>
        <option value="2295414" <?=$region == '2295414' ? ' selected="selected"' : '';?>>Hyderabad</option>
        <option value="23424936" <?=$region == '23424936' ? ' selected="selected"' : '';?>>Russia</option>
        <option value="610264" <?=$region == '610264' ? ' selected="selected"' : '';?>>Marseille</option>
        <option value="2471390" <?=$region == '2471390' ? ' selected="selected"' : '';?>>Phoenix</option>
        <option value="733075" <?=$region == '733075' ? ' selected="selected"' : '';?>>Rotterdam</option>
        <option value="609125" <?=$region == '609125' ? ' selected="selected"' : '';?>>Lyon</option>
        <option value="2364559" <?=$region == '2364559' ? ' selected="selected"' : '';?>>Birmingham</option>
        <option value="2367105" <?=$region == '2367105' ? ' selected="selected"' : '';?>>Boston</option>
        <option value="23424803" <?=$region == '23424803' ? ' selected="selected"' : '';?>>Ireland</option>
        <option value="2123260" <?=$region == '2123260' ? ' selected="selected"' : '';?>>Saint Petersburg</option>
        <option value="44418" <?=$region == '44418' ? ' selected="selected"' : '';?>>London</option>
        <option value="1398823" <?=$region == '1398823' ? ' selected="selected"' : '';?>>Lagos</option>
        <option value="23424738" <?=$region == '23424738' ? ' selected="selected"' : '';?>>United Arab Emirates</option>
        <option value="2442047" <?=$region == '2442047' ? ' selected="selected"' : '';?>>Los Angeles</option>
        <option value="4118" <?=$region == '4118' ? ' selected="selected"' : '';?>>Toronto4118</option>
        <option value="2357024" <?=$region == '2357024' ? ' selected="selected"' : '';?>>Atlanta2357024</option>
        <option value="1582504" <?=$region == '1582504' ? ' selected="selected"' : '';?>>Johannesburg1582504</option>
        <option value="455833" <?=$region == '455833' ? ' selected="selected"' : '';?>>Manaus455833</option>
        <option value="116545" <?=$region == '116545' ? ' selected="selected"' : '';?>>Mexico City</option>
      </select>  
      </label>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'expiration' ); ?>"><?php _e( 'Update Trends :' ); ?>
      <select class="widefat" name="<?php echo $this->get_field_name( 'expiration' ); ?>">
        <option value="1" <?=$expiration == '1' ? ' selected="selected"' : '';?>>Hourly</option>
        <option value="12" <?=$expiration == '12' ? ' selected="selected"' : '';?>>Twice Daily</option>
        <option value="24" <?=$expiration == '24' ? ' selected="selected"' : '';?>>Daily</option>
        <option value="168" <?=$expiration == '168' ? ' selected="selected"' : '';?>>Weekly</option>
        <option value="720" <?=$expiration == '720' ? ' selected="selected"' : '';?>>Monthly</option>
      </select>
      </label>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'display' ); ?>"><?php _e( 'Display Number of Trends :' ); ?>
      <input class="widefat" id="<?php echo $this->get_field_id( 'display' ); ?>" name="<?php echo $this->get_field_name( 'display' ); ?>" type="text" value="<?php echo $display; ?>" />
      </label>
    </p>
    <p>
      <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=ajaypatel_aj%40yahoo%2ecom&lc=US&item_name=Buy Me a Cup of Coffee!&no_note=0&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donate_LG%2egif%3aNonHostedGuest" target="_blank"><img src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" alt="Buy Me a Cup of Cofee!"></a>
    </p>
    
    <?php
  }
} // class TwitterTrendsWidget

  /**
   * Using WordPress transient API
   *
   * @see Transients API : http://codex.wordpress.org/Transients_API
   *
   * @param array $count saved Twitter Trends by region values from Twitter Trends API.
   */

function twitter_trends($region,$expiration){
        
        $count = get_transient('twitter_trends');
    if ($count !== false) return $count;
         $count = 0;

         $url = 'https://api.twitter.com/1/trends/'.$region.'.json?count=50';
         $dataOrig = file_get_contents($url, true); //getting the file content
   if (is_wp_error($dataOrig)) {
         return 'Error while fetching data from Twitter API!';
   }else{
        $count = json_decode($dataOrig, true); //getting the file content as array
        $count = $count;         
        }

set_transient('twitter_trends', $count, 60*60*$expiration); // set cache
return $count;
}
?>