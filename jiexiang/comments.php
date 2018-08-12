<?php function threadedComments($comments, $options) {
    $commentClass = '';
    if ($comments->authorId) {
        if ($comments->authorId == $comments->ownerId) {
            $commentClass .= ' comment-by-author';
        } else {
            $commentClass .= ' comment-by-user';
        }
    } 
    $commentLevelClass = $comments->_levels > 0 ? ' comment-child' : ' comment-parent';
    if ($comments->url) {
        $author = '<a href="' . $comments->url . '" target="_blank"' . ' rel="external nofollow">' . $comments->author . '</a>';
    } else {
        $author = $comments->author;
    }
?>

                            <li id="li-<?php $comments->theId(); ?>" class="comment<?php 
if ($comments->_levels > 0) {
    echo ' comment-child';
    $comments->levelsAlt(' comment-level-odd', ' comment-level-even');
} else {
    echo ' comment-parent';
}
$comments->alt(' comment-odd', ' comment-even');
echo $commentClass; 
?>">
                                <div id="<?php $comments->theId(); ?>" class="comment-body">
                                    <div class="comment-author vcard">
                                        <?php $comments->gravatar('40', 'http://1.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536%3Fs%3D40&r=G'); ?>

                                        <cite class="fn"><?php echo $author; ?></cite>
                                    </div>
                                    <div class="comment-meta"><a href="<?php $comments->permalink(); ?>"><?php $comments->date('Y-m-d H:i'); ?></a></div>
                                    <?php $comments->content(); ?>

                                    <div class="reply"><?php $comments->reply('Reply'); ?></div>
                                </div>
<?php if ($comments->children) { ?>
                                <div class="children">
                                    <?php $comments->threadedComments($options); ?>

                                </div>
<?php } ?>
                            </li>
<?php } ?>

                    <section id="comments">
<?php $this->comments()->to($comments); ?>
<?php if ($comments->have()): ?>
                        <h3 class="comments-title"><?php $this->commentsNum(_t('0 Comments to'), _t('1 Comment'), _t('%d Comments')); ?></h3>

<?php $comments->pageNav(); ?>

                        <?php $comments->listComments(); ?>

<?php endif; ?>

<?php if($this->allow('comment')): ?>
                        <div id="<?php $this->respondId(); ?>" class="respond">
                            <h3>Leave a Comment</h3>
                            <div class="cancel-comment-reply">
                                <?php $comments->cancelReply('Click here to cancel reply'); ?>
                            </div>
                            <form method="post" action="<?php $this->commentUrl() ?>" id="comment_form">
<?php if($this->user->hasLogin()): ?>
                                <p>Welcome Back ! <a href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a>. <a href="<?php $this->options->logoutUrl(); ?>" title="Logout"><?php _e('退出'); ?> &raquo;</a></p>
<?php else: ?>
                                <p>
                                    <input type="text" name="author" id="author" required="true" size="22" value="<?php $this->remember('author'); ?>" />
                                    <label for="author"><small><?php _e('称呼 *'); ?></small></label>
                                </p>
                                <p>
                                    <input type="email" name="mail" id="mail" required="true" size="22" value="<?php $this->remember('mail'); ?>" />
                                    <label for="mail"><small><?php _e('邮箱 *'); ?></small></label>
                                </p>
                                <p>
                                    <input type="url" name="url" id="url" size="22" value="<?php $this->remember('url'); ?>" />
                                    <label for="url"><?php _e('网站'); ?><?php if ($this->options->commentsRequireURL): ?><span class="required">*</span><?php endif; ?></label>
                                </p>
                <?php endif; ?>
                                <p><textarea name="text" required="true" cols="58" rows="10" onkeydown="if(event.ctrlKey&&event.keyCode==13) {document.getElementById('submit').click();return false};"><?php $this->remember('text'); ?></textarea></p>
                                <p>
                                    <input type="submit" value="<?php _e('提交 (Ctrl+Enter)'); ?>" id="submit" />
                                    <label class="banmail"><input type="checkbox" name="banmail" value="stop">拒收邮件通知</label>
                                </p>
                            </form>
                        </div>
<?php endif; ?>
                    </section>
