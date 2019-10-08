			<div id='pengyou-cebianlandingwei'>
				<div id="pengyou-cebianlan">
					<div class="pengyou-cbl-span"><img src="images/icon/left3.png" onClick="tccebianlan();"></div>
					<div class="pengyou-cebianlan-touxiang" align="center">
						<?php
							if($pengyou_tximg){
							echo '<img src="images/touxiang/'.$pengyou_tximg.'">';
						}else{
							echo '<img src="images/icon/pengyouquan.jpg">';
						}
						?>
						<p>欢迎你<?php if(@$pengyou_user){echo $pengyou_user;}else{echo "游客";}?></p>
					</div>
					<div align="left" class="pengyou-cebianlan-left">
						<ul>
							<li  onClick="Dqopen('index.php')"><img src="images/icon/zy.png"><a href="#">首页</a></li>
							<?php
								if(@$pengyou_user){
									echo '<li onClick="Dqopen(\'shiming.php\')"><img src="images/icon/user3.png"><a href="#">实名认证</a></li>';
									echo '<li  onClick="Dqopen(\'userpyq.php?id='.$myId.'\')"><img src="images/icon/pengyouquan4.png"><a href="#">我的朋友圈</a></li>';
									echo '<li onClick="Dqopen(\'userzl.php\')"><img src="images/icon/xg1.png"><a href="#">修改资料</a></li>';
									echo '<li onClick="Dqopen(\'xgpass.php\')"><img src="images/icon/pass8.png"><a href="#">修改密码</a></li>';
									echo '<li onClick="Dqopen(\'zx.php\')"><img src="images/icon/zx.png"><a href="#">注销</a></li>';
								}else{
									echo '<li onClick="Dqopen(\'login.php\')"><img src="images/icon/user3.png"><a href="#">登录</a></li>';
									echo '<li onClick="Dqopen(\'register.php\')"><img src="images/icon/reg1.png"><a href="#">注册</a></li>';
								}
							?>
							<li  onClick="Newopen('http://love.zhijiaoqiang.com')"><img src="images/icon/xin2.png"><a href="#">说说不约</a></li>
							<li  onClick="Newopen('http://zhijiaoqiang.com/make')"><img src="images/icon/jinyan.png"><a href="#">照片动起来</a></li>
						</ul>
				</div>
				</div>
				
			</div>