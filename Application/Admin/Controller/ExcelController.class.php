<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;

/**
 * 首页
 */
class ExcelController extends BaseController {
    	
    /**
     * [index 首页]
     * @仝朋朋:http://mytpp.com/admin/Excel/index
     * @url示例:
     * @DateTime    2018-08-08
     * @逻辑:
     * @Author      仝朋朋
     * @return      [type]     [description]
     */
    public function index() {

    	$where = ['status' => 1];
    	if ($content = I('content')) $where['_complex'] = array(
    		'title' => array('LIKE', '%'.$content.'%'),
    		'filename' => array('LIKE', '%'.$content.'%'),
    		'_logic' => 'or'
    	);
    	$count = M('project_excel_group')->where($where)->count();
    	$Page = new \Think\Page($count,10);

    	$list = M('project_excel_group')->where($where)->limit($Page->firstRow.','.$Page->listRows)->order('id')->select();

    	$this->assign(
    		array(
    			'list' => $list,
    			'show' => $Page->show(),
    			'content' => $content
    		)
    	)->display();
    }

    /**
     * [addExcel 添加excel组]
     * @仝朋朋:http://mytpp.com/admin/Excel/addExcel
     * @url示例:
     * @DateTime    2018-08-08
     * @逻辑:
     * @Author      仝朋朋
     * @param      <string> <title> { 文件标题 }
     * @param      <string> <filename> { 文件名称 }
     */
    public function addExcel() {

    	if (!($title = I('title') ) ) $this->error('请输入标题', 'Excel-index');
    	if (!($filename = I('filename') ) ) $this->error('请输入文件名称', 'Excel-index');

    	$data = array(
    		'title' => $title,
    		'filename' => $filename,
    		'addtime' => date('Y-m-d H:i:s')
    	);
    	$res = M('project_excel_group')->add($data);
    	if (!$res) $this->error('创建Excel失败了，联系仝朋朋，改BUG', 'Excel-index');
    	$this->success('创建Excel成功');
    }

    /**
     * [delExcel 删除excel组]
     * @仝朋朋:http://mytpp.com/admin/Excel/delExcel
     * @url示例:
     * @DateTime    2018-08-08
     * @逻辑:
     * @Author      仝朋朋
     * @param      <int> <group_id> { excel分组id  project_excel_group.id }
     * @return      [type]     [description]
     */
    public function delExcel() {

    	if (!($group_id = I('group_id') ) ) $this->error('告诉我删除谁', 'Excel-index');

    	$where = ['id' => $group_id];
    	$data = M('project_excel_group')->where($where)->find();
    	if (!$data) $this->error('excel文件未找到', 'Excel-index');

    	$res = M('project_excel_group')->where($where)->save(['status' => 0]);
    	if (false === $res) $this->error('删除Excel失败了，联系仝朋朋，改BUG', 'Excel-index');
    	$this->success('删除Excel成功');
    }

    /**
     * [delExcel 编辑excel组]
     * @仝朋朋:http://mytpp.com/admin/Excel/editExcel
     * @url示例:
     * @DateTime    2018-08-08
     * @逻辑:
     * @Author      仝朋朋
     * @param      <int> <group_id> { excel分组id  project_excel_group.id }
     * @param      <string> <title> { 文件标题 }
     * @param      <string> <filename> { 文件名称 }
     * 
     * @return      [type]     [description]
     */
    public function editExcel() {

    	if (!($group_id = I('group_id') ) ) $this->error('告诉我改谁', 'Excel-index');
    	if (!($title = I('title') ) ) $this->error('请输入标题', 'Excel-index');
    	if (!($filename = I('filename') ) ) $this->error('请输入文件名称', 'Excel-index');

    	$saveData = array(
    		'title' => $title,
    		'filename' => $filename
    	);

    	$where = ['id' => $group_id];
    	$data = M('project_excel_group')->where($where)->find();
    	if (!$data) $this->error('excel文件未找到', 'Excel-index');

    	$res = M('project_excel_group')->where($where)->save($saveData);
    	if (false === $res) $this->error('编辑Excel失败了，联系仝朋朋，改BUG', 'Excel-index');
    	$this->success('编辑Excel成功');
    }

