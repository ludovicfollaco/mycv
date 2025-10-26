<?php

	$urlImg = '../img/common/avatar/';
    $page_ = 'index';
    if(preg_match('/goldorak/', $_SERVER['REQUEST_URI'])){

        $urlImg = '../img/common/avatar/';
        $page_ = 'goldorak';

	}if(preg_match('/garageparrot/', $_SERVER['REQUEST_URI'])){

        $urlImg = '../img/common/avatar/';
        $page_ = 'garageparrot';
	}

    require_once('../controller/common/user.controller.php');

    use Model\Utilities\Utilities;
?>

<div class="mt-5">
    <?php require_once('../module/common/searchUser.php'); ?>
</div>

<div class="mt-3">
    <?php require_once('../module/common/select_page.php'); ?>
</div>

<div class="container">

    <section class="d-flex flex-wrap justify-content-center align-items-center m-0 p-0">

    <?php for($i=0;$i != count($users);$i++) { ?>

    <article class="border rounded-4 px-3 m-4">

        <form action="<?php echo $page_ . '.php?page=userEdit'; ?>" method="post">

            <div class="d-flex justify-content-center div__Car--img mt-3">
                <img src= "<?php echo $urlImg . Utilities::escapeInput($users[$i]['avatar']); ?>" alt="Avatar de l'utilisateur" style="width:70px; height: 70px; object-fit: cover;">
            </div>

            <div class="div__user--img">

                <table class='table__user--img'>

                    <tr>
                        <td class="tdLabel text-end text-light border border-0 pe-1">ID:</td>
                        <td class="tdText border border-0"><input type="text" name='txt_userEdit_id'  class="bg-transparent text-light text-start ps-2" readonly value='<?php echo Utilities::escapeInput($users[$i]['id_user']);?>'></td>
                    </tr>

                    <tr>
                        <td class="tdLabel text-end border border-0 pe-1">Nom:</td>
                        <td class="tdText border border-0"><input type="text" name="txt_user_name" class="bg-transparent text-light text-start ps-2" readonly value='<?php echo Utilities::escapeInput($users[$i]['name']);?>'></td>
                    </tr>

                    <tr>
                        <td class="tdLabel text-end border border-0 pe-1">Prénom:</td>
                        <td class="tdText border border-0"><input type="text" name="txt_user_surname" class="bg-transparent text-light text-start ps-2" readonly value='<?php echo Utilities::escapeInput($users[$i]['surname']);?>'></td>
                    </tr>

                </table>
            </div>

            <div class="div__user--data">

                <table class='table__user--data'>

                    <tr>
                        <td class="tdLabel text-end border border-0 pe-1">Pseudo:</td>
                        <td class="tdText border border-0"><input type="text" name="txt_user_pseudo" class="bg-transparent text-light text-start ps-2" readonly value='<?php echo Utilities::escapeInput($users[$i]['pseudo']);?>'></td>
                    </tr>

                    <tr>
                        <td class="tdLabel text-end border border-0 pe-1">Email:</td>
                        <td class="tdText border border-0"><input type="email" name="txt_user_email" class="bg-transparent text-light text-start ps-2" readonly value='<?php echo Utilities::escapeInput($users[$i]['email']);?>'></td>
                    </tr>

                    <tr>
                        <td class="tdLabel text-end border border-0 pe-1">Phone:</td>
                        <td class="tdText border border-0"><input type="tel" name="txt_user_phone" class="bg-transparent text-light text-start ps-2" readonly value='<?php echo Utilities::escapeInput($users[$i]['phone']);?>'></td>
                    </tr>

                    <tr>
                        <td class="tdLabel text-end border border-0 pe-1">Formule:</td>
                        <td class="tdText border border-0"><input type="tel" name="txt_user_formule" class="bg-transparent text-light text-start ps-2" readonly value='<?php echo Utilities::escapeInput($users[$i]['subscription']);?>'></td>
                    </tr>

                    <tr>
                        <td class="tdLabel text-end border border-0 pe-1">Type:</td>
                        <td class="tdText border border-0"><input type="tel" name="txt_user_type" class="bg-transparent text-light text-start ps-2" readonly value='<?php echo Utilities::escapeInput($users[$i]['type']);?>'></td>
                    </tr>

                </table>

            </div>

        <?php
        if($_SESSION['dataConnect']['type'] != 'Guest'){

        ?>
            <div class="d-flex justify-content-center my-2">
                <button type="submit" class='btn btn-primary fs-3 mt-3' name='btn_userEdit'>Editer</button>
            </div>

        <?php
        }
        ?>
    </form>
        <?php
        if($_SESSION['dataConnect']['type'] === 'Guest'){

        ?>
            <div class="d-flex justify-content-center my-2">
                <button type="submit" class='btn btn-primary fs-3 mt-3' name='btn_user_editMember'>Editer</button>
            </div>
            
        <?php
        }
        ?>

</article>

<?php } ?>

    </section>
</div>

<div class="mb-5">
    <?php require_once('../module/common/select_page.php'); ?>
</div>
