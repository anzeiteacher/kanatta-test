<?php
App::uses('AppHelper', 'View/Helper');

class LabelHelper extends AppHelper
{

    var $helpers = array(
            'Html', 'Session'
    );

    /**
     * image
     * @param $file
     * @return
     */
    function image($file = null, $options = array())
    {
        if(!$this->_makeSrc($file, $options)){
            return empty($options['noFile']) ? '' : $options['noFile'];
        }
        return $this->Html->image($this->_makeSrc($file, $options), $options);
    }

    /**
     * _makeSrc
     * @param $file
     * @param $options
     * @return
     */
    function _makeSrc($file = null, $options = array())
    {
        $hash   = $this->Session->read('Filebinder.hash');
        $prefix = empty($options['prefix']) ? '' : $options['prefix'];
        /**
         * S3 url
         */
        if(!empty($options['S3']) || !empty($options['s3'])){
            return $this->_makeS3Url($file, $options);
        }
        $filePath = empty($file['file_path']) ? (empty($file['tmp_bind_path']) ? false : $file['tmp_bind_path']) : preg_replace('#/([^/]+)$#', '/'
                                                                                                                                               .$prefix
                                                                                                                                               .'$1', $file['file_path']);
        if(empty($file) || !$filePath){
            return false;
        }
        //Logicky追加
        //windowsだとエラーになる。DSがバックスラッシュのため
        $www_root = WWW_ROOT;
        if(DS == '\\'){
            $www_root = str_replace('\\', '/', $www_root);
            $filePath = str_replace('\\', '/', $filePath);
        }
        //ファイルが公開ディレクトリにない場合
        if(!preg_match('#'.$www_root.'#', $filePath)){
            if(!empty($file['tmp_bind_path'])){
                if(empty($file['model_id']) || file_exists($file['tmp_bind_path'])){
                    $file['model_id']  = 0;
                    $file['file_name'] = preg_replace('#.+/([^/]+)$#', '$1', $file['tmp_bind_path']);
                }
            }
            // over 1.3
            $prefixes = Configure::read('Routing.prefixes');
            if(!$prefixes && Configure::read('Routing.admin')){
                $prefixes = Configure::read('Routing.admin');
            }
            $url = array();
            foreach((array)$prefixes as $p){
                $url[$p] = false;
            }
            $url = array_merge($url, array(
                    'plugin' => 'filebinder', 'controller' => 'filebinder', 'action' => 'loader', $file['model'],
                    $file['model_id'], $file['field_name'],
                    Security::hash($file['model'].$file['model_id'].$file['field_name'].$hash),
                    $prefix.$file['file_name']
            ));
            return $url;
        }
        $src = preg_replace('#'.$www_root.'#', '/', $filePath);
        return $src;
    }

    /**
     * _makeS3Url
     */
    public function _makeS3Url($file, $options)
    {
        if(empty($file['model'])){
            return null;
        }
        $prefix    = empty($options['prefix']) ? '' : $options['prefix'];
        $urlPrefix = !empty($options['url_prefix']) ? $options['url_prefix'] : Configure::read('Filebinder.S3.url_prefix');
        $http      = empty($options['ssl']) ? 'http' : 'https';
        return $http.'://'.Configure::read('Filebinder.S3.bucket').'.s3.amazonaws.com/'.$urlPrefix.$file['model'].'/'
               .$file['model_id'].'/'.$file['field_name'].'/'.$prefix.$file['file_name'];
    }

    /**
     * サムネイル用　image
     * @param null  $file
     * @param       $w
     * @param       $h
     * @param array $options
     * @return string
     */
    function image_thumb($file = null, $w, $h, $options = array())
    {
        if(!$this->_makeSrc($file, $options)){
            return empty($options['noFile']) ? '' : $options['noFile'];
        }
        $pathinfo = pathinfo($this->_makeSrc($file, $options));
        $src      = $pathinfo['dirname'].'/'.$pathinfo['filename'].'_'.$w.'x'.$h.'.'.$pathinfo['extension'];
        return $this->Html->image($src, $options);
    }

    /**
     * link
     * $param $file
     * @return
     */
    function link($file = null, $options = array())
    {
        $src = $this->_makeSrc($file, $options);
        if(!$src){
            return empty($options['noFile']) ? '' : $options['noFile'];
        }
        $fileTitle = empty($options['title']) ? $file['file_name'] : $options['title'];
        unset($options['title']);
        return $this->Html->link($fileTitle, $src, $options);
    }

    /**
     * url
     * @param
     * @return
     */
    function url($file = null, $options = array())
    {
        $src = $this->_makeSrc($file, $options);
        if(!$src){
            return empty($options['noFile']) ? '' : $options['noFile'];
        }
        return $this->Html->url($src, $options);
    }

    /**
     * webroot内画像専用 webrootからの相対パスを返す(Logicky追加)
     */
    function url_s($file = null, $options = array())
    {
        return $this->_makeSrc($file, $options);
    }

    /**
     * サムネイル用url
     */
    function url_thumb($file = null, $w, $h, $options = array())
    {
        $src = $this->_makeSrc($file, $options);
        if($src){
            $pathinfo = pathinfo($src);
            return $pathinfo['dirname'].'/'.$pathinfo['filename'].'_'.$w.'x'.$h.'.'.$pathinfo['extension'];
        }else{
            return null;
        }
    }
}