    /**
     * [seeExcel 查看excel内容]
     * @仝朋朋:http://mytpp.com/admin/Excel/seeExcel
     * @url示例:
     * @DateTime    2018-08-08
     * @逻辑:
     * @Author      仝朋朋
     * @param      <int> <group_id> { excel分组id  project_excel_group.id }
     * @return      [type]     [description]
     */
    public function seeExcel() {

    	if (!($group_id = I('group_id') ) ) $this->error('告诉我你愁啥', 'Excel-index');

    	
    	$groupWhere = ['id' => $group_id, 'status' => 1];
    	$groupData = M('project_excel_group')->where($groupWhere)->find();
    	if (!$groupData) $this->error('excel文件未找到', 'Excel-index');

    	$where = ['excel_group_id' => $group_id, 'status' => 1];
    	if ($content = I('content')) $where['_complex'] = array(
    		'title' => array('LIKE', '%'.$content.'%'),
    		'filename' => array('LIKE', '%'.$content.'%'),
    		'_logic' => 'or'
    	);
    	$count = M('project_excel_payroll')->where($where)->count();
    	$Page = new \Think\Page($count,10);

    	$list = M('project_excel_payroll')->where($where)->limit($Page->firstRow.','.$Page->listRows)->order('A')->select();

    	$this->assign(
    		array(
    			'list' => $list,
    			'show' => $Page->show(),
    			'groupData' => $groupData,
    			'content' => $content
    		)
    	)->display();

    }

    /**
     * [addExcelData 添加excel 数据]
     * @仝朋朋:http://mytpp.com/admin/Excel/addExcelData
     * @url示例:
     * @DateTime    2018-08-08
     * @逻辑:
     * @param     数据库字段 project_excel_payroll  status 没有
     * @Author      仝朋朋
     */
    public function addExcelData() {

    	$param = I('post.');
    	if (!$param) $this->error('增加数据未找到', 'Excel-index');

    	$excel_group_id = $param['excel_group_id']; // 分组id
    	
    	// 验证分组id有效性
    	$where = ['excel_group_id' => $excel_group_id, 'status' => 1];
    	$groupData = M('project_excel_group')->where($where)->find();
    	if (!$groupData) $this->error('excel文件未找到', 'Excel-index');

    	$res = M('project_excel_payroll')->add($param);
    	if (!$res) $this->error('添加excel数据失败，联系仝朋朋，改BUG', 'Excel-index');
    	$this->success('添加Excel数据成功');
    }

