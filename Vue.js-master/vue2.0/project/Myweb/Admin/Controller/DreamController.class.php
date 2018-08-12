<?php
namespace Admin\Controller;
use Think\Controller;
class DreamController extends AllowController {
    //浏览梦想
    public function index(){
        $mod=M("x_list");
        //实例化分页类
        $page=new \Think\Page($mod->Count(),4);
        //分页设置
        $page->setConfig('prev','上一页');
        $page->setConfig('next','下一页');
        $page->setConfig('first','首页');
        $page->setConfig('last','末页');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        //查询用户梦想信息
        $list=$mod->limit($page->firstRow,$page->listRows)->select();
        $this->assign('page',$page->show());
        $this->assign('list',$list);
    	$this->display("Dream/index");
    }
    //加载添加梦想页面·
    public function add(){
        $this->display("Dream/add");
    }
    //执行添加梦想的操作
    public function doadd(){
       //实例化文件上传类
        $upload=new \Think\Upload();
        //设置参数
        $upload->maxSize=3145555555;
        $upload->exts=array('jpg','jpeg','png','gif');
        $upload->rootPath="./Public/Uploads/";
        //执行上传
        $info=$upload->upload();

        if(!$info){
            $this->error($upload->getError());
        }else{
                $s=$info['xpic']['savepath'].$info['xpic']['savename'];
        }
        //数据插入数据库
        //实例化Model类
        $mod=M('x_list');
        //获取需要添加的信息
        $data['xtitle']=$_POST['xtitle'];
        $data['xdetail']=$_POST['xdetail'];
        $data['xpic']=$s;
        $data['userid']=session('userid');
        $data['username']=session('username');
        // var_dump($data);die;
        //执行添加
        if($mod->add($data)){
            $this->success('添加成功',U('Dream/index'));
        }else{
            $this->error('添加失败');
        }
    }
    //删除操作
    public function delete(){
       //实例化
        $mod = M('x_list');
        $id=$_GET['id'];
        //获取需要删除的数据
        $row=$mod->find($id);  
        if($mod->delete($id)){
            //删除文件夹的图片
            unlink("./Public/Uploads/".$row['xpic']);
            echo "1";
        }else{
            echo "0";
        }
        
    }
    //加载梦想详情页面
    public function xiangqing(){
        $id=$_GET['id'];
        $mod=M("x_list");
        $xiang=$mod->find($id);
        $this->assign('xiang',$xiang);
        $this->display("Dream/xiang");   
    }
    //执行修改
    public function update(){
        //获取需要
        // 修改的数据
        $mod=M('shops');
        //获取id
        $id=$_POST['id'];
        $row=$mod->find($id);
        //还原大图
        $olderimg=preg_replace('/t_/','',$row['pic']);
        //实例化文件上传类
        $upload=new \Think\Upload();
        //设置参数
        $upload->maxSize=3145555555;
        $upload->exts=array('jpg','jpeg','png','gif');
        $upload->rootPath="./Public/Uploads/";
        //执行上传
        $info=$upload->upload();
        if(!$info){
            $this->error($upload->getError());
        }else{
            foreach($info as $file){
                //实例化图像处理类
                $image=new\Think\Image();
                //打开需要缩放的图片
                $image->open('./Public/Uploads/'.$file['savepath'].$file['savename']);
                $s=$file['savepath']."t_".$file['savename'];
                //缩放
                $image->thumb(100,100)->save('./Public/Uploads/'.$s);
            }
        }

        //数据插入数据库
        //实例化Model类
        $mod=M('shops');
        // var_dump($mod->create());
        //获取需要添加的信息
        $data['name']=$_POST['name'];
        $data['cates_id']=$_POST['cates_id'];
        $data['pic']=$s;
        $data['descr']=$_POST['descr'];
        $data['jieshao']=$_POST['jieshao'];
        // var_dump($data);die;
        //执行修改
        if($mod->where("id=$id")->save($data)){
            unlink('./Public/Uploads/'.$olderimg);
            unlink('./Public/Uploads/'.$row['pic']);

            $this->success('修改成功',U('Shops/index'));
        }else{
            $this->error('修改失败');
        }

    }
    //加载梦想排行页面
    public function paihang(){
        $mod=M("x_list");
        $three=$mod->order('num DESC')->limit(3)->select();
        $dream=$mod->select();
        $this->assign('dream',$dream);
        $this->assign('three',$three);
        $this->display("Dream/paihang");   
    }

}
