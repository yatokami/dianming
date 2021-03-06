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
            <div class="am-header-left am-header-nav">
                <a href="<?php echo U('/named/search');?>">
                    <i class="am-header-icon am-icon-home"></i>
                </a>
            </div>

            <h1 class="am-header-title">
                <a href="<?php echo U('/named/search');?>" style="font-size:18px">点名系统</a>
                <span style="font-size:10px">V2.02</span>
            </h1>

            <div class="am-header-right am-header-nav">
                <?php if(($uname) > "0"): ?><a data-am-modal="{target: '#info'}"><?php echo ($uname); ?>
                        <i class="am-header-icon am-icon-sign-out"></i>
                    </a>
                <?php else: ?>
                    <a href="<?php echo U('/WinXin/Index/login');?>">
                        <i class="am-header-icon am-icon-sign-in"></i>
                    </a><?php endif; ?>
            </div>
        </header>
    

    

    <div data-am-widget="navbar" class="am-navbar am-cf am-navbar-default">
        <ul class="am-navbar-nav am-cf am-avg-sm-4">
            <li>
                <a href="<?php echo U('/named/search');?>">
                    <span class="am-icon-search"></span>
                    <span class="am-navbar-label">查询</span>
                </a>
            </li>
        <?php if(is_admin() > '0'): ?><li>
                <a href="<?php echo U('/named/dm');?>">
                    <span class="am-icon-check-square-o"></span>
                    <span class="am-navbar-label">点名</span>
                </a>
            </li>

            <li>
                <a href="<?php echo U('/named/revoke');?>">
                    <span class="am-icon-check-square-o"></span>
                    <span class="am-navbar-label">销假</span>
                </a>
            </li>
        <?php else: endif; ?>
            <li>
                <a href="<?php echo U('/named/exam');?>">
                    <span class="am-icon-check-square-o"></span>
                    <span class="am-navbar-label">考试</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="am-modal-actions" id="info">
        <div class="am-modal-actions-group">
            <ul class="am-list">
                <!-- <li><a href="<?php echo U('/user/passwd');?>">修改密码</a></li> -->
                <!-- <li class="am-modal-actions-danger"><a href="<?php echo U('/user/logout');?>">退出</a></li> -->
                <li class="am-modal-actions-danger">
                    <input type="button" value="退出" onclick="close_wechat()" />
                </li>
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
        function close_wechat(){
            WeixinJSBridge.call("closeWindow");
        }
    </script>
</body>
</html>


<div class="am-g">
    <div class="am-u-lg-4 am-u-md-5 am-u-sm-centered">
        <legend>绑定学号</legend>
        <form method="post" class="am-form" action="<?php echo U('Login/bindId');?>">
             请绑定你的学号: <input type="hidden" name="openid" value=<?php echo ($openid); ?> readonly>
            <br>
            <input type="text" name="id" placeholder="学号">
            <br>
            <div class="am-cf">
                <input name="" value="绑 定" class="am-btn am-btn-primary am-btn-sm am-fl" type="submit">
            </div>
        </form>
        <hr>
<!--         <p>© 2015 &lt;/CZJT&gt;, Inc. </p> -->
    </div>
</div>

</body>
</html>