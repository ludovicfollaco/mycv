<?php
    use Model\GpSchedules\GpSchedules;
    use Model\Utilities\Utilities;

    $scheldule = new GpSchedules();
    
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bt_schedules'])){
        
        $scheldule->setLundiMatin(isset($_POST['txt_shedules_lundiMatin'])?Utilities::filterInput('txt_shedules_lundiMatin'):'');
        $scheldule->setLundiAM(isset($_POST['txt_shedules_lundiAM'])?Utilities::filterInput('txt_shedules_lundiAM'):'');
        $scheldule->setMardiMatin(isset($_POST['txt_shedules_mardiMatin'])?Utilities::filterInput('txt_shedules_mardiMatin'):'');
        $scheldule->setMardiAM(isset($_POST['txt_shedules_mardiAM'])?Utilities::filterInput('txt_shedules_mardiAM'):'');
        $scheldule->setMercrediMatin(isset($_POST['txt_shedules_mercrediMatin'])?Utilities::filterInput('txt_shedules_mercrediMatin'):'');
        $scheldule->setMercrediAM(isset($_POST['txt_shedules_mercrediAM'])?Utilities::filterInput('txt_shedules_mercrediAM'):'');
        $scheldule->setJeudiMatin(isset($_POST['txt_shedules_jeudiMatin'])?Utilities::filterInput('txt_shedules_jeudiMatin'):'');
        $scheldule->setJeudiAM(isset($_POST['txt_shedules_jeudiAM'])?Utilities::filterInput('txt_shedules_jeudiAM'):'');
        $scheldule->setVendrediMatin(isset($_POST['txt_shedules_vendrediMatin'])?Utilities::filterInput('txt_shedules_vendrediMatin'):'');
        $scheldule->setVendrediAM(isset($_POST['txt_shedules_vendrediAM'])?Utilities::filterInput('txt_shedules_vendrediAM'):'');
        $scheldule->setSamediMatin(isset($_POST['txt_shedules_samediMatin'])?Utilities::filterInput('txt_shedules_samediMatin'):'');
        $scheldule->setSamediAM(isset($_POST['txt_shedules_samediAM'])?Utilities::filterInput('txt_shedules_samediAM'):'');
        $scheldule->setDimancheMatin(isset($_POST['txt_shedules_dimancheMatin'])?Utilities::filterInput('txt_shedules_dimancheMatin'):'');
        $scheldule->setDimancheAM(isset($_POST['txt_shedules_dimancheAM'])?Utilities::filterInput('txt_shedules_dimancheAM'):'');

        $scheldule->updateSchedules(1);
    }
    $horaires = $scheldule->getCurrentSchedules(1);
?>