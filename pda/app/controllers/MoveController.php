<?php

use Phalcon\Mvc\Controller;
use Phalcon\Tag;

class MoveController extends Controller
{
	public static $dbid = 6;//0->live,6->test
	private static $chk_id = 3;
	public static $chk_arr = array("","출고","숙성","이동","실사","패킹");
	
	public function indexAction()
	{
		$this->session->set('o_data',NULL);
		$this->session->set('b_cods',NULL);
		include 'view_basic.php';
	}
	
	public function cancelAction()
	{
		$i_ids = $this->session->get('i_ids');
		if($stmt = $this->sql->execute("delete from mInvHistory where his_id in(".$i_ids.")")){
			$user = $this->session->get('user');
			$f_data = array();
			$f_arr = ['','1공장','2공장','3공장','4공장','5공장','6공장'];
			for($i = 1; $i <= 6; $i++)
			{
				$f_data[$i-1]['key'] = '00'.(string)$i;
				$f_data[$i-1]['val'] = $f_arr[$i];
				if($user['fac'] == '00'.(string)$i) $f_data[$i-1]['chk'] = "selected = 'selected'";
				else $f_data[$i-1]['chk'] = '';
			}
			//Add some local CSS resources
			$this->view->setVar('udata',$u_data);
			$this->view->setVar('fdata',$f_data);
			//취소리스트로 리스트를 만들어 보여주어야 함
			$data = $this->session->get('o_data');
			$this->session->set('b_cods','');
			$this->view->setVar('data',$data);
			include 'view_basic.php';
		}
		else {
			$err = true;
			$this->view->setVar('c_data','기록을 취소하지 못했습니다.&#13;&#10;다시 시도해 주십시오.');
		}
		$this->view->setVar('today',date('Y-m-d'));
		$this->view->setVar('err',$err);
		include 'view_basic.php';
	}
	
	public function recordoutAction()
	{
		$data = $this->session->get('o_data');
		$user = $this->session->get('user');
		//this->tag->setDoctype(Tag::HTML401_STRICT);
		$insert_txt = '';
		$b_cod_arr = array();
		$b_cods = $this->session->get('b_cods');
		foreach($data as $key => $value)
		{
			$b_cod = $data[$key]['req_code'].$data[$key]['req_seq'];
			if($this->request->getPost((string)$key,'int') == 1){
				$b_cods_cnt = count($b_cods);
				$b_exist = in_array($b_cod,$b_cods);
				if(($b_cods_cnt > 0 && $b_exist == FALSE) || $b_cods_cnt == 0)
				{
					if(isset($data[$key]['itm_width'])) $tmp_width = $data[$key]['itm_width'];
					else $tmp_width = 0;
					if(isset($data[$key]['itm_length'])) $tmp_length = $data[$key]['itm_length'];
					else $tmp_length = 0;
					if(isset($data[$key]['itm_ea'])) $tmp_ea = $data[$key]['itm_ea'];
					else $tmp_ea = 0;
					if(isset($data[$key]['qty'])) $tmp_qty = $data[$key]['qty'];
					else $tmp_qty = 0;
          $tmp_req_code = self::get_decode_req($data[$key]['req_code']);
					$insert_txt .= "(0,'P','5','".date('Ymd')."','".$user['fac']."','".$data[$key]['equ_code']."','".$data[$key]['itm_code']."',".$tmp_ea.",'".$data[$key]['lot_no']."','".$data[$key]['quality']."',".$tmp_qty.",'".$user['pda_id']."',current_timestamp,'','".$tmp_req_code."','" . $b_cod . "'),";
				}
			}
			$b_cod_arr[] = $b_cod;
		}
		if(strlen($insert_txt) > 0)
		{
			$insert_txt = substr($insert_txt,0,-1);
			if($stmt = $this->sql->execute("insert into mInvHistory(task_id,his_part,use_for,move_date,fac_code,equ_code,itm_code,itm_ea,lot_no,quality,qty,insert_emp,insert_dt,mix_group,req_code,bar_code) values".$insert_txt.' returning his_id')){
				$insert_ids = $stmt->fetchAll(PDO::FETCH_NUM);
				$i_ids = str_replace(array("]","["),"",json_encode($insert_ids));
				$this->session->set('i_ids',$i_ids);
				$this->session->set('b_cods',$b_cod_arr);
				$this->view->setVar('c_data','반출되었습니다.&#13;&#10;반출된 리스트는 다음과 같습니다.');
				$this->view->setVar('data',$data);
				$err = false;
			}
			else{
				$this->view->setVar('c_data','데이터 베이스 기록에 실패하였습니다.&#13;&#10;다시 시도해 주십시오.');
				$err = true;
			}
		}
		else{
			$this->view->setVar('c_data','선택된 반출리스트가 없거나 이미 반출한 바코드입니다.');
			$err = true;
		}
		$this->view->setVar('err',$err);
		include 'view_basic.php';
	}
	
