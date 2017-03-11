<?php

return [
    'version' => [
        'code' => '1.1',
        'css' => '1.1',
        'js' => '1.1',
    ],
    'siteconfig' => [
        'sitemanager' => 'sitemanager',
        'menu' => 'menu',
    ],
    'filemanager' => [
        'key' => '686d68b1b20d600fcdd0581eafbf81b0', // get from $access_keys of FileManager Config
        'url' => 'public/packages/filemanager', // File Manager Dir
    ],
    'uploads' => [
        'driver' => 'picasa',
        'username' => 'kgh003@gmail.com', // Gmail Accout
        'password' => '123456a@', // Password
        'user_agent' => 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:37.0) Gecko/20100101 Firefox/37.0',
        'account_id' => '117446852389532044151', // ID Google Picasa
        'album_id' => ['6146733046875183857', '6146733300085209841', '6146734513630558001', '6146734403121712081', '6146734298099145617', '6146734052773526417'], // Album id
    ],
];
