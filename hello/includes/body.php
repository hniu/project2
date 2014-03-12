</head>
<body>
    <div id="background_overlay" style="display:none"></div>
    <section id="header" class="clearfix">
        <div class="container">
            <header>
                <div id="logo">Hello Courses!</div>
            </header>
            <div align="center">
                <nav class="clearfix">
                    <ul class="clearfix">
                        <li><a href="dashboard.php" class="box">DASHBOARD</a></li>
                        <li><a href="addCourses.php" class="box">ADD COURSES</a></li>
                        <li><a href="schedule.php?id=<?php echo $trackid ?>" id='schedulelink' class="box">DEGREE OUTLOOK</a></li>
                        <li><a href="courseratings.php" class="box">COURSE RATINGS</a></li>
                    </ul>
                    <a href="#" id="pull">&nbsp;</a>
                </nav>
            </div>
        </div>
    </section>
    <div id="contentdash">
        <div id="user">
            Welcome, <b><?php echo $name?></b>! <a href="core/logout.php">logout</a>
        </div>
            <div id="loadit" style="display:none;">
            	
        <section id="home">
            <div align="center">

