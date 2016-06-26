<?php defined('_JEXEC') or die('Direct Access to this location is not allowed.'); ?>
<?php     if($this->params->get('show_comments')): ?>
            <div class="jg_cmtl">
              <?php echo JText::_('COM_JOOMGALLERY_DETAIL_AUTHOR'); ?>
            </div>
            <div class="jg_cmtr">
              <?php echo JText::_('COM_JOOMGALLERY_COMMON_COMMENT'); ?>
            </div>
<?php       foreach($this->comments as $comment): ?>
          <div class="jg_row<?php $this->i++; echo ($this->i % 2) + 1; ?>">
            <div class="jg_cmtl">
              <span><?php echo $comment->author; ?></span>
            </div>
            <div class="jg_cmtr">
              <span class="small">
                <?php echo JText::sprintf('COM_JOOMGALLERY_DETAIL_COMMENTS_COMMENT_ADDED', JHTML::_('date', $comment->cmtdate, JText::_('DATE_FORMAT_LC1'))); ?>
              </span>
              <span class="comment_text"><?php echo stripslashes($comment->text); ?></span>
            </div>
          </div>
<?php       endforeach;
          endif;
          if($this->params->get('no_comments_message')): ?>
          <div class="jg_row<?php $this->i++; echo ($this->i % 2) + 1; ?>">
            <div class="jg_cmtf">
              <?php echo $this->params->get('no_comments_message'); ?>
              <?php echo $this->params->get('no_comments_message2'); ?>
            </div>
          </div>
<?php     endif;?>