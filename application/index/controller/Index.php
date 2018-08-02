<?php
namespace app\index\controller;

use QL\QueryList;
use think\Controller;
use think\Db;

class Index extends Controller
{
    public function index()
    {
        $list=Db::name('doutu')
            ->order('id','desc')
            ->paginate(12);
        return $this->fetch('',compact('list'));
    }

    public function collect()
    {
        set_time_limit(0);
        ini_set("display_errors","On");
        error_reporting(E_ALL);
        $i=1662;
        $max_i=1763;
        $data=[];
        for($i;$i<=$max_i;$i++){
            $page='http://www.doutula.com/photo/list/?page='.$i;
            $ql=QueryList::get($page)
                ->rules([
                    'title'=>['.img-responsive.lazy.image_dta','alt'],
                    'img_link'=>['.img-responsive.lazy.image_dta','data-original']
                ])
                ->query()
                ->getData();
            $res=$ql->all();
            Db::name('doutu')->insertAll($res);
            echo str_repeat(" ",1024);
            echo $i.'<br />';
            ob_flush();
            flush();
            sleep(1);
        }
    }
}
