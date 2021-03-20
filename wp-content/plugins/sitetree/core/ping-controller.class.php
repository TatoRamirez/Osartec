<?php
/**
 * @package SiteTree
 * @copyright Copyright 2020 Luigi Cavalieri.
 * @license https://opensource.org/licenses/GPL-3.0 GPL v3.0
 *
 *
 *
 * @since 3.2
 */
final class SiteTreePingController {
    /**
     * @since 3.2
     * @var object
     */
    private $plugin;

    /**
     * @since 4.1
     * @var object
     */
    private $db;
    
    /**
     * Persistent object. Instance of {@see SiteTreePingState}.
     *
     * @since 3.2
     * @var object
     */
    private $pingState;

    /**
     * @since 3.2
     * @var array
     */
    private $targets = array(
        'google' => 'https://www.google.com/ping?sitemap=',
        'bing'   => 'https://www.bing.com/ping?sitemap='
    );

    /**
     * Number of seconds elapsed since the last ping.
     *
     * @since 3.2
     * @var int
     */
    private $timeSinceLastPing;

    /**
     * @since 4.1
     * @var array
     */
    private $minTimeBetweenPings;
    
    /**
     * @since 3.2
     * @param object $plugin
     */
    public function __construct( $plugin ) {
        $this->plugin = $plugin;
        $this->db     = $plugin->db();

        $five_minutes   = 5 * MINUTE_IN_SECONDS;
        $thirty_minutes = 30 * MINUTE_IN_SECONDS;

        $this->minTimeBetweenPings = array(
            'sitemap' => $thirty_minutes,
            'newsmap' => $five_minutes
        );
    }

    /**
     * @since 4.1
     * @param string $sitemap_id
     */
    private function getPingState( $sitemap_id ) {
        if ( !$this->pingState || ( $this->pingState->sitemapID() != $sitemap_id ) ) {
            $this->pingState = $this->db->getNonAutoloadOption( 'pingState', false, $sitemap_id );

            if ( 
                !( $this->pingState instanceof SiteTreePingState ) ||
                ( $this->pingState->sitemapID() != $sitemap_id ) 
            ) {
                $this->pingState = new SiteTreePingState( $sitemap_id );
            }
        }

        return $this->pingState;
    }
    
    /**
     * @since 3.2
     *
     * @param string $sitemap_id
     * @param bool $is_automatic_ping
     */
    public function ping( $sitemap_id, $is_automatic_ping = false ) {
        if ( 
            !( $is_automatic_ping || $this->canPingOnRequest( $sitemap_id ) ) || 
            $this->plugin->isServerLocal()
        ) {
            return false;
        }

        $pingState = $this->getPingState( $sitemap_id );

        if ( 
            $is_automatic_ping || 
            ( $this->timeSinceLatestPing > $this->minTimeBetweenPings[$sitemap_id] )
        ) {
            $google_pinged = $this->sendPing( 'google' );
            $bing_pinged   = ( ( $sitemap_id == 'sitemap' ) ? $this->sendPing( 'bing' ) : true );

            if ( $google_pinged && $bing_pinged ) {
                $pingState->setCode( 'succeeded' );
                $pingState->registerTime();
            }
            elseif ( $google_pinged ) {
                $pingState->setCode( 'no_bing' );
                $pingState->registerTime();
            }
            elseif ( $bing_pinged ) {
                $pingState->setCode( 'no_google' );
                $pingState->registerTime();
            }
            else {
                $pingState->setCode( 'failed' );
            }

            $this->savePingState();
        }
        else {
            switch ( $pingState->getCode() ) {
                case 'no_google':
                    if ( $this->sendPing( 'google' ) ) {
                        $pingState->setCode( 'succeeded' );
                        $pingState->registerTime();
                        
                        $this->savePingState();
                    }
                    break;

                case 'no_bing':
                    if ( $this->sendPing( 'bing' ) ) {
                        $pingState->setCode( 'succeeded' );
                        $pingState->registerTime();
                        
                        $this->savePingState();
                    }
                    break;
            }
        }
    }

