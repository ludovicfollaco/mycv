<?php
    require_once('../controller/common/userPwReset.controller.php');

    use Model\Utilities\Utilities;

    $theSite = 'index';
    if(Utilities::checkValueInUrl('goldorak')){
        $theSite = 'goldorak';
    }else if(Utilities::checkValueInUrl('garageparrot')){
        $theSite = 'garageparrot';
    }
?>

<div class="container">

    <div class="row">
        
        <div class="d-flex flex-column justify-content-center align-items-center">
            <form
                action="<?php echo $theSite . '.php?page=userPwResetNew'; ?>"
                method="post"
            >

                <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
                
                <fieldset class="bg-dark bg-opacity-75 rounded-4 p-5">
                    
                    <legend class="text-center text-light mb-3" >Reset your password <br> Réinitialisez votre mot de passe</legend>

                    <div class="form-group mb-3">

                        <label class="text-light w-100" for="password">Nouveau mot de passe</label>

                        <input
                            class=""
                            type="password"
                            id="password"
                            name="password"
                            required
                            placeholder="Saisissez votre mot de passe"
                        >

                    </div>

                    <div class="form-group mb-3">

                        <label class="text-light w-100" for="confirmPw">Confirmer mot de passe</label>

                        <input
                            class=""
                            type="password"
                            id="confirm_password"
                            name="confirm_password"
                            required
                            placeholder="Confirmez votre mot de passe"
                        >

                    </div>

                    <div class="form-group my-5">

                        <input
                            class="btn btn-lg btn-primary"
                            type="submit"
                            name="pwChange"
                            id="pwChange"
                            value="envoyer"
                        >

                    </div>

                </fieldset>

                <div style='color:red;'>
                    <p class=" text-left fs-4 pt-3">
                        <?php
                            echo $_SESSION['other']['messagePw'] != '' ?
                                 $_SESSION['other']['messagePw'] :
                                 'Le mot de passe doit contenir au moins 13 caratères,<br>
                                 dont 1 majuscule, 1 minuscule, 1 chiffre et<br>
                                 1 caractère spécial parmis les suivants /*-.!?@';
                        ?>
                    </p>
                </div>

            </form>

            <p></p>

        </div>

    </div>

</div>