    /**
     * [downLoad excel下载特殊格式 W专属]
     * @仝朋朋:http://mytpp.com/admin/Excel/downLoad
     * @url示例:
     * @DateTime    2018-08-07
     * @逻辑:
     * @Author      仝朋朋
     * @param      <int> <group_id> { excel分组id  project_excel_group.id }
     * @return      [type]     [description]
     */
    public function downLoad()
    {
    	if (!($group_id = I('group_id') ) ) $this->error('你下载哪个文件？', 'Excel-index');

    	$where = ['id' => $group_id, 'status' => 1];
    	$groupData = M('project_excel_group')->where($where)->find();
    	if (!$groupData) $this->error('excel文件未找到', 'Excel-index');

    	$xlsName  = $groupData['filename'];
    	$title  = $groupData['title'];

    	// 获取excel数据
    	$xlsData = M('project_excel_payroll')->field('A, B, C, D, E, F, G, H, I, J, K, L, M, N, O, P, Q, R, S, T, U, V, W, X, Y, Z, AA, AB, AC, AD')->where(['status' => 1, 'excel_group_id' => $group_id])->select();
    	
		// $xlsData = [
		// 	[
		// 		'A' => 1, // 编号
		// 		'B' => 仝朋朋, // 姓名
		// 		'C' => 天王老子, // 入职离职
		// 		'D' => 中南海, // 部门
		// 		'E' => 国家主席, // 职级
		// 		'F' => 365, // 应出勤
		// 		'G' => 100, // 计薪天数
		// 		'H' => 100, // 基本工资（标准）
		// 		'I' => 99, // 基本工资（应发工资）
		// 		'J' => '', // 绩效提成
		// 		'K' => '', // 加班费
		// 		'L' => '', // 高温补
		// 		'M' => '', // 话补
		// 		'N' => '', // 印管
		// 		'O' => '', // 应发金额(社保差额)
		// 		'P' => '', // 其他补
		// 		'Q' => 99, // 应发合计
		// 		'R' => 10, // 社保
		// 		'S' => 100, // 请事假（天数）
		// 		'T' => '', // 请事假（扣款）
		// 		'U' => 1, // 迟到次数
		// 		'V' => 1, // 迟到扣款
		// 		'W' => 3, // 缺卡次数
		// 		'X' => 2, // 缺卡扣款
		// 		'Y' => 2, // 旷工天数
		// 		'Z' => 3, // 旷工扣款
		// 		'AA' => 12, // 社保差额
		// 		'AB' => 22, // 应扣合计(元)
		// 		'AC' => 99, // 实发工资
		// 		'AD' => '' // 签字
		// 	],
		// 	[
		// 		'A' => 1,
		// 		'B' => 测试数据2,
		// 		'C' => 天王老子2,
		// 		'D' => 中南海2,
		// 		'E' => 国家主席2,
		// 		'F' => 3652,
		// 		'G' => 1002,
		// 		'H' => 1002,
		// 		'I' => 992,
		// 		'J' => '',
		// 		'K' => '',
		// 		'L' => '',
		// 		'M' => '',
		// 		'N' => '',
		// 		'O' => '',
		// 		'P' => '',
		// 		'Q' => 929,
		// 		'R' => 102,
		// 		'S' => 1020,
		// 		'T' => '',
		// 		'U' => 12,
		// 		'V' => 12,
		// 		'W' => 32,
		// 		'X' => 22,
		// 		'Y' => 22,
		// 		'Z' => 32,
		// 		'AA' => 122,
		// 		'AB' => 222,
		// 		'AC' => 992,
		// 		'AD' => ''
		// 	],
		// ];
    	$this->exportExcel($xlsName,$title,$xlsData);
    }


