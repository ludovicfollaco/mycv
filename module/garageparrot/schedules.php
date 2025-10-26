<?php
    require_once('../controller/garageparrot/schedules.controller.php');
?>

<table class="table table-dark table-bordered fs-4">
    <thead>
        <tr>
            <td colspan="3" class="text-center fs-4">Horaires d'ouverture</td>
        </tr>
        <tr>
            <th class="text-center fs-4">Jour</th>
            <th class="text-center fs-4">Matin</th>
            <th class="text-center fs-4">Après-midi</th>
        </tr>
    <thead>
    <tbody>
        <form action="../" method="post">
            <tr class="table-active">
                <td class="fs-4" style="text-align: right;">Lundi</td>
                <td class="text-center">
                    <input class="form-control fs-4 <?php if($_SESSION['dataConnect']['avatar'] != 'Administrator'){echo 'bg-transparent text-light';} ?> text-center border border-0" id="txt_shedules_lundiMatin" name="txt_shedules_lundiMatin" type="text" <?php if($_SESSION['dataConnect']['avatar'] != 'Administrator'){echo 'readonly';} ?> value="<?php echo $horaires['lundiMatin']; ?>">
                </td>    
                <td class="text-center">
                    <input class="form-control fs-4 <?php if($_SESSION['dataConnect']['avatar'] != 'Administrator'){echo 'bg-transparent text-light';} ?> text-center border border-0" id="txt_shedules_lundiAM" name="txt_shedules_lundiAM" type="text" <?php if($_SESSION['dataConnect']['avatar'] != 'Administrator'){echo 'readonly';} ?> value="<?php echo $horaires['lundiAM']; ?>">
                </td>
            </tr>
            <tr class="table-active">
                <td class="fs-4" style="text-align: right;">Mardi</td>
                <td class="text-center">
                    <input class="form-control fs-4 <?php if($_SESSION['dataConnect']['avatar'] != 'Administrator'){echo 'bg-transparent text-light';} ?> text-center border border-0" id="txt_shedules_mardiMatin" name="txt_shedules_mardiMatin" type="text" <?php if($_SESSION['dataConnect']['avatar'] != 'Administrator'){echo 'readonly';} ?> value="<?php echo $horaires['mardiMatin']; ?>">
                </td>    
                <td class="text-center">
                    <input class="form-control fs-4 <?php if($_SESSION['dataConnect']['avatar'] != 'Administrator'){echo 'bg-transparent text-light';} ?> text-center border border-0" id="txt_shedules_mardiAM" name="txt_shedules_mardiAM" type="text" <?php if($_SESSION['dataConnect']['avatar'] != 'Administrator'){echo 'readonly';} ?> value="<?php echo $horaires['mardiAM']; ?>">
                </td>
            </tr>
            <tr class="table-active">
                <td class="fs-4" style="text-align: right;">Mercredi</td>
                <td class="text-center fs-4">
                    <input class="form-control fs-4 <?php if($_SESSION['dataConnect']['avatar'] != 'Administrator'){echo 'bg-transparent text-light';} ?> text-center border border-0" id="txt_shedules_mercrediMatin" name="txt_shedules_mercrediMatin" type="text" <?php if($_SESSION['dataConnect']['avatar'] != 'Administrator'){echo 'readonly';} ?> value="<?php echo $horaires['mercrediMatin']; ?>">
                </td>    
                <td class="text-center fs-4">
                    <input class="form-control fs-4 <?php if($_SESSION['dataConnect']['avatar'] != 'Administrator'){echo 'bg-transparent text-light';} ?> text-center border border-0" id="txt_shedules_mercrediAM" name="txt_shedules_mercrediAM" type="text" <?php if($_SESSION['dataConnect']['avatar'] != 'Administrator'){echo 'readonly';} ?> value="<?php echo $horaires['mercrediAM']; ?>">
                </td>
            </tr>
            <tr class="table-active">
                <td class="fs-4" style="text-align: right;">Jeudi</td>
                <td class="text-center">
                    <input class="form-control fs-4 <?php if($_SESSION['dataConnect']['avatar'] != 'Administrator'){echo 'bg-transparent text-light';} ?> text-center border border-0" id="txt_shedules_jeudiMatin" name="txt_shedules_jeudiMatin" type="text" <?php if($_SESSION['dataConnect']['avatar'] != 'Administrator'){echo 'readonly';} ?> value="<?php echo $horaires['jeudiMatin']; ?>">
                </td>    
                <td class="text-center">
                    <input class="form-control fs-4 <?php if($_SESSION['dataConnect']['avatar'] != 'Administrator'){echo 'bg-transparent text-light';} ?> text-center border border-0" id="txt_shedules_jeudiAM" name="txt_shedules_jeudiAM" type="text" <?php if($_SESSION['dataConnect']['avatar'] != 'Administrator'){echo 'readonly';} ?> value="<?php echo $horaires['jeudiAM']; ?>">
                </td>
            </tr>
            <tr class="table-active">
                <td class="fs-4" style="text-align: right;">Vendredi</td>
                <td class="text-center">
                    <input class="form-control fs-4 <?php if($_SESSION['dataConnect']['avatar'] != 'Administrator'){echo 'bg-transparent text-light';} ?> text-center border border-0" id="txt_shedules_vendrediMatin" name="txt_shedules_vendrediMatin" type="text" <?php if($_SESSION['dataConnect']['avatar'] != 'Administrator'){echo 'readonly';} ?> value="<?php echo $horaires['vendrediMatin']; ?>">
                </td>    
                <td class="text-center">
                    <input class="form-control fs-4 <?php if($_SESSION['dataConnect']['avatar'] != 'Administrator'){echo 'bg-transparent text-light';} ?> text-center border border-0" id="txt_shedules_vendrediAM" name="txt_shedules_vendrediAM" type="text" <?php if($_SESSION['dataConnect']['avatar'] != 'Administrator'){echo 'readonly';} ?> value="<?php echo $horaires['vendrediAM']; ?>">
                </td>
            </tr>
            <tr class="table-active">
                <td class="fs-4" style="text-align: right;">Samedi</td>
                <td class="text-center">
                    <input class="form-control fs-4 <?php if($_SESSION['dataConnect']['avatar'] != 'Administrator'){echo 'bg-transparent text-light';} ?> text-center border border-0" id="txt_shedules_samediMatin" name="txt_shedules_samediMatin" type="text" <?php if($_SESSION['dataConnect']['avatar'] != 'Administrator'){echo 'readonly';} ?> value="<?php echo $horaires['samediMatin']; ?>">
                </td>    
                <td class="text-center">
                    <input class="form-control fs-4 <?php if($_SESSION['dataConnect']['avatar'] != 'Administrator'){echo 'bg-transparent text-light';} ?> text-center border border-0" id="txt_shedules_samediAM" name="txt_shedules_samediAM" type="text" <?php if($_SESSION['dataConnect']['avatar'] != 'Administrator'){echo 'readonly';} ?> value="<?php echo $horaires['samediAM']; ?>">
                </td>
            </tr>
            <tr class="table-active">
                <td class="fs-4" style="text-align: right;">Dimanche</td>
                <td class="text-center">
                    <input class="form-control fs-4 <?php if($_SESSION['dataConnect']['avatar'] != 'Administrator'){echo 'bg-transparent text-light';} ?> text-center border border-0" id="txt_shedules_dimancheMatin" name="txt_shedules_dimancheMatin" type="text" <?php if($_SESSION['dataConnect']['avatar'] != 'Administrator'){echo 'readonly';} ?> value="<?php echo $horaires['dimancheMatin']; ?>">
                </td>    
                <td class="text-center">
                    <input class="form-control fs-4 <?php if($_SESSION['dataConnect']['avatar'] != 'Administrator'){echo 'bg-transparent text-light';} ?> text-center border border-0" id="txt_shedules_dimancheAM" name="txt_shedules_dimancheAM" type="text" <?php if($_SESSION['dataConnect']['avatar'] != 'Administrator'){echo 'readonly';} ?> value="<?php echo $horaires['dimancheAM']; ?>">
                </td>
            </tr>
            <?php
            if($_SESSION['dataConnect']['avatar'] === 'Administrator'){
            ?>
                <tr class="table-active">
                    <td colspan="3" class="text-center">
                        <button class="btn btn-lg btn-primary fs-4" type="submit" id="bt_schedules" name="bt_schedules">Enregistrer</button>
                    </td>
                </tr>
            <?php
            }
            ?>
        </form>
    </tbody>
</table>
