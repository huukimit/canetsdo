<?php return array (
  'about' => 
  array (
    'content' => '<p>私たち「キメラ」という名前は、同一個体内に様々な細胞が混じっている事や状態を意味する 【chimera】に由来し、ロゴマークは、ライオンの頭と山羊の胴体、毒蛇の尻尾を持つ神話のキマイラをあらわしています。<br>キメラとは、その名の通り、複数のコンテンツが入り交じって世界を広げていき、多くの人や次世代の子供達に、参加するコンテンツやパフォーマーの魅力を伝えていくことを目的にしています。<br>その潜在ファンの数は計り知れません。<br>しかし、それらの魅力や興奮を、簡単に観ることができて身近に楽しめる、一堂に会したような場が、この世には存在しないです。<br>それは、世界中に存在するファンや競技者たちの世界においても、言えること。<br>だから、CHIMERA（キメラ）は、つくります。<br>WEB TVとイベントを駆使して、世界中のマイナーエンターテイメントが集結する革新的な場を。<br>単体では小規模だったとしても、それが集団となったとき、とてつもないパワーが生まれ、メジャーにも勝るフィールドになります。<br>CHIMERA（キメラ）は、魅力的かつ面白い、人に伝えないではいられないマイナーコンテンツやパフォーマーの数々を、マイナージャンルが集結するビッグスケールなイベント（リアル）と、壮大な規模の映像視聴ができるWEB TV（バーチャル）で、世界に発信していきます。</p><br />
							<p>世界には、野球やサッカーなどの「メジャーエンターテイメント」がある一方、独創的な世界観で私たちを熱狂させる「マイナーエンターテイメント」があります。<br>たとえば、メジャープレイヤーも一目を置くエクストリームスポーツ。<br>高度で華やかで刺激的な技のるつぼを、あなたは観たことがあるでしょうか。<br>カートやドリフト、BMX、スケートボーディング、さらにはポールダンスやチアリーディングなど、マイナーの世界には圧倒的魅力を持つ多種多様のジャンルが存在し、その潜在ファンの数は計り知れません。<br>しかし、それらの魅力や興奮を、簡単に観ることができて身近に楽しめる、一堂に会したような場が、この世には存在しないです。<br>それは、世界中に存在するファンや競技者たちの世界においても、言えること。<br>だから、CHIMERA（キメラ）は、つくります。<br>WEB TVとイベントを駆使して、世界中のマイナーエンターテイメントが集結する革新的な場を。<br>単体では小規模だったとしても、それが集団となったとき、とてつもないパワーが生まれ、メジャーにも勝るフィールドになります。<br>CHIMERA（キメラ）は、魅力的かつ面白い、人に伝えないではいられないマイナーコンテンツやパフォーマーの数々を、マイナージャンルが集結するビッグスケールなイベント（リアル）と、壮大な規模の映像視聴ができるWEB TV（バーチャル）で、世界に発信していきます。</p>',
  ),
  'admin' => 
  array (
    'percent_hiro' => 50,
    'limit_query' => 15,
    'message' => 
    array (
      'editaccount_successfull' => 'アカウントの編集ができました。',
      'editaccount_oldpassword_invalid' => '旧パスワードが正しくありません。',
      'editaccount_user_notexits' => 'ユーザ名が存在していません。',
      'editaccount_email_notexits' => 'メールアドレスが既に存在しています。',
      'editaccount_username_notexits' => 'ユーザ名が既に存在しています。',
      'edituser_successfull' => 'ユーザ情報の編集ができました。',
      'editplayer_successfull' => 'プレイヤー情報の編集ができました。',
    ),
  ),
  'filesystems' => 
  array (
    'default' => 'local',
    'cloud' => 's3',
    'disks' => 
    array (
      'local' => 
      array (
        'driver' => 'local',
        'root' => '/var/www/html/canets/storage/app',
      ),
      's3' => 
      array (
        'driver' => 's3',
        'key' => 'your-key',
        'secret' => 'your-secret',
        'region' => 'your-region',
        'bucket' => 'your-bucket',
      ),
      'rackspace' => 
      array (
        'driver' => 'rackspace',
        'username' => 'your-username',
        'key' => 'your-key',
        'container' => 'your-container',
        'endpoint' => 'https://identity.api.rackspacecloud.com/v2.0/',
        'region' => 'IAD',
        'url_type' => 'publicURL',
      ),
    ),
  ),
  'database' => 
  array (
    'fetch' => 8,
    'default' => 'mysql',
    'connections' => 
    array (
      'sqlite' => 
      array (
        'driver' => 'sqlite',
        'database' => '/var/www/html/canets/storage/database.sqlite',
        'prefix' => '',
      ),
      'mysql' => 
      array (
        'driver' => 'mysql',
        'host' => '127.0.0.1',
        'database' => 'db_cannets',
        'username' => 'root',
        'password' => 'vanthanh',
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => '',
        'strict' => false,
      ),
      'pgsql' => 
      array (
        'driver' => 'pgsql',
        'host' => '127.0.0.1',
        'database' => 'db_cannets',
        'username' => 'root',
        'password' => 'vanthanh',
        'charset' => 'utf8',
        'prefix' => '',
        'schema' => 'public',
      ),
      'sqlsrv' => 
      array (
        'driver' => 'sqlsrv',
        'host' => '127.0.0.1',
        'database' => 'db_cannets',
        'username' => 'root',
        'password' => 'vanthanh',
        'prefix' => '',
      ),
    ),
    'migrations' => 'migrations',
    'redis' => 
    array (
      'cluster' => false,
      'default' => 
      array (
        'host' => '127.0.0.1',
        'port' => 6379,
        'database' => 0,
      ),
    ),
  ),
  'app' => 
  array (
    'debug' => true,
    'url' => 'http://localhost',
    'timezone' => 'Asia/Ho_Chi_Minh',
    'locale' => 'ja',
    'fallback_locale' => 'en',
    'key' => 'xPGMgwXki6m0hZ8LZlTsDOIb1wATptCW',
    'cipher' => 'rijndael-128',
    'log' => 'daily',
    'providers' => 
    array (
      0 => 'Illuminate\\Foundation\\Providers\\ArtisanServiceProvider',
      1 => 'Illuminate\\Auth\\AuthServiceProvider',
      2 => 'Illuminate\\Bus\\BusServiceProvider',
      3 => 'Illuminate\\Cache\\CacheServiceProvider',
      4 => 'Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider',
      5 => 'Illuminate\\Routing\\ControllerServiceProvider',
      6 => 'Illuminate\\Cookie\\CookieServiceProvider',
      7 => 'Illuminate\\Database\\DatabaseServiceProvider',
      8 => 'Illuminate\\Encryption\\EncryptionServiceProvider',
      9 => 'Illuminate\\Filesystem\\FilesystemServiceProvider',
      10 => 'Illuminate\\Foundation\\Providers\\FoundationServiceProvider',
      11 => 'Illuminate\\Hashing\\HashServiceProvider',
      12 => 'Illuminate\\Mail\\MailServiceProvider',
      13 => 'Illuminate\\Pagination\\PaginationServiceProvider',
      14 => 'Illuminate\\Pipeline\\PipelineServiceProvider',
      15 => 'Illuminate\\Queue\\QueueServiceProvider',
      16 => 'Illuminate\\Redis\\RedisServiceProvider',
      17 => 'Illuminate\\Auth\\Passwords\\PasswordResetServiceProvider',
      18 => 'Illuminate\\Session\\SessionServiceProvider',
      19 => 'Illuminate\\Translation\\TranslationServiceProvider',
      20 => 'Illuminate\\Validation\\ValidationServiceProvider',
      21 => 'Illuminate\\View\\ViewServiceProvider',
      22 => 'App\\Providers\\AppServiceProvider',
      23 => 'App\\Providers\\BusServiceProvider',
      24 => 'App\\Providers\\ConfigServiceProvider',
      25 => 'App\\Providers\\EventServiceProvider',
      26 => 'App\\Providers\\RouteServiceProvider',
      27 => 'Illuminate\\View\\ViewServiceProvider',
      28 => 'Illuminate\\Html\\HtmlServiceProvider',
      29 => 'Barryvdh\\Debugbar\\ServiceProvider',
      30 => 'Jenssegers\\Agent\\AgentServiceProvider',
      31 => 'Maatwebsite\\Excel\\ExcelServiceProvider',
      32 => 'Intervention\\Image\\ImageServiceProvider',
      33 => 'Elibyy\\TCPDF\\ServiceProvider',
      34 => 'Rap2hpoutre\\LaravelLogViewer\\LaravelLogViewerServiceProvider',
    ),
    'aliases' => 
    array (
      'App' => 'Illuminate\\Support\\Facades\\App',
      'Artisan' => 'Illuminate\\Support\\Facades\\Artisan',
      'Auth' => 'Illuminate\\Support\\Facades\\Auth',
      'Blade' => 'Illuminate\\Support\\Facades\\Blade',
      'Bus' => 'Illuminate\\Support\\Facades\\Bus',
      'Cache' => 'Illuminate\\Support\\Facades\\Cache',
      'Config' => 'Illuminate\\Support\\Facades\\Config',
      'Cookie' => 'Illuminate\\Support\\Facades\\Cookie',
      'Crypt' => 'Illuminate\\Support\\Facades\\Crypt',
      'DB' => 'Illuminate\\Support\\Facades\\DB',
      'Eloquent' => 'Illuminate\\Database\\Eloquent\\Model',
      'Event' => 'Illuminate\\Support\\Facades\\Event',
      'File' => 'Illuminate\\Support\\Facades\\File',
      'Hash' => 'Illuminate\\Support\\Facades\\Hash',
      'Input' => 'Illuminate\\Support\\Facades\\Input',
      'Inspiring' => 'Illuminate\\Foundation\\Inspiring',
      'Lang' => 'Illuminate\\Support\\Facades\\Lang',
      'Log' => 'Illuminate\\Support\\Facades\\Log',
      'Mail' => 'Illuminate\\Support\\Facades\\Mail',
      'Password' => 'Illuminate\\Support\\Facades\\Password',
      'Queue' => 'Illuminate\\Support\\Facades\\Queue',
      'Redirect' => 'Illuminate\\Support\\Facades\\Redirect',
      'Redis' => 'Illuminate\\Support\\Facades\\Redis',
      'Request' => 'Illuminate\\Support\\Facades\\Request',
      'Response' => 'Illuminate\\Support\\Facades\\Response',
      'Route' => 'Illuminate\\Support\\Facades\\Route',
      'Schema' => 'Illuminate\\Support\\Facades\\Schema',
      'Session' => 'Illuminate\\Support\\Facades\\Session',
      'Storage' => 'Illuminate\\Support\\Facades\\Storage',
      'URL' => 'Illuminate\\Support\\Facades\\URL',
      'Validator' => 'Illuminate\\Support\\Facades\\Validator',
      'View' => 'Illuminate\\Support\\Facades\\View',
      'Form' => 'Illuminate\\Html\\FormFacade',
      'HTML' => 'Illuminate\\Html\\HtmlFacade',
      'Debugbar' => 'Barryvdh\\Debugbar\\Facade',
      'Agent' => 'Jenssegers\\Agent\\Facades\\Agent',
      'Excel' => 'Maatwebsite\\Excel\\Facades\\Excel',
      'Image' => 'Intervention\\Image\\Facades\\Image',
    ),
  ),
  'view' => 
  array (
    'paths' => 
    array (
      0 => '/var/www/html/canets/resources/views',
    ),
    'compiled' => '/var/www/html/canets/storage/framework/views',
  ),
  'excel' => 
  array (
    'cache' => 
    array (
      'enable' => true,
      'driver' => 'memory',
      'settings' => 
      array (
        'memoryCacheSize' => '32MB',
        'cacheTime' => 600,
      ),
      'memcache' => 
      array (
        'host' => 'localhost',
        'port' => 11211,
      ),
      'dir' => '/var/www/html/canets/storage/cache',
    ),
    'properties' => 
    array (
      'creator' => 'Pham Dinh Cuong',
      'lastModifiedBy' => 'Pham Dinh Cuong',
      'title' => 'S2 CMS Document',
      'description' => 'Default spreadsheet export',
      'subject' => 'Spreadsheet export',
      'keywords' => 'maatwebsite, excel, export',
      'category' => 'Excel',
      'manager' => 'S2 Team',
      'company' => 'S2 Team',
    ),
    'sheets' => 
    array (
      'pageSetup' => 
      array (
        'orientation' => 'portrait',
        'paperSize' => '9',
        'scale' => '100',
        'fitToPage' => false,
        'fitToHeight' => true,
        'fitToWidth' => true,
        'columnsToRepeatAtLeft' => 
        array (
          0 => '',
          1 => '',
        ),
        'rowsToRepeatAtTop' => 
        array (
          0 => 0,
          1 => 0,
        ),
        'horizontalCentered' => false,
        'verticalCentered' => false,
        'printArea' => NULL,
        'firstPageNumber' => NULL,
      ),
    ),
    'creator' => 'Pham Dinh Cuong',
    'csv' => 
    array (
      'delimiter' => ',',
      'enclosure' => '"',
      'line_ending' => '
',
    ),
    'export' => 
    array (
      'autosize' => true,
      'autosize-method' => 'approx',
      'generate_heading_by_indices' => true,
      'merged_cell_alignment' => 'left',
      'calculate' => false,
      'includeCharts' => false,
      'sheets' => 
      array (
        'page_margin' => false,
        'nullValue' => NULL,
        'startCell' => 'A1',
        'strictNullComparison' => false,
      ),
      'store' => 
      array (
        'path' => '/var/www/html/canets/storage/exports',
        'returnInfo' => false,
      ),
      'pdf' => 
      array (
        'driver' => 'DomPDF',
        'drivers' => 
        array (
          'DomPDF' => 
          array (
            'path' => '/var/www/html/canets/vendor/dompdf/dompdf/',
          ),
          'tcPDF' => 
          array (
            'path' => '/var/www/html/canets/vendor/tecnick.com/tcpdf/',
          ),
          'mPDF' => 
          array (
            'path' => '/var/www/html/canets/vendor/mpdf/mpdf/',
          ),
        ),
      ),
    ),
    'filters' => 
    array (
      'registered' => 
      array (
        'chunk' => 'Maatwebsite\\Excel\\Filters\\ChunkReadFilter',
      ),
      'enabled' => 
      array (
      ),
    ),
    'import' => 
    array (
      'heading' => 'slugged',
      'startRow' => 1,
      'separator' => '_',
      'includeCharts' => false,
      'to_ascii' => true,
      'encoding' => 
      array (
        'input' => 'UTF-8',
        'output' => 'UTF-8',
      ),
      'calculate' => true,
      'ignoreEmpty' => false,
      'force_sheets_collection' => false,
      'dates' => 
      array (
        'enabled' => true,
        'format' => false,
        'columns' => 
        array (
        ),
      ),
      'sheets' => 
      array (
        'test' => 
        array (
          'firstname' => 'A2',
        ),
      ),
    ),
    'views' => 
    array (
      'styles' => 
      array (
        'th' => 
        array (
          'font' => 
          array (
            'bold' => true,
            'size' => 12,
          ),
        ),
        'strong' => 
        array (
          'font' => 
          array (
            'bold' => true,
            'size' => 12,
          ),
        ),
        'b' => 
        array (
          'font' => 
          array (
            'bold' => true,
            'size' => 12,
          ),
        ),
        'i' => 
        array (
          'font' => 
          array (
            'italic' => true,
            'size' => 12,
          ),
        ),
        'h1' => 
        array (
          'font' => 
          array (
            'bold' => true,
            'size' => 24,
          ),
        ),
        'h2' => 
        array (
          'font' => 
          array (
            'bold' => true,
            'size' => 18,
          ),
        ),
        'h3' => 
        array (
          'font' => 
          array (
            'bold' => true,
            'size' => 13.5,
          ),
        ),
        'h4' => 
        array (
          'font' => 
          array (
            'bold' => true,
            'size' => 12,
          ),
        ),
        'h5' => 
        array (
          'font' => 
          array (
            'bold' => true,
            'size' => 10,
          ),
        ),
        'h6' => 
        array (
          'font' => 
          array (
            'bold' => true,
            'size' => 7.5,
          ),
        ),
        'a' => 
        array (
          'font' => 
          array (
            'underline' => true,
            'color' => 
            array (
              'argb' => 'FF0000FF',
            ),
          ),
        ),
        'hr' => 
        array (
          'borders' => 
          array (
            'bottom' => 
            array (
              'style' => 'thin',
              'color' => 
              array (
                0 => 'FF000000',
              ),
            ),
          ),
        ),
      ),
    ),
  ),
  'debugbar' => 
  array (
    'enabled' => NULL,
    'storage' => 
    array (
      'enabled' => true,
      'driver' => 'file',
      'path' => '/var/www/html/canets/storage/debugbar',
      'connection' => NULL,
    ),
    'include_vendors' => true,
    'capture_ajax' => true,
    'clockwork' => false,
    'collectors' => 
    array (
      'phpinfo' => true,
      'messages' => true,
      'time' => true,
      'memory' => true,
      'exceptions' => true,
      'log' => true,
      'db' => true,
      'views' => true,
      'route' => true,
      'laravel' => false,
      'events' => false,
      'default_request' => false,
      'symfony_request' => true,
      'mail' => true,
      'logs' => true,
      'files' => true,
      'config' => true,
      'auth' => true,
      'session' => true,
    ),
    'options' => 
    array (
      'auth' => 
      array (
        'show_name' => false,
      ),
      'db' => 
      array (
        'with_params' => true,
        'timeline' => false,
        'backtrace' => false,
        'explain' => 
        array (
          'enabled' => false,
          'types' => 
          array (
            0 => 'SELECT',
          ),
        ),
        'hints' => true,
      ),
      'mail' => 
      array (
        'full_log' => false,
      ),
      'views' => 
      array (
        'data' => false,
      ),
      'route' => 
      array (
        'label' => true,
      ),
      'logs' => 
      array (
        'file' => NULL,
      ),
    ),
    'inject' => true,
    'route_prefix' => '_debugbar',
  ),
  'mail' => 
  array (
    'driver' => 'smtp',
    'host' => 'mailtrap.io',
    'port' => '2525',
    'from' => 
    array (
      'address' => NULL,
      'name' => NULL,
    ),
    'encryption' => 'tls',
    'username' => NULL,
    'password' => NULL,
    'sendmail' => '/usr/sbin/sendmail -bs',
    'pretend' => false,
  ),
  'cache' => 
  array (
    'default' => 'file',
    'stores' => 
    array (
      'apc' => 
      array (
        'driver' => 'apc',
      ),
      'array' => 
      array (
        'driver' => 'array',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'cache',
        'connection' => NULL,
      ),
      'file' => 
      array (
        'driver' => 'file',
        'path' => '/var/www/html/canets/storage/framework/cache',
      ),
      'memcached' => 
      array (
        'driver' => 'memcached',
        'servers' => 
        array (
          0 => 
          array (
            'host' => '127.0.0.1',
            'port' => 11211,
            'weight' => 100,
          ),
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
      ),
    ),
    'prefix' => 'laravel',
  ),
  'auth' => 
  array (
    'driver' => 'eloquent',
    'model' => 'App\\User',
    'table' => 'users',
    'password' => 
    array (
      'email' => 'emails.password',
      'table' => 'password_resets',
      'expire' => 60,
    ),
    'no_csrf' => 
    array (
      0 => 'service/mobile/login',
      1 => 'service/mobile/registercustomer',
      2 => 'service/mobile/registerlaborer',
      3 => 'service/mobile/sendmail',
      4 => 'service/mobile/forgotpassword',
      5 => 'service/mobile/sendmailactive',
      6 => 'service/mobile/checkmakhuyenmai',
      7 => 'service/mobile/giupviecmotlan',
      8 => 'service/mobile/giupviecthuongxuyen',
      9 => 'service/mobile/updatelatlong',
      10 => 'service/mobile/changepassword',
      11 => 'service/mobile/testpushnotify',
      12 => 'service/mobile/screentopcustomer',
      13 => 'service/mobile/screentopnguoilaodong',
      14 => 'service/mobile/cancelbooking',
      15 => 'service/mobile/nhanviec',
      16 => 'service/mobile/dangkytaikhoanlaodong',
      17 => 'service/mobile/getlistbided',
      18 => 'service/mobile/getthongtinlaodong',
      19 => 'service/mobile/rate',
      20 => 'service/mobile/nhanlaodong',
      21 => 'service/mobile/onoffservice',
      22 => 'service/mobile/getdetailjob',
      23 => 'service/mobile/sinhvienganday',
      24 => 'service/mobile/naptien',
      25 => 'service/mobile/napthe',
      26 => 'service/mobile/lichsugiaodich',
      27 => 'service/mobile/getbookingmissednotify',
      28 => 'service/mobile/getCustomerbyLatLong',
      29 => 'service/mobile/getThongtinBookingAndLaodong',
      30 => 'service/mobile/baoDaLamXong',
      31 => 'service/mobile/checkParamsRequested',
      32 => 'service/mobile/test',
      33 => 'service/mobile/upAnh',
      34 => 'service/mobile/thongbaoSvhuy',
      35 => 'service/mobile/historybooking',
      36 => 'service/mobile/svCancel',
      37 => 'service/mobile/getDetailHistoryJob',
      38 => 'service/mobile/getDetailBooking',
      39 => 'service/mobile/khachhangnhanlaodong',
      40 => 'service/mobile/getContract',
      41 => 'service/mobile/feedBack',
    ),
  ),
  'queue' => 
  array (
    'default' => 'sync',
    'connections' => 
    array (
      'sync' => 
      array (
        'driver' => 'sync',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'jobs',
        'queue' => 'default',
        'expire' => 60,
      ),
      'beanstalkd' => 
      array (
        'driver' => 'beanstalkd',
        'host' => 'localhost',
        'queue' => 'default',
        'ttr' => 60,
      ),
      'sqs' => 
      array (
        'driver' => 'sqs',
        'key' => 'your-public-key',
        'secret' => 'your-secret-key',
        'queue' => 'your-queue-url',
        'region' => 'us-east-1',
      ),
      'iron' => 
      array (
        'driver' => 'iron',
        'host' => 'mq-aws-us-east-1.iron.io',
        'token' => 'your-token',
        'project' => 'your-project-id',
        'queue' => 'your-queue-name',
        'encrypt' => true,
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'queue' => 'default',
        'expire' => 60,
      ),
    ),
    'failed' => 
    array (
      'database' => 'mysql',
      'table' => 'failed_jobs',
    ),
  ),
  'session' => 
  array (
    'driver' => 'file',
    'lifetime' => 1440,
    'expire_on_close' => false,
    'encrypt' => false,
    'files' => '/var/www/html/canets/storage/framework/sessions',
    'connection' => NULL,
    'table' => 'sessions',
    'lottery' => 
    array (
      0 => 2,
      1 => 100,
    ),
    'cookie' => 'laravel_session',
    'path' => '/',
    'domain' => NULL,
    'secure' => false,
  ),
  'services' => 
  array (
    'role_user' => 3,
    'role_idol' => 2,
    'role_admin' => 1,
    'zeni_action' => 1,
    'point_action' => 1,
    'type_gift' => 1,
    'type_item_waiting' => 2,
    'type_purchase_point' => 1,
    'mailgun' => 
    array (
      'domain' => '',
      'secret' => '',
    ),
    'mandrill' => 
    array (
      'secret' => '',
    ),
    'ses' => 
    array (
      'key' => '',
      'secret' => '',
      'region' => 'us-east-1',
    ),
    'stripe' => 
    array (
      'model' => 'App\\User',
      'secret' => '',
    ),
    'device' => 
    array (
      'android' => 
      array (
        'api_key' => 'AIzaSyCUw5lhaP21rPTBGkm8xoPrjHEni-rGguc',
        'api_url' => 'https://android.googleapis.com/gcm/send',
      ),
      'android_firebase' => 
      array (
        'api_key' => 'AIzaSyAdLPj-577PQOQyLeN7_vb4jGWB7tvHNHs',
        'api_url' => 'https://fcm.googleapis.com/fcm/send',
      ),
      'ios' => 
      array (
        'pem_file_dir' => '/var/www/html/canets/storage/notify/ios.pem',
        'pem_pass' => '123',
        'ios_server' => 'ssl://gateway.sandbox.push.apple.com:2195',
      ),
    ),
    'notify' => 
    array (
      'no_param' => 'No param',
      'user_exist' => 'Số điện thoại hoặc email đã tồn tại, vui lòng sử dụng email hoặc số điện thoại khác',
      'register_successfull' => 'Register successfully',
      'register_fail' => 'Register fail',
      'login_successfull' => 'Login successfully',
      'login_fail' => 'Login fail',
      'logout_successfull' => 'Logout successfully',
      'logout_fail' => 'Email or password invalid',
      'not_exits_user' => 'User is not exits',
      'send_mail_fail' => 'Send email fail',
      'send_mail_successfull' => 'Send email successfully',
      'email_not_exits' => 'Email is not exits',
      'token_reset_invalid' => '既にパスワードを再発行しております。i-1グランプリからのメールをご確認ください。',
      'register_device_successfull' => 'Register device successfully',
      'register_device_fail' => 'Register device fail',
      'get_profile_succesfull' => 'Get profile is successfully',
      'user_invalid' => 'User is invalid',
      'update_profile_successfull' => 'Update profile is successfully',
      'change_password_successfull' => 'Change password is successfully',
      'old_password_invalid' => 'Old password invalid',
      'thanks_activeuser' => 'ユーザー登録が完了いたしました。アプリよりログインできることを確認してください。',
      'missing_point' => 'missing point',
      'get_item_waiting_complete' => 'get item waiting complete',
      'read_item_waiting_complate' => 'read item waiting complete',
      'user_not_active' => 'User not active',
      'user_is_block' => 'User is block',
      'sync_customer_ss' => 'Sync customers success',
      'duplicate_id' => 'Có lỗi do việc đồng bộ bị trùng giữa e user nên sảy ra việc trùng id, vui lòng đồng bộ lại',
    ),
    'query_limit' => 15,
  ),
  'compile' => 
  array (
    'files' => 
    array (
      0 => '/var/www/html/canets/app/Providers/AppServiceProvider.php',
      1 => '/var/www/html/canets/app/Providers/BusServiceProvider.php',
      2 => '/var/www/html/canets/app/Providers/ConfigServiceProvider.php',
      3 => '/var/www/html/canets/app/Providers/EventServiceProvider.php',
      4 => '/var/www/html/canets/app/Providers/RouteServiceProvider.php',
    ),
    'providers' => 
    array (
    ),
  ),
  'image' => 
  array (
    'driver' => 'gd',
    'photo' => 
    array (
      'watermask' => 'uploads/default/watermask.png',
    ),
  ),
  'manager' => 
  array (
    'version' => 
    array (
      'code' => '1.1',
      'css' => '1.1',
      'js' => '1.1',
    ),
    'siteconfig' => 
    array (
      'sitemanager' => 'sitemanager',
      'menu' => 'menu',
    ),
    'filemanager' => 
    array (
      'key' => '686d68b1b20d600fcdd0581eafbf81b0',
      'url' => 'public/packages/filemanager',
    ),
    'uploads' => 
    array (
      'driver' => 'picasa',
      'username' => 'kgh003@gmail.com',
      'password' => '123456a@',
      'user_agent' => 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:37.0) Gecko/20100101 Firefox/37.0',
      'account_id' => '117446852389532044151',
      'album_id' => 
      array (
        0 => '6146733046875183857',
        1 => '6146733300085209841',
        2 => '6146734513630558001',
        3 => '6146734403121712081',
        4 => '6146734298099145617',
        5 => '6146734052773526417',
      ),
    ),
  ),
  'laravel-tcpdf' => 
  array (
    'page_format' => 'A4',
    'page_orientation' => 'P',
    'page_units' => 'mm',
    'unicode' => true,
    'encoding' => 'UTF-8',
    'font_directory' => '',
    'image_directory' => '',
    'tcpdf_throw_exception' => false,
  ),
);
