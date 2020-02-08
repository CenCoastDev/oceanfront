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

        <div class="jumbotron text-center my-bgimg2">
            <h3 class="words-up-front">
                What Is This For?
            </h3>
        </div>
        <!-- end big picture thing -->

        <div class="col-12 p-3 alt-bg1">
            <h4>What is the purpose of this website?</h4>

            <p>
                The purpose of this website is just to give an anonymous software coder a place to try things out. Specifically, trying to create an efficient website that's responsive (a buzzword) to mobile.
                <br />
                <br /> It hasn't been easy. There's a lot to website development, like:
                <ul>
                    <li>HTML 5</li>
                    <li>CSS 3</li>
                    <li>Bootstrap 4 (that's what I concentrated on mostly for this site)</li>
                    <li>javascript (yes, the language. I didn't know a bit of it before.)</li>
                    <li>ECMAScript version...who knows by now</li>
                    <li>TypeScript</li>
                    <li>jQuery</li>
                    <li>jQuery Validation (or validate.js or Parsley or..?)</li>
                    <li>AJAX (I know, it's not a language it's...(?)</li>
                    <li>JSON (Again, I know, it's not a language)</li>
                    <li>Moment.js</li>
                    <li>ReactJS</li>
                    <li>Node.js</li>
                    <li>Angular</li>
                    <li>Express</li>
                    <li>Vue</li>
                    <li>Modernizr</li>
                    <li>npm to get all the node.js shtuff working</li>
                    <li>Passport (I think / hope that's where authentication will be)</li>
                    <li>And many more...</li>
                </ul>
                <br />How hard is this?
                <br /><br /> I've spent - literally - days trying to do something as moronically insignificant as getting rid of an orange dotted outline on the collapse/expand 'X' thing when in mobile view.
                <br /><br /> This 'front-end website development' stuff sucks.
            </p>

        </div>
        <!-- the main part where you enter stuff -->

    </div>
    <!-- end container -->

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

</body>

</html>