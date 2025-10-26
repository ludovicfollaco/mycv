<?php
    //use Model\Article\Article;
    use Model\Utilities\Utilities;
    use Model\Home\Home;

    //$articles = new Article();
    $homes = new Home();

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        
        resetOtherVarSession();
        
        $article_id = isset($_POST['article_id']) ? Utilities::filterInput('article_id') : '';
        $btn_article_img = "btn_article_img_" . $article_id;
        $btn_delete_article = "btn_delete_article_" . $article_id;
        $btn_save_article = "btn_save_article_" . $article_id;

        $formActif =    isset($_POST['btn_save_header']) ||
                        isset($_POST['btn_new_article']) ||
                        isset($_POST[$btn_article_img]) ||
                        isset($_POST[$btn_delete_article]) ||
                        isset($_POST[$btn_save_article]) ||
                        isset($_POST['btn_save_header']);
        
        if($formActif){

            if(!Utilities::ckeckCsrf()){
                
                die('Token CSRF invalide');

            }else{
                
                if(isset($_POST['btn_save_header'])){
                    
                    varHome($homes);
                    $homes->updateHome(1);
                    unset($_POST['btn_save_header']);

                }elseif(isset($_POST['btn_new_article'])){
                    
                    varArticle($homes, 'new');
                    $homes->insertArticle();
                    unset($_POST['btn_new_article']);

                }elseif(isset($_POST[$btn_save_article])){

                    varArticle($homes, $article_id);                
                    $homes->updateArticle($article_id);
                    unset($_POST['btn_save_article']);

                }elseif(isset($_POST[$btn_delete_article])){
                    
                    $homes->deleteArticle($article_id);
                    unset($_POST[$btn_delete_article]);
                    unset($_POST['btn_delete_article']);

                }elseif(isset($_POST[$btn_article_img])){

                    varArticle($homes, $article_id);

                    if (Utilities::uploadImg('user', "newImgChapter1","text_article_img_" . $article_id,"file_article_img_" . $article_id,"./img/mycv/article/")){

                        $arrayHomeArticle['articleImg'] = $_SESSION['user']['newImgChapter1'];
                        $homes->setArticleImg($_SESSION['user']['newImgChapter1']);
                        $homes->updateArticle($article_id);

                    }else{

                        echo "<script>alert('Désolé, une erreur s\'est produite lors de l\'upload de l\'image.');</script>";

                    }

                    unset($_POST[$btn_article_img]);
                
                }

            }
        }
    }
    
    $home = $homes->getHome(1);
    $article = $homes->getArticleList(1, 'article_sort', 'ASC', 0, 20);

    if(preg_match("/mycv/", $_SERVER['REQUEST_URI'])){
        $home['home_title_page'] = "L'HISTOIRE D'UN PARCOURS PASSIONNÉ";
    }else if(preg_match("/network/", $_SERVER['REQUEST_URI'])){
        $home['home_title_page'] = "LA PRESSE EN PARLE";
    }else if(preg_match("/contact/", $_SERVER['REQUEST_URI'])){
        $home['home_title_page'] = "Envoyez un courriel à Ludovic FOLLACO!";
    }else{
        $home['home_title_page'] = "";
        $_SESSION['other']['message'] = "";
    }

//----------------------------------------------------------------------------------------------------------------------
// FUNCTIONS
//----------------------------------------------------------------------------------------------------------------------

    function varArticle($homes, $article_id): array{

        $articleTitle = isset($_POST["text_article_title_" . $article_id]) ? Utilities::filterInput("text_article_title_" . $article_id) : '';
        $article = isset($_POST["textarea_article_" . $article_id]) ? Utilities::filterInput("textarea_article_" . $article_id) : '';
        $articleImg = isset($_POST["text_article_img_" . $article_id]) ? Utilities::filterInput("text_article_img_" . $article_id) : '';
        $articleImgYesOrNo = isset($_POST["article_img_yesOrNo_" . $article_id]) ? Utilities::filterInput("article_img_yesOrNo_" . $article_id) : '';
        $articleImgRightOrLeft = isset($_POST["article_img_rightOrLeft_" . $article_id]) ? Utilities::filterInput("article_img_rightOrLeft_" . $article_id) : '';
        $articleImgWidth = isset($_POST["article_img_width_" . $article_id]) ? Utilities::filterInput("article_img_width_" . $article_id) : '';
        $articleImgHeight = isset($_POST["article_img_height_" . $article_id]) ? Utilities::filterInput("article_img_height_" . $article_id) : '';
        $articleImgObjectFit = isset($_POST["article_img_objectFit_" . $article_id]) ? Utilities::filterInput("article_img_objectFit_" . $article_id) : '';
        $articleBackground = isset($_POST["article_background_" . $article_id]) ? Utilities::filterInput("article_background_" . $article_id) : '';
        $articleSort = isset($_POST["article_sort_" . $article_id]) ? Utilities::filterInput("article_sort_" . $article_id) : '';

        $homes->setArticleTitle($articleTitle);
        $homes->setArticle($article);
        $homes->setArticleImg($articleImg);
        $homes->setArticleImgYesOrNo($articleImgYesOrNo);
        $homes->setArticleImgRightOrLeft($articleImgRightOrLeft);
        $homes->setArticleImgWidth($articleImgWidth);
        $homes->setArticleImgHeight($articleImgHeight);
        $homes->setArticleImgObjectFit($articleImgObjectFit);
        $homes->setArticleBackground($articleBackground);
        $homes->setarticleSort($articleSort);

        return array(
            'articleTitle' => $articleTitle,
            'article' => $article,
            'articleImg' => $articleImg,
            'articleImgYesOrNo' => $articleImgYesOrNo,
            'articleImgRightOrLeft' => $articleImgRightOrLeft,
            'articleImgWidth' => $articleImgWidth,
            'articleImgHeight' => $articleImgHeight,
            'articleImgObjectFit' => $articleImgObjectFit,
            'articleBackground' => $articleBackground,
            'articleSort' => $articleSort
        );

    }

    function varHome($home): array{

        $homeTitle = isset($_POST['text_home_title']) ? Utilities::filterInput('text_home_title') : '';
        $homeSubtitle = isset($_POST['text_home_subtitle']) ? Utilities::filterInput('text_home_subtitle') : '';
        $homeTitlePage = isset($_POST['text_home_title_page']) ? Utilities::filterInput('text_home_title_page') : '';

        $home->setHomeTitle($homeTitle);
        $home->setHomeSubtitle($homeSubtitle);
        $home->setHomeTitlePage($homeTitlePage);

        return array(
            'homeTitle' => $homeTitle,
            'homeSubtitle' => $homeSubtitle,
            'homeTitlePage' => $homeTitlePage
        );

    }

?>