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
                <a href="<?php echo U('/named/search');?>" style="font-size:18px">晚自习点名</a>
                <span style="font-size:10px">V2.02</span>
            </h1>

            <div class="am-header-right am-header-nav">
                <?php if(($uname) > "0"): ?><a data-am-modal="{target: '#info'}"><?php echo ($uname); ?>
                        <i class="am-header-icon am-icon-sign-out"></i>
                    </a>
                <?php else: ?>
                    <a href="<?php echo U('/user/login');?>">
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
            <li>
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

            <li data-am-navbar-share>
                <a href="#">
                    <span class="am-icon-share-square-o"></span>
                    <span class="am-navbar-label">分享</span>
                </a>
            </li>
            <li data-am-navbar-qrcode>
                <a href="#">
                    <span class="am-icon-qrcode"></span>
                    <span class="am-navbar-label">二维码</span>
                </a>
            </li>
            <li>
                <a href="<?php echo U('/named/about');?>">
                    <span class="am-icon-search"></span>
                    <span class="am-navbar-label">关于</span>
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

<style>
.am-list {font-size: 14px}
</style>

<div class="am-g am-g-fixed">
    <div class="am-u-lg-4 am-u-md-5 am-u-sm-centered">
      <br />
        <ul class="am-list am-list-border">
            <?php if(is_array($User)): foreach($User as $key=>$vo): ?><li><a href="#" data-am-modal="{target: '#<?php echo ($vo["class"]); ?>'}"><?php echo ($vo["class"]); ?></a></li><?php endforeach; endif; ?>
        </ul>
        <?php if(is_array($User)): foreach($User as $key=>$vo): ?><div class="am-modal-actions" id="<?php echo ($vo["class"]); ?>">
              <div class="am-modal-actions-group">
                <ul class="am-list">
                  <li class="am-modal-actions-header">请选择点名类型</li>
                  <li class="am-modal-actions-primary">
                    <a href="<?php echo U('start');?>?type=1&class=<?php echo ($vo["class"]); ?>">上课点名</a>
                  </li>
                  <li class="am-modal-actions-primary">
                    <a href="<?php echo U('start');?>?type=2&class=<?php echo ($vo["class"]); ?>">下课点名</a>
                  </li>
                  <li class="am-modal-actions-danger">
                    <a href="<?php echo U('start');?>?type=3&class=<?php echo ($vo["class"]); ?>">第一次抽点</a>
                  </li>
                  <li class="am-modal-actions-danger">
                    <a href="<?php echo U('start');?>?type=4&class=<?php echo ($vo["class"]); ?>">第二次抽点</a>
                  </li>
                  <li class="am-modal-actions-danger">
                    <a href="<?php echo U('start');?>?type=5&class=<?php echo ($vo["class"]); ?>">第三次抽点</a>
                  </li>
                </ul>
              </div>
              <div class="am-modal-actions-group">
                <button class="am-btn am-btn-secondary am-btn-block" data-am-modal-close>取消</button>
              </div>
            </div><?php endforeach; endif; ?>

    </div>
</div>

</body>
</html>