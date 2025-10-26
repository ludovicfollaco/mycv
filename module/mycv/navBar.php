<div class="d-flex justify-content-center bg-body-tertiary py-2">

    <nav class="navbar navbar-expand-lg bg-body-tertiary p-0 m-0">

        <div class="d-flex flex-column align-items-center">

            <a class="navbar-brand text-light" href="index.php?page=home"></a>
            <button
                class="navbar-toggler bg-corps-tertiaire mb-2"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">

                <ul class="navbar-nav">
                
                    <li class="nav-item custom-border-md-bottom">
                        <a class="nav-link" aria-current="page" href="index.php?page=home">
                            <img class="p-2 h-75" src="img/common/icon/black_house.svg" alt="icone du bouton s'identifier">
                            Accueil
                        </a>
                    </li>
                    
                    <li class="nav-item custom-border-md-bottom">
                        
                        <a class="nav-link" aria-current="page" href="index.php?page=mycv">
                            <img class="p-2 h-75" src="img/common/icon/black_calendar2-event.svg" alt="icone du bouton pacours professionnel">    
                            <span class="Nav_Span1">Parcours<br><span class="Nav_Span2">professionnel</span></span>
                        </a>

                    </li>
                    
                    <li class="nav-item custom-border-md-bottom">
                        
                        <a class="nav-link" aria-current="page" href="index.php?page=network">
                            <img class="p-2 h-75" src="img/common/icon/news.svg" alt="icone du bouton la presse en parle">    
                            <span class="Nav_Span1">La presse<br><span class="Nav_Span2">en parle</span></span>
                        </a>

                    </li>

                    <li class="nav-item dropdown custom-border-md-bottom">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img class="p-2 h-75" src="img/common/icon/columns_black.svg" alt="icone du menu my apps">
                            <span class="Nav_Span1">My apps<br><span class="Nav_Span2">Testez les!<?php //if($_SESSION['dataConnect']['pseudo']!= 'Guest'){echo 'Hello ' . $_SESSION['dataConnect']['pseudo'] . ' !';}?></span></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item Nav_Span1" href="goldorak.php?page=home" target="_blank">
                                    <img class="p-2" src="../img/common/icon/avatar_goldorak_01.webp" alt="icone du bouton goldorak" style="width:30px;">    
                                    Goldorak
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item Nav_Span1" href="garageparrot.php?page=home" target="_blank">
                                    <img class="p-2" src="../img/common/icon/garage_black_75x75.webp" alt="icone du bouton garage parrot" style="width:30px;">    
                                    Garage Parrot
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown custom-border-md-bottom">

                        <a class="nav-link dropdown-toggle" href="" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img class="p-2 h-75" src="img/common/icon/person-vcard.svg" alt="icone du bouton s'identifier">
                            <span class="Nav_Span1">Contactez<br><span class="Nav_Span2">Moi!</span></span>
                        </a>
                        
                        <ul class="dropdown-menu">

                            <li>
                                <a class="dropdown-item Nav_Span1" href="tel:0608818390">
                                    <img class="p-2 h-75" src="img/common/icon/black_telephone.svg" alt="icone du bouton s'identifier">
                                    <span class="Nav_Span2">06.08.81.83.90</span></span>
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item Nav_Span1" href="index.php?page=contact">
                                    <img class="p-2 h-75" src="img/common/icon/envelope-at.svg" alt="icone du bouton s'identifier">
                                    <span class="Nav_Span2">Formulaire de contact</span></span>
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item Nav_Span1" href="https://www.linkedin.com/in/ludovic-follaco-a74b5394/" target="_blank">
                                    <img class="p-2 h-75" src="img/common/icon/linkedin.svg" alt="icone du bouton s'identifier">
                                    <span class="Nav_Span2">Mon Linkedin</span></span>
                                </a>
                            </li>

                        </ul>

                    </li>
                    
                    <li class="nav-item dropdown custom-border-md-bottom">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <!-- <img class="p-2 h-75" src="img/common/icon/<?php //echo $_SESSION['dataConnect']['avatar']; ?>" alt="icone du menu s'identifier"> -->
                            <img class="p-2 h-75" src="img/common/avatar/<?php echo htmlspecialchars($_SESSION['dataConnect']['avatar'], ENT_QUOTES, 'UTF-8'); ?>" alt="icone du menu s'identifier">

                            <span class="Nav_Span1">Mon compte<br><span class="Nav_Span2"><?php if($_SESSION['dataConnect']['pseudo'] != 'Guest'){echo 'Hello ' . $_SESSION['dataConnect']['pseudo'] . ' !';}else{echo 'Hello Guest !';} ?></span></span>
                        </a>
                        <ul class="dropdown-menu">
                        <?php if(!$_SESSION['dataConnect']['connexion']){ ?>
                            <li>
                                <a class="dropdown-item Nav_Span1" href="index.php?page=connexion">
                                    <img class="p-2" src="img/common/icon/login_25x25.webp" alt="icone du bouton s'identifier">    
                                    Connexion
                                </a>
                            </li>
                        <?php } ?>
                        <?php if($_SESSION['dataConnect']['connexion']){ ?>
                            <li>
                                <a class="dropdown-item Nav_Span1" href="index.php?page=disconnect">
                                    <img class="p-2" src="img/common/icon/logout_25x25.webp" alt="icone du bouton s'identifier">    
                                    Déconnexion
                                </a>
                            </li>
                        <?php } ?>
                        </ul>
                    </li>

                </ul>

            </div>

        </div>

    </nav>

</div>