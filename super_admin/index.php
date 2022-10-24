<?php
ob_start();
?>



<?php include('include/header.php'); ?>

<?php include('include/side_nav.php'); ?>
<?php include('include/components/loading.php'); ?>

<!-- <div class="coo">
	<div class="loader li">
	</div>
</div> -->

<div class="main">

	<?php include('include/top_nav.php'); ?>

	<?php if(isset($_GET['page'])){

	if($_GET['page']=='co-ordinators'){
		include('include/co-ordinators_content.php');

	}else if($_GET['page']=='dept'){
		include('include/department_content.php');

	}else if($_GET['page']=='faculty'){
		include('include/faculty_content.php');

	}else if($_GET['page']=='settings'){
		include('include/settings_content.php');

	}else if($_GET['page']=='venues'){
		include('include/venues_content.php');

	}else if($_GET['page']=='courses'){
		include('include/courses_content.php');

	}else if($_GET['page']=='timetable'){
		include('include/gen_timetable.php');

	}else{
		echo "<div class='row'></div>
		<div class='row'>
		<h1 style='font-size:200px' class='text-center text-secondary'>404</h1>
		</div>";
	}

}else{
	include('include/index_content.php');
}

// $co = new Coordinator();
// $co->create();
// echo $co->id;

?>

	<?php include('include/footer.php'); ?>




	<script>
		document.addEventListener("DOMContentLoaded", function() {
			document.getElementById("datetimepicker-dashboard").flatpickr({
				inline: true,
				prevArrow: "<span class=\"fas fa-chevron-left\" title=\"Previous month\"></span>",
				nextArrow: "<span class=\"fas fa-chevron-right\" title=\"Next month\"></span>",
			});
		});
	</script>

	<!-- delete modal -->
	<div style="background-color: rgba(100,100,200,.3);" class="modal modal-colored modal-danger fade" id="delete"
		tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div style="background-color: rgb(50,100,200);" class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title text-danger">Warning!!!!!!</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body text-light m-3">
					<p class="mb-0">Are You Sure you Want to Delete?</p>
					<!-- <input name="delete_id" type="text" value=""> -->
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-dismiss="modal">No</button>
					<a id="yes" href="#" class="btn text-light bg-danger">Yes</a>
				</div>
			</div>
			</div> <script>
				$('.deleteee').click(function() {

				var del_row = $(this).attr('data')
				var id = del_row.split('/')[1]
				var del_from = del_row.split('/')[0]
				$("input[name='delete_id']").val('skdjkd')

				// $('#yes').attr('href').concat('include/action/delete_coordinator.php?id=')
				var url
				switch (del_from) {
				case 'coo':
				url = "include/action/delete_coordinator.php?id="+id
				break;
				case 'fac':
				url = "include/action/delete_faculty.php?id="+id
				break;
				case 'dept':
				url = "include/action/delete_department.php?id="+id
				break;
				case 'course':
				url = "include/action/delete_course.php?id="+id
				break;
				case 'venue':
				url = "include/action/delete_venue.php?id="+id
				break;

				default:
				break;
				}
				$('#yes').attr('href',url)
				// console.log($('#yes').attr('href'))

				})

				</script>


				</body>

				</html>