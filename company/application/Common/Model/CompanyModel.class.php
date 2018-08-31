<?php
namespace Common\Model;
use Common\Model\CommonModel;
class CompanyModel extends CommonModel
{
	
	protected $_validate = array(
		//array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
		array('company_name', 'require', '公司名称不能为空！', 1, 'regex', CommonModel:: MODEL_INSERT  ),
		array('user_login', 'require', '账号不能为空！', 1, 'regex', CommonModel:: MODEL_INSERT  ),
		array('user_pass', 'require', '密码不能为空！', 1, 'regex', CommonModel:: MODEL_INSERT ),
		array('company_name', 'require', '公司名称不能为空！', 0, 'regex', CommonModel:: MODEL_UPDATE  ),
		array('user_login', 'require', '账号不能为空！', 0, 'regex', CommonModel:: MODEL_UPDATE  )
	);
	
	protected $_auto = array(
	    array('create_time','mGetDate',CommonModel:: MODEL_INSERT,'callback')
	);
	
	//用于获取时间，格式为2012-02-03 12:12:12,注意,方法不能为private
	function mGetDate() {
		return time();
	}
	
	protected function _before_write(&$data) {
		parent::_before_write($data);
		
		if(!empty($data['user_pass']) && strlen($data['user_pass'])<25){
			$data['user_pass']=sp_password($data['user_pass']);
		}
	}

    //获取到甲方信息
    public function getInfo($where)
    {
        $info = M("company a")
            ->join(C('DB_PREFIX')."project b on a.id = b.company_id")
            ->where($where)
            ->find();

        return $info;
    }
	
}

