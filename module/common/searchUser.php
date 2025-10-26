<?php
    use Model\Type\Type;
?>

<div class="container">

    <form action="" method="post">

        <div class="d-sm-flex justify-content-sm-between p-3 bgDark border border-secondary border-3 rounded-4">

            <div class="container d-flex flex-column">
                <label for="Text_User_Nom" class="form-label text-light">Nom :</label>
                <input class="form-text text-danger fw-bolder rounded-3 pb-2 m-0" type="text" id="Text_User_Nom" name="Text_User_Nom" placeholder="Saisissez un nom"
                    value=
                    "<?php
                        if(isset($_POST['Text_User_Nom'])){
                            //$_SESSION['user']['criteriaName'] = $_POST['Text_User_Nom'];
                        }
                        echo $_SESSION['user']['criteriaName'];
                    ?>"
                >
            </div>
            
            <div class="container d-flex flex-column">
                
                <label for="Text_User_Pseudo" class="form-label text-light">Pseudo :</label>
                <input class="form-text text-danger fw-bolder rounded-3 py-2 m-0" type="text" id="Text_User_Pseudo" name="Text_User_Pseudo" placeholder="Saisissez un pseudo"
                    value=
                    "<?php
                        if(isset($_POST['Text_User_Pseudo'])){
                            //$_SESSION['user']['criteriaPseudo'] = $_POST['Text_User_Pseudo'];
                        }
                        echo $_SESSION['user']['criteriaPseudo'];
                    ?>"
                >

            </div>
            
            <div class="container d-flex flex-column">
                
                <label for="Select_User_Type" class="form-label text-light">Type Utilisateur :</label>
                <select class="form-select fw-bolder rounded-3" id="Select_User_Type" name="Select_User_Type">
                    <?php
                        if(isset($_POST['Select_User_Type'])){
                            //$_SESSION['user']['criteriaType'] = $_POST['Select_User_Type'];
                        }
                    ?>

                        <option value='<?php echo $_SESSION['user']['criteriaType']; ?>'><?php echo $_SESSION['user']['criteriaType']; ?></option>";
                        <option value='Selectionnez un type'>Selectionnez un type</option>
                        
                    <?php
                        $Types = new Type();
                        $MyType = $Types->getTypeList(1,'type', 'ASC', 0, 50);
                        unset($Types);
                        for($i=0;$i != count($MyType);$i++) { ?>
                            <option value="<?php echo $MyType[$i]['type']; ?>"><?php echo $MyType[$i]['type']; ?></option>
                    <?php } ?>
                </select>

            </div>
            
            <div class="container d-flex flex-column w-25">
                <label for="btn-SearchUser" class="form-label text-light text-dark">Rechercher</label>
                <button class="btn btn-lg btn-primary px-3 py-2" type="submit" id="btn-SearchUser" name="btn-SearchUser">Rechercher</button>
            </div>

        </div>

    </form>

</div>