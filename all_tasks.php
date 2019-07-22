<?php

include_once("models/init.php");
include_once('incs/auth.php');


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>STETiS Task Manager</title>
    <meta name="description" content="">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
    <meta http-equiv="Pragma" content="no-cache"/>
    <meta http-equiv="Expires" content="0"/>
    <?php include_once("incs/src_links.php"); ?>
    <script type="text/javascript">
        $(function(){

            var xhr = new XMLHttpRequest(), spinner = $('.infinite_spinner'),
                uid = "<?php echo $uid; ?>";
            spinner.show();
            xhr.open('POST', '<?php echo $baseURL; ?>views/task.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if(xhr.readyState == 3) { }
                if (xhr.readyState == 4 && xhr.status == 200){
                    spinner.hide();
                    setTimeout(function(){
                    }, 300);
                    $('#task_section').html(xhr.responseText);
                }

            }

            xhr.send('page='+ 2 + "&uid=" + uid);
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
            <span>All Tasks</span>
        </h3>
        <!-- header_widgets -->
        <?php include_once("incs/header_widgets.php"); ?>
        <!-- header_widgets -->
    </header>
    <!-- /header -->

    <!-- page_content -->
    <div class="page_content">
        <!-- task_section -->
        <div class="task_section" id="task_section">



        </div>
        <!-- /task_section -->

    </div>
    <!-- /page_content -->

    <!-- sticky_button -->
    <div class="sticky_button" style="">
        <a href="<?php echo $baseURL; ?>task/create">
            <i class="ion ion-plus"></i>
        </a>
    </div>
    <!-- /sticky_button -->

</div>
<!-- /page_container -->

</body>

</html>
