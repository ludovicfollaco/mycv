<?php
    //use Model\Experience\Experience;
    use Model\Utilities\Utilities;
    use Model\Experience\Experience;

    //$Experience = new Experience();
    $Experience = new Experience();

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        
        resetOtherVarSession();
        
        $id = isset($_POST['id']) ? Utilities::filterInput('id') : '';
        $btn_logo = "btn_logo_" . $id;
        $btn_delete_experience = "btn_delete_" . $id;
        $btn_save_experience = "btn_save_" . $id;

        $formActif =    isset($_POST['btn_save_header']) ||
                        isset($_POST['btn_save_new']) ||
                        isset($_POST[$btn_logo]) ||
                        isset($_POST[$btn_delete_experience]) ||
                        isset($_POST[$btn_save_experience]) ||
                        isset($_POST['btn_save_header']);
        
        if($formActif){

            if(!Utilities::ckeckCsrf()){
                
                die('Token CSRF invalide');

            }else{
                
                if(isset($_POST['btn_save_header'])){
                    
                    varMycv($Experience);
                    $Experience->updateExperience(1);
                    unset($_POST['btn_save_header']);

                }elseif(isset($_POST['btn_save_new'])){
                    
                    varExperience($Experience, 'new');
                    $Experience->insertExperience();
                    unset($_POST['btn_save_new']);

                }elseif(isset($_POST[$btn_save_experience])){

                    varExperience($Experience, $id);                
                    $Experience->updateExperience($id);
                    unset($_POST['btn_save_experience']);

                }elseif(isset($_POST[$btn_delete_experience])){
                    
                    $Experience->deleteExperience($id);
                    unset($_POST[$btn_delete_experience]);
                    unset($_POST['btn_delete_experience']);

                }elseif(isset($_POST[$btn_logo])){

                    varExperience($Experience, $id);

                    if (Utilities::uploadImg('user', "newImgChapter1","text_logo_" . $id,"file_logo_" . $id,"./img/mycv/logo/")){

                        $arrayExperienceExperience['experienceImg'] = $_SESSION['user']['newImgChapter1'];
                        $Experience->setLogo($_SESSION['user']['newImgChapter1']);
                        $Experience->updateExperience($id);

                    }else{

                        echo "<script>alert('Désolé, une erreur s\'est produite lors de l\'upload de l\'image.');</script>";

                    }

                    unset($_POST[$btn_logo]);
                
                }

            }
        }
    }
    
    //$home = $homes->getHome(1);
    $experiences = $Experience->getList(1, 'sort', 'ASC', 0, 20);

    
    /*$actuPresse = strpos($_SERVER['REQUEST_URI'], 'page=actuPresse') !== false;

    if($actuPresse){
        $home['home_title_page'] = "actuPresse";
    }else{
        $home['home_title_page'] = "";
        $_SESSION['other']['message'] = "";
    }*/

//----------------------------------------------------------------------------------------------------------------------
// FUNCTIONS
//----------------------------------------------------------------------------------------------------------------------

    function varExperience($Experience, $id): array{

        $job = isset($_POST["text_job_" . $id]) ? Utilities::filterInput("text_job_" . $id) : '';
        $logo = isset($_POST["text_logo_" . $id]) ? Utilities::filterInput("text_logo_" . $id) : '';
        $company = isset($_POST["text_company_" . $id]) ? Utilities::filterInput("text_company_" . $id) : '';
        $contract = isset($_POST["text_contract_" . $id]) ? Utilities::filterInput("text_contract_" . $id) : '';
        $start = isset($_POST["text_start_" . $id]) ? Utilities::filterInput("text_start_" . $id) : '';
        $end = isset($_POST["text_end_" . $id]) ? Utilities::filterInput("text_end_" . $id) : '';
        $place = isset($_POST["text_place_" . $id]) ? Utilities::filterInput("text_place_" . $id) : '';
        $experience = isset($_POST["textarea_" . $id]) ? Utilities::filterInput("textarea_" . $id) : '';
        $imgPrefix = isset($_POST["img_prefix_" . $id]) ? Utilities::filterInput("img_prefix_" . $id) : '';
        $imgYesOrNo = isset($_POST["img_yesOrNo_" . $id]) ? Utilities::filterInput("img_yesOrNo_" . $id) : '';
        $imgRightOrLeft = isset($_POST["img_rightOrLeft_" . $id]) ? Utilities::filterInput("img_rightOrLeft_" . $id) : '';
        $imgWidth = isset($_POST["img_width_" . $id]) ? Utilities::filterInput("img_width_" . $id) : '';
        $imgHeight = isset($_POST["img_height_" . $id]) ? Utilities::filterInput("img_height_" . $id) : '';
        $imgObjectFit = isset($_POST["img_objectFit_" . $id]) ? Utilities::filterInput("img_objectFit_" . $id) : '';
        $sort = isset($_POST["sort_" . $id]) ? Utilities::filterInput("sort_" . $id) : '';

        $Experience->setJob($job);
        $Experience->setLogo($logo);
        $Experience->setCompany($company);
        $Experience->setContract($contract);
        $Experience->setStart($start);
        $Experience->setEnd($end);
        $Experience->setPlace($place);
        $Experience->setExperience($experience);
        $Experience->setImgPrefix($imgPrefix);
        $Experience->setImgYesOrNo($imgYesOrNo);
        $Experience->setImgRightOrLeft($imgRightOrLeft);
        $Experience->setImgWidth($imgWidth);
        $Experience->setImgHeight($imgHeight);
        $Experience->setImgObjectFit($imgObjectFit);
        $Experience->setSort($sort);

        return array(
            'job' => $job,
            'logo' => $logo,
            'company' => $company,
            'contract' => $contract,
            'start' => $start,
            'end' => $end,
            'place' => $place,
            'experience' => $experience,
            'imgPrefix' => $imgPrefix,
            'imgYesOrNo' => $imgYesOrNo,
            'imgRightOrLeft' => $imgRightOrLeft,
            'imgWidth' => $imgWidth,
            'imgHeight' => $imgHeight,
            'imgObjectFit' => $imgObjectFit,
            'sort' => $sort
        );

    }

    function varMycv($mycv): array{

        $mycvTitle = isset($_POST['text_mycv_title']) ? Utilities::filterInput('text_mycv_title') : '';
        $mycvSubtitle = isset($_POST['text_mycv_subtitle']) ? Utilities::filterInput('text_mycv_subtitle') : '';
        $mycvTitlePage = isset($_POST['text_mycv_title_page']) ? Utilities::filterInput('text_mycv_title_page') : '';

        $mycv->setTitle($mycvTitle);
        $mycv->setSubtitle($mycvSubtitle);
        $mycv->setTitlePage($mycvTitlePage);

        return array(
            'mycvTitle' => $mycvTitle,
            'mycvSubtitle' => $mycvSubtitle,
            'mycvTitlePage' => $mycvTitlePage
        );

    }

?>