    protected function exportExcel($expName,$expTitle,$expTableData){
		$fileName = iconv('utf-8', 'gb2312', $expTitle);//文件名称
		// $fileName = $_SESSION['account'].date('_YmdHis');//or $xlsTitle 文件名称可根据自己情况设定
		

		Vendor("phpexcel.PHPExcel");
			
		// $objPHPExcel = new \PHPExcel();
		$excel = new \PHPExcel();

		// $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');

		// $objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
		// $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.'  Export time:'.date('Y-m-d H:i:s'));
		// for($i=0;$i<$cellNum;$i++){
		// 	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'2', $expCellName[$i][1]);
		// }
		// Miscellaneous glyphs, UTF-8
		// for($i=0;$i<$dataNum;$i++){
		// 	for($j=0;$j<$cellNum;$j++){
		// 		$objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+3), $expTableData[$i][$expCellName[$j][0]]);
		// 	}
		// }

		// header('pragma:public');
		// header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
		// header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
		// $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		// $objWriter->save('php://output');
		// exit;


		//Excel表格式,这里简略写了24列
		$letter = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD');

		// 大标题
		$excel->getActiveSheet()->setCellValue("A1", $expTitle);  //填充A1的值
			
		// 合并单元格那些恶心的小东西
		$excel->getActiveSheet()->mergeCells('A1:AD1');          //合并行从A1到D1<br>$excel->getActiveSheet()->mergeCells('C7:c10');       //合并列从C7到C10<br>
		$excel->getActiveSheet()->mergeCells('A2:A4');
		$excel->getActiveSheet()->mergeCells('B2:B4');
		$excel->getActiveSheet()->mergeCells('C2:C4');
		$excel->getActiveSheet()->mergeCells('D2:D4');
		$excel->getActiveSheet()->mergeCells('E2:E4');
		$excel->getActiveSheet()->mergeCells('F2:F4');
		$excel->getActiveSheet()->mergeCells('G2:G4');



		// 设置坐标那些恶心的东西

		// 一级恶心 （前面一些小喽啰）start
		$excel->getActiveSheet()->setCellValue("A2","编号");
		$excel->getActiveSheet()->setCellValue("B2","姓名");
		$excel->getActiveSheet()->setCellValue("C2","入职离职");
		$excel->getActiveSheet()->setCellValue("D2","部门");
		$excel->getActiveSheet()->setCellValue("E2","职级");
		$excel->getActiveSheet()->setCellValue("F2","应出勤");
		$excel->getActiveSheet()->setCellValue("G2","计薪天数");
		// 一级恶心 send

		// 二级恶心 (应发金额)start
		$excel->getActiveSheet()->mergeCells('H2:Q2');  
		$excel->getActiveSheet()->setCellValue("H2","应发金额");

		$excel->getActiveSheet()->mergeCells('H3:I3');  
		$excel->getActiveSheet()->setCellValue("H3","基本工资");
	 	
	 	$excel->getActiveSheet()->setCellValue("H4","标准");
	 	$excel->getActiveSheet()->setCellValue("I4","应发工资");

	 	$excel->getActiveSheet()->mergeCells('J3:J4');
	 	$excel->getActiveSheet()->setCellValue("J3","绩效提成");


	 	$excel->getActiveSheet()->mergeCells('K3:P3');  
	 	$excel->getActiveSheet()->setCellValue("K4","加班费");
	 	$excel->getActiveSheet()->setCellValue("L4","高温补");
	 	$excel->getActiveSheet()->setCellValue("M4","话补");
	 	$excel->getActiveSheet()->setCellValue("N4","印管");
	 	$excel->getActiveSheet()->setCellValue("O4","社保差额");
	 	$excel->getActiveSheet()->setCellValue("P4","其他补");

	 	$excel->getActiveSheet()->mergeCells('Q3:Q4');  
	 	$excel->getActiveSheet()->setCellValue("Q3","应发合计");

		// 二级恶心 end

		// 三级恶心(应扣金额) start
	 	
	 	$excel->getActiveSheet()->mergeCells('R2:AB2');  
	 	$excel->getActiveSheet()->setCellValue("H2","应扣金额");

	 	$excel->getActiveSheet()->setCellValue("R3","代缴费用");
	 	$excel->getActiveSheet()->setCellValue("R4","社保");

	 	$excel->getActiveSheet()->mergeCells('S3:T3');  
	 	$excel->getActiveSheet()->setCellValue("S3","请事假");
	 	$excel->getActiveSheet()->setCellValue("S4","天数(天)");
	 	$excel->getActiveSheet()->setCellValue("T4","扣款");

	 	$excel->getActiveSheet()->mergeCells('U3:V3');
	 	$excel->getActiveSheet()->setCellValue("U3","迟到");
	 	$excel->getActiveSheet()->setCellValue("U4","迟到(次)");
	 	$excel->getActiveSheet()->setCellValue("V4","扣款");

	 	$excel->getActiveSheet()->mergeCells('W3:X3');
	 	$excel->getActiveSheet()->setCellValue("W3","缺卡");
	 	$excel->getActiveSheet()->setCellValue("W4","缺卡(次)");
	 	$excel->getActiveSheet()->setCellValue("X4","扣款");

	 	$excel->getActiveSheet()->mergeCells('Y3:Z3');
	 	$excel->getActiveSheet()->setCellValue("Y3","旷工");
	 	$excel->getActiveSheet()->setCellValue("Y4","旷工(天)");
	 	$excel->getActiveSheet()->setCellValue("Z4","扣款");

	 	$excel->getActiveSheet()->mergeCells('AA3:AA4');
	 	$excel->getActiveSheet()->setCellValue("AA3","社保差额");

	 	$excel->getActiveSheet()->mergeCells('AB3:AB4');
	 	$excel->getActiveSheet()->setCellValue("AB3","应扣合计(元)");

	 	$excel->getActiveSheet()->mergeCells('AC2:AC4');
	 	$excel->getActiveSheet()->setCellValue("AC2","实发工资");
	 	$excel->getActiveSheet()->mergeCells('AD2:AD4');
	 	$excel->getActiveSheet()->setCellValue("AD2","签字");

		// 三级恶心 end




		// 设置列的宽度那些恶心的小东西
		// $excel->getActiveSheet()->getColumnDimension('A')->setWidth(13);//设置列的宽度
		// $excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		// $excel->getActiveSheet()->getColumnDimension('C')->setWidth(13);
		// $excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
		// $excel->getActiveSheet()->getRowDimension(5)->setRowHeight(100);

		 //设置行的高度数字代表第几行  那些恶心的小东西
		// $excel->getActiveSheet()->getRowDimension(2)->setRowHeight(25);
		// $excel->getActiveSheet()->getRowDimension(3)->setRowHeight(25);
		// $excel->getActiveSheet()->getRowDimension(4)->setRowHeight(25);
		// $excel->getActiveSheet()->getRowDimension(6)->setRowHeight(25);

		// 居中用的
		// $excel->getActiveSheet()->getStyle('A1:AD1')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);//横向居中<br><br>$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);//纵向居中
		
		// $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		// $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);

		$excel->getActiveSheet()->getStyle('A1:AD4')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('A1:AD4')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);

		

