<?php
namespace Admin\Controller;
class StudentController extends BaseController {
    public function index() {
        $this->assign('current',1);
        $this->display();
    }
    public function exportExcel($expTitle,$expCellName,$expTableData){
        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
        $fileName = $expTitle.date('_YmdHis');//or $xlsTitle 文件名称可根据自己情况设定
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);

        vendor("PHPExcel.PHPExcel");
            
        $objPHPExcel = new \PHPExcel();
        $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');

        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.'  Export time:'.date('Y-m-d H:i:s'));
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
        header("Content-Disposition:inline;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    /**
     *
     * 导出Excel
     */
    function expUser(){//导出Excel
        $xlsName  = "User";
        $xlsCell  = array(
        array('id','用户编号'),
        array('name','姓名'),
        array('sex','性别'),
        array('department','系部'),
        array('class','班级')
        );
        $xlsModel = M('user');
        $xlsData  = $xlsModel->Field('id,name,sex,department,class')->select();
        $this->exportExcel($xlsName,$xlsCell,$xlsData);
        $this->display('index');
    }
    /**
     *
     * 显示导入页面 ...
     */

    /**实现导入excel
     **/
    function impUser(){
        if (!empty($_FILES)) {
            $upload = new \Think\Upload();// 实例化上传类
            $filepath='./Public/Excel/'; 
            $upload->exts = array('xlsx','xls');// 设置附件上传类型
            $upload->rootPath  =  $filepath; // 设置附件上传根目录
            $upload->saveName  =     'time';
            $upload->autoSub   =     false;
            if (!$info=$upload->upload()) {
                $this->error($upload->getError());
            }
            foreach ($info as $key => $value) {
                unset($info);
                $info[0]=$value;
                $info[0]['savepath']=$filepath;
            }
            vendor("PHPExcel.PHPExcel");
            $file_name=$info[0]['savepath'].$info[0]['savename'];
            if( $info[0]["ext"] =='xlsx' )
            {
                $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
            }
            else
            {
                $objReader = \PHPExcel_IOFactory::createReader('Excel5');
            }
            // $objReader = \PHPExcel_IOFactory::createReader('Excel5');
            $objPHPExcel = $objReader->load($file_name,$encode='utf-8');
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow(); // 取得总行数
            $highestColumn = $sheet->getHighestColumn(); // 取得总列数
            $j=0;
            for($i=1;$i<=$highestRow;$i++)
            {

                $data['id'] = $objPHPExcel->getActiveSheet()->getCell("A".$i)->getValue();
                $data['name']= $objPHPExcel->getActiveSheet()->getCell("B".$i)->getValue();
                $data['sex']= $objPHPExcel->getActiveSheet()->getCell("C".$i)->getValue();
                $data['mail'] = $objPHPExcel->getActiveSheet()->getCell("D".$i)->getValue();
                $data['phone']= $objPHPExcel->getActiveSheet()->getCell("E".$i)->getValue();
                $data['department']= $objPHPExcel->getActiveSheet()->getCell("F".$i)->getValue();
                $data['major']= $objPHPExcel->getActiveSheet()->getCell("G".$i)->getValue();
                $data['class']= $objPHPExcel->getActiveSheet()->getCell("H".$i)->getValue();
                M('user')->add($data);
                $j++;
            }
            unlink($file_name);
            $this->success('导入成功！本次导入联系人数量：'.$j);
        }else
        {
            $this->error("请选择上传的文件");
        }
    }
}

?>