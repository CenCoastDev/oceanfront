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

        <div class="jumbotron text-center my-bgimg3">
            <h3 class="words-up-front">
                Why Do It?
            </h3>
        </div>
        <!-- end big picture thing -->

        <div class="col-12 p-3 alt-bg1">
            <h4>Why waste so much time and energy on this?</h4>

            <p>
                Why do this when I could have just gone to (...) and set up a FREE website within minutes?
                <br />
                <br /> I could have gone this direction but, like you, I wanted control.
                <br />
                <br /> You will, at one point look at your own website and say 'That looks ok, but I want to change...' and the fine people at (...) will say 'You want what? That'll cost you extra.' Per month. You want this other custom thing? Well, you'll
                have to hire an 'expert' at their per-hour billing rate plus pay this extra - per month - fee.
                <br />
                <br /> Don't forget - you don't own this site - it's owned by (...), it's not yours. It can't be moved to another (cheaper) hosting provider. You are free to go another direction, but you'll be doing your site over from scratch.
                <br />
                <br /> (...) is the biggest rubber-stamp cookie cutter generic all-in-one company out there but even the big guys fall. Just look at my Myspace page. Oh - I forgot - it's gone. Sometimes your favorite company gets bought out, changes hands
                or goes under. Where's your website then?<br />
                <br />
                <br /> (from Wikipedia, 'Myspace was the largest social networking site in the world from 2005 to 2008' https://en.wikipedia.org/wiki/Myspace )
                <br />
                <br /> And then there's the 'weight' of templated websites. I just loaded a (...) website and I'm looking at 87 requests to load files, 53 of them are just js files.
                <br /> When I load another site using one of the most popular website templates, WordPress, I see 44 requests and 9 js files. Of course, a WordPress site I started in 2018 with a simple template, no add-ins is about 3,067 files. A lot
                of php.
            </p>

        </div>
        <!-- the main part where you enter stuff -->

    </div>
    <!-- end container -->

    <?php include ("footer.html"); ?>

</body>

</html>