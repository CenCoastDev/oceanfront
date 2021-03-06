<!DOCTYPE html>
<html lang="en">

<head>
    <!--
	Mark Whitcomb
	10/10/2019
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
                Create A New Account
            </h3>

            <div class="pg4 newacct-form p-3">
                <h5>New Account</h5>
                <form id="newAcct" action="" method="post" onsubmit="return false">
                    <div class="form-group">
                        <label class="form-control-label" for="userid">ID</label>
                        <input type="text" class="form-control" name="userid" data-form-field="userid" required id="userid" size="20" maxlength="64">
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="pass">Password</label>
                        <input type="text" class="form-control" name="pass" data-form-field="pass" required id="pass" size="25" maxlength="64">
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="first">First Name</label>
                        <input type="text" class="form-control" name="first" data-form-field="first" required id="first" size="20" maxlength="25">
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="last">Last Name</label>
                        <input type="text" class="form-control" name="last" data-form-field="last" required id="last" size="35" maxlength="40">
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="email">Email</label>
                        <input type="text" class="form-control" name="email" data-form-field="email" id="email" size="50" maxlength="65">
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="street">Street Address</label>
                        <input type="text" class="form-control" name="street" data-form-field="street" id="street" size="50" maxlength="65">
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="city">City</label>
                        <input type="text" class="form-control" name="city" data-form-field="city" id="city" size="30" maxlength="45">
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="state">State</label>
                        <input type="text" class="form-control" name="state" data-form-field="state" id="state" size="4" maxlength="2">
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="zip">ZIP</label>
                        <input type="text" class="form-control" name="zip" data-form-field="zip" id="zip" size="12" maxlength="10">
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="phone">Phone</label>
                        <input type="text" class="form-control" name="phone" data-form-field="phone" id="phone" size="12" maxlength="12">
                    </div>
                    <div class="btn">
                        <button id="formNewAcct" type="submit">Create</button>
                    </div>
                </form>
            </div>

            <div id="divErr">
                <p id="errMsg" class="err"></p>
            </div>

            <!-- The width of textarea will be set in js, depends on size of div -->
            <div class="pg4 results p-3">
                <h5>Below is an area used for messages.</h5>
                <textarea class="results-textarea" rows="3"></textarea>
            </div>

        </div>
        <!-- end big picture thing -->

    </div>
    <!-- end container -->

    <?php include ("footer.html"); ?>
    
    <script src="js/myvalidate.js"></script>
    <script src="js/mynewacct.js"></script>
    <script>
        $(function() {

            let $divsize = $('.results').width();

            $('.results-textarea').width($divsize - 32);
        })
    </script>

</body>

</html>