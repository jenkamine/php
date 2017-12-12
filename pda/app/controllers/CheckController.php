<?php

use Phalcon\Mvc\Controller;
use Phalcon\Tag;

class CheckController extends Controller
{
	public static $dbid = 6;//0->live,6->test
	public static $chk_arr = array("","출고","숙성","이동","실사","패킹");
	private static $chk_id = 4;
	
	public function indexAction()
	{
		$this->session->set('o_data',NULL);
		$this->session->set('b_cods',NULL);
		include 'view_basic.php';
	}

	public function cancelAction()
	{
		$i_ids = $this->session->get('i_ids');
		if($stmt = $this->sql->execute("delete from mInvTakeStock where take_id in(".$i_ids.")")){
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
			$err = false;
			//Add some local CSS resources
			$this->view->setVar('fdata',$f_data);
			//취소리스트로 리스트를 만들어 보여주어야 함
			$data = $this->session->get('o_data');
			$this->session->set('b_cods','');
			$this->view->setVar('data',$data);
		}
		else {
			$err = true;
			$this->view->setVar('c_data','기록을 취소하지 못했습니다.&#13;&#10;다시 시도해 주십시오.');
		}
		$this->view->setVar('err',$err);
		include 'view_basic.php';
	}
	
	public function recordAction()
	{
		$data = $this->session->get('o_data');
		$user = $this->session->get('user');
		//this->tag->setDoctype(Tag::HTML401_STRICT);
		$insert_txt = '';
		$b_cod_arr = array();
		$b_cods = $this->session->get('b_cods');
		foreach($data as $key => $value)
		{
    //$this->logger->log('itm_ucode['.$key.']:'.$data[$key]['itm_ucode']);
			$b_cod = $data[$key]['req_code'].$data[$key]['req_seq'];
			$b_cods_cnt = count($b_cods);
			if(is_array ($b_cods) == TRUE) $b_exist = in_array($b_cod,$b_cods);
			if(($b_cods_cnt > 0 && $b_exist == FALSE) || $b_cods_cnt == 0)
			{
				if(isset($data[$key]['itm_width'])) $tmp_width = $data[$key]['itm_width'];
				else $tmp_width = 0;
				if(isset($data[$key]['itm_width2'])) $tmp_width2 = $data[$key]['itm_width2'];
				else $tmp_width2 = 0;
				if(isset($data[$key]['itm_length'])) $tmp_length = $data[$key]['itm_length'];
				else $tmp_length = 0;
				if(isset($data[$key]['itm_ea'])) $tmp_ea = $data[$key]['itm_ea'];
				else $tmp_ea = 0;
				if(isset($data[$key]['qty'])) $tmp_qty = $data[$key]['qty'];
				else $tmp_qty = 0;
				$insert_txt .= "('".$data[$key]['type_name']."','".$data[$key]['itm_name']."',".$tmp_width.",".$tmp_width2.",".$tmp_length.",'".$data[$key]['itm_thic']."','".$data[$key]['rip_code']."','".$data[$key]['itm_ucode']."','".$data[$key]['lot_no']."','".$data[$key]['req_code']."','".$data[$key]['req_seq']."','".date('Ym')."','".$user['fac']."','".$user['pda_id']."',current_timestamp,'".$data[$key]['itm_code']."','A','".$data[$key]['itm_etc']."','".$data[$key]['itm_iunit']."',".$tmp_ea.",".$tmp_qty."),";
			}
			$b_cod_arr[] = $b_cod;
		}
		if(strlen($insert_txt) > 0)
		{
			$insert_txt = substr($insert_txt,0,-1);
			if($stmt = $this->sql->execute("insert into mInvTakeStock(type_name,itm_name,itm_width,itm_width2,itm_length,itm_thic,rip_code,itm_ucode,lot_no,req_code,req_seq,job_month,fac_code,insert_emp,insert_dt, itm_code,itm_quality,itm_etc,itm_iunit,itm_ea,itm_qty) values".$insert_txt.' returning take_id')){
				$insert_ids = $stmt->fetchAll(PDO::FETCH_NUM);
				$i_ids = str_replace(array("]","["),"",json_encode($insert_ids));
				$this->session->set('i_ids',$i_ids);
				$this->session->set('b_cods',$b_cod_arr);
				$this->view->setVar('c_data','기록되었습니다.&#13;&#10;기록된 리스트는 다음과 같습니다.');
				$this->view->setVar('data',$data);
				$err = false;
			}
			else{
				$this->view->setVar('c_data','데이터 베이스 기록에 실패하였습니다.&#13;&#10;다시 시도해 주십시오.');
				$err = true;
			}
		}
		else{
			$this->view->setVar('c_data','선택된 리스트가 없거나 이미 기록한 바코드입니다.');
			$err = true;
		}
		$this->view->setVar('err',$err);
		include 'view_basic.php';
	}
	//바코드를 읽어 바코드에 해당하는 품목들을 불러들인다.
	public function listAction()
	{
		$err = false;
		//this->tag->setDoctype(Tag::HTML401_STRICT);
		$b_id = strtoupper($this->request->getPost('b_id'));
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
    $stmt = $this->sql->execute("select req_code from mInvTakeStock where req_code = :b_cod and req_seq = :b_seq"
           ,array('b_cod'=>$b_cod,'b_seq'=>$b_seq),self::$dbid);
    $check = $stmt->fetchAll(PDO::FETCH_ASSOC);
	  if(count($check) == 0)
  	{
  		if(isset($b_id)){
        try {
        //job_month,itm_quality,itm_iunit
          $stmt = $this->sql->execute("select a.req_code,a.req_seq,a.itm_code,c.type_name,b.itm_name,b.itm_width,b.itm_width2,b.itm_length,b.itm_thic,b.itm_ucode,b.itm_type as itm_etc,b.rip_code,a.itm_ea,b.itm_iunit,a.equ_code,a.lot_no,a.cst_code,a.qty from mBcodHis a inner join mItmMst b on a.itm_code = b.itm_code inner join xItmType c on b.itm_type2 = c.type_code where a.req_code = :b_cod and a.req_seq = :b_seq order by a.req_code,a.req_seq"
                ,array('b_cod'=>$b_cod,'b_seq'=>$b_seq),self::$dbid);
    			$o_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    			if(count($o_data) == 0){
    				$data = '바코드에 해당하는 기록이 없거나 잘못된 바코드입니다.&#13;&#10;다시 읽어주세요.&#13;&#10;ex)170526S0601';
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
    					$data[$key]['post'] = "post('/check/list',{'del':'".$data[$key]['req_code'].$data[$key]['req_seq']."'});";
    				}
    				$this->session->set('o_data',$data);
    			}
        } catch (PDOException $e) {
                $log = $e->getMessage();
                $this->logger->log($log);
                $this->view->setVar('c_data', '데이터 베이스 기록에 실패하였습니다.&#13;&#10;다시 시도해 주십시오.');
                $this->view->setVar('data', '');
                $err = true;
        }
  		}
  		else{
  			$data = '박스라벨의 바코드를 입력해주세요 ex)170526S0601';
  			$err = true;
  		}
    }
    else
    {
        $data = '이미 기록된 바코드입니다';
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
		$this->view->setVar('fdata',$f_data);
		$this->view->setVar('data',$data);
		$this->view->setVar('err',$err);
		$this->view->setVar('today',date('Y-m-d'));
		include 'view_basic.php';
	}
}