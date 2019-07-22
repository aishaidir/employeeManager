<?php

include_once("models/init.php");
include_once('incs/auth.php');

if(!$user->hasPrivilege("Supervision Privilege")) {
	echo "No permission";
	die;
} 

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

            var xhr = new XMLHttpRequest(); spinner = $('.infinite_spinner'),
            	uid = "<?php echo $uid; ?>";
            //loadingBar.css({'width':'60%', 'opacity':'1', 'visibility':'visible'});
                spinner.show();
            xhr.open('POST', '<?php echo $baseURL; ?>views/subordinate.php', true);
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
                    $('#subordinates_tbl').html(xhr.responseText); 
                }
                
            }
            
            xhr.send('page='+ 1 + "&uid=" + uid);
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
					<span>Subordinates - <?php echo $library->total("subordinates", $uid); ?></span>
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
					<table class="table" id="subordinates_tbl">
						
					</table>
					
				</div>
				<!-- /table_section -->
			</div>
			
		</div>
		<!-- /page_container -->

		<div class="modal small" id="delete_modal">
        <div class="modal_backdrop"></div>
        <div class="modal_dialogue">
            <div class="modal_content">
                <div class="modal_header">
                    <h4>Delete User?</h4>
                </div>
                <div class="modal_body">
                    <b>Are you sure you want to delete this post?</b>
                    <br>
                    This action cannot be undone.
                </div>
                <div class="modal_footer">
                    <button class="button cancel_button small cancel_delete">Cancel</button>
                    <a href="" class="button danger_button small confirm_delete">Deleted</a>
                </div>
            </div>
        </div>
    </div>

		<div class="modal small" id="permission">
        <div class="modal_backdrop"></div>
        <div class="modal_dialogue">
            <div class="modal_content">
                <div class="modal_header">
                    <h4>Permission denied!</h4>
                </div>
                <div class="modal_body">
                    Please contact the System Administrator <br><br>
                </div>
                <div class="modal_footer">
                    <button type="button" class="button primary_button small close">OK</button>
                </div>
            </div>
        </div>
    </div>
		
	</body>

</html>
