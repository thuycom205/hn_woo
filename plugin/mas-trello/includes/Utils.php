<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class WOO_TRELLO_Utils {
    static $key = 'fc37781b415ba6e22400ce1be85d4a1d';

    public function getting_all_trello_boards($token=''){
        if (empty($token)) {
            return;
        }

        $key = self::$key ;
        $url = 'https://api.trello.com/1/members/me/boards?&filter=open&key='.$key.'&token='.$token.'';

        $trello_returns = wp_remote_get( $url , array());
        $boards = array();

        if ($trello_returns['response']['code'] == 200) {
            foreach (json_decode($trello_returns['body'] , true) as $key => $value) {
                $boards[$value['id']] = $value['name'];
            }
        }else{
            # Error Log
        }
        return $boards ;
    }

    public function bptc_gatting_spacific_board_lists( $token='', $board_id=''){
        if (empty($token) || empty($board_id) ) {
            return;
        }
        $key = self::$key ; ;
        $url = 'https://api.trello.com/1/boards/'.$board_id.'/lists?filter=open&key='.$key.'&token='.$token.'';

        $trello_returns = wp_remote_get( $url , array());
        $lists = array();

        if ($trello_returns['response']['code'] == 200) {
            foreach (json_decode($trello_returns['body'] , true) as $key => $value) {
                $lists[$value['id']] = $value['name'];
            }
        }else{
            # Error Log

        }

        return $lists;
    }
}
