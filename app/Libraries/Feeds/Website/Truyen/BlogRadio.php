<?php

namespace App\Libraries\Feeds\Website\Truyen;

use App\Libraries\Feeds\FeedsBase;

class BlogRadio extends FeedsBase {

    function __construct() {
        parent::__construct();
        $this->base_url = 'http://blogradio.vn';
    }

    public function feedAll($url = '', $parent_id = 0, $cat_id = 0) {
        $list = [ ];
        $load_dom = $this->read_url($url);
        $dom_list = $load_dom->find('div[class=fl wid470]', 0);
        foreach( $dom_list->find('div[class=mt3 clearfix]') as $item ) {
            $detail = [ ];
            $get_title = $item->find('a', 0);
            if( is_object($get_title) ) {
                $detail['title'] = trim($get_title->title);
                $detail['source'] = $this->base_url . $item->find('a', 0)->href;
                $photo = $item->find('img', 0);
                $detail['thumb'] = is_object($photo) ? $photo->src : '';
                $description = $item->find('div[class=fon5]', 0)->plaintext;
                $detail['description'] = trim(str_replace('(Dân trí) -', '', $description));

                $detail['parent_id'] = $parent_id;
                $detail['cat_id'] = $cat_id;
//$this->loadContent($detail);

                $list[] = $detail;
            }
            unset($detail);
        }
        $this->getContent($list);
        return $list;
    }

    public function getContent($list) {
        foreach( $list as $detail ) {
            $content = $this->getDetail($detail['source']);
            $detail['content'] = $content['content'];
            $detail['keyword'] = $content['keyword'];
            $detail['photo'] = $content['photo'];
            $detail['created'] = $content['created'];

            $this->SaveContent($detail);
        }
    }

    public function getDetail($url = '') {
        $dom = $this->read_url($url);
        $data = [ ];
        $data['description'] = $dom->find('meta[name=description]', 0)->content;

        $noidung = $dom->find('div[class=noidung_trangtrong]', 0);
        if( is_object($noidung) ) {
            $data['title'] = $noidung->find('h1', 0)->plaintext;
            $data['update'] = $noidung->find('h5', 0)->plaintext;
            $audio = $noidung->find('param[name=flashvars]', 0)->value;
            $audio = str_replace('file=', '', $audio);
            list($file_mp3) = explode('.mp3', $audio);
            $data['audio'] = "http://media.nhacvietplus.com.vn" . $file_mp3 . ".mp3";

            $html = $noidung->find('p[rel=content-body]', 0);
            foreach( $html->find('div[class=txt_tab_table]') as $ads ) {
                if( is_object($ads) ) {
                    $ads->outertext = '';
                }
            }
            foreach( $html->find('div[class=text_link_ads_details]') as $ads ) {
                if( is_object($ads) ) {
                    $ads->outertext = '';
                }
            }
            foreach( $html->find('img[alt=facebook blog radio]') as $ads ) {
                if( is_object($ads) ) {
                    $ads->outertext = '';
                }
            }
            foreach( $html->find('font[face=Arial]') as $ads ) {
                if( is_object($ads) ) {
                    $ads->outertext = '';
                }
            }
            foreach( $html->find('strong') as $ads ) {
                if( is_object($ads) ) {
                    $ads->outertext = '';
                }
            }
            $data['content'] = $html->innertext;
            if( !isset($data['photo']) ) {
                foreach( $html->find('img') as $img ) {
                    if( is_object($img) ) {
                        $data['photo'] = $img->src
                        ;
                    }
                }
            }
            return $data;
        } else {
            return false;
        }
    }

    public function loading_css() {
        return '<style>.detail-content img{border:none;max-width:100%;}.detail-content .imgHover{display:inline;position:relative}.detail-content .imgHover .fbShare{position:absolute;bottom:10px;left:10px;right:10px;width:54px;height:14px;overflow:hidden;display:none;padding:5px;z-index:1000;background:rgba(255,255,255,.7)}.detail-content .imgHover .zoomIcon{background:rgba(32,32,32,.7);position:absolute;right:0;width:18px;height:16px;overflow:hidden;display:none;padding:5px;z-index:10}.detail-content .imgHover .zoomIcon p{background:url(http://dantri3.vcmedia.vn/App_Themes/Default/fancybox/helpers/fancybox_buttons.png) -6px -67px;width:18px;height:16px}</style>';
    }

    public function getLink() {
        $link = 'http://blogradio.vn/blog-radio/287';
        $list = [ ];
        for( $i = 12; $i > 0; $i-- ) {
            $url = $i > 1 ? $link . '?' . $i : $link;
            $load_dom = $this->read_url($url);
            foreach( $load_dom->find('div[class=box_trangtrong_left1]') as $item ) {
                $list[] = $this->base_url . $item->find('a', 0)->href;
            }
        }
        return $list;
    }

}
