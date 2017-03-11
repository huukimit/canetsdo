<?php

namespace App\Http\Controllers;

use App\Models\Setting,
    Input,
    Session,
    Debugbar;

class S2Controller extends Controller {

    protected $extraHeader = '', $extraFooter = '', $extraHeaderCSS = '', $extraHeaderJS = '', $extraFooterJS = '';
    protected $website_info = array();
    protected $setData = array();
    protected $dir_views = 'frontend._pages.';
    protected $dir_template = '';
    protected $css_version = '';
    protected $js_version = '';

    function __construct() {
        $this->website_info = array(
            'title' => 'Idol Admin Panel',
            'head_title' => '',
            'back_link' => '',
            'description' => "",
            'images' => "",
            'keyword' => "",
            'favicon' => "",
            'author_name' => "",
            'author_link' => "",
            'google_wmt' => "",
            'twitter_page' => "",
            'twitter_user' => "",
            'site_name' => "Chimera application",
            'og_title' => "",
            'og_description' => "",
            'og_image' => "",
            'og_video' => ""
        );
        $this->css_version = config('manager.version.css');
        $this->js_version = config('manager.version.js');
        $this->debugbar_manager();
        $this->loading_base_style();
    }

    public function debugbar_manager() {
        $debug_param = Input::get('debug', 'off');
        if (in_array($debug_param, ['on', 'off', 'mini'])) {
            Session::put('set_debug', $debug_param);
        }
        $get_debug = Session::get('set_debug', '');
        if ($get_debug == 'on') {
            Debugbar::enable();
        }
        if ($get_debug == 'off') {
            Debugbar::disable();
        }
        if ($get_debug == 'mini') {
            Debugbar::disable();
            ob_start("minify_output"); // Nén dữ liệu html
        }
    }

    /**
     *
     * Extra HTML content
     *
     */
    public function link_css($file_name) {
        $linkFile = url($file_name) . '?v=' . $this->css_version;
        if (strpos($this->extraHeaderCSS, '<link rel="stylesheet" href="' . $linkFile . '" type="text/css">') === false) {
            $this->extraHeaderCSS .= '<link rel="stylesheet" href="' . $linkFile . '" type="text/css">' . "\n";
        }
    }

    public function link_js($file_name) {
        $linkFile = url($file_name) . '?v=' . $this->js_version;
        if (strpos($this->extraFooterJS, '<script type="text/javascript" src="' . $linkFile . '"></script>') === false) {
            $this->extraFooterJS .= '<script type="text/javascript" src="' . $linkFile . '"></script>' . "\n";
        }
    }

    public function link_js_header($file_name) {
        $linkFile = url($file_name) . '?v=' . $this->js_version;
        if (strpos($this->extraHeaderJS, '<script type="text/javascript" src="' . $linkFile . '"></script>') === false) {
            $this->extraHeaderJS .= '<script type="text/javascript" src="' . $linkFile . '"></script>' . "\n";
        }
    }

    public function loading_base_style() {
        $this->link_js_header('public/packages/jquery/jquery.min.js');
        $this->link_js_header('public/packages/jquery/jquery-migrate.min.js');
        $this->link_js('public/packages/cms/main.js');
        $javascript_config = '<script type="text/javascript">';
        $javascript_config .= "var BASE_URL = '" . url("/") . "/';";
        $javascript_config .= "var TIME_NOW = '" . time() . "';";
        $javascript_config .= "var NO_IMAGE_URL = '" . url("uploads/default/no-photo.jpg") . "';";
        $javascript_config .= "var LANGUAGE = '" . \App::getLocale() . "';";
        $javascript_config .= '</script>';
        $this->link_header($javascript_config);
    }

    public function loading_bootstrap_style() {
        // Bootstrap
        $this->link_css('public/packages/addons/bootstrap/css/bootstrap.min.css');
        $this->link_js('public/packages/addons/bootstrap/js/bootstrap.min.js');
        // Font
        $this->link_css('public/packages/addons/font-awesome/css/font-awesome.min.css');
        // Bootstrap Dialog
        $this->link_css('public/packages/addons/bootstrap3-dialog/css/bootstrap-dialog.css');
        $this->link_js('public/packages/addons/bootstrap3-dialog/js/bootstrap-dialog.min.js');
    }

    public function link_header($text) {
        $this->extraHeader .= $text;
    }

    public function link_footer($text) {
        $this->extraFooter .= $text;
    }

    /**
     * Set Data To Views
     *
     * @return array()
     */
    public function PushDataToView() {
        $data = array();
        $data['website_info'] = $this->website_info;
        $data['extraHeader'] = $this->extraHeader;
        $data['extraFooter'] = $this->extraFooter;
        $data['extraHeaderCSS'] = $this->extraHeaderCSS;
        $data['extraHeaderJS'] = $this->extraHeaderJS;
        $data['extraFooterJS'] = $this->extraFooterJS;
        $data['getData'] = $this->setData;

        return $data;
    }

    /**
     * Show template
     *
     * @return html
     */
    public function ShowTemplate($template) {
        $this->loading_header($template);
        return view($this->dir_views . $template, $this->PushDataToView());
    }

    function loading_header($template_page) {
        $javascript_config = '<script type="text/javascript">';
        $javascript_config .= "var CURRENT_PAGE = '" . $template_page . "';";
        $javascript_config .= '</script>';
        $this->link_header($javascript_config);
    }

}
