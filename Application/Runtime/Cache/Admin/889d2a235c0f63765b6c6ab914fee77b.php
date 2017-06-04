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
    <!-- <script src="/Public/js/phone/appcan.js"></script>
    <script src="/Public/js/phone/appcan.control.js"></script> -->
    
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
            <li>
                <a href="<?php echo U('/Admin/student');?>">
                    <span class="am-icon-check-square-o"></span>
                    <span class="am-navbar-label">学生管理</span>
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
        <legend>发布考卷</legend>
        <hr>
		<div class="am-u-sm-12 am-u-md-6">
	        <div class="am-btn-toolbar">
	            <div class="am-btn-group am-btn-group-xs">
	              <button type="button" class="am-btn am-btn-default" onclick="location.href='exam/add_exam'"><span class="am-icon-plus"></span> 新增</button>
	              <button type="button" class="am-btn am-btn-default" onclick="del_exam()"><span class="am-icon-trash-o"></span> 删除</button>
	            </div>
	        </div>
	    </div>
        <table class="am-table">
		    <thead>
		        <tr>
		        	<th class="table-check"><input id="CheckAll" type="checkbox" /></th>
		            <th>考试主题</th>
		            <th>创建时间</th>
		            <th>操作</th>
		        </tr>
		    </thead>
		    <tbody>
		    <?php if(is_array($exam_menu)): $i = 0; $__LIST__ = $exam_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
		         	<td><input name="chkItem" type="checkbox" value="<?php echo ($vo["m_id"]); ?>" /></td>
		            <td><?php echo ($vo["menu_title"]); ?></td>
		            <td><?php echo (date("Y-m-d",$vo["create_date"])); ?></td>
		            <td>
			            <div class="am-btn-toolbar">
		                    <div class="am-btn-group am-btn-group-xs">
		                      	<button class="am-btn am-btn-default am-btn-xs am-text-secondary" onclick="add_task(<?php echo ($vo["m_id"]); ?>)"><span class="am-icon-pencil-square-o"></span>发布</button>
		                    </div>
	                    </div>
	                </td>
		        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
		    </tbody>
		</table>
    </div>
</div>
<script>
	function add_task(m_id) {
		location.href="/Admin/Exam/task?m_id="+m_id;
	}

	 //checkbox 单选事件
    $('input[name="chkItem"]:checkbox').click(function(){
        var isCheck = $('input[name="chkItem"]:not(:checked)').length?false:true;
        $('#CheckAll').prop("checked",isCheck);
    });

    //checkbox 全选事件
    $('#CheckAll').click(function(){
        var self = $(this);
        $('input[name="chkItem"]').each(function(){
            $(this).prop("checked",self.is(':checked'));
        });
    });

    //删除考试
    function del_exam() {
    	if(window.confirm('确认删除？')){
	    	var m_ids = "";
	    	$('input[name="chkItem"]:checked').each(function() {
	    		var self = $(this);
	    		m_ids = m_ids + self.val() + ',';
	    	})
	    	data = {'m_ids':m_ids};
	    	$.ajax({
	            url:'exam/del_exam',
	            type:'post',
	            data: data,
	            success:function(data,status){
	            	alert("删除成功");
	            	location.reload();
	            },
	            error:function(data,status){
	            	alert("删除失败");
	            }
	        });
	    }
    }
</script>
</body>
</html>