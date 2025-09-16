<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php $RGB_team_mb_wrap_bg_clr = dazz_hex2rgb_teams($team_mb_wrap_bg_clr);
$Hover_RGB_team_mb_wrap_bg_clr = implode(", ", $RGB_team_mb_wrap_bg_clr); ?>
	<!-- wpshopmart team member wrapper -->
	<div class="dazzler_team_1_m_row" id="dazzler_team_1_m_row_<?php echo $PostId; ?>">
		<div class="dazzler_row">  
			<style>
				
				#dazzler_team_1_m_row_<?php echo $PostId; ?> .dazzler_team_1_our-team{
					text-align: center;
				}
				#dazzler_team_1_m_row_<?php echo $PostId; ?> .dazzler_single_team{
					margin-bottom:30px;
				}
				#dazzler_team_1_m_row_<?php echo $PostId; ?> .dazzler_team_1_our-team .dazzler_team_1_pic{
					position: relative;
					overflow: hidden;
				}
				#dazzler_team_1_m_row_<?php echo $PostId; ?> .dazzler_team_1_our-team .dazzler_team_1_pic img{
					width: 100%;
					height: auto;
					transition: all 0.2s ease 0s;
				}
				#dazzler_team_1_m_row_<?php echo $PostId; ?> .dazzler_team_1_our-team:hover .dazzler_team_1_pic img{
					transform: translateY(15px);
				}
				#dazzler_team_1_m_row_<?php echo $PostId; ?> .dazzler_team_1_our-team .dazzler_team_1_social_media_team{
					width: 100%;
					position: absolute;
					bottom: -100%;
					padding: 25px;
					background-color:rgba(<?php echo $Hover_RGB_team_mb_wrap_bg_clr; ?>,<?php echo $opacity = $team_mb_opacity/100; ?>) !important; 
					transition: all 0.35s ease 0s;
					
				}
				#dazzler_team_1_m_row_<?php echo $PostId; ?> .dazzler_team_1_our-team:hover .dazzler_team_1_social_media_team{
					bottom: 0px;
				}
				#dazzler_team_1_m_row_<?php echo $PostId; ?> .dazzler_team_1_our-team .dazzler_team_1_description{
					margin-top: 10px;
					color:<?php echo $team_mb_desc_clr; ?> !important; 
					font-size: <?php echo $team_mb_desc_ft_size; ?>px !important;
					text-align: center;
					font-family:'<?php  echo $font_family; ?>' !important;
				}
				#dazzler_team_1_m_row_<?php echo $PostId; ?> .dazzler_team_1_our-team .dazzler_team_1_team_social{
					list-style: none;
					padding: 0;
					margin: 0;
					height: 100%;
					position: relative;
					top:2%;
				}
				#dazzler_team_1_m_row_<?php echo $PostId; ?> .dazzler_team_1_our-team .dazzler_team_1_team_social li{
					display: inline-block;
					margin: 0 5px 0 0;
					padding: 0px;
				}
				#dazzler_team_1_m_row_<?php echo $PostId; ?> .dazzler_team_1_our-team .dazzler_team_1_team_social li a{
					width: 45px;
					height: 45px;
					line-height: 45px;
					display: block;
					color:<?php echo $team_mb_social_icon_clr; ?>;
					font-size: 18px;
					transition: all 1.3s ease 0s;
				}
				#dazzler_team_1_m_row_<?php echo $PostId; ?> .dazzler_team_1_our-team .dazzler_team_1_team_social li a:hover{
					color:<?php echo $team_mb_social_icon_clr_bg; ?>;
					  
				}
				#dazzler_team_1_m_row_<?php echo $PostId; ?> .dazzler_team_1_our-team .dazzler_team_1_team-prof{
					margin-top: 10px;
				}
				#dazzler_team_1_m_row_<?php echo $PostId; ?> .dazzler_team_1_our-team .dazzler_team_1_post-title a{
					text-transform: capitalize;
					color:<?php echo $team_mb_pos_clr; ?> !important;
					transition: all 0.2s ease 0s;
				}
				#dazzler_team_1_m_row_<?php echo $PostId; ?> .dazzler_team_1_our-team .dazzler_team_1_post-title a:hover{
					text-decoration: none;
					color:<?php echo $team_mb_pos_clr; ?>;
				}
				#dazzler_team_1_m_row_<?php echo $PostId; ?> .dazzler_team_1_our-team .dazzler_team_1_post{
					color:<?php echo $team_mb_pos_clr; ?>;
					font-size: <?php echo $team_mb_pos_ft_size; ?>px;
					font-family:'<?php  echo $font_family; ?>';
				}
				@media screen and (max-width: 990px){
					.our-team{
						margin-bottom: 30px;
					}
				}
				#dazzler_team_1_m_row_<?php echo $PostId; ?> .dazzler_team_1_our-team .dazzler_team_1_team-prof h3{
				color:<?php echo $team_mb_name_clr; ?> !important;
				font-family:'<?php  echo $font_family; ?>' !important;
				font-size: <?php echo $team_mb_name_ft_size; ?>px !important;
				padding-top: 10px;
				padding-bottom: 10px;
				margin:0px;
				}
				.dazzler_row{
					overflow:hidden;
					display:block;
					width:100%;
				}
				<?php echo $custom_css; ?>			
			</style>
			<?php 
			if($TotalCount!=-1)
			{	
				$i=1;
				switch($team_layout){
					case(6):
						$row=2;
					break;
					case(4):
						$row=3;
					break;
					case(3):
						$row=4;
					break;
				}
				foreach($All_data as $single_data)
				{
					$mb_photo = $single_data['mb_photo'];
					$mb_name = $single_data['mb_name'];
					$mb_pos = $single_data['mb_pos'];
					$mb_desc = $single_data['mb_desc'];
					$mb_fb_url = $single_data['mb_fb_url'];
					$mb_twit_url = $single_data['mb_twit_url'];
					$mb_lnkd_url = $single_data['mb_lnkd_url'];
					 
					
					?>			 
					 <div class="col-md-<?php echo $team_layout; ?> wpsm-col-div dazzler_single_team">
						<div class="dazzler_team_1_our-team">
							<div class="dazzler_team_1_pic">
								<img src="<?php echo $mb_photo; ?>" alt="<?php echo $mb_name; ?>">
								<div class="dazzler_team_1_social_media_team">
									<p class="dazzler_team_1_description">
										<?php echo $mb_desc; ?>
									</p>
									<ul class="dazzler_team_1_team_social">
										<?php if($mb_fb_url!="") { ?><li><a target="_blank" href="<?php echo $mb_fb_url; ?>"><i class="fa fa-facebook"></i></a></li> <?php } ?>
										<?php if($mb_twit_url!="") { ?><li><a target="_blank" href="<?php echo $mb_twit_url; ?>"><i class="fa fa-twitter"></i></a></li> <?php } ?>
										<?php if($mb_lnkd_url!="") { ?><li><a target="_blank" href="<?php echo $mb_lnkd_url; ?>"><i class="fa fa-linkedin"></i></a></li> <?php } ?>
									</ul>
								</div>
							</div>
							<div class="dazzler_team_1_team-prof">
								<h3 class="dazzler_team_1_post-title"><?php echo $mb_name; ?></h3>
								<span class="dazzler_team_1_post"><?php echo $mb_pos; ?></span>
							</div>
						</div>
					</div>
					  
					<?php
					if($i%$row==0){
						?>
						</div>
						<div class="dazzler_row">
						<?php 
					}	
					?>
					<?php 
					 $i++;
				}
				
			}
			else
			{
				echo "No Team Group Found";
			}
		
			?>		
		</div>
	</div>