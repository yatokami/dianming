<?php
namespace Named\Controller;
use Think\Controller;
class InoutController extends Controller {
    public function exportExcel($expTitle,$expCellName,$expTableData,$stime,$etime){
        $xlsTitle = iconv("utf-8", "gb2312", $expTitle);//文件名称
        $fileName = $stime.'~'.$etime.$xlsTitle;//or $xlsTitle 文件名称可根据自己情况设定
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);

        vendor("PHPExcel");
            
        $objPHPExcel = new \PHPExcel();
        $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');

        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(24);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(22);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);




        for($i=0;$i<$cellNum;$i++){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'2', $expCellName[$i][1]);
        }
        // Miscellaneous glyphs, UTF-8
        for($i=0;$i<$dataNum;$i++){
            for($j=0;$j<$cellNum;$j++){
                $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+3), $expTableData[$i][$expCellName[$j][0]]);
            }
        }

        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
        header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    /**
     *
     * 导出Excel
     */
    function expUser(){//导出Excel
        $xlsName  = "晚自习缺勤名单明细表";
        $start = I('get.stime');  //获取开始时间
        $end = I('get.etime');  //获取结束时间
        $class = I('get.class');  //获取班级
        $xlsCell  = array(
        array('user_id','学号'),
        array('user_name','姓名'),
        array('department','系部'),
        array('class','班级'),
        array('type','缺勤类型'),
        array("date",'时间'),
        array('cadres_id','学委签名'),
        array('admin','操作员')
        );
        $xlsModel = M('named_log');
        if ($class == '信息工程系') {
            $xlsData = $xlsModel->field([
                'user_id',
                'user_name',
                'class',
                'department',
                "FROM_UNIXTIME(`date`,'%Y-%m-%d %H:%i:%s')" => 'date',
                'cadres_id',
                'type',
                'admin'
            ])->where([
                'come' => 0,
                "FROM_UNIXTIME(`date`,'%Y-%m-%d')" => [['EGT',I('get.stime')],['ELT',I('get.etime')]]
            ])->select();
        } else {
            $xlsData = $xlsModel->field([
                'user_id',
                'user_name',
                'class',
                'department',
                "FROM_UNIXTIME(`date`,'%Y-%m-%d %H:%i:%s')" => 'date',
                'cadres_id',
                'type',
                'admin'
            ])->where([
                'class' => $class,
                'come' => 0,
                "FROM_UNIXTIME(`date`,'%Y-%m-%d')" => [['EGT',I('get.stime')],['ELT',I('get.etime')]]
            ])->select();
        }

        foreach ($xlsData as $key => $value) {
            if ($value['type'] == 1) {
                $xlsData[$key]['type'] = '上课未到';
            } elseif ($value['type'] == 2) {
                $xlsData[$key]['type'] = '下课未到';
            } else {
                $xlsData[$key]['type'] = '第'.($value['type']-2).'次抽点未到';
            }

            $xlsData[$key]['admin'] = M('user')->getFieldById($value['admin'],'name');
        }

        //dump($xlsData);

        $this->exportExcel($xlsName,$xlsCell,$xlsData,I('get.stime'),I('get.etime'));
            
    }
}
?>