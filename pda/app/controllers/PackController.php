<?php

use Phalcon\Mvc\Controller;
use Phalcon\Tag;

class PackController extends Controller {

    public static $dbid = 6; //0->live,6->test
    private static $chk_id = 5;
    public static $chk_arr = array("", "출고", "숙성", "이동", "실사", "패킹");

    public function indexAction() {
        //Add some local CSS resources
        $this->session->set('c_data', NULL);
        $this->session->set('o_data', NULL);
        $this->session->set('b_cods', NULL);
        include 'view_basic.php';
    }

    public function cancelAction() {
        $c_data = $this->session->get('c_data');
        $user = $this->session->get('user');
        
        try {
            $this->sql->execute('START TRANSACTION', array(), $db_num);
            foreach ($c_data as $key => $value) {
                $stmt = $this->sql->execute("update mBcodHis set packing_no = '" . $c_data[$key]['packing_no'] . "' where (req_code = '" . $c_data[$key]['req_code'] . "' and req_seq = '" . $c_data[$key]['req_seq'] . "')");
            }
            $stmt = $this->sql->execute('COMMIT', array(), $db_num);
            $this->session->set('c_data', NULL);
            $this->session->set('o_data', NULL);
            $this->session->set('b_cods', NULL);
        } catch (PDOException $e) {
            $log = $e->getMessage();
            $this->logger->log($log);
            $this->view->setVar('c_data', '데이터 베이스 기록에 실패하였습니다.&#13;&#10;다시 시도해 주십시오.');
            $this->view->setVar('data', '');
            $err = true;
        }

        $this->view->setVar('err', $err);
        include 'view_basic.php';
    }

    public function get_packing_no() {
        $code_arr = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "A", "B", "C", "D", "F", "G", "H", "J", "K", "L", "M", "N", "P", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
        //2619년12월31일까지 대응
        $yy = (int) (substr(date('Y'), 2)) - 17;
        $mm = (int) (date('m'));
        $dd = (int) (date('d'));
        $tmp_date = $code_arr[$dd] . $code_arr[$mm] . $code_arr[$yy];
        $stmt = $this->sql->execute("select max(packing_no) as m_data from mBcodHis where packing_no like '" . $tmp_date . "%'");
        $m_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($m_data) == 0)
            $tmp_date .= '01';
        else
            $tmp_date .= str_pad((int) substr($m_data[0]['m_data'], -2) + 1, 2, '0', STR_PAD_LEFT);
        //$this->logger->log("$tmp_date:".$tmp_date);

