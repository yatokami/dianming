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


<script></script>

<div class="am-g am-g-fixed">
    <div class="am-u-md-6 am-u-sm-centered">
        <ul class="am-nav am-nav-pills am-nav-justify" style="padding-top:15px">
            <li><a href="<?php echo U('/named/search');?>">个人查询</a></li>
            <li class="am-active"><a href="<?php echo U('named/search/c');?>">班级查询</a></li>
        </ul>
        <br>
        <form class="am-form">
            <div class="am-g am-g-fixed">
                <div class="am-u-sm-6">
                    <?php if(($start != null)): ?><input type="text" class="am-form-field" name="stime" value="<?php echo ($start); ?>" data-am-datepicker readonly>
                    <?php else: ?>
                        <input type="text" class="am-form-field" name="stime" value="<?php echo date('Y-m-d',time());?>" data-am-datepicker readonly><?php endif; ?>
                </div>
                <div class="am-u-sm-6">
                    <?php if(($end != null)): ?><input type="text" class="am-form-field" name="etime" value="<?php echo ($end); ?>" data-am-datepicker readonly>
                    <?php else: ?>
                        <input type="text" class="am-form-field" name="etime" value="<?php echo date('Y-m-d',time());?>" data-am-datepicker readonly><?php endif; ?>
                </div>
            </div>
            <p><select data-am-selected="{btnWidth: '100%'}" name="class">
                <option value="信息工程系">全部</option>
                <option value="15电子信息工程技术1">15电子信息工程技术1</option>
                <option value="15计算机网络技术1">15计算机网络技术1</option>
                <option value="15计算机网络技术2">15计算机网络技术2</option>
                <option value="15计算机应用技术1">15计算机应用技术1</option>
                <option value="15计算机应用技术2">15计算机应用技术2</option>
                <option value="15软件技术1">15软件技术1</option>
                <option value="15嵌入式系统工程1">15嵌入式系统工程1</option>
                <option value="15图形图像制作1">15图形图像制作1</option>
            </select></p>
            <button class="am-btn am-btn-primary am-btn-block" type="submit" target="_blank">查询</button>
            <br />
            <?php if(!empty($rough)): ?><a class="am-btn am-btn-primary am-btn-block" type="button" href="<?php echo U('Named/Inout/expUser');?>?stime=<?php echo ($start); ?>&etime=<?php echo ($end); ?>&class=<?php echo ($class); ?>" >导出EXCEL</a><?php endif; ?>
        </form>
        <?php if(!empty($rough)): ?><table class="am-table" id="info">
                <thead>
                    <tr>
                        <th>学号</th>
                        <th>姓名</th>
                        <th>次数</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(is_array($rough)): $i = 0; $__LIST__ = $rough;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                            <td><?php echo ($vo["user_id"]); ?></td>
                            <td><?php echo ($vo["user_name"]); ?></td>
                            <td><?php echo ($vo["count"]); ?></td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
            </table><?php endif; ?>
    </div>
</div>

<script type="text/javascript">
var tem = "<?php echo ($class); ?>";
if (tem != null) {
    var option= document.getElementsByTagName('option');
    for(var i in option) {
        if (option[i].value == tem) {
            option[i].selected='selected';
        };
    }
};
</script>