<?php
defined('_JEXEC') or die;
$app             = JFactory::getApplication();
$doc             = JFactory::getDocument();
$user            = JFactory::getUser();
include_once ('includes/functions.php');
include_once ('includes/includes.php');
if ($hideByEdit == false){
  if(!class_exists('Mobile_Detect')){
    require_once 'includes/Mobile_Detect.php';
  }
  $detect = new Mobile_Detect;
}
$this->language  = $doc->language;
$this->direction = $doc->direction;
JHtml::_('bootstrap.framework');
$bodyClass = '';
if(isset($detect) && ($detect->isMobile() || $detect->isTablet())){
  if(isset($_COOKIE['disableMobile'])){
    if($_COOKIE['disableMobile']=='false'){
      $bodyClass = "mobile_mode";
    }
    else{
      $bodyClass = "desktop_mode";
    }
  }
  else {
    $bodyClass = "mobile_mode";
  }
}
JHtml::_('bootstrap.loadCss', false, $this->direction);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
  <head>
    <?php if(isset($detect) && ($detect->isMobile() || $detect->isTablet())){
      if(isset($_COOKIE['disableMobile'])){ ?>
        <?php if($_COOKIE['disableMobile']=='false'){ ?>
          <meta id="viewport" name="viewport" content="width=device-width, initial-scale=1">
        <?php }
      }
      else { ?>
        <meta id="viewport" name="viewport" content="width=device-width, initial-scale=1">
      <?php }
    }
      if ($themeLayout == 1){
          $doc->addStyleSheet('templates/'.$this->template.'/css/layout.css');
      }
      if ($hideByEdit == false){
        $doc->addStyleSheet('templates/'.$this->template.'/css/jquery.fancybox.css');
        $doc->addStyleSheet('templates/'.$this->template.'/css/jquery.fancybox-buttons.css');
        $doc->addStyleSheet('templates/'.$this->template.'/css/jquery.fancybox-thumbs.css');
        $doc->addStyleSheet('templates/'.$this->template.'/css/template.css');
      }
      else{
        $doc->addStyleSheet('administrator/templates/'.$adminTemplate.'/css/template.css');
        $doc->addStyleSheet('templates/'.$this->template.'/css/edit.css');
      }
    ?>
    <jdoc:include type="head" />
    <link href='//fonts.googleapis.com/css?family=Ubuntu:400,300,300italic,400italic,500,700italic,500italic,700' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Comfortaa:400,300,700' rel='stylesheet' type='text/css'>
    <!--[if lt IE 9]>
      <link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/ie8.css" />
      <script src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/html5shiv+printshiv.js"></script>
    <![endif]-->  
  </head>
  <body class="<?php echo $bodyClass . " " . $option . " view-" . $view . " task-" . $task . " itemid-" . $itemid . " body__" . $pageClass;if(isset($detect) && ($detect->isMobile() || $detect->isTablet())){echo ' mobile';}?>">
    <!--[if lt IE 9]>
      <div style=' clear: both; text-align:center; position: relative;'>
        <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
          <img src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/images/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today." />
        </a>
      </div>
    <![endif]-->
    <!-- Body -->
    <div id="wrapper">
      <div class="wrapper-inner">
        <?php if ($hideByEdit == false): ?>
        <!-- Top -->
        <div id="top">
          <div class="row-container">
            <div class="<?php echo $containerClass; ?>">
              <div class="<?php echo $rowClass; ?>">
                <!-- Logo -->
                <div id="logo" class="span<?php echo $this->params->get('logoBlockWidth'); ?>">
                  <a href="<?php echo JURI::base(); ?>">
                    <?php if(isset($logo)) : ?>
                    <img src="<?php echo $logo;?>" alt="<?php echo $sitename; ?>">
                    <h1><?php echo $sitename; ?></h1>
                    <?php else : ?><h1><?php echo wrap_chars_with_span($sitename); ?></h1><?php endif; ?>
                  </a>
                </div>
                <jdoc:include type="modules" name="top" style="themeHtml5" />
                <div class="clearfix"></div>
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>
        <!-- Header -->
        <?php if ($this->countModules('header') && $hideByEdit == false): ?>
        <div id="header">
          <div class="row-container">
            <div class="<?php echo $containerClass; ?>">
              <div class="<?php echo $rowClass; ?>">
                <jdoc:include type="modules" name="header" style="themeHtml5" />
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>
        <?php if ($this->countModules('navigation') && $hideByEdit == false): ?>
        <!-- Navigation -->
        <div id="navigation" role="navigation">
          <div class="row-container">
            <div class="<?php echo $containerClass; ?>">
              <div class="<?php echo $rowClass; ?>">
                <jdoc:include type="modules" name="navigation" style="themeHtml5" />
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>
        <?php if ($this->countModules('showcase') && $hideByView == false && $hideByEdit == false): ?>
        <!-- Showcase -->
        <div id="showcase">
          <jdoc:include type="modules" name="showcase" style="html5nosize" />
        </div>
        <?php endif; ?>
        <?php if ($this->countModules('feature') && $hideByView == false && $hideByEdit == false): ?>
        <!-- Feature -->
        <div id="feature">
          <div class="row-container">
            <div class="<?php echo $containerClass; ?>">
              <div class="<?php echo $rowClass; ?>">
                  <jdoc:include type="modules" name="feature" style="themeHtml5" />
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>
        <?php if ($this->countModules('maintop') && $hideByView == false && $hideByEdit == false): ?>
        <!-- Maintop -->
        <div id="maintop"<?php if( !$detect->isMobile() && !$detect->isTablet() && ((int)$detect->version('IE') == '' || (int)$detect->version('IE') > 8 )){ ?> data-stellar-background-ratio="0.6"<?php } ?>>
          <div class="row-container">
            <div class="<?php echo $containerClass; ?>">
              <div class="<?php echo $rowClass; ?>">
                <jdoc:include type="modules" name="maintop" style="themeHtml5" />
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>
        <!-- Main Content row -->
        <div id="content">
          <div class="row-container">
            <div class="<?php echo $containerClass; ?>">
              <div class="content-inner <?php echo $rowClass; ?>">   
                <?php if ($this->countModules('aside-left') && ($hideByOption) == false && $view !== 'form' && $hideByEdit == false): ?>     
                <!-- Left sidebar -->
                <div id="aside-left" class="span<?php echo $asideLeftWidth; ?>">
                  <aside role="complementary">
                    <jdoc:include type="modules" name="aside-left" style="html5nosize" />
                  </aside>
                </div>
                <?php endif; ?>        
                <div id="component" class="span<?php echo $mainContentWidth; ?>">
                  <main role="main">
                    <?php if ($this->countModules('breadcrumbs') && $layout !== 'edit'): ?>
                    <!-- Breadcrumbs -->
                    <div id="breadcrumbs-row">
                      <div id="breadcrumbs">
                        <jdoc:include type="modules" name="breadcrumbs" style="html5nosize" />
                      </div>
                    </div>
                    <?php endif; ?>       
                    <?php if ($this->countModules('content-top') && $hideByView == false && $hideByEdit == false): ?> 
                    <!-- Content-top -->
                    <div id="content-top-row" class="<?php echo $rowClass; ?>">
                      <div id="content-top">
                        <jdoc:include type="modules" name="content-top" style="themeHtml5" />
                      </div>
                    </div>
                    <?php endif; ?>   
                    <jdoc:include type="message" />     
                    <jdoc:include type="component" />   
                    <?php if ($this->countModules('content-bottom') && $hideByView == false && $hideByEdit == false): ?>     
                    <!-- Content-bottom -->
                    <div id="content-bottom-row" class="<?php echo $rowClass; ?>">
                      <div id="content-bottom">
                        <jdoc:include type="modules" name="content-bottom" style="themeHtml5" />
                      </div>
                    </div>
                    <?php endif; ?>
                  </main>
                </div>        
                <?php if ($this->countModules('aside-right') && ($hideByOption) == false && $view !== 'form' && $hideByEdit == false): ?>
                <!-- Right sidebar -->
                <div id="aside-right" class="span<?php echo $asideRightWidth; ?>">
                  <aside role="complementary">
                    <jdoc:include type="modules" name="aside-right" style="html5nosize" />
                  </aside>
                </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
        <?php if ($this->countModules('video') && $hideByView == false && $hideByEdit == false): ?>
        <!-- Video -->
        <div id="video">
          <jdoc:include type="modules" name="video" style="html5nosize" />
        </div>
        <?php endif; ?>
        <?php if ($this->countModules('mainbottom') && $hideByView == false && $hideByEdit == false): ?>
        <!-- Mainbottom -->
        <div id="mainbottom">
          <jdoc:include type="modules" name="mainbottom" style="html5nosize" />
        </div>
        <?php endif; ?>
        <?php if ($this->countModules('mainbottom-2') && $hideByView == false && $hideByEdit == false): ?>
        <!-- Mainbottom -->
        <div id="mainbottom-2">
          <div class="row-container">
            <div class="<?php echo $containerClass; ?>">
              <div class="<?php echo $rowClass; ?>">
                <jdoc:include type="modules" name="mainbottom-2" style="themeHtml5" />
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>
        <?php if ($this->countModules('mainbottom-3') && $hideByView == false && $hideByEdit == false): ?>
        <!-- Mainbottom -->
        <div id="mainbottom-3"<?php if( !$detect->isMobile() && !$detect->isTablet() && ((int)$detect->version('IE') == '' || (int)$detect->version('IE') > 8 )){ ?> data-stellar-background-ratio="0.6"<?php } ?>>
          <div class="row-container">
            <div class="<?php echo $containerClass; ?>">
              <div class="<?php echo $rowClass; ?>">
                <jdoc:include type="modules" name="mainbottom-3" style="themeHtml5" />
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>
        <?php if ($this->countModules('mainbottom-4') && $hideByView == false && $hideByEdit == false): ?>
        <!-- Mainbottom -->
        <div id="mainbottom-4">
          <div class="row-container">
            <div class="<?php echo $containerClass; ?>">
              <div class="<?php echo $rowClass; ?>">
                <jdoc:include type="modules" name="mainbottom-4" style="themeHtml5" />
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>
        <?php if ($this->countModules('mainbottom-5') && $hideByView == false && $hideByEdit == false): ?>
        <!-- Mainbottom -->
        <div id="mainbottom-5">
          <div class="row-container">
            <div class="<?php echo $containerClass; ?>">
              <div class="<?php echo $rowClass; ?>">
                <jdoc:include type="modules" name="mainbottom-5" style="themeHtml5" />
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>
        <?php if ($this->countModules('bottom') && $hideByView == false && $hideByEdit == false): ?>
        <!-- Bottom -->
        <div id="bottom"<?php if( !$detect->isMobile() && !$detect->isTablet() && ((int)$detect->version('IE') == '' || (int)$detect->version('IE') > 8 )){ ?> data-stellar-background-ratio="0.8"<?php } ?>>
          <div class="row-container">
            <div class="<?php echo $containerClass; ?>">
              <div class="<?php echo $rowClass; ?>">
                <jdoc:include type="modules" name="bottom" style="themeHtml5" />
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>
        <?php if ($this->countModules('footer') && $hideByView == false && $hideByEdit == false): ?>
        <!-- Footer -->
        <div id="footer">
          <div class="row-container">
            <div class="<?php echo $containerClass; ?>">
              <div class="<?php echo $rowClass; ?>">
                <jdoc:include type="modules" name="footer" style="themeHtml5" />
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>  
        <div id="push"></div>
      </div>
    </div>
    <?php if ($hideByEdit == false): ?>
    <div id="footer-wrapper">
      <div class="footer-wrapper-inner">    
        <!-- Copyright -->
        <div id="copyright" role="contentinfo">
          <div class="row-container">
            <div class="<?php echo $containerClass; ?>">
              <div class="<?php echo $rowClass; ?>">
                <jdoc:include type="modules" name="copyright" style="themeHtml5" />
                <div class="copyright span<?php echo $this->params->get('footerWidth'); ?>">
                  <?php if($this->params->get('footerLogo') == 1) : ?>
                  <!-- Footer Logo -->
                  <a class="footer_logo" href="<?php echo $this->baseurl; ?>"><img src="<?php echo $footerLogo;?>" alt="<?php echo $sitename; ?>" /></a>
    					    <?php else: ?>
                  <span class="siteName"><?php echo $sitename; ?></span>
    					    <?php endif; ?>
  					      <?php if($this->params->get('footerCopy') == 1) echo '<span class="copy">&copy;</span>'; ?>
  					      <?php if($this->params->get('footerYear') == 1) echo '<span class="year">'.date('Y').'</span>'; ?>
                  <?php if($this->params->get('privacyLink') == 1) :?>
                  <a class="privacy_link" rel="license" href="<?php echo $privacy_link_url; ?>"><?php echo $this->params->get('privacy_link_title'); ?></a>
    					    <?php endif; ?>
                  <?php if($this->params->get('termsLink') == 1) :?>
                  <a class="terms_link" href="<?php echo $terms_link_url; ?>"><?php echo $this->params->get('terms_link_title'); ?></a>
    					    <?php endif; ?>
                </div>
                <?php if($this->params->get('todesktop') && ($detect->isMobile() || $detect->isTablet()) && !$detect->isiPad()): ?>
                <div class="span12" id="to-desktop">
                  <a href="#">
                  <?php if(isset($_COOKIE['disableMobile'])){ ?>
                    <?php if($_COOKIE['disableMobile']=='false'){ ?>
                      <span class="to_desktop"><?php echo $this->params->get('todesktop_text') ?></span>
                    <?php }
                    else{ ?>
                      <span class="to_mobile"><?php echo $this->params->get('tomobile_text') ?></span>
                    <?php }
                  }
                  else{ ?>
                    <span class="to_desktop"><?php echo $this->params->get('todesktop_text') ?></span>
                  <?php } ?>
                  </a>
                </div>
                <?php endif; ?>
                More European Restaurant Joomla Themes at <a  rel='nofollow' href='http://www.templatemonster.com/category/european-restaurant-joomla-themes/' target='_blank'>TemplateMonster.com</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php if($this->params->get('totop')): ?>
    <div id="back-top">
      <a href="#"><span></span><?php echo $this->params->get('totop_text') ?></a>
    </div>
    <?php endif; ?>
    <?php if ($this->countModules('modal')): ?>
    <div id="modal" class="modal hide fade loginPopup">
      <div class="modal-hide"></div>
      <div class="modal_wrapper">
        <button type="button" class="close modalClose">×</button>
        <jdoc:include type="modules" name="modal" style="modal" />
      </div>
    </div>
    <?php endif; ?>
    <jdoc:include type="modules" name="debug" style="none"/>
    <?php if ($this->countModules('fixed-sidebar-left')): ?>
    <jdoc:include type="modules" name="fixed-sidebar-left" style="none" />
    <?php endif; ?>
    <?php if( $detect->isiPad() || $detect->isiPod()){
      if(isset($_COOKIE['disableMobile'])){ ?>
        <?php if($_COOKIE['disableMobile']=='false'){ ?>
          <script src="<?php echo 'templates/'.$this->template.'/js/ios-orientationchange-fix.js'; ?>"></script>
        <?php }
      }
      else { ?>
        <script src="<?php echo 'templates/'.$this->template.'/js/ios-orientationchange-fix.js'; ?>"></script>
      <?php }
    }
    if( $detect->isMobile() || $detect->isTablet() ){ ?>
    <script src="<?php echo 'templates/'.$this->template.'/js/desktop-mobile.js'; ?>"></script>
    <?php } ?>
    <script src="<?php echo 'templates/'.$this->template.'/js/jquery.modernizr.min.js'; ?>"></script>
    <?php if( !$detect->isMobile() && !$detect->isTablet() && ((int)$detect->version('IE') == '' || (int)$detect->version('IE') > 8 )){ ?>
    <script src="<?php echo 'templates/'.$this->template.'/js/jquery.stellar.min.js'; ?>"></script>
    <script>
      jQuery(function($) {
        if (!Modernizr.touch) {
          $(window).load(function(){
            $.stellar({responsive: true,horizontalScrolling: false});
          });
        }
      });
    </script>
    <?php }
    if( !$detect->isMobile() && !$detect->isTablet() && ((int)$detect->version('IE') == '' || (int)$detect->version('IE') > 8 ) && !$detect->version('iOS')){ ?>
    <script src="<?php echo 'templates/'.$this->template.'/js/jquery.simplr.smoothscroll.min.js'; ?>"></script>
    <script>
      jQuery(function($) {
        if (!Modernizr.touch) {
          var platform = navigator.platform.toLowerCase();
          if (platform.indexOf('win') == 0 || platform.indexOf('linux') == 0) {
            if ($.browser.webkit) {
              $.srSmoothscroll({ease: 'easeOutQuart'});
            }
          }
        }
      });
    </script>
    <?php }
    if($this->params->get('blackandwhite')): ?>
    <script src="<?php echo 'templates/'.$this->template.'/js/jquery.BlackAndWhite.min.js'; ?>"></script>
    <script>
      ;(function($, undefined) {
      $.fn.BlackAndWhite_init = function () {
        var selector = $(this);
        selector.find('img').not(".slide-img").parent().BlackAndWhite({
          invertHoverEffect: ".$this->params->get('invertHoverEffect').",
          intensity: 1,
          responsive: true,
          speed: {
              fadeIn: ".$this->params->get('fadeIn').",
              fadeOut: ".$this->params->get('fadeOut')." 
          }
        });
      }
      })(jQuery);
      jQuery(window).load(function($){
        jQuery('.item_img a').find('img').not('.lazy').parent().BlackAndWhite_init();
      });
    </script>
    <?php endif; ?>
    <script src="<?php echo 'templates/'.$this->template.'/js/jquery.fancybox.pack.js'; ?>"></script>
    <script src="<?php echo 'templates/'.$this->template.'/js/jquery.fancybox-buttons.js'; ?>"></script>
    <script src="<?php echo 'templates/'.$this->template.'/js/jquery.fancybox-media.js'; ?>"></script>
    <script src="<?php echo 'templates/'.$this->template.'/js/jquery.fancybox-thumbs.js'; ?>"></script>
    <script src="<?php echo 'templates/'.$this->template.'/js/jquery.pep.js'; ?>"></script>
    <script src="<?php echo 'templates/'.$this->template.'/js/jquery.vide.min.js'; ?>"></script>
    <script src="<?php echo 'templates/'.$this->template.'/js/scripts.js'; ?>"></script>
    <?php endif; ?>
  </body>
</html>