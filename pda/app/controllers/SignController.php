<?php
use Phalcon\Mvc\Controller;

class SignController extends Controller
{
	public function indexAction()
	{
		//if(isset($this->session->get('user'))) $this->session->set('user',array('pda_id'=>'','name'=>'');
		//Add some local CSS resources
		$this->assets->addJs('js/menu.js');
		$this->assets->addCss('css/style.css');
		$this->view->setVar('title','test');
	}
	
	public function inAction()
	{
		if (!$this->security->checkToken()) {
			header("Location:/");
			exit(1);
		}
		$id = strtoupper($this->request->getPost('userid','string'));
		$pwd = $this->request->getPost('dst_ps','string');
		$fac = $this->request->getPost('place','string');
		// $stmt = $this->db[$dbnum]->prepare($prepare);
			// $stmt->execute($bind_params);
			
		$stmt = $this->sql->execute(
			"select web_pass, fac_code, emp_nm from xempmst where emp_stt = '1' and (emp_no ilike :login or emp_id ilike :login) and web_pass = crypt(:pwd, web_pass)",
			array(':login'=>$id,':pwd'=>$pwd)
		);
		
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if( empty($row['fac_code']))
		{
			$stmt = $this->sql->execute(
				'update xempmst set fac_code = :fac where emp_no = :id',
				array(':id' => $id, ':fac' => $fac)
			);
		}
		if ( isset($row['emp_nm']))
		{
			$this->session->set('user',array('pda_id'=>$id,'name'=>$row['emp_nm'],'fac'=>$fac));
			header("Location:/home");
			//print_r($user['pda_id']);
			exit(1);
		}
		else
		{
			echo "The validation has failed";
		}
	}
}