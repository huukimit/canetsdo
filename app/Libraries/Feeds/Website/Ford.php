<?php

namespace App\Libraries\Feeds\Website;

use App\Libraries\Feeds\FeedsBase;
use DB, Cache;
use App\Libraries\Uploads\Picasa;

class Ford extends FeedsBase {

    function __construct() {
        parent::__construct();
        $this->base_url = 'http://ford102.com';
    }

    static function auto(){
        //echo with(new static)->base_url;
        $url = 'http://ford102.com/productcat/ford-transit/';
        $cat_id = 3;
        self::getDataCategory($url,$cat_id);
        self::updateData($url,$cat_id);
    }

    static function updateData($url,$cat_id){
        $data = Cache::get('ford_md_' . $url);
        foreach ($data as $item) {
            $info = DB::table('shop_item')->where('source',$item['source'])->first();
            if(!$info){
                $load_dom = with(new static)->read_url($item['source']);
                $item['code'] = 'S2'.randChar(6);
                $item['cat_id'] = $cat_id;
                $item['description'] = $load_dom->find('div[class=page-content]',0)->innertext;
                $content = $load_dom->find('div[id=tab-description]',0);
                $content->find('a[id=dd_start]',0)->outertext = '';
                $content->find('a[id=dd_end]',0)->outertext = '';
                $content->find('div[class=dd_outer]',0)->outertext = '';
                $item['content'] = strip_tags($content->innertext,'<p><a><img><strong><br><b><i><em><div>');

                DB::table('shop_item')->insert($item);
            }
        }
    }

    static function getDataCategory($url,$cat_id){
        $cache_key = 'ford_md_' . $url;
        $list = Cache::get($cache_key);
        if (!$list) {
            $list = [];
            $load_dom = with(new static)->read_url($url);

            $description = $load_dom->find('div[class=term-description]',0)->innertext;
//            $info = DB::table('shop_category')->find(1);
            DB::table('shop_category')->where('id',$cat_id)->update(['content' => $description]);

            foreach ($load_dom->find('div[class=t2-item]') as $item) {
                $detail = [];
                $get_title = $item->find('a', 0);
                if (is_object($get_title)) {
                    $detail['name'] = trim($item->find('h2',0)->plaintext);
                    $detail['source'] = $item->find('a', 0)->href;
                    $photo = $item->find('img', 0);
                    $thumb = is_object($photo) ? $photo->src : '';
                    
                    //var_dump($thumb);die;
                    $detail['photo'] = $thumb;       
                    $detail['price'] = priceToFloat($item->find('span[class=amount]',0)->plaintext);
                    $detail['price_promte'] = priceToFloat($item->find('span[class=amount]',0)->plaintext);

                    $list[] = $detail;
                }
                unset($detail);
            }

            if ($list) {
                Cache::put($cache_key, $list, 86400);
            }
        }
        var_dump($list);


        

    }


    public function feedAll($url = '' , $parent_id = 0 , $cat_id = 0) {
        $list = [];
        $load_dom = $this->read_url($url);
        $dom_list = $load_dom->find('div[class=fl wid470]', 0);
        foreach ($dom_list->find('div[class=mt3 clearfix]') as $item) {
            $detail = [];
            $get_title = $item->find('a', 0);
            if (is_object($get_title)) {
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

    public function getContent($list){
        foreach ($list as $detail) {
            $content = $this->getDetail($detail['source']);
            $detail['content'] = $content['content'];
            $detail['keyword'] = $content['keyword'];
            $detail['photo'] = $content['photo'];
            $detail['created'] = $content['created'];

            $this->SaveContent($detail);
        }
    }

    public function getDetail($url = '') {
        $data = [];
        $dom = $this->read_url($url);
        //<meta itemprop="datePublished" content="2015-04-13"/>Thứ Hai, 13/04/2015 - 19:00</span>
        $time_post = $dom->find('meta[itemprop=datePublished]',0)->content;
        $date = date_create($time_post);
        $created= date_timestamp_get($date);
        $time_rand = time() - $created;
        if($time_rand > 84600) $time_rand = 84600; // lấy ngẫu nhiên 1 ngày
        $data['created'] = $created + rand(0 , $time_rand);
        $data['photo'] = $dom->find('meta[id=ctl00_idOgImg]', 0)->content;
        $content = $dom->find('div[class=detail-content]', 0);
        // dd($content->innertext);
        $keyword = [];
        $content_kw = $content->find('div[class=news-tag]', 0);
        if(is_object($content_kw)){
            foreach ($content_kw->find('a') as $link) {
                $keyword[] = $link->plaintext;
            }
            $content->find('div[class=news-tag]', 0)->outertext = '';
        }
        $data['keyword'] = implode(',', $keyword);

        foreach ($content->find('input') as $input) {
            $input->outertext = '';
        }
        $data['content'] = $this->loading_css() . '<div class="detail-content">' . trim($content->innertext) . '</div>';
        return $data;
    }

    public function loading_css() {
        return '<style>.detail-content img{border:none;max-width:100%;}.detail-content .imgHover{display:inline;position:relative}.detail-content .imgHover .fbShare{position:absolute;bottom:10px;left:10px;right:10px;width:54px;height:14px;overflow:hidden;display:none;padding:5px;z-index:1000;background:rgba(255,255,255,.7)}.detail-content .imgHover .zoomIcon{background:rgba(32,32,32,.7);position:absolute;right:0;width:18px;height:16px;overflow:hidden;display:none;padding:5px;z-index:10}.detail-content .imgHover .zoomIcon p{background:url(http://dantri3.vcmedia.vn/App_Themes/Default/fancybox/helpers/fancybox_buttons.png) -6px -67px;width:18px;height:16px}</style>';
    }

}
