<?php require_once "../controller/common/comment.controller.php"; ?>
        
<div class="me-0 px-0 pt-3 pt-sm-0">
        
    <h2>Ils témoignent</h2>

    <div class="p-0 m-0">
        
    <?php
        for($i=0;$i != count($Comment);$i++){ 
    ?>
        <div class="px-0 mb-3">

            <div class="card">

                <form action="" method="post">

                    <div class="card-header fs-4">

                        <div class="container">

                            <div class="row">

                                <div class="d-none">
                                    <input type="text" id="txt_comment_id" name="txt_comment_id" readonly value="<?php echo $Comment[$i]['id_comment']; ?>">
                                    <input type="text" id="txt_local" name="txt_local" readonly value="<?php echo $_SESSION['other']['local']; ?>">
                                </div>

                                <div class="col-12 col-sm-5 col-lg-12 col-xxl-5 d-flex mx-0 px-0">

                                    <div class="col-1 col-xxl-2">
                                        <img src="../img/common/avatar/<?php echo $Comment[$i]['avatar']; ?>" alt="avatar du membre" style="width: 20px;">
                                    </div>

                                    <div class="col-11 col-xxl-10">
                                        <input class="text-start" type="text" readonly value="<?php echo $Comment[$i]['pseudo']; ?>">
                                    </div>

                                </div>

                                <div class="col-12 col-sm-4 col-lg-12 col-xxl-4 mx-0 px-0">
                                    <input class="text-start text-sm-center text-lg-start text-xxl-center" type="text" readonly value="<?php echo $Comment[$i]['date_']; ?>">
                                </div>

                                <div class="col-12 col-sm-3 col-lg-12 col-xxl-3 mx-0 px-0">
                                    <input class="text-start text-sm-end text-lg-start text-xxl-end" type="text" readonly value="note : <?php echo $Comment[$i]['rating']; ?>/5">
                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="card-body">

                        <blockquote class="blockquote mb-0 fs-4" style="text-align: justify;">
                            <?php echo $Comment[$i]['comment']; ?>
                        </blockquote>

                    </div>

                    <?php
                    if($_SESSION['dataConnect']['type'] != 'Guest' && $_SESSION['dataConnect']['type'] != 'Member'){
                    ?>

                        <div class="card-footer d-flex flex-wrap justify-content-center">

                            <input class="btn btn-lg btn-primary me-2 comment-action" type="button" data-comment-id="<?php echo $Comment[$i]['id_comment']; ?>" data-action="bt_comment_validate" style="width: 100px;" value="Valider">
                            <input class="btn btn-lg btn-warning me-2 comment-action" type="button" data-comment-id="<?php echo $Comment[$i]['id_comment']; ?>" data-action="bt_comment_refuse" style="width: 100px;" value="Refuser">
                            <input class="btn btn-lg btn-danger me-2 comment-action" type="button" data-comment-id="<?php echo $Comment[$i]['id_comment']; ?>" data-action="bt_comment_delete" style="width: 100px;" value="Supprimer">
                        
                        </div>

                        <div id="bgStateComment_<?php echo $Comment[$i]['id_comment'];?>">

                            <input id="stateComment_<?php echo $Comment[$i]['id_comment'];?>" class="text-center <?php
                                                        if ($Comment[$i]['publication'] == '0'){
                                                            echo "bg-info";
                                                        }elseif ($Comment[$i]['publication'] == '1'){
                                                            echo "bg-warning";
                                                        }elseif ($Comment[$i]['publication'] == '2'){
                                                            echo "bg-success";
                                                        }
                                                    ?>"
                                value="Etat : <?php
                                                if ($Comment[$i]['publication'] == '0'){
                                                    echo "En attente";
                                                }elseif ($Comment[$i]['publication'] == '1'){
                                                    echo "Refusé";
                                                }elseif ($Comment[$i]['publication'] == '2'){
                                                    echo "Validé";
                                                }
                                            ?>"
                                type="text" readonly
                            >

                        </div>

                    <?php
                    }
                    ?>

                </form>

            </div>

        </div>

    <?php
        }

        $local = $_SESSION['other']['local'];
    ?>

    </div>

</div>

<script src="../js/common/comment.js"></script>