<?php
    require_once('../controller/common/connexion.controller.php');

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
 <!-- "index.php?page=connexion" -->
            <form
                action="<?php echo $theSite . '.php?page=connexion'; ?>"
                method="post"
            >

                <input type="hidden" name="csrf" value="<?php echo Utilities::escapeInput($_SESSION['token']['csrf']); ?>">

                <fieldset class="bg-dark bg-opacity-75 rounded-4 p-5">
                    
                    <legend class="text-center text-light mb-3" >Connexion</legend>

                    <div class="form-group mb-3">

                        <label class="text-light w-100" for="email">email</label>

                        <input
                            class=""
                            type="email"
                            id="email"
                            name="email"
                            placeholder="Saisissez votre email"
                        >

                    </div>

                    <div class="form-group mb-3">

                        <label class="text-light w-100" for="password">mot de passe</label>

                        <input
                            class=""
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Saisissez votre mot de passe"
                        >

                    </div>

                    <div class="form-group my-5">

                        <input
                            class="btn btn-lg btn-primary"
                            type="submit"
                            name="envoyer"
                            id="envoyer"
                            value="Se connecter"
                        >

                    </div>

                </fieldset>

                <div style='color:red;'>
                    <p class=" text-center fs-2 pt-3"> <?php echo $_SESSION['other']['message'] != '' ? htmlspecialchars_decode($_SESSION['other']['message']) : '' ?> </p>
                    <p class=" text-center fs-2 pt-3"> <?php echo $_SESSION['other']['messagePw'] != '' ? htmlspecialchars_decode($_SESSION['other']['messagePw']) : '' ?> </p>
                </div>

                <div class="d-flex justify-content-center pb-5"><a href="<?php echo $theSite . '.php?page=userPwRequestNew'; ?>">Mot de passe oublié ?</a></div>

            </form>

        </div>

    </div>

</div>

<?php
    $_SESSION['other']['message'] = '';
    $_SESSION['other']['messagePw'] = '';
?>