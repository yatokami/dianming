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
        <legend>增加新管理员</legend>
        <form method="post" class="am-form" action="<?php echo U('Index/add_admin');?>">
            <input type="text" name="id"  placeholder="学生学号或教师工号">
            <br>
            <input type="password" name="pwd" placeholder="密码">
            <br>
            <div class="am-form-group">
		      <label class="am-radio-inline">
		        <input type="radio" name="rad_type" value="0" checked>教师
		      </label>
		      <label class="am-radio-inline">
		        <input type="radio" name="rad_type" value="1">学生管理者
		      </label>
		    </div>
            <div class="am-cf">
                <input name="" value="提交" class="am-btn am-btn-primary am-btn-sm am-fl" type="submit">
            </div>
        </form>
        <hr>
    </div>
</div>

</body>
</html>