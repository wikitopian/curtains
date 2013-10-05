<!--START THE WRAPPER-->
<div class='curtain_wrapper'>

	<!-- 2 CURTAIN IMAGES START HERE  -->
	<img class='curtain curtainLeft' src='<?=$image_left?>' />
	<img class='curtain curtainRight' src='<?=$image_right?>' />
    <!-- END IMAGES -->

    <!-- START THE CONTENT DIV -->
	<div class='content'>
		<!-- YOUR CONTENT HERE -->
		<?=$content?>
	<!-- END YOUR CONTENT -->
    </div>
    <!-- END THE CONTENT DIV -->

    <!-- START DESCRIPTION DIV, WHICH WILL BE SHOWN ON TOP OF THE CURTAIN AND REMOVED WHEN THE CURTAINS OPEN -->
    <div class='description'>
		<?=$description?>
    </div>
    <!-- END DESCRIPTION DIV -->

</div>
<!--END THE WRAPPER-->
