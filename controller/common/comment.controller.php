<?php

    use Model\Comment\Comment;
    use Model\Utilities\Utilities;
    use \Firebase\JWT\JWT;

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $bt_save_comment = isset($_POST['bt_save_comment']) ? true : false;
        unset($_POST['bt_save_comment']);

        $bt_comment_delete = isset($_POST['bt_comment_delete']) ? true : false;
        unset($_POST['bt_comment_delete']);

        $bt_comment_validate = isset($_POST['bt_comment_validate']) ? true : false;
        unset($_POST['bt_comment_validate']);

        $bt_comment_refuse = isset($_POST['bt_comment_refuse']) ? true : false;
        unset($_POST['bt_comment_refuse']);

        $pseudo_ = isset($_POST['txt_comment_pseudo']) ? Utilities::filterInput('txt_comment_pseudo') : '';
        unset($_POST['txt_comment_pseudo']);

        $rating_ = isset($_POST['selectedRating']) ? Utilities::filterInput('selectedRating') : '';
        unset($_POST['selectedRating']);

        $comment_ = isset($_POST['txt_comment_comment']) ? Utilities::filterInput('txt_comment_comment') : '';
        unset($_POST['txt_comment_comment']);

        $idComment = isset($_POST['txt_comment_id']) ? Utilities::filterInput('txt_comment_id') : '';
        unset($_POST['txt_comment_id']);
    }

    if(!isset($comments)){
        $comments = new Comment();
    }

/*    $jwt1 = JWT::jsondecode($_SESSION['token']['jwt']['tokenJwt']);
    $jwt2 = JWT::jsondecode(Utilities::tokenJwt($_SESSION['dataConnect']['pseudo'], $_SESSION['token']['jwt']['secretKey'], $_SESSION['token']['jwt']['delay']));

    if($jwt2->{'delay'} - $jwt1->{'delay'} <= $_SESSION['token']['jwt']['delay']){

        if($jwt1->{'pseudo'} === $jwt2->{'pseudo'} && $jwt1->{'key'} === $jwt2->{'key'}){
*/
            if(!Utilities::ckeckCsrf()){
                
                if($bt_save_comment){

                    $bt_save_comment = false;
                    
                    $comments->setDate(date("Y-m-d"));
                    $comments->setPseudo($pseudo_);
                    $comments->setRating($rating_);
                    $comments->setComment($comment_);

                    $comments->insertComment();
                    return;

                }elseif($bt_comment_delete){

                    $bt_comment_delete = false;
                    
                    $comments->deleteComment($idComment);
                    return;

                }elseif($bt_comment_validate){

                    $bt_comment_validate = false;
                    
                    $comments->modereComment($idComment, 2);
                    return;

                }elseif($bt_comment_refuse){

                    $bt_comment_refuse = false;
                    
                    $comments->modereComment($idComment, 1);
                    return;
                }

            }
/*
        }

    }elseif($_SESSION['dataConnect']['pseudo'] != 'Guest'){

        $_SESSION['dataConnect']['type'] = 'Guest';
        $_SESSION['dataConnect']['pseudo'] = 'Guest';
        $_SESSION['dataConnect']['avatar'] = 'avatar_membre_white.webp';
        $_SESSION['dataConnect']['subscription'] = 'Vénusia';
        $_SESSION['dataConnect']['connexion'] = false;

        Utilities::redirectToPage('timeExpired');
    }
*/

    if($_SESSION['dataConnect']['type'] === 'Administrator'){

        $Comment = $comments->getCommentList(1,'date_','DESC', 0, 50);

    }elseif($_SESSION['dataConnect']['type'] === 'User'){

        $Comment = $comments->getCommentList('`publication` = 0','date_','DESC',0,50);

    }else{

        $Comment = $comments->getCommentList("`comment`.`publication` = 2",'date_','DESC',0,50);

    }

?>