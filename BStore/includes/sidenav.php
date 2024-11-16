<div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="dashboard.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading">Interface</div>                         
                            <div aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="books-listview.php">
                                        <i class="fas fa-book-open p-2"></i> 
                                          Books
                                    </a>
                                    <a class="nav-link" href="publications-listview.php">
                                        <i class="fas fa-eye p-2"></i> 
                                          Publications
                                    </a>
                                    <a class="nav-link" href="authors-listview.php">
                                        <i class="fas fa-users p-2"></i>
                                          Authors
                                    </a>
                                </nav>
                            </div> 
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        <?php
                             echo $_SESSION['username']; 
                        ?>
                    </div>
                </nav>
            </div>