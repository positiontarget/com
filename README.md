# com
# git 命令
 
 * 码云、GITHUB 配置公钥：
 ssh-keygen -t rsa -C "xxxxx@xxxxx.com"
 
 * 查看生成的公钥key
 $ cat ~/.ssh/id_rsa.pub
 
 https://github.com/positiontarget/com.git
 
 
#解决github网站 git push或者git clone代码速度太慢的方法 <br/>
 https://blog.csdn.net/wynter_/article/details/64572012<br/>
#程序猿必备技能之解决github访问慢方案<br/>
 https://blog.csdn.net/wu__di/article/details/50538916<br/>
 https://blog.csdn.net/IT_xiao_bai/article/details/80692152<br/>
 
#访问ipaddress网站https://www.ipaddress.com/，
	查看网站对应的IP地址，
	输入网址则可查阅到对应的IP地址，
	这是一个查询域名映射关系的工具
	查询 github.global.ssl.fastly.net 和 github.com 两个地址
	多查几次，选择一个稳定，延迟较低的 ip 
	按如下方式添加到host文件的最后面

 
 1.打开hosts文件 <br/>

sudo vim /etc/hosts<br/>

2.在该文件末尾空一行填入<br/>
151.101.113.194 github.global.ssl.fastly.net<br/>
192.30.253.112 github.com<br/>

保存hosts文件<br/>
重启浏览器，或刷新DNS缓存，告诉电脑hosts文件已经修改，<br/>
linux/mac执行sudo /etc/init.d/networking restart命令；<br/>
windows在cmd中输入ipconfig /flushdns命令即可。<br/>
起飞！！！