        return $tmp_date;
    }

    public function packAction() {
        $data = $this->session->get('o_data');
        $c_data = $this->session->get('c_data');
        $packing_title = $this->session->get('p_title');
        $this->logger->log('pack data count:' . count($c_data).',$packing_title:'.$packing_title);
        //this->tag->setDoctype(Tag::HTML401_STRICT);
        try {
            $this->sql->execute('START TRANSACTION', array(), $db_num);
            if($packing_title == '신규') {
                $tmp_packing_no = self::get_packing_no();
            }
            else {
                $tmp_packing_no = $packing_title;
            }
            foreach ($c_data as $key => $value) {
                if($c_data[$key]['add'] == 2)
                {
                    $stmt = $this->sql->execute("update mBcodHis set packing_no = '" . $tmp_packing_no . "' where (req_code = '" . $c_data[$key]['req_code'] . "' and req_seq = '" . $c_data[$key]['req_seq'] . "')");
                }
                else if($c_data[$key]['add'] == 1){
                    $stmt = $this->sql->execute("update mBcodHis set packing_no = '' where (req_code = '" . $c_data[$key]['req_code'] . "' and req_seq = '" . $c_data[$key]['req_seq'] . "')");
                }
            }
            $stmt = $this->sql->execute('COMMIT', array(), $db_num);
            
            $this->view->setVar('data', $data);
            $this->view->setVar('c_data', $packing_no.'번호로 패킹되었습니다.&#13;&#10;패킹된 리스트는 다음과 같습니다.');
            $this->view->setVar('packing_no', $packing_no);
        } catch (PDOException $e) {
            $log = $e->getMessage();
            $this->logger->log($log);
            $this->view->setVar('c_data', '데이터 베이스 기록에 실패하였습니다.&#13;&#10;다시 시도해 주십시오.');
            $this->view->setVar('data', '');
            $err = true;
        }
        $this->view->setVar('p_title',$packing_title);
        $this->view->setVar('err', $err);
        $this->assets->addJs('js/barcode.js?'.time());
        include 'view_basic.php';
    }

    //바코드를 읽어 바코드에 해당하는 품목들을 불러들인다.
    public function listAction() {
        //this->tag->setDoctype(Tag::HTML401_STRICT);
        $b_id = strtoupper($this->request->getPost('b_id')); //,'int'를 추가하면 숫자로만 인식
        $data = $this->session->get('o_data');
        //지우기 처리
        $c_data = $this->session->get('c_data');
        if(empty($c_data)) {
            $c_data = array();
        }
        $del_key = $this->request->getPost('del');
        $this->logger->log('del_key:' . $del_key);
        if (strlen($del_key) == 8) {
            foreach ($data as $key => $value) {
                if ($del_key == $data[$key]['req_code'] . $data[$key]['req_seq']) {
                    if($data[0]['packing_no'] == $data[$key]['packing_no'])
                    {
                        foreach ($c_data as $key2 => $value2) {
                            if($c_data[$key2]['req_code'] == $data[$key]['req_code'] && $c_data[$key2]['req_seq'] == $data[$key]['req_seq']) {
                                $c_data[$key2]['add'] = 1;
                                $this->session->set('c_data', $c_data);
                            }
                        }
                    }
                    unset($data[$key]);
                    $this->session->set('o_data', $data);                    
                    break;
                }
            }
        }
        $err = false;
        if (isset($b_id)) {
            //출고되었었는지 확인(패킹번호로부터)
            if (strlen($b_id) == 5) {
                $stmt = $this->sql->execute("select 2 as add,a.req_code,a.req_seq,a.itm_code,b.itm_name,b.itm_width,b.itm_length,a.itm_ea,b.itm_unit as his_iunit,a.equ_code,'A' as quality,a.lot_no,a.cst_code,a.qty,a.packing_no from mBcodHis a inner join mItmMst b on a.itm_code = bitm_code where a.packing_no = :p_no"
                        , array('p_no' => $b_id), self::$dbid);
                $o_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($o_data as $key => $value) {
                    $b_code = $o_data[$key]['req_code'] . $o_data[$key]['req_seq'];
                    $stmt = $this->sql->execute("select his_part from mInvHistory where bar_code = :b_cod and his_part = 'P' and use_for = '6'"
                        , array('b_cod' => $b_code), self::$dbid);
                    $test_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if(count($test_data) > 0) {
                        unset($o_data[$key]);
                    }
                    else {
                        $c_data[] = $o_data[$key];
                        $this->session->set('c_data', $c_data);
                    }
                }
            } 
            //출고되었었는지 확인(바코드로부터)
            else {
                $stmt = $this->sql->execute("select his_part from mInvHistory where bar_code = :b_cod and his_part = 'P' and use_for = '6'"
                    , array('b_cod' => $b_id), self::$dbid);
                $test_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            if (count($test_data) == 0) {
                if (strlen($b_id) != 5) {
                    $stmt = $this->sql->execute("select 0 as add,a.req_code,a.req_seq,a.itm_code,b.itm_name,b.itm_width,b.itm_length,a.itm_ea,b.itm_unit as his_iunit,a.equ_code,'A' as quality,a.lot_no,a.cst_code,a.qty,a.packing_no from mBcodHis a inner join mItmMst b on a.itm_code = bitm_code where a.req_code = :b_cod and a.req_seq = :b_seq order by a.req_code,a.req_seq"
                        , array('b_cod' => $b_cod, 'b_seq' => $b_seq), self::$dbid);
                    $o_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
                if (count($o_data) == 0) {
                    if(isset($del_key)) {
                        $err = false;
                    }
                    else {
                        $err_msg = '바코드가 없거나 잘못된 바코드입니다.&#13;&#10;다시 읽어주세요.&#13;&#10;ex)L901DS02';
                        $err = true;
                    }
                } else {
                    $same_bid = false;
                    if (is_array($data) || is_object($data)) {
                        foreach ($data as $key => $value) {
                            if (strlen($b_id) == 5) {
                                if ($b_id == $data[$key]['packing_no']) {
                                    $same_bid = true;
                                }
                            }
                            else {
                                if ($b_id == $data[$key]['req_code'] . $data[$key]['req_seq']) {
                                    $same_bid = true;
                                }
                            }
                        }
                        if ($same_bid == false) {
                            foreach ($o_data as $key => $value) {
                                $o_data[$key]['add'] = 2;
                                $data[] = $o_data[$key];
                                $c_data[] = $o_data[$key];
                                $this->session->set('c_data', $c_data);
                            }
                        }
                    } else {
                        $data = $o_data;
                    }
                    foreach ($data as $key => $value) {
                        $data[$key]['post'] = "post('/pack/list',{'del':'" . $data[$key]['req_code'] . $data[$key]['req_seq'] . "'});";
                    }
                    $this->session->set('o_data', $data);
                }
            } else {
                $err_msg = '이미 창고에서 출고된 바코드입니다.&#13;&#10;다시 읽어주세요.&#13;&#10;ex)L901DS02';
                $err = true;
            }
        } else if(empty($del_key)) {
            $err_msg = '바코드를 입력해주세요 ex)L901DS02';
            $err = true;
        }
        if(empty($del_key)) {
            //특정 바코드 처리일 경우
            if(strlen($data[0]['packing_no']) > 0) {
                $packing_title = $data[0]['packing_no'];
            }
            //신규일 경우
            else {
                $packing_title = '신규';
            }
            $this->session->set('p_title',$packing_title);
        }
        $packing_title = $this->session->get('p_title');
        $this->view->setVar('p_title',$packing_title);
        foreach ($c_data as $key => $value) {
            $this->logger->log('['.$key.']req_code:'.$c_data[$key]['req_code'] .',req_seq:'.$c_data[$key]['req_seq'].',add:'.$c_data[$key]['add'].',packing_no:'.$c_data[$key]['packing_no']);
        }
        $this->logger->log('pack data count:' . count($c_data).',$packing_title:'.$packing_title);
        //Add some local CSS resources
        $this->view->setVar('data', $data);
        $this->view->setVar('d_cnt', count($data));
        $this->view->setVar('err_msg', $err_msg);
        $this->view->setVar('err', $err);
        $this->view->setVar('today', date('Y-m-d'));
        include 'view_basic.php';
    }
}
