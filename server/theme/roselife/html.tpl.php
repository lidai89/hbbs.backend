<!DOCTYPE html>
<html lang='zh' dir='ltr'>
   <head>
      <meta charset='UTF-8'>
      <meta name='description' content='<?php print $head_description; ?>'>      
      <meta name='viewport' content='width=device-width, initial-scale=1'>

      <!--BEBIN JS-->
      <!--[if lt IE 9]>
      <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
      <script>
         if ('querySelector' in document && 'localStorage' in window && 'addEventListener' in window) {
            document.write('<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"><\/script>');
         } else {
            document.write('<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"><\/script>');
         }
      </script>
      <script>
         if (!window.jQuery)
         {
            if ('querySelector' in document && 'localStorage' in window && 'addEventListener' in window) {
               document.write('<script src="//ajax.aspnetcdn.com/ajax/jQuery/jquery-2.1.1.min.js"><\/script>');
            }
            else {
               document.write('<script src="//ajax.aspnetcdn.com/ajax/jQuery/jquery-1.11.1.min.js"><\/script>');
            }
         }
      </script>

      <script>(typeof JSON === 'object') || document.write('<script src="//cdnjs.cloudflare.com/ajax/libs/json3/3.3.2/json3.min.js"><\/script>')</script>

      <?php if ( $tpl_debug ): ?>
         <script src="/themes/<?php print $tpl_theme; ?>/js/jquery.cookie.js"></script>
         <script src="/themes/<?php print $tpl_theme; ?>/js/jquery.imageslider.js"></script>
         <script src="/themes/<?php print $tpl_theme; ?>/js/jquery.hoverIntent.js"></script>
         <script src="/themes/<?php print $tpl_theme; ?>/js/jquery.superfish.js"></script>
         <script src="/themes/<?php print $tpl_theme; ?>/js/jquery.markitup.js"></script>
         <script src="/themes/<?php print $tpl_theme; ?>/js/jquery.markitup.bbcode.set.js"></script>
         <script src="/themes/<?php print $tpl_theme; ?>/js/jquery.upload-1.0.2.js"></script>
         <script src="/themes/<?php print $tpl_theme; ?>/js/main.js"></script>
      <?php else: ?>
         <script src="/themes/<?php print $tpl_theme; ?>/js/min_1408892908.js"></script>
      <?php endif; ?>
      <!--END JS-->

      <!--BEGIN CSS-->
      <?php if ( $tpl_debug ): ?>
         <link href="/themes/<?php print $tpl_theme; ?>/css/normalize.css" rel="stylesheet" type="text/css">
         <link href="/themes/<?php print $tpl_theme; ?>/css/markitup.style.css" rel="stylesheet" type="text/css">
         <link href="/themes/<?php print $tpl_theme; ?>/css/markitup.bbcode.css" rel="stylesheet" type="text/css">
         <link href="/themes/<?php print $tpl_theme; ?>/css/nav_xs.css" rel="stylesheet" type="text/css">
         <link href="/themes/<?php print $tpl_theme; ?>/css/nav_sm.css" rel="stylesheet" type="text/css">
         <link href="/themes/<?php print $tpl_theme; ?>/css/main_xs.css" rel="stylesheet" type="text/css">
         <link href="/themes/<?php print $tpl_theme; ?>/css/main_sm.css" rel="stylesheet" type="text/css">
         <link href="/themes/<?php print $tpl_theme; ?>/css/main_md.css" rel="stylesheet" type="text/css">
         <link href="/themes/<?php print $tpl_theme; ?>/css/main_lg.css" rel="stylesheet" type="text/css">
      <?php else: ?>
         <link href="/themes/<?php print $tpl_theme; ?>/css/min_1408892908.css" rel="stylesheet" type="text/css">
      <?php endif; ?>
      <!--END CSS-->

      <title><?php print $head_title; ?></title>
      <!--BEING APPLE ICON-->
      <link rel='apple-touch-icon' href='/apple-touch-icon.png'>
      <link rel='apple-touch-icon' sizes='72x72' href='/apple-touch-icon-72x72.png'>
      <link rel='apple-touch-icon' sizes='114x114' href='/apple-touch-icon-114x114.png'>
      <!--END APPLE ICON-->
   </head>
   <body>
      <div id='page'>
         <header id='page_header'>
            <div id="logo_div">
               <a id='logo' href='/'><img src='/themes/roselife/images/logo.png'></a>
               <span id='messagebox'><?php print $head_title; ?></span>
            </div>
            <div id="page_header_ad"><span></span><a 
                  href="http://www.llestudyusa.com" target="_blank"><img src="/data/ad/lles-1.jpg"></a><a
                  href="http://www.har.com/AWS/aws.cfm?agent_number=634860" target="_blank"><img src="/data/ad/alicewang-1.gif"></a><a 
                  href="http://jeffreyjinteam.com/" target="_blank"><img src="/data/ad/jinfei.gif"></a>
            </div>
         </header>
         <nav id='page_navbar' class='hidden'>
            <ul class="sf-menu" style="display: inline-block; float: right;">
               <li class='v_user'><a><?php print $username; ?></a></li>
               <li class='v_user'><a id="pm" href="/pm/mailbox">短信</a></li>
               <li class='v_user'><a href="/user/bookmark">收藏夹</a></li>
               <li class='v_user'><a href="/user">我的账户</a></li>
               <li class='v_user'><a href="/password/change">更改密码</a></li>
               <li class='v_user'><a  href="/user/logout">登出</a></li>
               <li class='v_guest'><a href="/user/login">登录</a></li>
               <li class='v_guest'><a href="/password/forget">忘记密码</a></li>
               <li class='v_guest'><a href="/user/username">忘记用户名</a></li>
               <li class='v_guest'><a href="/user/register">注册帐号</a></li>
            </ul>
            <?php print $page_navbar; ?>
         </nav>
         <section id='page_body'><?php print $content; ?></section>
         <footer id='page_footer'>
            <div class='google_ad_xs'>
               <style>
                  .responsive-ad-xs { display:none; }
                  @media(max-width: 767px) { .responsive-ad-xs { display: block; width: 100%; height: 60px; } }
               </style>
               <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
               <!-- responsive_ad_xs -->
               <ins class="adsbygoogle responsive-ad-xs"
                    data-ad-client="ca-pub-8257334386742604"
                    data-ad-slot="9976046082"></ins>
               <script>
         (adsbygoogle = window.adsbygoogle || []).push({});
               </script>
            </div>
            <div id='copyright'>如有问题，请联络网站管理员<a href="mailto:admin@houstonbbs.com">admin@houstonbbs.com</a> | © 2009-2014 HoustonBBS 版权所有 | <a href='/term'>免责声明</a></div>
         </footer>
      </div>
   </body>
   <?php if ( !$debug ): ?>
      <script>
         (function(i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function() {
               (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o), m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
         })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

         ga('create', 'UA-36671672-1', 'houstonbbs.com');
         ga('send', 'pageview');
      </script>
   <?php endif; ?>
</html>