<?php
// no direct access
defined( '_JEXEC' ) or die;
//all parameters
$appID = $params->get('appID' ,'');
$pageURL = $params->get('pageURL', 'https://www.facebook.com/facebook');
$name = $params->get('name', 'Facebook');
$width = $params->get('width', '');
$height = $params->get('height', '');
$show_faces = $params->get('show_faces', 1);
$show_posts = $params->get('show_posts', 0);
$hide_cover = $params->get('hide_cover', 0);
$lang = JFactory::getLanguage();
$print_facebook = '
    <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/'.$lang->getTag().'/sdk.js#xfbml=1&version=v2.3&appId='.$appID.'";
  fjs.parentNode.insertBefore(js, fjs);
}(document, \'script\', \'facebook-jssdk\'));</script>';
$print_facebook .= '<div class="fb-page" data-href="'.$pageURL.'" data-hide-cover="'.$hide_cover.'" data-show-facepile="'.$show_faces.'" data-width="'.$width.'" data-height="'.$height.'" data-show-posts="'.$show_posts.'"><div class="fb-xfbml-parse-ignore"><blockquote cite="'.$pageURL.'"><a href="'.$pageURL.'">'.$name.'</a></blockquote></div></div>';
?>
<div id="tm_facebook_page_plugin_<?php echo $module->id; ?>" class="tm_facebook_page_plugin_<?php echo $params->get('moduleclass_sfx');?>">
	<?php echo $print_facebook; ?>
</div>
<script>
	;(function ($) {
        var o = $('.fb-page');

        $(window).load(function () {
            o.css({'display': 'block'})
                .find('span').css({
                    'width': '100%',
                    'display': 'block',
                    'text-align': 'inherit'
                })
                .find('iframe').css({
                    'display': 'inline-block',
                    'position': 'static'
                });
        });

        $(window).on('load resize', function () {
            if (o.parent().width() < o.find('iframe').width()) {
                o.find('iframe').css({
                    'transform': 'scale(' + (o.width() / o.find('iframe').width()) + ')',
                    'transform-origin': '0% 0%'
                })
                    .parent().css({
                        'height': (o.find('iframe').height() * (o.width() / o.find('iframe').width())) + 'px'
                    });
            } else {
                o
                    .find('span').css({
                        'height': o.find('iframe').height()
                    })
                    .find('iframe').css({
                        'transform': 'none'
                    });
            }
        });
    })(jQuery);
</script>