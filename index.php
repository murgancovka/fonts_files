<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>Font/Files</title>
		<style type="text/css">
		<!--
		@import url("style.css");
		-->
		</style>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#clickme").click(function () {
					$("#content").html('Loading...');
					
					var data = { 'exts[]' : [], 'other_exts' : $("#other_exts").val() };
					$(":checked").each(function() {
					  data['exts[]'].push($(this).val());
					});
						
					$.ajax({
						type: "POST",
						data: data,
						url: "font.php",
						success: function(msg){
							$("#content").html(msg)
						}
					});
				});
			});
		</script>
    </head>
    <body>
		<p>
			<?php 
				$arr=array();
				$arr = array('ttf', 'otf', 'ttc', 'zip');
				$count=sizeof($arr);
				for($i=0; $i < $count; $i++){
			?>
				<input type="checkbox" id="checkbox" name="exts[]" value="<?php echo $arr[$i]; ?>" /> <?php echo $arr[$i]; ?> 
			<?php
				}
			?>
			or <input id="other_exts" type="text"  />
			<input type="submit" name="submit" id="clickme" value="Go!" />
		</p>
		
	<div id="content"></div>
	
	
    </body>
</html>	
