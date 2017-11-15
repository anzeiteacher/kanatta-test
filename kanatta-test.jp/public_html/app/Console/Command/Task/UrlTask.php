<?php
class UrlTask extends Shell {
    public $uses = array();
    public function execute(){}

    public function getProjectViewUrl($base_url, $pj_id)
    {
        $base_url = $this->_makeBaseUrl($base_url);
        return $base_url.'projects/view/'.$pj_id;
    }

    public function getMypageCardUrl($base_url)
    {
        $base_url = $this->_makeBaseUrl($base_url);
        return $base_url.'card/';
    }

    private function _makeBaseUrl($base_url)
    {
        $last_str = mb_substr($base_url, -1);
        if($last_str == '/') return $base_url;
        return $base_url.'/';
    }
}