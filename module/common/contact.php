<?php require_once('../controller/common/contact.controller.php'); ?>

<table class="table table-dark table-bordered fs-4">
    <thead>
        <tr>
            <td colspan="2" class="text-center fs-4">Formulaire de contact</td>
        </tr>
    <thead>
    <form action="" method="post">
        <tbody>
            <tr class="table-active">
                <td style="text-align: right;">
                    <label class="form-label fs-4" for="contact_objet">Objet</label>
                </td>
                <td>
                    <input class="form-control fs-4" type="text" id="contact_objet" name="contact_objet" placeholder="Objet du message" required>
                </td>
            </tr>
            <tr class="table-active">
                <td style="text-align: right;">
                    <label class="form-label fs-4" for="contact_name">Nom</label>
                </td>
                <td>
                    <input class="form-control fs-4" type="text" id="contact_name" name="contact_name" placeholder="Nom et prénom" required>
                </td>
            </tr>
            <tr class="table-active">
                <td style="text-align: right;">
                    <label class="form-label fs-4" for="contact_email">eMail</label>
                </td>
                <td>
                    <input class="form-control fs-4" type="mail" id="contact_email" name="contact_email" placeholder="email" required>
                </td>
            </tr>
            <tr class="table-active">
                <td style="text-align: right;">
                    <label class="form-label fs-4" for="contact_tel">Phone</label>
                </td>
                <td>
                    <input class="form-control fs-4" type="tel" id="contact_tel" name="contact_tel" placeholder="+33 6 08 81 83 90" pattern="^\+33\s[1-9](\s\d{2}){4}$" required>
                </td>
            </tr>
            <tr class="table-active">
                <td style="text-align: right;">
                    <label class="form-label fs-4" for="contact_description">Message</label>
                </td>
                <td>
                    <textarea class="form-control fs-4" id="contact_description" name="contact_description" rows="3" placeholder="Ici votre message" required></textarea>
                </td>
            </tr>
            <tr class="table-active">
                <td class="text-center" colspan="2">
                    <button class="btn btn-lg btn-primary fs-4" type="submit" id="bt_contact" name="bt_contact">Envoyer</button>
                </td>
            </tr>
        </tbody>
    </form>
</table>