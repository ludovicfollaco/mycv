<?php
    require_once('../controller/common/userPwSentEmail.controller.php');

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
                action="<?php echo $theSite . '.php?page=userPwRequestNew'; ?>"
                method="post"
            >

                <input type="hidden" name="csrf" value="<?php echo Utilities::escapeInput($_SESSION['token']['csrf']); ?>">

                <fieldset class="bg-dark bg-opacity-75 rounded-4 p-5">
                    
                    <legend class="text-center text-light mb-3" >Recover your password <br> Récupérer votre mot de passe</legend>

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

                    <div class="form-group my-5">

                        <input
                            class="btn btn-lg btn-primary"
                            type="submit"
                            name="pwForgot"
                            id="pwForgot"
                            value="envoyer"
                        >

                    </div>

                </fieldset>

                <div style='color:red;'>
                    <p class=" text-center fs-2 pt-3"> <?php echo htmlspecialchars_decode($_SESSION['other']['message']); ?> </p>
                </div>

            </form>

        </div>

    </div>

</div>