    /**
     * @since 4.1
     *
     * @param string $sitemap_id
     * @return bool
     */
    public function canPingOnRequest( $sitemap_id ) {
        $now = time();

        $pingState        = $this->getPingState( $sitemap_id );
        $status_code      = $pingState->getCode();
        $latest_ping_time = $pingState->getLatestTime();

        $this->timeSinceLatestPing = $now - $latest_ping_time;

        return (
            ( $status_code != 'succeeded' ) ||
            ( $this->timeSinceLatestPing > $this->minTimeBetweenPings[$sitemap_id] )
        );
    }

    /**
     * @since 3.2
     *
     * @param string $target_id
     * @return bool True on success, false otherwise.
     */
    private function sendPing( $target_id ) {
        $sitemap_id = $this->pingState->sitemapID();

        $url  = $this->targets[$target_id];
        $url .= urlencode( $this->plugin->sitemapURL( $sitemap_id ) );

        $response = wp_remote_get( $url );
        
        return (
            !is_wp_error( $response ) &&
            ( wp_remote_retrieve_response_code( $response ) === 200 )
        );
    }

    /**
     * @since 3.2
     * @param string $sitemap_id
     */
    private function savePingState() {
        $this->db->setNonAutoloadOption( 'pingState', $this->pingState, $this->pingState->sitemapID() );
    }
    
    /**
     * @since 3.2
     *
     * @param string $sitemap_id
     * @return array
     */
    public function getPingInfo( $sitemap_id ) {
        $ping_info = array(
            'ping_failed' => false
        );
        $pingState = $this->getPingState( $sitemap_id );

        switch ( $pingState->getCode() ) {
            case 'succeeded':
                if ( $sitemap_id == 'sitemap' ) {
                    $status_msg_format = __( 'The latest pings were sent on %s.', 'sitetree' );
                }
                else {
                    $status_msg_format = __( 'Google was last pinged on %s.', 'sitetree' );
                }

                $date = '<time>' . sitetree_fn\gmt_to_local_date( $pingState->getLatestTime() ) . '</time>';

                $ping_info['ping_btn_title'] = __( 'Ping anew', 'sitetree' );
                $ping_info['status_msg']     = sprintf( $status_msg_format, $date );
                break;

            case 'no_google':
                $ping_info['ping_failed']    = true;
                $ping_info['ping_btn_title'] = __( 'Ping it again', 'sitetree' );
                $ping_info['status_msg']     = __( "I couldn't ping Google.", 'sitetree' );
                break;

            case 'no_bing':
                $ping_info['ping_failed']    = true;
                $ping_info['ping_btn_title'] = __( 'Ping them again', 'sitetree' );
                $ping_info['status_msg']     = __( "I couldn't ping Bing and Yahoo!", 'sitetree' );
                break;

            case 'failed':
                $ping_info['ping_failed']    = true;
                $ping_info['ping_btn_title'] = __( 'Resend pings', 'sitetree' );
                $ping_info['status_msg']     = __( 'Bloody hell, all pings have failed.', 'sitetree' );
                break;

            default:
                $ping_info['ping_btn_title'] = __( 'Ping', 'sitetree' );
                $ping_info['status_msg']     = __( 'No ping sent, yet.', 'sitetree' );
                break;
        }
        
        return $ping_info;
    }

    /**
     * @since 3.2
     *
     * @param string $sitemap_id
     * @return string
     */
    public function getTimeToNextPingInWords( $sitemap_id ) {
        $minutes = ceil( ( $this->minTimeBetweenPings[$sitemap_id] - $this->timeSinceLatestPing ) / MINUTE_IN_SECONDS );

        return sprintf( _n( 'about 1 minute', '%d minutes', $minutes, 'sitetree' ), $minutes );
    }
}
?>