<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php $RGB_team_mb_wrap_bg_clr = dazz_hex2rgb_teams($team_mb_wrap_bg_clr);
$Hover_RGB_team_mb_wrap_bg_clr = implode(", ", $RGB_team_mb_wrap_bg_clr); ?>
	<!-- wpshopmart team member wrapper -->
	<div class="dazzler_team_2_m_row" id="dazzler_team_2_m_row_<?php echo $PostId; ?>">
		<div class="dazzler_row">  
			<style>		
				#dazzler_team_2_m_row_<?php echo $PostId; ?> .dazzler_team_2_m_our-team{
					border-left: 8px solid <?php echo $team_mb_wrap_bg_clr; ?>;
					border-bottom: 8px solid <?php echo $team_mb_wrap_bg_clr; ?>;
					margin-bottom:30px;
				}
				#dazzler_team_1_m_row_<?php echo $PostId; ?> .dazzler_single_team{
					margin-bottom:30px;
				}
				 
				#dazzler_team_2_m_row_<?php echo $PostId; ?> .dazzler_team_2_m_our-team .dazzler_team_2_m_team-image{
					position: relative;
					text-align: center;
				} 
				 
				#dazzler_team_2_m_row_<?php echo $PostId; ?> .dazzler_team_2_m_our-team img{
					width: 100%;
					height: auto;
				}
				#dazzler_team_2_m_row_<?php echo $PostId; ?> .dazzler_team_2_m_our-team .dazzler_team_2_m_description{
					width: 100%;
					height: 100%;
					text-align: center;
					position: absolute;
					top: 0;
					left: 0;
					
					line-height:1.5;
					padding: 40px 20px 50px 20px;
					margin:0px;
					opacity: 0;
					background-color:rgba(<?php echo $Hover_RGB_team_mb_wrap_bg_clr; ?>,0.7) !important; 
					transition: all 0.5s ease 0s;
					color:<?php echo $team_mb_desc_clr; ?> !important; 
					font-size: <?php echo $team_mb_desc_ft_size; ?>px !important;
					<?php if($font_family!=0){ ?>
						font-family:'<?php  echo $font_family; ?>' !important;
					<?php } ?>
					 
				}
				 
				#dazzler_team_2_m_row_<?php echo $PostId; ?> .dazzler_team_2_m_our-team:hover .dazzler_team_2_m_description{
					opacity:1;
				}
				
				#dazzler_team_2_m_row_<?php echo $PostId; ?> .dazzler_team_2_m_our-team .dazzler_team_2_m_social{
					padding: 10px 0 0 0;
					margin: 0;
					list-style: none;
					position: absolute;
					top: 40px;
					left: -27px;
					background: <?php echo $team_mb_wrap_bg_clr; ?>;
					text-align: center;
					transform: translate(25px, 0px) rotateY(90deg);
					transition: all 0.5s ease 0s;
					
				}
				#dazzler_team_2_m_row_<?php echo $PostId; ?> .dazzler_team_2_m_our-team:hover .dazzler_team_2_m_social{
					transform: translate(0px, 0px) rotateY(0deg);
					
					
				}
				#dazzler_team_2_m_row_<?php echo $PostId; ?> .dazzler_team_2_m_our-team .dazzler_team_2_m_social li{
					display: block;
					margin-bottom: 10px;
					margin:0px;
					padding:0px;
				}
				#dazzler_team_2_m_row_<?php echo $PostId; ?> .dazzler_team_2_m_our-team .dazzler_team_2_m_social li a{
					display: block;
					width: 40px;
					height: 35px;
					font-size: 17px;
					color:<?php echo $team_mb_social_icon_clr; ?>;
					line-height: 30px;
					transition: all 0.5s ease 0s;
				}
				#dazzler_team_2_m_row_<?php echo $PostId; ?> .dazzler_team_2_m_our-team .dazzler_team_2_m_social li a:hover{
					color:<?php echo $team_mb_social_icon_clr_bg; ?>;
				}
				#dazzler_team_2_m_row_<?php echo $PostId; ?> .dazzler_team_2_m_our-team .dazzler_team_2_m_team-info{
					padding: 20px;
				}
				#dazzler_team_2_m_row_<?php echo $PostId; ?> .dazzler_team_2_m_our-team .dazzler_team_2_m_title{
					font-size: <?php echo $team_mb_name_ft_size; ?>px !important;
					color: <?php echo $team_mb_name_clr; ?>;
					letter-spacing: 2px;
					margin: 0 0 15px 0;
					padding:0px;
					transition: all 0.5s ease 0s;
					<?php if($font_family!=0){ ?>
						font-family:'<?php  echo $font_family; ?>' !important;
					<?php } ?>
				}
				#dazzler_team_2_m_row_<?php echo $PostId; ?> .dazzler_team_2_m_our-team .dazzler_team_2_m_post{
					display: block;
					font-size: <?php echo $team_mb_pos_ft_size; ?>px;
					color:<?php echo $team_mb_pos_clr; ?>;
					text-transform: capitalize;
					<?php if($font_family!=0){ ?>
						font-family:'<?php  echo $font_family; ?>' !important;
					<?php } ?>
				}
				
				@media only screen and (max-width: 990px){
					.our-team{ margin-bottom: 30px; }
				}
				@media only screen and (max-width: 767px){
					.our-team .social{ left: -20px; }
				}
				@media only screen and (max-width: 480px){
					.our-team .social{ left: -20px; }
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
						<div class="dazzler_team_2_m_our-team">
							<div class="dazzler_team_2_m_team-image">
								<img src="<?php echo $mb_photo; ?>" alt="<?php echo $mb_name; ?>">
								<p class="dazzler_team_2_m_description">
									<?php echo $mb_desc; ?>
								</p>
								<ul class="dazzler_team_2_m_social">
									<?php if($mb_fb_url!="") { ?><li><a target="_blank" href="<?php echo $mb_fb_url; ?>"><i class="fa fa-facebook"></i></a></li> <?php } ?>
										<?php if($mb_twit_url!="") { ?><li><a target="_blank" href="<?php echo $mb_twit_url; ?>"><i class="fa fa-twitter"></i></a></li> <?php } ?>
										<?php if($mb_lnkd_url!="") { ?><li><a target="_blank" href="<?php echo $mb_lnkd_url; ?>"><i class="fa fa-linkedin"></i></a></li> <?php } ?>
								</ul>
							</div>
							<div class="dazzler_team_2_m_team-info">
								<h3 class="dazzler_team_2_m_title"><?php echo $mb_name; ?></h3>
								<span class="dazzler_team_2_m_post"><?php echo $mb_pos; ?></span>
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