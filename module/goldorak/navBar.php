<nav class="navbar navbar-expand-lg mx-auto mt-auto mb-3 ">

    <div class="d-flex flex-column align-items-center">

        <a class="navbar-brand text-light" href="goldorak.php?page=home"></a>
        <button
            class="navbar-toggler bg-primary"
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
                    <a class="nav-link active text-light" aria-current="page" href="goldorak.php?page=home">
                        <img class="p-2 h-75"
                             src="../img/common/icon/house.svg"
                             alt="icone accueil"
                        >
                        <span class="Nav_Span1">Accueil</span>
                    </a>
                </li>
                
                <li class="nav-item dropdown custom-border-md-bottom">
                    <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img class="p-2 h-75"
                             alt="icone événements"
                             src="../img/common/icon/calendar2-event.svg"
                        >
                        <span class="Nav_Span1">Evénements</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item text-light" href="goldorak.php?page=events">
                                <img class="p-0 pe-2 mb-1" src="../img/common/icon/calendar2-event.svg" alt="icone consulter événements">  
                                Consulter
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item text-light" href="goldorak.php?page=events#SalonDeParis2023">
                                <img class="p-0 pe-2 mb-1" src="../img/common/icon/incognito.svg" alt="icone Manga Paris 2023">  
                                Manga Paris 2023
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item text-light" href="goldorak.php?page=events#SalonJapanExpo2024">
                                <img class="p-0 pe-2 mb-1" src="../img/common/icon/tencent-qq.svg" alt="icone Japan Expo 2024">  
                                Japan Expo 2024
                            </a>
                        </li>
                    </ul>
                </li>

            <?php if($_SESSION['dataConnect']['type'] === 'Administrator' || $_SESSION['dataConnect']['type'] === 'Member'){ ?>
                <li class="nav-item dropdown custom-border-md-bottom">
                    <a class="nav-link active text-light" aria-current="page" href="goldorak.php?page=media">
                        <img class="p-2 h-75"
                             src="../img/common/icon/card-image.svg"
                             alt="icone médias"
                        >
                        <span class="Nav_Span1">Médias</span>                        
                    </a>
                </li>
            <?php } ?>
            
            <?php if($_SESSION['dataConnect']['subscription'] != 'Vénusia' && $_SESSION['dataConnect']['type'] != 'User' && $_SESSION['dataConnect']['type'] != 'Guest'){ ?>
                <li class="nav-item dropdown custom-border-md-bottom">
                    <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img class="p-2 h-75"
                             alt="icone joystick du menu jeux"
                             src="../img/common/icon/joystick.svg"
                        >
                        <span class="Nav_Span1">Jeux</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item text-light" href="goldorak.php?page=goldorakgo">
                                <img class="p-0 pe-2 mb-1" src="../img/common/icon/crosshair2.svg" alt="icone du jeu goldorak go">    
                                Goldorak Go
                            </a>
                        </li>
                    <?php if($_SESSION['dataConnect']['subscription'] === 'Goldorak' ){ ?>
                        <li>
                            <a class="dropdown-item text-light" href="goldorak.php?page=commander">
                                <img class="p-0 pe-2 mb-1" src="../img/common/icon/dice-6.svg" alt="icone du jeu my commendeur">    
                                My Commander
                            </a>
                        </li>
                    <?php } ?>
                    </ul>
                </li>
            <?php } ?>
                
            <?php if($_SESSION['dataConnect']['type'] === 'Administrator'){ ?>
                <li class="nav-item dropdown custom-border-md-bottom">
                    <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img class="p-2 h-75"
                             alt="icone du bouton profil"
                             src="../img/common/icon/people.svg"
                        >
                        <span class="Nav_Span1">Profils</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>    
                            <a class="dropdown-item text-light" href="goldorak.php?page=user">
                                <img class="pe-2 mb-1" src="../img/common/icon/search.svg" alt="icone consulter les profils">
                                Consulter
                            </a>
                        </li>
                        <li>
                            <form action="goldorak.php?page=userEdit" method="post">
                                <button class="dropdown-item text-light" id="btn_navBar_new" name="btn_navBar_new" type="submit">
                                    <img class="pe-2 mb-1" src="../img/common/icon/person-plus.svg" alt="icone nouveau profil">
                                    Nouveau
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            <?php } ?>
                
                <li class="nav-item dropdown custom-border-md-bottom">
                    <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img class="p-2 h-75"
                            alt="icone du l'utilisateur"
                            src="<?php
                                    if($_SESSION['dataConnect']['type'] === 'Administrator'){
                                        echo "../img/common/avatar/avatar_admin_white.webp";

                                    }else if($_SESSION['dataConnect']['type'] != 'Guest'){
                                        echo "../img/common/avatar/" . $_SESSION['dataConnect']['avatar'];

                                    }else{
                                        echo "../img/common/icon/person.svg"; 
                                    }
                                ?>"
                        >
                        <span class="Nav_Span1">Mon compte<br><span class="Nav_Span2"><?php if($_SESSION['dataConnect']['pseudo']!= 'Guest'){echo 'Hello ' . $_SESSION['dataConnect']['pseudo'] . ' !';}?></span></span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php if($_SESSION['dataConnect']['type'] === 'Guest'){ ?>
                        <li>
                            <a class="dropdown-item Nav_Span1 text-light" href="goldorak.php?page=connexion">
                                <img class="p-2" src="../img/common/icon/box-arrow-in-left.svg" alt="icone du bouton connexion">    
                                Connexion
                            </a>
                        </li>
                        <?php } ?>
                        <?php if($_SESSION['dataConnect']['type'] != 'Guest'){ ?>
                        <li>
                            <a class="dropdown-item text-light" href="goldorak.php?page=disconnect">
                                <img class="p-2" src="../img/common/icon/box-arrow-right.svg" alt="icone du bouton déconnexion">    
                                Déconnexion
                            </a>
                        </li>
                        <?php } ?>
                    <?php if($_SESSION['dataConnect']['type'] != 'Guest' && $_SESSION['dataConnect']['pseudo'] != 'Admin'){ ?>
                        <li>
                            <form action="goldorak.php?page=userEdit" method="post">
                                <button class="dropdown-item text-light" type="submit" name="btn_monCompte">
                                    <img class="p-2" src="../img/common/icon/person-gear.svg" alt="icone du bouton mon compte">    
                                    Mon compte
                                </button>
                            </form>
                        </li>
                    <?php } ?>
                    
                    <?php if($_SESSION['dataConnect']['type'] === 'Guest'){ ?>
                        <li>
                            <a class="dropdown-item text-light" href="goldorak.php?page=adherer">
                                <img class="p-0 m-0 pe-2" src="../img/common/icon/pencil-square.svg" alt="icone du bouton adhérer">    
                                Adhérer
                            </a>
                        </li>
                    <?php } ?>
                    </ul>
                </li>

            </ul>

        </div>

    </div>

</nav>