	public function recordinAction()
	{
		$data = $this->session->get('o_data');
		$user = $this->session->get('user');
		//this->tag->setDoctype(Tag::HTML401_STRICT);
		$insert_txt = '';
		$b_cod_arr = array();
		$b_cods = $this->session->get('b_cods');
		foreach($data as $key => $value)
		{
			$b_cod = $data[$key]['req_code'].$data[$key]['req_seq'];
			if($this->request->getPost((string)$key,'int') == 1){
				$b_cods_cnt = count($b_cods);
				$b_exist = in_array($b_cod,$b_cods);
				if(($b_cods_cnt > 0 && $b_exist == FALSE) || $b_cods_cnt == 0)
				{
					if(isset($data[$key]['itm_width'])) $tmp_width = $data[$key]['itm_width'];
					else $tmp_width = 0;
					if(isset($data[$key]['itm_length'])) $tmp_length = $data[$key]['itm_length'];
					else $tmp_length = 0;
					if(isset($data[$key]['itm_ea'])) $tmp_ea = $data[$key]['itm_ea'];
					else $tmp_ea = 0;
					if(isset($data[$key]['qty'])) $tmp_qty = $data[$key]['qty'];
					else $tmp_qty = 0;
          $tmp_req_code = self::get_decode_req($data[$key]['req_code']);
					$insert_txt .= "(0,'P','1','".date('Ymd')."','".$user['fac']."','".$data[$key]['equ_code']."','".$data[$key]['itm_code']."',".$tmp_ea.",'".$data[$key]['lot_no']."','".$data[$key]['quality']."',".$tmp_qty.",'".$user['pda_id']."',current_timestamp,'','".$tmp_req_code."','" . $b_cod . "'),";
				}
			}
			$b_cod_arr[] = $b_cod;
		}
		if(strlen($insert_txt) > 0)
		{
			$insert_txt = substr($insert_txt,0,-1);
			if($stmt = $this->sql->execute("insert into mInvHistory(task_id,his_part,use_for,move_date,fac_code,equ_code,itm_code,itm_ea,lot_no,quality,qty,insert_emp,insert_dt,mix_group,req_code,bar_code) values".$insert_txt.' returning his_id')){
				$insert_ids = $stmt->fetchAll(PDO::FETCH_NUM);
				$i_ids = str_replace(array("]","["),"",json_encode($insert_ids));
				$this->session->set('i_ids',$i_ids);
				$this->session->set('b_cods',$b_cod_arr);
				$this->view->setVar('c_data','반입되었습니다.&#13;&#10;반입된 리스트는 다음과 같습니다.');
				$this->view->setVar('data',$data);
				$err = false;
			}
			else{
				$this->view->setVar('c_data','데이터 베이스 기록에 실패하였습니다.&#13;&#10;다시 시도해 주십시오.');
				$err = true;
			}
		}
		else{
			$this->view->setVar('c_data','선택된 반입리스트가 없거나 이미 반입한 바코드입니다.');
			$err = true;
		}
		$this->view->setVar('err',$err);
		include 'view_basic.php';
	}
	

