<?php
    //use Model\Network\Network;
    use Model\Utilities\Utilities;
    use Model\Network\Network;
    use Model\Media\Media;

    $Network = new Network();
    $Media = new Media();

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        
        resetOtherVarSession();
        
        $id = isset($_POST['id']) ? Utilities::filterInput('id') : '';
        $btn_logo = "btn_logo_" . $id;
        $btn_delete_network = "btn_delete_" . $id;
        $btn_save_network = "btn_save_" . $id;

        $formActif =    isset($_POST['btn_save_header']) ||
                        isset($_POST['btn_save_new']) ||
                        isset($_POST[$btn_logo]) ||
                        isset($_POST[$btn_delete_network]) ||
                        isset($_POST[$btn_save_network]) ||
                        isset($_POST['btn_save_header']);
        
        if($formActif){

            if(!Utilities::ckeckCsrf()){
                
                die('Token CSRF invalide');

            }else{
                
                if(isset($_POST['btn_save_header'])){
                    
                    varMycv($Network);
                    $Network->updateNetwork(1);
                    unset($_POST['btn_save_header']);

                }elseif(isset($_POST['btn_save_new'])){
                    
                    varNetwork($Network, 'new');
                    $Network->insertNetwork();
                    unset($_POST['btn_save_new']);

                }elseif(isset($_POST[$btn_save_network])){

                    varNetwork($Network, $id);                
                    $Network->updateNetwork($id);
                    unset($_POST['btn_save_network']);

                }elseif(isset($_POST[$btn_delete_network])){
                    
                    $Network->deleteNetwork($id);
                    unset($_POST[$btn_delete_network]);
                    unset($_POST['btn_delete_network']);

                }elseif(isset($_POST[$btn_logo])){

                    varNetwork($Network, $id);

                    if (Utilities::uploadImg('user', "newImgChapter1","text_logo_" . $id,"file_logo_" . $id,"./img/mycv/logo/")){

                        $arrayNetworkNetwork['networkImg'] = $_SESSION['user']['newImgChapter1'];
                        $Network->setLogo($_SESSION['user']['newImgChapter1']);
                        $Network->updateNetwork($id);

                    }else{

                        echo "<script>alert('Désolé, une erreur s\'est produite lors de l\'upload de l\'image.');</script>";

                    }

                    unset($_POST[$btn_logo]);
                
                }

            }
        }
    }
    
    $networks = $Network->getList(1, 'sort', 'ASC', 0, 20);
    $medias = $Media->getList(1, 'sort', 'ASC', 0, 20);

    $toto = 0;

//----------------------------------------------------------------------------------------------------------------------
// FUNCTIONS
//----------------------------------------------------------------------------------------------------------------------

    function varNetwork($Network, $id): array{

        $newspaper = isset($_POST["text_newspaper_" . $id]) ? Utilities::filterInput("text_newspaper_" . $id) : '';
        $date = isset($_POST["text_date_" . $id]) ? Utilities::filterInput("text_date_" . $id) : '';
        $title = isset($_POST["text_title_" . $id]) ? Utilities::filterInput("text_title_" . $id) : '';
        $subtitle = isset($_POST["text_subtitle_" . $id]) ? Utilities::filterInput("text_subtitle_" . $id) : '';
        $editor = isset($_POST["text_editor_" . $id]) ? Utilities::filterInput("text_editor_" . $id) : '';
        $article = isset($_POST["textarea_article_" . $id]) ? Utilities::filterInput("textarea_article_" . $id) : '';
        $media = isset($_POST["text_media_" . $id]) ? Utilities::filterInput("text_media_" . $id) : '';
        $legend = isset($_POST["text_legend_" . $id]) ? Utilities::filterInput("text_legend_" . $id) : '';
        $altMedia = isset($_POST["text_altMedia_" . $id]) ? Utilities::filterInput("text_altMedia_" . $id) : '';
        $mediaPrefix = isset($_POST["media_prefix_" . $id]) ? Utilities::filterInput("media_prefix_" . $id) : '';
        $mediaYesOrNo = isset($_POST["media_yesOrNo_" . $id]) ? Utilities::filterInput("media_yesOrNo_" . $id) : '';
        $mediaRightOrLeft = isset($_POST["media_rightOrLeft_" . $id]) ? Utilities::filterInput("media_rightOrLeft_" . $id) : '';
        $mediaWidth = isset($_POST["media_width_" . $id]) ? Utilities::filterInput("media_width_" . $id) : '';
        $mediaHeight = isset($_POST["media_height_" . $id]) ? Utilities::filterInput("media_height_" . $id) : '';
        $mediaObjectFit = isset($_POST["media_objectFit_" . $id]) ? Utilities::filterInput("media_objectFit_" . $id) : '';
        $background = isset($_POST["text_background_" . $id]) ? Utilities::filterInput("text_background_" . $id) : '';
        $backgroundTitle = isset($_POST["text_background_title_" . $id]) ? Utilities::filterInput("text_background_title_" . $id) : '';
        $urlArticle = isset($_POST["text_urlArticle_" . $id]) ? Utilities::filterInput("text_urlArticle_" . $id) : '';
        $sort = isset($_POST["sort_" . $id]) ? Utilities::filterInput("sort_" . $id) : '';

        $Network->setNewspaper($newspaper);
        $Network->setDate($date);
        $Network->setTitle($title);
        $Network->setSubtitle($subtitle);
        $Network->setEditor($editor);
        $Network->setArticle($article);
        $Network->setMediaPrefix($mediaPrefix);
        $Network->setMedia($media);
        $Network->setLegend($legend);
        $Network->setAltMedia($altMedia);
        $Network->setMediaYesOrNo($mediaYesOrNo);
        $Network->setMediaRightOrLeft($mediaRightOrLeft);
        $Network->setMediaWidth($mediaWidth);
        $Network->setMediaHeight($mediaHeight);
        $Network->setMediaObjectFit($mediaObjectFit);
        $Network->setBackground($background);
        $Network->setBackgroundTitle($backgroundTitle);
        $Network->setBackgroundTitle($urlArticle);
        $Network->setSort($sort);

        return array(
            'newspaper' => $newspaper,
            'date' => $date,
            'title' => $title,
            'subtitle' => $subtitle,
            'editor' => $editor,
            'article' => $article,
            'mediaPrefix' => $mediaPrefix,
            'media' => $media,
            'legend' => $legend,
            'altMedia' => $altMedia,
            'mediaYesOrNo' => $mediaYesOrNo,
            'mediaRightOrLeft' => $mediaRightOrLeft,
            'mediaWidth' => $mediaWidth,
            'mediaHeight' => $mediaHeight,
            'mediaObjectFit' => $mediaObjectFit,
            'background' => $background,
            'backgroundTitle' => $backgroundTitle,
            'urlArticle' => $urlArticle,
            'sort' => $sort
        );

    }

    function varToto($network): array{

        $networkTitle = isset($_POST['text_network_title']) ? Utilities::filterInput('text_network_title') : '';
        $networkSubtitle = isset($_POST['text_network_subtitle']) ? Utilities::filterInput('text_network_subtitle') : '';
        $networkTitlePage = isset($_POST['text_network_title_page']) ? Utilities::filterInput('text_network_title_page') : '';

        $network->setTitle($networkTitle);
        $network->setSubtitle($networkSubtitle);
        $network->setTitlePage($networkTitlePage);

        return array(
            'networkTitle' => $networkTitle,
            'networkSubtitle' => $networkSubtitle,
            'networkTitlePage' => $networkTitlePage
        );

    }

?>