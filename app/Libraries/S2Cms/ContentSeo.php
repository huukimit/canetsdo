<?php

namespace App\Libraries\S2Cms;

class ContentSeo{

    static function SpinContent(){

    }

    static function ReloadContent($html , $title , $base_url =''){
		$data = array();
        $data['image'] = '';
        require base_path() . '/third_party/simplehtmldom/simple_html_dom.php';
        $dom = str_get_html($html);
        $count_img = 0;
        foreach ( $dom->find('img') as $image ) {
            $link_image = $image->src;
            if ( (preg_match('/http/i' , $link_image)) && (!preg_match('/' . DOMAIN . '/i' , $link_image)) ) {
                $image->src = 'hinh-anh/' . $title_link . '/' . self::removeHttp($link_image);
                if ( !$data['image'] ) {
                    $data['image'] = $image->src;
                } // Lấy ảnh đầu tiên tìm được
            }
            // Thêm thể alt và title vào ảnh
            $image->alt = $image->alt . ' - ' . $title . ' ' . $count_img;
            $image->title = $image->alt;
            $count_img++;
        }
        // Thay đổi link của đường dẫn
        $count_link = 0;
        foreach ( $dom->find('a') as $links ) {
            $link = $links->href;
            $title_link = $links->plaintext;
            // Kiểm tra link tuyệt đối có http và không phải link từ domain đi ra thì đặt quảng cáo cho nó :)
            if ( (preg_match('/http/i' , $link)) && (!preg_match('/' . DOMAIN . '/i' , $link)) ) {
                $links->href = 'url.php?link=' . urlencode(self::get_adfly_link($link));
                $links->target = '_blank';
            }
            // Thay đổi thẻ title của link
            $links->title = $title_link . ' - ' . $title . ' ' . $count_link;
            $count_link++;
        }
        $data['content'] = $dom->innertext;
        return $data;
    }


}
