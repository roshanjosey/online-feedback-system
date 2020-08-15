<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
  	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<title>student registration page</title>
	<meta content="" name="descriptison">
  	<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>home</title>
  <meta content="" name="descriptison">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="mamba/assets/img/favicon.png" rel="icon">
  <link href="mamba/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,600,600i,700,700i,900" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?php echo base_url();?>mamba/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>mamba/assets/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>mamba/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>mamba/assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>mamba/assets/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="<?php echo base_url();?>mamba/assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>mamba/assets/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?php echo base_url();?>mamba/assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Mamba - v2.3.0
  * Template URL: https://bootstrapmade.com/mamba-one-page-bootstrap-template-free/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.0.6/css/all.css">
</head>

<body>

  <!-- ======= Top Bar ======= -->
  <section id="topbar" class="d-none d-lg-block">
    <div class="container clearfix">
      <div class="contact-info float-left">
        <i class="icofont-envelope"></i><a href="mailto:contact@example.com">contact@holychrist.com</a>
        <i class="icofont-phone"></i> +1 5589 55488 55
      </div>
      <div class="social-links float-right">
        <a href="#" class="twitter"><i class="icofont-twitter"></i></a>
        <a href="#" class="facebook"><i class="icofont-facebook"></i></a>
        <a href="#" class="instagram"><i class="icofont-instagram"></i></a>
        <a href="#" class="skype"><i class="icofont-skype"></i></a>
        <a href="#" class="linkedin"><i class="icofont-linkedin"></i></i></a>
      </div>
    </div>
  </section>

  <!-- ======= Header ======= -->
  <header id="header">
    <div class="container">

      <div class="logo float-left">
        <h1 class="text-light"><a href="<?php echo base_url('index.php/Control/student');?>"><span>HOLY CHRIST</span></a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
      </div>

      <nav class="nav-menu float-right d-none d-lg-block">
        <ul>

        <?php
          foreach ($details as $key => $value) 
          {
        ?>
          <li class="active"><a href="<?php echo base_url('index.php/Control/student_logged_page/'.$value->student_id);?>">Home</a></li>
          <li><a href="#footer">Contact Us</a></li>
        </ul>
      </nav><!-- .nav-menu -->

    </div>
  </header><!-- End Header -->

  <div class="container-fluid" style="margin-top: 20px;">
  	<div class="row">
  		<div class="col-xs-12 col-sm-12 col-md-12" data-aos="fade-up" data-aos-delay="100">

            <form method="POST" enctype="multipart/form-data">
              <div class="form-row container-fluid">
                <div class="form_group col-sm-6 col-md-6">
                  <div class="row">
                    <input type="image" name="image" src="<?php echo base_url('image/'.$value->image);?>" height="100px" width="150px" style="border: 1px solid black;">                  
                  </div>
                </div>
                <div class="form-group col-sm-6 col-md-6">
                  <div class="row">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" readonly value="<?php echo $value->name;?>">
                  </div>
                </div>                
              </div><br>
              <div class="form-group">
                <label>Gender</label><br>
                <input type="radio" name="gender" value="male" readonly <?php
                  if($value->gender=="male")
                  {
                    echo "checked";
                  }
                ?>>male
                <input type="radio" name="gender" value="female" readonly style="margin-left: 5px;" <?php
                  if($value->gender=="female")
                  {
                    echo "checked";
                  }
                ?>>female
              </div>
              <div class="form-group">
                <label>Address</label>
                <input type="text" class="form-control" name="address" readonly value="<?php echo $value->address;?>">
              </div>
              <div class="form-row">
                <div class="form-group col-md-5">
                  <label for="inputCity">City</label>
                  <input type="text" class="form-control" name="city" readonly value="<?php echo $value->city;?>">
                </div>
                <div class="form-group col-md-5">
                  <label for="inputCity">State</label>
                  <input type="text" class="form-control" name="state" readonly value="<?php echo $value->state;?>">
                </div>
                <div class="form-group col-md-2">
                  <label>Zip</label>
                  <input type="number" class="form-control" name="zip" readonly value="<?php echo $value->zip;?>">
                </div>
              </div>
              <div class="form-group">
                <label>Branch</label>
                <input type="text" class="form-control" name="branch" readonly value="<?php echo $value->branch;?>">
              </div>
              <div class="form-group">
                <label for="inputAddress2">Semester</label>
                <input type="number" class="form-control" name="semester" readonly value="<?php echo $value->semester;?>">
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label>Email</label>
                  <input type="email" class="form-control" name="email" readonly value="<?php echo $value->email;?>">
                </div>
              </div>
            </form>

        <?php
          }
        ?>
  			
  		</div>
  	</div>

  	  <!-- ======= Footer ======= -->
	  <footer id="footer" style="margin-top: 10px;" data-aos="fade-up" data-aos-delay="100">
	    <div class="footer-top" style="height: 300px;">
	      <div class="container">
	        <div class="row">

	          <div class="col-xs-12 col-sm-12 col-md-12 footer-info">
	            <h3>Holy Christ</h3>
	            <p>
	              Holy Cross College of Management & Technology<br>
	              Puttady, Idukki. Kerala - 685 551<br><br>
	              <strong>Phone:</strong> +1 5589 55488 55<br>
	              <strong>Email:</strong> contact@holychrist.com<br>
	            </p>
	            <div class="social-links mt-3" align="center">
	              <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
	              <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
	              <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
	              <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
	              <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
	            </div>
	          </div>

	        </div>
	      </div>
	    </div>

	  </footer><!-- End Footer -->
  	
  </div>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

  <!-- Vendor JS Files -->
  <script src="<?php echo base_url();?>mamba/assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url();?>mamba/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo base_url();?>mamba/assets/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="<?php echo base_url();?>mamba/assets/vendor/php-email-form/validate.js"></script>
  <script src="<?php echo base_url();?>mamba/assets/vendor/jquery-sticky/jquery.sticky.js"></script>
  <script src="<?php echo base_url();?>mamba/assets/vendor/venobox/venobox.min.js"></script>
  <script src="<?php echo base_url();?>mamba/assets/vendor/waypoints/jquery.waypoints.min.js"></script>
  <script src="<?php echo base_url();?>mamba/assets/vendor/counterup/counterup.min.js"></script>
  <script src="<?php echo base_url();?>mamba/assets/vendor/owl.carousel/owl.carousel.min.js"></script>
  <script src="<?php echo base_url();?>mamba/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="<?php echo base_url();?>mamba/assets/vendor/aos/aos.js"></script>

  <!-- Template Main JS File -->
  <script src="<?php echo base_url();?>mamba/assets/js/main.js"></script>

  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>

</html>