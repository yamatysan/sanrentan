		<!--<p class="titleLabelKojiharu">最新のこじはる予想！</p>-->
		<div id="recentKojiharuArea">
			<img src="/img/common/label_kojiharu_expect.png" class="label1 pc">
			<div class="expectArea">
				<p><?php echo date("m月d日",strtotime($recentKojiharu["Race"]["race_date"]));?><br><span style="font-size:115%;"><a href="/result/<?php echo $recentKojiharu['Race']['id'];?>"><?php echo $recentKojiharu["Race"]["name"];?><?php if($recentKojiharu['Race']['grade']>0):?> (G<?php echo $recentKojiharu['Race']['grade'];?>)<?php endif;?></a></span></p>
				<dl>
				<?php foreach($recentKojiharu["Expectation"]["view"] as $key=>$data):?>
					<div class="expect">
						<dt class="wk<?php echo $data['wk'];?>"><?php echo $data["uma"];?></dt><dd class="wkname"><?php echo $data["name"];?></dd>
						<div class="clearfix"></div>
					</div>
				<?php endforeach;?>
				</dl>

				<div style="display:none;">
					<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://www.sanrentan-box.com" data-text="<?php echo $recentKojiharu['Race']['name'];?>の３連単予想！「<?php foreach($recentKojiharu["Expectation"]["view"] as $key=>$data):?><?php if($key==0):?><?php echo $data["uma"];?><?php else:?>-<?php echo $data["uma"];?><?php endif;?><?php endforeach;?>
			」" data-via="sanrentan_box" data-lang="ja" data-size="large" data-hashtags="こじはる３連単予想">ツイート</a>
					<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
				</div>
			</div>
		</div>
		<a href="/kojiharu_list" class="pc"><img src="/img/button/btn_view_list.png" class="view_btn1"></a>
		<!--<div id="subBannerArea" style="float:right; padding-right:10px;padding-top:20px;"><img src="/img/common/umairasto.png" style="max-width:90px;"></div>-->
		<div class="clearfix"></div>


		<!--
		<div class="adArea pc tag3">
			<ul>
				<?php foreach($adTags3 as $key=>$data):?>
					<li>
						<?php echo $data['AdTag']['tag'];?>
					</li>
				<?php endforeach;?>

			</ul>
		</div>
		-->
