<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta property="qc:admins" content="170450215246727" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>C Team - 点名系统 | V2.02</title>

    <link rel="stylesheet" href="/Public/css/amazeui.min.css"/>
    <script src="/Public/js/jquery.min.js"></script>
    <script src="/Public/js/amazeui.min.js"></script>
    <script src="/Public/js/phone/appcan.js"></script>
    <script src="/Public/js/phone/appcan.control.js"></script>
    
</head>
<body>
    
        <header data-am-widget="header" class="am-header am-header-default am-header-fixed">
            <h1 class="am-header-title">
                <a href="#" style="font-size:18px">后台管理</a>
                <span style="font-size:10px">V2.02</span>
            </h1>

            <div class="am-header-right am-header-nav">
                <?php if(($uname) > "0"): ?><a data-am-modal="{target: '#info'}"><?php echo ($uname); ?>
                        <i class="am-header-icon am-icon-sign-out"></i>
                    </a>
                <?php else: ?>
                    <a href="<?php echo U('/Admin/Login/logout');?>">
                        <i class="am-header-icon am-icon-sign-in"></i>
                    </a><?php endif; ?>
            </div>
        </header>
    

    

    <div data-am-widget="navbar" class="am-navbar am-cf am-navbar-default">
        <ul class="am-navbar-nav am-cf am-avg-sm-4">
            <li>
                <a href="<?php echo U('/Admin/Index');?>">
                    <span class="am-icon-check-square-o"></span>
                    <span class="am-navbar-label">管理员管理</span>
                </a>
            </li>
            <li>
                <a href="<?php echo U('/Admin/exam');?>">
                    <span class="am-icon-check-square-o"></span>
                    <span class="am-navbar-label">考试管理</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="am-modal-actions" id="info">
        <div class="am-modal-actions-group">
            <ul class="am-list">
                <li><a href="<?php echo U('/user/passwd');?>">修改密码</a></li>
                <li class="am-modal-actions-danger"><a href="<?php echo U('/user/logout');?>">退出</a></li>
            </ul>
        </div>
        <div class="am-modal-actions-group">
            <button class="am-btn am-btn-secondary am-btn-block" data-am-modal-close>取消</button>
        </div>
    </div>

    
    <script type="text/javascript">
        var c1c = 0;  
        window.uexOnload = function(type){  
            uexWindow.setReportKey(0,1);  
            uexWindow.onKeyPressed = function(){   
                if (c1c > 0) {  
                    uexWidgetOne.exit();  
                }  
                else {  
                    uexWindow.toast(0, 5, '再按一次退出应用', 1000);   
                    c1c=1; setTimeout(function(){ c1c=0; }, 2000);  
                }  
            };  
        }  
    </script>
</body>
</html>


<div class="am-g">
    <div class="am-u-lg-4 am-u-md-5 am-u-sm-centered">
        <legend>新增考卷</legend>
        <form method="post" class="am-form">
            <div class="am-g am-margin-top">
              	<div class="am-u-sm-4 am-u-md-2 am-text-right">
                	考试主题
              	</div>
             	<div class="am-u-sm-8 am-u-md-4">
              	  	<input name="menu_title"  type="text" class="am-input-sm">
             	</div>
            </div>
	       <hr>
	        <legend>考试题目</legend>
	        <div name="q1">
				<div class="am-g am-margin-top">
	              	<div class="am-u-sm-2 am-u-md-2 am-text-left">
	                	第(1)题
	              	</div>
	             	<div class="am-u-sm-10 am-u-md-4">
	              	  	<textarea name="menu_title"  class="am-input-sm"></textarea>
	             	</div>
	            </div>
				<div class="am-g am-margin-top">
					<div class="am-u-sm-3 am-u-md-4 am-text-left">
	                	正确答案
	              	</div>
	             	<div class="am-u-sm-9 am-u-md-4">
	              	  	<input name="menu_title"  type="text" class="am-input-sm">
	             	</div>
				</div>
				<div class="am-g am-margin-top">
					<div class="am-u-sm-3 am-u-md-4 am-text-left">
	                	错误答案
	              	</div>
	             	<div class="am-u-sm-9 am-u-md-4">
	              	  	<input name="menu_title"  type="text" class="am-input-sm">
	             	</div>
				</div>
				<div class="am-g am-margin-top">
					<div class="am-u-sm-3 am-u-md-4 am-text-left">
	                	错误答案
	              	</div>
	             	<div class="am-u-sm-9 am-u-md-4">
	              	  	<input name="menu_title"  type="text" class="am-input-sm">
	             	</div>
				</div>
			</div>
			<span class="am-icon-plus-square-o am-icon-md" onclick="alert('a')"></span>
            <div class="am-margin">
		        <button type="submit" class="am-btn am-btn-primary am-btn-xs">发布</button>
		         <button type="submit" class="am-btn am-btn-primary am-btn-xs">增加题目</button>
		    </div>
        </form>
    </div>
</div>

</body>
</html>