		// 调色用的
		$excel->getActiveSheet()->getStyle('A1:AD1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
		$excel->getActiveSheet()->getStyle('A2:AD2')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
		$excel->getActiveSheet()->getStyle('A3:AD3')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
		$excel->getActiveSheet()->getStyle('A4:AD4')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
		 $excel->getActiveSheet()->getStyle('A1:AD1')->getFill()->getStartColor()->setARGB("00ff99cc");
		 $excel->getActiveSheet()->getStyle('A2:AD2')->getFill()->getStartColor()->setARGB("00ff99cc");
		 $excel->getActiveSheet()->getStyle('A3:AD3')->getFill()->getStartColor()->setARGB("00ff99cc");
		 $excel->getActiveSheet()->getStyle('A4:AD4')->getFill()->getStartColor()->setARGB("00ff99cc");

		 // 边框用的
		 $styleThinBlackBorderOutline = array(
	        'borders' => array(
	            'allborders' => array( //设置全部边框
	                'style' => \PHPExcel_Style_Border::BORDER_THIN //粗的是thick
	            ),

	        ),
	    );
	    $excel->getActiveSheet()->getStyle('A1:AD4')->applyFromArray($styleThinBlackBorderOutline);

	    // 设置字体颜色
	    

	    $excel->getActiveSheet()->getStyle("A1:AD4")->getFont()->setBold(true)
                                ->setName('Verdana')
                                ->setSize(10);
        $excel->getActiveSheet()->getStyle("A1:AD1")->getFont()->setBold(true)
                                ->setName('Verdana')
                                ->setSize(18);

	    $excel->getActiveSheet()->getStyle("H4")->getFont()->setBold(true)
                                ->setName('Verdana')
                                ->setSize(10)
                                ->getColor()->setRGB('FF0000');

        $excel->getActiveSheet()->getStyle("I4")->getFont()->setBold(true)
                                ->setName('Verdana')
                                ->setSize(10)
                                ->getColor()->setRGB('FF0000');

        $excel->getActiveSheet()->getStyle("Q3")->getFont()->setBold(true)
                                ->setName('Verdana')
                                ->setSize(10)
                                ->getColor()->setRGB('FF0000');
		$excel->getActiveSheet()->getStyle("T4")->getFont()->setBold(true)
                                ->setName('Verdana')
                                ->setSize(10)
                                ->getColor()->setRGB('FF0000');
        $excel->getActiveSheet()->getStyle("V4")->getFont()->setBold(true)
                                ->setName('Verdana')
                                ->setSize(10)
                                ->getColor()->setRGB('FF0000');
        $excel->getActiveSheet()->getStyle("X4")->getFont()->setBold(true)
                                ->setName('Verdana')
                                ->setSize(10)
                                ->getColor()->setRGB('FF0000');
        $excel->getActiveSheet()->getStyle("Z4")->getFont()->setBold(true)
                                ->setName('Verdana')
                                ->setSize(10)
                                ->getColor()->setRGB('FF0000');                        
        $excel->getActiveSheet()->getStyle("AB3")->getFont()->setBold(true)
                                ->setName('Verdana')
                                ->setSize(10)
                                ->getColor()->setRGB('FF0000');       
        $excel->getActiveSheet()->getStyle("AC2")->getFont()->setBold(true)
                                ->setName('Verdana')
                                ->setSize(10)
                                ->getColor()->setRGB('FF0000');      


        // 循环添加数据
        $i = 5;
        foreach ($expTableData as $key => $value) {
        	

        	foreach ($value as $k2 => $v2) {
        		
	        	$excel->getActiveSheet()->setCellValue($k2.$i,$v2);


	        	// $objActSheet->setCellValue('G'.$i, "=SUM('F".$i."'-'S".$i."')"); // 公式

	        	// 垂直居中
	        	$excel->getActiveSheet()->getStyle($k2.$i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$excel->getActiveSheet()->getStyle($k2.$i)->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);

				// 边框
				$excel->getActiveSheet()->getStyle($k2.$i)->applyFromArray($styleThinBlackBorderOutline);

				// 设置高度
				$excel->getActiveSheet()->getRowDimension($i)->setRowHeight(25);
        	}
       		$i++;
       	}

       	// 合计 start
       	$excel->getActiveSheet()->mergeCells('A'.$i.':G'.$i);

       	$excel->getActiveSheet()->setCellValue('A'.$i,"合计");
       	$excel->getActiveSheet()->setCellValue('H'.$i,"\\"); // 标准
       	$excel->getActiveSheet()->setCellValue('I'.$i,"100"); // 应发工资
       	$excel->getActiveSheet()->setCellValue('J'.$i,"");
       	$excel->getActiveSheet()->setCellValue('Q'.$i,"100"); // 应发合计

       	$excel->getActiveSheet()->setCellValue('R'.$i,"12"); // 社保
       	$excel->getActiveSheet()->setCellValue('S'.$i,"\\"); // 请事假天数
       	$excel->getActiveSheet()->setCellValue('T'.$i,"10"); // 请事假扣款

       	$excel->getActiveSheet()->setCellValue('U'.$i,"\\"); // 迟到次数
       	$excel->getActiveSheet()->setCellValue('V'.$i,"1"); // 迟到扣款

       	$excel->getActiveSheet()->setCellValue('W'.$i,"\\"); // 缺卡次数
       	$excel->getActiveSheet()->setCellValue('X'.$i,"2"); // 缺卡扣款

       	$excel->getActiveSheet()->setCellValue('Y'.$i,"\\"); // 旷工次数
       	$excel->getActiveSheet()->setCellValue('Z'.$i,"0"); // 旷工扣款

       	$excel->getActiveSheet()->setCellValue('AA'.$i,"12"); // 社保差额
       	$excel->getActiveSheet()->setCellValue('AB'.$i,"22"); // 应扣合计

       	$excel->getActiveSheet()->setCellValue('AC'.$i,"200"); // 实发工资
       	$excel->getActiveSheet()->setCellValue('AD'.$i,""); // 签字

       	$excel->getActiveSheet()->getStyle('A'.$i.':AD'.$i)->applyFromArray($styleThinBlackBorderOutline);

       	// 垂直居中
    	$excel->getActiveSheet()->getStyle('A'.$i.':AD'.$i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('A'.$i.':AD'.$i)->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
		// 合计 end

		$i++;

		$excel->getActiveSheet()->mergeCells('A'.$i.':AD'.$i);
		$excel->getActiveSheet()->getStyle('A'.$i.':AD'.$i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('A'.$i.':AD'.$i)->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->setCellValue('A'.$i,"本月合计：（小写） （大写）");

		$i++;
		$excel->getActiveSheet()->mergeCells('A'.$i.':G'.$i);
		$excel->getActiveSheet()->setCellValue('A'.$i,"制表：");

		$excel->getActiveSheet()->setCellValue('K'.$i,"审核：");

		$excel->getActiveSheet()->mergeCells('S'.$i.':U'.$i);
		$excel->getActiveSheet()->setCellValue('S'.$i,"批准：");

		$excel->getActiveSheet()->getStyle('A'.$i.':AD'.$i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('A'.$i.':AD'.$i)->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);




		$write = \PHPExcel_IOFactory::createWriter($excel, 'Excel5');
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
		header("Content-Type:application/force-download");
		header("Content-Type:application/vnd.ms-execl");
		header("Content-Type:application/octet-stream");
		header("Content-Type:application/download");;
		header("Content-Disposition:attachment;filename=".$fileName.".xls");//要生成的表名
		header("Content-Transfer-Encoding:binary");
		$write->save('php://output');

		exit();
	}
}