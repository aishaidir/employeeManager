<?php

include_once("models/init.php");
include_once("incs/auth.php");

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title><?php echo $siteTitle; ?></title>
		<meta name="description" content="">
		<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
		<meta http-equiv="Pragma" content="no-cache"/>
		<meta http-equiv="Expires" content="0"/>
		<?php include_once("incs/src_links.php"); ?>
		<script type="text/javascript">
        $(function(){

            var xhr = new XMLHttpRequest(); spinner = $('.infinite_spinner');
            //loadingBar.css({'width':'60%', 'opacity':'1', 'visibility':'visible'});
                spinner.show();
            xhr.open('POST', '<?php echo $baseURL; ?>views/role.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if(xhr.readyState == 3){
                    
                    //loadingBar.css({'width':'100%'});
                }
                if (xhr.readyState == 4 && xhr.status == 200){
                    spinner.hide();
                    setTimeout(function(){
                       // loadingBar.css({'width':'0%', 'opacity':'0', 'visibility':'hidden'});
                    }, 300);
                    $('#roles_tbl').html(xhr.responseText); 
                }
                
            }
            
            xhr.send('page='+ 1);
        });
        </script>
	</head>
	
	<body>
		
		<!-- light_overlay -->
		<div class="light_overlay"></div>
		<!-- /light_overlay -->
		
		<!-- page_container -->
		<div class="page_container">
			
			<!-- aside -->
			<?php include_once("incs/aside.php"); ?>
			<!-- /aside -->
			
			<!-- header -->
			<header cleafix>
				<div class="mobile_navicon pull_left">
					<i class="ion ion-navicon"></i>
				</div>
				<h3 class="page_title clearfix">
					<span>Roles</span>
				</h3>
				<!-- header_widgets -->
				<?php include_once("incs/header_widgets.php"); ?>
				<!-- header_widgets -->
			</header>
			<!-- /header -->
			
			<!-- page_content -->
			<div class="page_content">
				<!-- table_section -->
				<div class="table_section">
					<!-- table_widgets -->
					<div class="table_widgets clearfix">
						<!-- row -->
						<div class="row no_margin">
							<div class="column_3 pull_right">
								<div class="search_area">
									<span class="search_icon">
										<i class="ion ion-search"></i>
									</span>
									<input class="search" type="text" placeholder="Search">
								</div>
							</div>
						</div>
						<!-- /row -->
					</div>
					<!-- /table_widgets -->
					<table class="table" id="roles_tbl"></table>
					
				</div>
				<!-- /table_section -->
			</div>
			
			<!-- sticky_button -->
			<div class="sticky_button" style="">
				<a href="<?php echo $baseURL; ?>settings/create/role">
					<i class="ion ion-plus"></i>
				</a>
			</div>
			<!-- /sticky_button -->
			
		</div>
		<!-- /page_container -->
		
	</body>

</html>