	//바코드를 읽어 바코드에 해당하는 품목들을 불러들인다.
	public function listAction()
	{
		$u_data = 0;
		$err = false;
		//this->tag->setDoctype(Tag::HTML401_STRICT);
		$b_id = strtoupper($this->request->getPost('b_id'));//,'int'를 추가하면 숫자로만 인식
		$b_cod = substr($b_id, 0, -2);
		$b_seq = substr($b_id, -2);
		//지우기 처리
		$del_key = $this->request->getPost('del');
		$this->logger->log('del_key:'.$del_key);
		if(strlen($del_key) == 8)
		{
			foreach($data as $key => $value) {
				if($del_key == $data[$key]['req_code'].$data[$key]['req_seq'])
				{
					unset($data[$key]);
					$this->session->set('o_data',$data);
					break;
				}
			}
		}
		if(isset($b_id)){
			$stmt = $this->sql->execute("select use_for from mInvHistory where bar_code = :b_cod and his_part = 'P' and use_for in('5','6')",array('b_cod'=>$b_id),self::$dbid);
			$o_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$t1 = count($o_data);
			$t2 = $o_data[0]['use_for'];
			$t3 = 'c1:'.$t1.',c2:'.$t2;
			$this->logger->log($t3);
			if(count($o_data) == 0 || $o_data[0]['use_for'] == '5'){
				if($o_data[0]['use_for'] == '5') $u_data = 5;
				$stmt = $this->sql->execute("select a.req_code,a.req_seq,a.itm_code,b.itm_name,b.itm_width,b.itm_length,a.itm_ea,b.itm_unit as his_iunit,a.equ_code,'A' as quality,a.lot_no,a.cst_code,a.qty from mBcodHis a inner join mItmMst b on a.itm_code = b.itm_code where a.req_code = :b_cod and a.req_seq = :b_seq order by a.req_code,a.req_seq"
				,array('b_cod'=>$b_cod,'b_seq'=>$b_seq),self::$dbid);
				$o_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if(count($o_data) == 0){
					$data = '바코드에 해당하는 기록이 없거나 잘못된 바코드입니다.&#13;&#10;다시 읽어주세요.&#13;&#10;ex)17042100101';
					$err = true;
				}
				else{
					$same_bid = false;
					$data = $this->session->get('o_data');
					if (is_array($data) || is_object($data)){
						foreach($data as $key => $value) {
							if($b_id == $data[$key]['req_code'].$data[$key]['req_seq']) $same_bid = true;
						}
						if($same_bid == false){
							foreach ($o_data as $key => $value) {
								$data[] = $o_data[$key];
							}
						}
					}
					else{
						$data = $o_data;
					}
					foreach($data as $key => $value)
					{
						$data[$key]['post'] = "post('/move/list',{'del':'".$data[$key]['req_code'].$data[$key]['req_seq']."'});";
					}
					$this->session->set('o_data',$data);
				}
			}
			else{
				$data = '이미 창고에서 출고된 바코드입니다.&#13;&#10;다시 읽어주세요.&#13;&#10;ex)17042100101';
				$err = true;
			}
		}
		else{
			$data = '출고요청서의 바코드를 입력해주세요 ex)17042100101';
			$err = true;
		}
		$user = $this->session->get('user');
		$f_data = array();
		$f_arr = ['','1공장','2공장','3공장','4공장','5공장','6공장'];
		for($i = 1; $i <= 6; $i++)
		{
			$f_data[$i-1]['key'] = '00'.(string)$i;
			$f_data[$i-1]['val'] = $f_arr[$i];
			if($user['fac'] == '00'.(string)$i) $f_data[$i-1]['chk'] = "selected = 'selected'";
			else $f_data[$i-1]['chk'] = '';
		}
		//Add some local CSS resources
		$this->view->setVar('udata',$u_data);
		$this->view->setVar('fdata',$f_data);
		$this->view->setVar('data',$data);
		$this->view->setVar('err',$err);
		$this->view->setVar('today',date('Y-m-d'));
		include 'view_basic.php';
	}
  
  public function get_decode_req($req_code) {
    $code_arr = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "A", "B", "C", "D", "F", "G", "H", "J", "K", "L", "M", "N", "P", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
    //2619년12월31일까지 대응
    $dd = substr($req_code,0,1);
  	$dd = array_search($dd,$code_arr);
  	$dd = str_pad($dd, 2, '0', STR_PAD_LEFT);
  	$mm = substr($req_code,1,1);
  	$mm = array_search($mm,$code_arr);
  	$mm = str_pad($mm, 2, '0', STR_PAD_LEFT);
  	$yy = (int)(substr($req_code,2,1)) + 17;
  	$tmp_date = $yy.$mm.$dd.substr($req_code,-3);
    //$this->logger->log('tmp_date:'.$tmp_date.',req_code:'.$req_code.',yy:'.$yy.',mm:'.$mm.',dd:'.$dd.',substr($req_code,-3):'.substr($req_code,-3));

    return $tmp_date;
  }
}      