<?php

//initilize the page
$libpath = $_SERVER['DOCUMENT_ROOT'] . "/app/views/";
// $libpath = $f3->get('DOCUMENT_ROOT');
require_once($libpath . "inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once($libpath . "inc/config.ui.php");

/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "User Profile";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_body_prop = array("class" => "fixed-page-footer"); //optional properties for <body>
$page_css[] = "your_style.css";
include($libpath . "inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
//$page_nav["misc"]["sub"]["blank"]["active"] = false;
include($libpath . "inc/nav.php");

?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
	<?php
		//configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
		//$breadcrumbs["New Crumb"] => "http://url.com"
		//$breadcrumbs["MyProfile"] = "";
		$breadcrumbs = array();
		include($libpath . "inc/ribbon.php");
	?>
	<!-- MAIN CONTENT -->
	<div id="content">
		<!-- widget grid -->
		<section id="widget-grid" class="">
			<?php
				$ui = new SmartUI;
				$ui->start_track();
				
				// $data = json_decode(file_get_contents(APP_URL.'/data/data.json'));

				// SmartForm layout
				$fields = array(
					'fname' => array(
						'type' => 'input', // or FormField::FORM_FIELD_INPUT
						'col' => 6,
						'properties' => array(
							'placeholder' => 'First name',
							'icon' => 'fa-user',
							'icon_append' => false
						)
					),
					'lname' => array(
						'type' => 'input',
						'col' => 6,
						'properties' => array(
							'placeholder' => 'Last name',
							'icon' => 'fa-user',
							'icon_append' => false
						)
					),
					'email' => array(
						'type' => 'input',
						'col' => 6,
						'properties' => array(
							'placeholder' => 'E-mail',
							'icon' => 'fa-envelope',
							'type' => 'email',
							'icon_append' => false
						)
					),
					'phone' => array(
						'type' => 'input',
						'col' => 6,
						'properties' => array(
							'placeholder' => 'Phone',
							'icon' => 'fa-phone',
							'type' => 'email',
							'icon_append' => false
						)
					),
					'country' => array(
						'type' => 'select',
						'col' => 5,
						'properties' => array(
							'data' => array(
								array('country' => 'India'),
								array('country' => 'USA'),
								array('country' => 'Canada')
							)
						)
					),
					'city' => array(
						'type' => 'input',
						'col' => 4,
						'properties' => array(
							'placeholder' => 'City'
						)
					),
					'zip' => array(
						'type' => 'input',
						'col' => 3,
						'properties' => array(
							'placeholder' => 'Post Code'
						)
					),
					'address' => array(
						'type' => 'input',
						'properties' => 'Address'
					),
					'other-info' => array(
						'type' => 'textarea',
						'properties' => 'Additional Info'
					),
					'card' => array(
						'type' => 'radio',
						'properties' => array(
							'items' => array(array('label' => 'Visa', 'checked' => true), 'MasterCard', 'American Express'),
							'inline' => true
						)
					),
					'name-on-card' => array(
						'col' => 10,
						'properties' => 'Name on card'
					),
					'cvv' => array(
						'col' => 2,
						'properties' => 'CVV2'
					),
					'card-label' => array(
						'type' => 'label',
						'col' => 4,
						'properties' => 'Expiration Date'
					),
					'card-month' => array(
						'type' => 'select',
						'col' => 5,
						'properties' => array(
							'data' => array(
								array('month' => 'January'),
								array('month' => 'February'),
								array('month' => 'March'),
								array('month' => '...')
							)
						)
					),
					'card-year' => array(
						'col' => 3,
						'properties' => 'Year'
					)
				);


				$form = $ui->create_smartform($fields); //,array('action'=>'/profile', 'method'=>'post'));
				$form->options('method', 'post');
				$form->fieldset(0, array('fname', 'lname', 'email', 'phone'));
				$form->fieldset(1, array('address', 'country', 'city', 'zip', 'other-info'));
				$form->fieldset(2, array('card', 'name-on-card', 'cvv', 'card-label', 'card-month', 'card-year'));

				$form->header($user->username);
				$form->footer(function() use ($ui) {
					$btn = $ui->create_button('Update details', 'primary')->attr(array('type' => 'submit'));
					return $btn->print_html(true);
				});

				$form->title('<h2>Details</h2>');
				$result = $form->print_html(true);
				echo $result;
			?>

			<!-- START ROW -->
			<div class="row">
			<!-- NEW COL START -->
			<article class="col-sm-12 col-md-12 col-lg-6">
				<!-- Widget ID (each widget will need unique ID)-->
				<div class="jarviswidget" id="wid-id-4" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false">
					<!-- widget options:
						usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">
						
						data-widget-colorbutton="false"	
						data-widget-editbutton="false"
						data-widget-togglebutton="false"
						data-widget-deletebutton="false"
						data-widget-fullscreenbutton="false"
						data-widget-custombutton="false"
						data-widget-collapsed="true" 
						data-widget-sortable="false"
						
					-->
					<header>
						<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
						<h2><?php echo $user->username; ?></h2>				
						
					</header>

					<!-- widget div-->
					<div>
						
						<!-- widget edit box -->
						<div class="jarviswidget-editbox">
							<!-- This area used as dropdown edit box -->
							
						</div>
						<!-- end widget edit box -->
						
						<!-- widget content -->
						<div class="widget-body no-padding">
							
							<form id="smart-form-register" class="smart-form">

								<fieldset>
									<div class="row">
										<section class="col col-6">
											<label class="input">
												<input type="text" name="firstname" placeholder="First name">
											</label>
										</section>
										<section class="col col-6">
											<label class="input">
												<input type="text" name="lastname" placeholder="Last name">
											</label>
										</section>
									</div>
									
									<div class="row">
										<section class="col col-6">
											<label class="select">
												<select name="gender">
													<option value="0" selected="" disabled="">Gender</option>
													<option value="1">Male</option>
													<option value="2">Female</option>
													<option value="3">Prefer not to answer</option>
												</select> <i></i> </label>
										</section>
										<section class="col col-6">
											<label class="input"> <i class="icon-append fa fa-calendar"></i>
												<input type="text" name="request" placeholder="Account activated on" class="datepicker" data-dateformat='dd/mm/yy'>
											</label>
										</section>
									</div>	

								</fieldset>

								<fieldset>
									<section>
										<label class="label">Username</label>
										<label class="input"> <i class="icon-append fa fa-user"></i>
											<input type="text" name="username" placeholder="Username" disabled value="<?php echo $user->username; ?>">
											</label>
											<!-- <b class="tooltip tooltip-bottom-right">Needed to enter the website</b> </label> -->
									</section>
									
									<section>
										<label class="label">Email</label>
										<label class="input"> <i class="icon-append fa fa-envelope-o"></i>
											<input type="email" name="email" placeholder="Email address" disabled value="<?php echo $user->email; ?>">
											<!-- <b class="tooltip tooltip-bottom-right">Needed to verify your account</b> </label> -->
									</section>

									<section>
										<label class="input"> <i class="icon-append fa fa-lock"></i>
											<input type="password" name="password" placeholder="Password" id="password">
											<b class="tooltip tooltip-bottom-right">Don't forget your password</b> </label>
									</section>

									<section>
										<label class="input"> <i class="icon-append fa fa-lock"></i>
											<input type="password" name="passwordConfirm" placeholder="Confirm password">
											<b class="tooltip tooltip-bottom-right">Don't forget your password</b> </label>
									</section>
								</fieldset>

								
								<footer>
									<button type="submit" class="btn btn-primary">
										Update details
									</button>
								</footer>
							</form>						
							
						</div>
						<!-- end widget content -->
						
					</div>
					<!-- end widget div -->
					
				</div>
				<!-- end widget -->
				</article>
				<!-- END COL -->
			</div>
			<!-- END ROW -->
		</section>
		<!-- end widget grid -->

	</div>
	<!-- END MAIN CONTENT -->

</div>
<!-- END MAIN PANEL -->
<!-- ==========================CONTENT ENDS HERE ========================== -->

<!-- PAGE FOOTER -->
<?php
	// include page footer
	include($libpath . "inc/footer.php");
?>
<!-- END PAGE FOOTER -->

<?php 
	//include required scripts
	include($libpath . "inc/scripts.php"); 
?>

<!-- PAGE RELATED PLUGIN(S) 
<script src="<?php echo ASSETS_URL; ?>/js/plugin/YOURJS.js"></script>-->

<script>

	$(document).ready(function() {
		/* DO NOT REMOVE : GLOBAL FUNCTIONS!
		 *
		 * pageSetUp(); WILL CALL THE FOLLOWING FUNCTIONS
		 *
		 * // activate tooltips
		 * $("[rel=tooltip]").tooltip();
		 *
		 * // activate popovers
		 * $("[rel=popover]").popover();
		 *
		 * // activate popovers with hover states
		 * $("[rel=popover-hover]").popover({ trigger: "hover" });
		 *
		 * // activate inline charts
		 * runAllCharts();
		 *
		 * // setup widgets
		 * setup_widgets_desktop();
		 *
		 * // run form elements
		 * runAllForms();
		 *
		 ********************************
		 *
		 * pageSetUp() is needed whenever you load a page.
		 * It initializes and checks for all basic elements of the page
		 * and makes rendering easier.
		 *
		 */
		
		 pageSetUp();
		 
		/*
		 * ALL PAGE RELATED SCRIPTS CAN GO BELOW HERE
		 * eg alert("my home function");
		 * 
		 * var pagefunction = function() {
		 *   ...
		 * }
		 * loadScript("js/plugin/_PLUGIN_NAME_.js", pagefunction);
		 * 
		 * TO LOAD A SCRIPT:
		 * var pagefunction = function (){ 
		 *  loadScript(".../plugin.js", run_after_loaded);	
		 * }
		 * 
		 * OR
		 * 
		 * loadScript(".../plugin.js", run_after_loaded);
		 */

		var $registerForm = $("#smart-form-register").validate({

			// Rules for form validation
			rules : {
				username : {
					required : true
				},
				email : {
					required : true,
					email : true
				},
				password : {
					required : true,
					minlength : 3,
					maxlength : 20
				},
				passwordConfirm : {
					required : true,
					minlength : 3,
					maxlength : 20,
					equalTo : '#password'
				},
				firstname : {
					required : true
				},
				lastname : {
					required : true
				},
				gender : {
					required : true
				},
				terms : {
					required : true
				}
			},

			// Messages for form validation
			messages : {
				login : {
					required : 'Please enter your login'
				},
				email : {
					required : 'Please enter your email address',
					email : 'Please enter a VALID email address'
				},
				password : {
					required : 'Please enter your password'
				},
				passwordConfirm : {
					required : 'Please enter your password one more time',
					equalTo : 'Please enter the same password as above'
				},
				firstname : {
					required : 'Please select your first name'
				},
				lastname : {
					required : 'Please select your last name'
				},
				gender : {
					required : 'Please select your gender'
				},
				terms : {
					required : 'You must agree with Terms and Conditions'
				}
			},

			// Do not change code below
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});
	})


</script>

<?php 
	//include footer
	// include("inc/google-analytics.php"); 
?>