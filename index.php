<!DOCTYPE html>
<html lang="en">

<head>
    <!--
	Mark Whitcomb
	6/7/2019
    Copyright
    2/8/2020 Rename from index.html to index.php
    just so I can use the fucking 'php include' syntax
    to include common html in a used-by-all html file.
    Fuck You Very Much front-end development environment.
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

        <div class="jumbotron my-bgimg1">
            <h3>
                We all know California is just one earthquake away from falling into the Pacific Ocean. Act now and get prime real estate in the next new hot market!
            </h3>
        </div>
        <!-- end big picture thing -->

        <div class="col-12 alt-bg1">
            <h4>Diffie - Hellman Key Exchange</h4>

            <p>
                This is the infamous public/private key generation algorithm from 1976 which lets you generate a shared secret key without sending the secret key. Basically, A^b mod p = B^a mod p
                <br /> where A, B and p are public and a and b are secret.
                <br />
                <br /> To get there, I need to do a little different calculation. I need to:
                <br /> Get a prime number n 2^size of mod p in bits. This is going to be the 'prime modulo number'.
                <br /> then do the math of 'base g taken to the power of Alice's secret number modulo the prime modulo number. Do the same with Bob's secret number.
            </p>

            <div id="divErr">
                <p id="errMsg" class="err"></p>
            </div>

            <form id="dhPrep" action="" method="post" onsubmit="return false" data-form-title="Calculate DH values">

                <div class="row row-sm-offset">
                    <div class="col-md-3" data-for="baseG" autofocus>
                        The base number is usually one of the numbers shown below.
                        <br />
                        <div class="form-group form-check-inline">
                            <label class="btn btn-default active form-control-label">
                                <input type="radio" name="baseG" checked value="3">&nbsp;&nbsp;3
                            </label>
                            <label class="btn btn-default form-control-label">
                                <input type="radio" name="baseG" value="5">&nbsp;&nbsp;5
                            </label>
                            <label class="btn btn-default form-control-label">
                                <input type="radio" name="baseG" value="7">&nbsp;&nbsp;7
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4 multi-horizontal" data-for="modPSize">
                        This should be a power of 2 like 16, 32, 64, 128, 256, 512, 1024. I'm going to calculate something like '3 to the power of 256', so this is going to calculate out to be a really big number.
                        <br />
                        <div class="form-group">
                            <label class="form-control-label " for="modPSize">size of mod p</label>
                            <input type="number" class="form-control" name="modPSize" data-form-field="modPSize" required id="modPSize">
                        </div>
                    </div>
                    <div class="col-md-6 multi-horizontal" data-for="aSecret">
                        <div class="form-group">
                            <label class="form-control-label " for="aSecret">Alice's secret number</label>
                            <input type="text" class="form-control" name="aSecret" data-form-field="aSecret" required id="aSecret">
                        </div>
                    </div>
                    <div class="col-md-6 multi-horizontal" data-for="bSecret">
                        <div class="form-group">
                            <label class="form-control-label " for="bSecret">Bob's secret number</label>
                            <input type="text" class="form-control" name="bSecret" data-form-field="bSecret" required id="bSecret">
                        </div>
                    </div>
                </div>

                <span class="input-group-btn">
				    <button id="formSubmit" type="submit" class="btn btn-primary btn-form">Calculate</button>
			    </span>

            </form>


        </div>
        <!-- the main part where you enter stuff -->


        <div class="col-12 alt-bg1">
            <h4>Results</h4>
            <p>
                Below we have a few numbers.
                <ul>
                    <li>The first is a random prime number</li>
                    <li>Next is Alice's computed public key</li>
                    <li>Followed by Bob's computed public key</li>
                    <li>The last two numbers should match, and is the actual secret key shared by both Alice and Bob.</li>
                </ul>
            </p>
            <textarea rows="7" id="theReturn" style="min-width: 100%"></textarea>

        </div>
        <!-- the results -->

    </div>
    <!-- end container -->

    <!--
            This is one way of getting a simple html file into an html file,
            but the drawback is you can't 'debug' the html in any browser based
            developer tool.  You can't see the html in 'footer.html'.
            
            <span id="myfooter"></span>
            <script type="text/javascript">
                $("#myfooter").load("footer.html");
            </script>
        -->
    <!-- 
            So, I'm left with the simple thing below.
            It's easy, takes one line and you can see what it does.
            However...this now means I need to convert each and every
            file ending in .html to end with .php.  I don't want to 
            do that because the whole fucking purpose of this exercise
            was to show that everything could be done with simple html
            and css.  That's going out the window if I have to make 
            all files end in .php.  
        -->
    <?php include ("footer.html"); ?>

    <script src="js/mynav.js"></script>
    <script src="js/myvalidate.js"></script>
    <script src="js/dhprep.js"></script>

</body>

</html>