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
			<li class="am-active"><a href="<?php echo U('/named/search');?>">个人查询</a></li>
			<li><a href="<?php echo U('named/search/c');?>">班级查询</a></li>
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
					<input type="text" class="am-form-field" name="etime" value="<?php echo date('Y-m-d',time());?>" data-am-datepicker readonly>
				</div>
			</div>

			<p><div class="am-input-group">
				<input type="text" class="am-form-field" placeholder="学号" value="<?php echo ($user_id); ?>" name="id">
				<span class="am-input-group-btn">
					<button class="am-btn am-btn-default" type="submit">查询</button>
				</span>
			</div></p>
		</form>
		<?php if(($user_id != NULL) AND ($rough == NULL)): ?><p class="am-text-primary">恭喜你没有旷课记录呢O(∩_∩)O~~</p><?php endif; ?>
		<?php if(!empty($rough)): ?><table class="am-table">
				<thead>
					<tr>
						<th>学号</th>
						<th>姓名</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?php echo ($rough['user_id']); ?></td>
						<td><?php echo ($rough['user_name']); ?></td>
					</tr>
				</tbody>
			</table>
		
			<button type="button" class="am-btn am-btn-primary am-btn-block" data-am-modal="{target: '#my-popup'}">
				总计：<?php echo ($rough['count']); ?>次 点击查看详情
			</button>

			<div class="am-popup" id="my-popup">
			  <div class="am-popup-inner">
				<div class="am-popup-hd">
				  <h4 class="am-popup-title">详情</h4>
				  <span data-am-modal-close
						class="am-close">&times;</span>
				</div>
				<div class="am-popup-bd">

				  <?php if(is_array($about)): foreach($about as $key=>$vo): ?><div class="am-panel am-panel-primary">
					  <div class="am-panel-bd">
					  	学号：<?php echo ($vo["user_id"]); ?><br />
					  	姓名：<?php echo ($vo["user_name"]); ?><br />
					  	类型：
					  	<?php if($vo["type"] == 1): ?>上课点名未到
					  		<?php elseif($vo["type"] == 2): ?>下课点名未到
					  		<?php else: ?>第<?php echo ($vo['type']-2); ?>次抽点未到<?php endif; ?><br />
					  	时间：<?php echo ($vo["date"]); ?><br />
					  	操作员：<?php echo ($vo["admin"]); ?><br />
					  	签名班委: <?php echo ($vo["cadres_id"]); ?><br />					    
					  </div>
					</div><?php endforeach; endif; ?>

				</div>
				<div class="am-modal-footer">
				  <span class="am-modal-btn">确定</span>
				</div>
			  </div>
			</div><?php endif; ?>
	</div>
</div>

</body>
</html>