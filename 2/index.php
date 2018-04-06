<?php
/**
 * 简单的不能再简单的主题
 * 
 * @package 初恋
 * @author 夏目贵志
 * @version 1.1
 * @link https://xiamuyourenzhang.cn/
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
 ?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php $this->options->title(); ?><?php $this->archiveTitle(); ?></title>
	<?php $this->header(); ?>
	<style>
	body{margin:40px auto;max-width:650px;line-height:1.6;font-size:18px;color:#444;padding:0 10px;background:#f5f5f5;font-family:"lucida grande","lucida sans unicode",lucida,helvetica,"Hiragino Sans GB","Microsoft YaHei","WenQuanYi Micro Hei",sans-serif}h1,h2,h3{line-height:1.2}a:link{color:#000;text-decoration:none}a:visited{text-decoration:none;color:#000}a:hover{text-decoration:none;color:#007fff}a:active{text-decoration:none;color:#000}#comments{margin-top:10px;padding:20px;box-shadow:0 1px 2px 0 rgba(0,0,0,.05)}.comment-list,.comment-list ol{list-style:none;margin:0;padding:0}.comment-list li{padding:10px 0 0 0;margin-top:10px;border-top:1px solid #eee}.comment-list li:first-child{border-top:none}.comment-list li li{padding-left:20px}.comment-list li.comment-by-author .comment-author:after{content:url(../img/v.png)}.comment-list li .comment-reply{text-align:right;font-size:.92857em}.comment-list li .comment-reply a{color:#9e9e9e;font-size:14px}.comment-meta{font-size:12px;color:#9e9e9e}.comment-meta a{color:#999;font-size:.92857em}.comment-author{display:block;margin-bottom:3px;color:#444}.comment-author .avatar{float:left;margin-right:10px;border-radius:30px}.comment-author cite{font-style:normal}.comment-list .respond{margin-top:15px;border-top:1px solid #eee}.respond .cancel-comment-reply{float:right;margin-top:15px;font-size:.92857em}#comment-form label{display:block;margin-bottom:.5em;font-weight:700}#comment-form .required:after{content:" *";color:#c00}.submit{color:#007fff;border:1px solid #007fff;font-size:14px;background-color:transparent;padding:5px 20px;border-radius:20px}.textarea{width:100%}#secondary{word-wrap:break-word;margin:25px 0;padding:0}.page-navigator{list-style:none;margin:25px 0;padding:0;text-align:center}.page-navigator li{display:inline-block;margin:0 4px}.page-navigator a{display:inline-block;padding:0 10px;height:30px;line-height:30px}.page-navigator a:hover{background:#eee;text-decoration:none；}.page-navigator .current a{color:#444;background:#eee}img{max-width:100%}
	</style>
</head>
<body>

    <header>
        <h1><a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title() ?> </a></h1>
        <aside><?php $this->options->description() ?></aside>
			<nav>
			<a href="<?php $this->options->siteUrl(); ?>">HOME</a> |
				<?php $this->widget('Widget_Contents_Page_List')
						   ->parse('<a href="{permalink}">{title}</a> |'); ?>
			<a href="#" onclick="sousuo()">搜索</a>
			<script>
			function sousuo(){
				var name=prompt("输入关键词",""); // 搜索文章
				if (name!=null && name!="")
				{
				location.href='<?php $this->options->siteUrl(); ?>/search/' + name;
				}
			}
			</script>		
		</nav>
	</header>
	<hr>
	
	<?php if(($this->is('index'))||($this->is('archive'))): ?><!--判断是否首页或者是archive 通用（分类、搜索、标签、作者）页面文件  只要是其中一个 输出文章 不是则继续循环-->
	
	<?php while($this->next()): ?><!--是否主页 yes/输出文章 No/继续判断 -->
	<article>
	<h2><a href="<?php $this->permalink() //文章链接?>"><?php $this->title() //文章标题?></a></h2><!--输出标题 和链接 -->
	<p><?php $this->excerpt('300','...');  //限制首页摘要300字 ?></p>
	</article>
	<?php endwhile; ?>	<!--文章循环结束-->
	
	<div class="page"><!--首页文章列表分页-->
     <?php $this->pageLink('上一页'); ?>
     <?php $this->pageLink('下一页','next'); ?>	
	</div>

	<?php else: ?><!--不是首页继续循环判断-->
	
	<?php if(($this->is('post'))||($this->is('page'))): ?><!--判断是否文章页或者是独立页面  只要是其中一个 输出文章 不是则继续循环-->
	
	<article><!--是文章页面 输出文章标题和内容-->
	<h2><?php $this->title() ?></h2>
	<p> <?php $this->content('Continue Reading...'); ?></p>
	</article>
		<!--加载评论-->	
		<div id="comments">
		<?php $this->comments()->to($comments); ?>
		<?php if ($comments->have()): ?>
		<h3><?php $this->commentsNum(_t('暂无评论'), _t('仅有一条评论'), _t('已有 %d 条评论')); ?></h3>		
		<?php $comments->listComments(); ?>
		<?php $comments->pageNav('&laquo; 前一页', '后一页 &raquo;'); ?>		
		<?php endif; ?>
		<?php if($this->allow('comment')): ?>
		<div id="<?php $this->respondId(); ?>" class="respond">
			<div class="cancel-comment-reply">
			<?php $comments->cancelReply(); ?>
			</div>
		
			<h3 id="response"><?php _e('添加新评论'); ?></h3>
			<form method="post" action="<?php $this->commentUrl() ?>" id="comment-form" role="form">
				<?php if($this->user->hasLogin()): ?>
				<p><?php _e('登录身份: '); ?><a href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a>. <a href="<?php $this->options->logoutUrl(); ?>" title="Logout"><?php _e('退出'); ?> &raquo;</a></p>
				<?php else: ?>
				<p>
					<label for="author" class="required"><?php _e('称呼'); ?></label>
					<input type="text" name="author" id="author" class="text" value="<?php $this->remember('author'); ?>" required />
				</p>
				<p>
					<label for="mail"<?php if ($this->options->commentsRequireMail): ?> class="required"<?php endif; ?>><?php _e('Email'); ?></label>
					<input type="email" name="mail" id="mail" class="text" value="<?php $this->remember('mail'); ?>"<?php if ($this->options->commentsRequireMail): ?> required<?php endif; ?> />
				</p>
				<p>
					<label for="url"<?php if ($this->options->commentsRequireURL): ?> class="required"<?php endif; ?>><?php _e('网站'); ?></label>
					<input type="url" name="url" id="url" class="text" placeholder="<?php _e('http://'); ?>" value="<?php $this->remember('url'); ?>"<?php if ($this->options->commentsRequireURL): ?> required<?php endif; ?> />
				</p>
				<?php endif; ?>
				<p>
					<label for="textarea" class="required"><?php _e('内容'); ?></label>
					<textarea rows="8" cols="50" name="text" id="textarea" class="textarea" required ><?php $this->remember('text'); ?></textarea>
				</p>
				<p>
					<button type="submit" class="submit"><?php _e('提交评论'); ?></button>
				</p>
			</form>
		</div>
		<?php else: ?>
		<h3><?php _e('评论已关闭'); ?></h3>
		<?php endif; ?>
		</div>
		<!--评论加载结束-->
	<?php endif; ?><!--判断结束-->

	<?php endif; ?><!--判断结束 -->
	
	<hr><!--底部网站声明 -->
	<p>Copyright © 2013-2018 <?php $this->options->title() ?>  runoob.com All Rights Reserved. Theme：<a href="https://xiamuyourenzhang.cn" target="_blank">夏目贵志</a>。</p>
</body>
</html>
