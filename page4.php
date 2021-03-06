<!DOCTYPE html>
<html lang="en">

<head>
    <!--
	Mark Whitcomb
	6/7/2019
	Copyright
-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat|Shadows+Into+Light+Two">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/mycss.css">
    <script src="js/jquery-3.4.0.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/mynav.js"></script>
</head>

<body>

    <!-- Start of site identity and navigation -->
    <nav class="navbar align-items-start navbar-expand-sm navbar-dark bg-my-nav-color">

        <div class="container p-0 d-flex flex-row flex-wrap align-items-start">
            <img class="navbar-brand p-0 col-1" src="images/logo1.png" alt="We're doomed!">

            <div class="company-name p-0 col-8">
                <span class="co-name1">Oceanfront Arizona Properties</span>
            </div>
            <!-- end div company-name -->

            <button class="navbar-toggler ml-auto my-collapse p-0 col-2" type="button" data-toggle="collapse" data-target="#navLinks">
			<div class="hamburger">
				<span></span>
				<span></span>
				<span></span>
				<span></span>
			</div> <!-- end div hamburger -->
		    </button>
        </div>
        <!-- end div container -->

        <div class="d-flex flex-wrap flex-column">
            <!-- Target for toggler and the links -->
            <div class="navbar-collapse collapse" id="navLinks">

                <!-- Links -->
                <ul class="navbar-nav">
                    <?php include ("nav-items.html"); ?>
                </ul>
            </div>
            <!-- end div collapse -->

        </div>
        <!-- end div d-flex flex-wrap -->

    </nav>
    <!-- end of site identity and navigation -->

    <div class="container-fluid mycontainer">

        <div class="jumbotron my-bgimg4">
            <h3 class="text-center pg4 words-up-front">
                The Ultra-Secret Login Page
            </h3>

            <div class="pg4 login-form p-3">
                <h5>Please enter your Login ID and Password</h5>
                <form id="login" action="" method="post" onsubmit="return false">
                    <div class="form-group">
                        <label class="form-control-label" for="userid">ID</label>
                        <input type="text" class="form-control" name="userid" data-form-field="userid" required id="userid" size="20" maxlength="50">
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="pw">Password</label>
                        <input type="text" class="form-control" name="pw" data-form-field="pw" required id="pw" size="25" maxlength="64">
                    </div>
                    <div>
                        <!-- 
                        Below is just so I can use bootstrap's 'btn', which oddly 
                        enough doesn't work when the class name is on the actual button.
                        Excessive use of divs should be a crime.
                    -->
                        <div class="btn">
                            <button id="formSubmit" type="submit">Login</button>
                        </div>
                        <span class="rightjust new-href">New?
                            <a href="newacct.php">Create a new acct</a>
                        </span>
                    </div>
                </form>
            </div>

            <div id="divErr">
                <p id="errMsg" class="err"></p>
            </div>

            <!-- The width of textarea will be set in js, depends on size of div -->
            <div class="pg4 results p-3">
                <h5>Your login ID and name.</h5>
                <textarea class="results-textarea" rows="10"></textarea>
            </div>

        </div>
        <!-- end big picture thing -->

    </div>
    <!-- end container -->

    <?php include ("footer.html"); ?>

    <script src="js/myvalidate.js"></script>
    <script src="js/mylogin.js"></script>

    <script>
        $(function() {

            let $divsize = $('.results').width();

            $('.results-textarea').width($divsize - 32);
        })
    </script>

</body>

</html>