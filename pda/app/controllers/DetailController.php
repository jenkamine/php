<?php

use Phalcon\Mvc\Controller;
use Phalcon\Tag;

class DetailController extends Controller
{
	public static $dbid = 6;//0->live,6->test
	private static $chk_id = 1;
	public static $chk_arr = array("","출고","숙성","이동","실사","패킹");
	
	public function indexAction()
	{
		$this->session->set('rcodes',NULL);
		$this->session->set('o_data',NULL);
		$this->session->set('r_data',NULL);
		$this->session->set('b_cods',NULL);
		include 'view_basic.php';
	}

	//바코드를 읽어 바코드에 해당하는 품목들을 불러들인다.
	public function viewAction()
	{
		$err = false;
		$this->session->set('i_ids','');
		//this->tag->setDoctype(Tag::HTML401_STRICT);
		$b_id = strtoupper($this->request->getPost('b_id'));//,'int'를 추가하면 숫자로만 인식
		$data = $this->session->get('o_data');
		$rdata = $this->session->get('r_data');
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
			if(strlen($b_id) == 9){
				$stmt = $this->sql->execute("select a.req_code,b.itm_code,c.itm_name,c.itm_width, c.itm_length, case when g.ord_qty is null then c.ord_qty else g.ord_qty end as ord_qty, case when d.cst_alias > '' then d.cst_alias else c.cst_code end as cst_code from mSalesReqMst a left join mtasklistmst b on b.req_code = a.req_code inner join mSalesOrdList c on a.ord_id = c.ord_id left join mSalesOrdModify g on a.ord_id = g.ord_id and g.sal_id = (select max(sal_id) as sal_id from msalesordmodify where ord_id = a.ord_id)left join xCstMst d on c.cst_code = d.cst_code where a.req_code = :r_id"
				,array('r_id'=>$b_id),self::$dbid);
				$r_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if(count($r_data) == 0){
					$err_msg = '의뢰코드에 해당하는 기록이 없거나 잘못된 의뢰코드입니다.&#13;&#10;다시 읽어주세요.&#13;&#10;ex)170606017';
					$err = true;
				}
				else{
					$same_bid = false;
					if (is_array($rdata) || is_object($rdata)){
						foreach($rdata as $key => $value) {
							if($b_id == $rdata[$key]['req_code']) $same_bid = true;
						}
						if($same_bid == false){
							foreach ($r_data as $key => $value) {
								$rdata[] = $r_data[$key];
							}
						}
					}
					else{
						$rdata = $r_data;
					}
					$this->session->set('r_data',$rdata);
				}
			}
			else if(strlen($b_id) == 5){
				$stmt = $this->sql->execute("select req_code,req_seq from mBcodHis where packing_no = :p_no"
				,array('p_no'=>$b_id),self::$dbid);
				$p_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
				foreach ($p_data as $key => $value) {
					$b_id = $p_data[$key]['req_code'].$p_data[$key]['req_seq'];
					$result = self::selectAction($b_id);
					if($result[1] == true) break;
				}
				$data = $result[0];
				$err = $result[1];
				$err_msg = $result[2];
			}
			else{
				$result = self::selectAction($b_id);
				$data = $result[0];
				$err = $result[1];
				$err_msg = $result[2];
			}
		}
		if($err == true){
			$this->view->setVar('err_msg',$err_msg);
		}
		//Add some local CSS resources
		$this->view->setVar('rdata',$rdata);
		$this->view->setVar('data',$data);
		$this->view->setVar('d_cnt',count($data));
		$this->view->setVar('err',$err);
		$this->view->setVar('today',date('Y-m-d'));
		include 'view_basic.php';
	}
	
	public function selectAction($b_id)
	{
		$b_cod = substr($b_id, 0, -2);
		$b_seq = substr($b_id, -2);
		$data = $this->session->get('o_data');
		if(isset($b_id)){
			$stmt = $this->sql->execute("select his_part from mInvHistory where bar_code = :b_cod and his_part = 'P' and use_for = '6'"
			,array('b_cod'=>$b_id),self::$dbid);
			$o_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if(count($o_data) == 0){
				$stmt = $this->sql->execute("select a.req_code,a.req_seq,a.itm_code,b.itm_name,b.itm_width,b.itm_length,a.itm_ea,b.itm_unit as his_iunit,a.equ_code,'A' as quality,a.lot_no,a.cst_code,a.qty from mBcodHis a inner join mItmMst b on a.itm_code = b.itm_code where a.req_code = :b_cod and a.req_seq = :b_seq order by a.req_code,a.req_seq"
				,array('b_cod'=>$b_cod,'b_seq'=>$b_seq),self::$dbid);
				$o_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if(count($o_data) == 0){
					$err_msg = '바코드에 해당하는 기록이 없거나 잘못된 바코드입니다.&#13;&#10;다시 읽어주세요.&#13;&#10;ex)C9008101';
					$err = true;
				}
				else{
					$same_bid = false;
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
						$data[$key]['post'] = "post('/output/list',{'del':'".$data[$key]['req_code'].$data[$key]['req_seq']."'});";
					}
					$this->session->set('o_data',$data);
				}
			}
			else{
				$err_msg = '이미 창고에서 출고된 바코드입니다.&#13;&#10;다시 읽어주세요.&#13;&#10;ex)C9008101';
				$err = true;
			}
		}
		else{
			$err_msg = '출고요청서의 바코드를 입력해주세요 ex)C9008101';
			$err = true;
		}
		$result[0] = $data;
		$result[1] = $err;
		$result[2] = $err_msg;

		return $result;
	}
	
	public function writeAction($out_part,$p_data)
	{
		$user = $this->session->get('user');
		//this->tag->setDoctype(Tag::HTML401_STRICT);
		$insert_txt = '';
		$req_txt = '';
		$b_cod_arr = array();
		$b_cods = $this->session->get('b_cods');
		$data = $this->session->get('o_data');
		$rdata = $this->session->get('r_data');
		if(count($data) == 0)
		{
			if(count($rdata) > 0)
			{
				$this->view->setVar('c_data','의뢰코드만으로 출고되었습니다.&#13;&#10;출고된 의뢰는 위 리스트와 같습니다.');
				foreach($rdata as $key => $value)
				{
					$b_cod = $rdata[$key]['req_code'];
					$b_cods_cnt = count($b_cods);
					$b_exist = in_array($b_cod,$b_cods);
					$this->logger->log('b_cods_cnt:'.$b_cods_cnt.',b_exist:'.$b_exist);
					if(($b_cods_cnt > 0 && $b_exist == FALSE) || $b_cods_cnt == 0)
					{
						if(isset($rdata[$key]['itm_width'])) $tmp_width = $rdata[$key]['itm_width'];
						else $tmp_width = 0;
						if(isset($rdata[$key]['itm_length'])) $tmp_length = $rdata[$key]['itm_length'];
						else $tmp_length = 0;
						if($p_data[$key]) $tmp_ea = $p_data[$key];
						else $tmp_ea = 0;
						$tmp_qty = $tmp_ea * $tmp_width * $tmp_length * 0.001;     
						$insert_txt .= ",(0,0,'P','".$out_part."','".date('Ymd')."','".$user['fac']."','','','".$rdata[$key]['itm_code']."',".$tmp_width.",".$tmp_length.",".$tmp_ea.",'','','P','',".$tmp_qty.",'".$user['pda_id']."',current_timestamp,'','".$rdata[$key]['req_code']."','')";
						$req_txt .= ','.$rdata[$key]['req_code'];
					}
					$b_cod_arr[] = $b_cod;
				}
			}
		}
		else
		{
			$this->view->setVar('c_data','출고되었습니다.&#13;&#10;출고된 리스트는 다음과 같습니다.');
			foreach($data as $key => $value)
			{
				$b_cod = $data[$key]['req_code'].$data[$key]['req_seq'];
				$b_cods_cnt = count($b_cods);
				$b_exist = in_array($b_cod,$b_cods);
				$this->logger->log('b_cods_cnt:'.$b_cods_cnt.',b_exist:'.$b_exist);
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
					$insert_txt .= ",(0,'P','".$out_part."','".date('Ymd')."','".$user['fac']."','".$data[$key]['equ_code']."','".$data[$key]['itm_code']."',".$tmp_ea.",'".$data[$key]['lot_no']."','".$data[$key]['quality']."',".$tmp_qty.",'".$user['pda_id']."',current_timestamp,'','".$tmp_req_code."','".$b_cod."')";
					$req_txt .= ','.$data[$key]['req_code'];
				}
				$b_cod_arr[] = $b_cod;
			}
		}
		if(strlen($insert_txt) > 0)
		{
			$insert_txt = substr($insert_txt,1);
			$this->logger->log('insert_txt:'.$insert_txt);
			if($stmt = $this->sql->execute("insert into mInvHistory(task_id,his_part,use_for,move_date,fac_code,equ_code,itm_code,itm_ea,lot_no,quality,qty,insert_emp,insert_dt,req_code,bar_code) values".$insert_txt.' returning his_id')){
				$insert_ids = $stmt->fetchAll(PDO::FETCH_NUM);
				$i_ids = str_replace(array("]","["),"",json_encode($insert_ids));
				$req_txt = substr($req_txt,1);
				$this->session->set('i_ids',$i_ids);
				$this->session->set('rcodes',$req_txt);
				$this->session->set('b_cods',$b_cod_arr);
				$err = false;
				$stmt = $this->sql->execute("update mSalesReqMst set itm_stat = 7 where req_code in(:rcodes)"
				,array('rcodes'=>$req_txt),self::$dbid);
			}
			else{
				$this->view->setVar('c_data','데이터 베이스 기록에 실패하였습니다.&#13;&#10;다시 시도해 주십시오.');
				$this->view->setVar('data','');
				$err = true;
			}
		}
		$this->view->setVar('data',$data);
		$this->view->setVar('rdata',$rdata);
		$this->view->setVar('err',$result);
		
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