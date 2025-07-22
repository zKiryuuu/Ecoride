<?php
// HEADER
require_once  BASE_PATH . '/Templates/header.php';
?>
<!-- Section avec la table de tous les utilisateurs -->
<section class="container admin-espace-container mt-3 mb-5">
    <!-- Bouton pour créer un compte employé -->
    <button class="create-employe-account btn btn-warning secondary-btn" data-bs-toggle="modal" data-bs-target="#createEmployeAccountModal">Créer un compte employé</button>
    <!-- Modal pour concevoir un compte employé-->
    <div class="modal fade create-employe-account-modal" id="createEmployeAccountModal" tabindex="-1" aria-labelledby="createEmployeAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createEmployeAccountModalLabel">Créer un compte employé</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulaire pour créer un compte employé -->
                    <form method="post" class="d-flex flex-column create-employe-account-form" id="createEmployeAccountForm">
                        <!-- Tous les champs du formulaire de l'utilisateur -->
                        <div class="create-employe-account-body">
                            <!-- Pseudo -->
                            <div class="form-floating">
                                <input type="text" name="pseudo" class="form-control small-text"
                                    id="floatingInput" placeholder="juanes" value="<?= $employePseudoAccount ?>">
                                <label for="floatingPseudo" class="small-text">Pseudo</label>
                                <!-- S'il y a des erreurs on affiche le message d'erreur -->
                                <!-- Les messages sont chargés dynamiquement depuis le js -->
                                <div class="invalid-tooltip position-static invalid-tooltip-mdp small-text hidden" id="pseudoEmpty"></div>
                            </div>
                            <!-- E-mail -->
                            <div class="form-floating">
                                <input type="email" class="form-control small-text"
                                    id="floatingMail" name="mail" placeholder="name@example.com" value="<?= $employeMailAccount ?>">
                                <label for="floatingMail" class="small-text">Email address</label>
                                <!-- S'il y a des erreurs on affiche le message d'erreur -->
                                <!-- Les messages sont chargés dynamiquement depuis le js -->
                                <div class="invalid-tooltip position-static invalid-tooltip-mdp small-text hidden" id="mailEmpty"></div>
                                <div class="invalid-tooltip position-static invalid-tooltip-mdp small-text hidden" id="mailUsed"></div>
                            </div>
                            <!-- Mot de passe -->
                            <div class="form-floating">
                                <input type="password" class="form-control small-text"
                                    id="floatingPassword" name="password" placeholder="Password" value="<?= $employePasswordAccount ?>">
                                <label for="floatingPassword" class="small-text">Mot de passe</label>
                                <!-- message et button pour afficher le mot de passe -->
                                <div class="show-password">
                                    <span class="text-dark small-text" id="showPasswordText">Afficher le mot de passe</span>
                                    <i class="bi bi-square" id="showPasswordIcon"></i>
                                </div>
                                <!-- S'il y a des erreurs on affiche le message d'erreur -->
                                <!-- Les messages sont chargés dynamiquement depuis le js -->
                                <div class="invalid-tooltip position-static invalid-tooltip-mdp small-text hidden" id="passwordEmpty"></div>
                                <div class="invalid-tooltip position-static invalid-tooltip-mdp small-text hidden" id="passwordLen"></div>
                                <div class="invalid-tooltip position-static invalid-tooltip-mdp small-text hidden" id="passwordInfo"></div>
                            </div>
                        </div>
                        <!-- Button pour créer le compte -->
                        <div class="modal-footer justify-content-center gap-3">
                            <button type="button" class="btn btn-danger secondary-btn text-white small-text" data-bs-dismiss="modal">Annuler</button>
                            <button class="btn btn-primary secondary-btn text-white small-text" name="singUp" type="submit">
                                Créer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Div pour faire la table responsive -->
    <div class="table-responsive small-text">
        <table class="table table-hover user-table table-striped" id="userTable">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Pseudo</th>
                    <th scope="col">Mail</th>
                    <th scope="col">Role</th>
                    <th scope="col"># Crédits</th>
                    <th scope="col">Actif</th>
                    <th scope="col" class="actions-row">Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Php avec les donées de la table -->
                <?php
                $modals = ''; // On initialise une variable pour stocker les modals qui sont générées automatiquement par DataTable
                // On parcour le tableau des utilisateurs pour remplir la table avec les données de chaque user
                foreach ($allUsers as $user) { ?>
                    <tr>
                        <th scope="row" class="id-row" data-cell="ID"><?= $user['id'] ?></th>
                        <td data-cell="Pseudo"><?= $user['pseudo'] ?></td>
                        <td data-cell="Mail"><?= $user['mail'] ?></td>
                        <td data-cell="Role"><?= $user['user_role'] ?></td>
                        <td data-cell="# Crédits"><?= $user['nb_credits'] ?></td>
                        <td data-cell="Actif" class="active-col">
                            <!-- On affiche une icone si l'utilisateur est actif ou inactif -->
                            <?php if ($user['active'] == 1) { ?>
                                <i class="bi bi-check-circle-fill"></i>
                            <?php } else { ?>
                                <i class="bi bi-x-circle-fill"></i>
                            <?php } ?>
                            <!-- La collone avec les bouton d'action : suspendre un utilisateur -->
                        <td class="actions-col" data-cell="Actions">
                            <i class="bi bi-person-fill-slash <?= ($user['active'] == 0) ? "inactif-user-delete-btn" : "" ?> "
                                <?= ($user['active'] == 1) ? "data-bs-toggle='modal' data-bs-target='#suspendUserConfirm{$user['id']}'" : "" ?>
                                data-bs-toggleTooltip="tooltip" data-bs-placement="right"
                                data-bs-title="<?= ($user['active'] == 1) ? "Suspendre l'utilisateur" : "Utilisateur inactif" ?>"
                                data-bs-custom-class="custom-tooltip">
                            </i>
                        </td>
                    </tr>
                    <!-- On ajout le html de la modale à la vaiable $modals -->
                    <?php $modals .= "
                        <div class='modal fade modal-suspend-user' id='suspendUserConfirm{$user['id']}' tabindex='-1' aria-labelledby='suspendUserConfirmLabel' aria-hidden='true'>
                            <div class='modal-dialog modal-dialog-centered'>
                                <div class='modal-content bg-light'>
                                    <div class='btn-close-div'>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                    </div>
                                    <form method='post' class='gap-4 suspend-user-form'>
                                        <input type='hidden' name='id' value='{$user['id']}'>
                                        <label class='content-text text-center fw-medium'>
                                            Voulez-vous vraiment suspendre le compte de <br>
                                            <strong>{$user['pseudo']}</strong>
                                            ({$user['mail']}) ?
                                         </label>
                                        <div class='d-flex gap-3 justify-content-center'>
                                            <input type='submit' class='btn btn-danger text-white small-text secondary-btn' value='Confirmer' name='suspendUser'>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>";
                    ?>
                <?php } ?>
            </tbody>
        </table>

    </div>
</section>
<!-- Section avec toutes les modales générées -->
<!-- Il faut appeler la modal en dehors de la table générée par DataTable, afin d'eviter des erreurs -->
<section>
    <!-- Appèl des modales -->
    <?= $modals ?>
</section>


<?php
// FOOTER
require_once  BASE_PATH . '/Templates/footer.php';
?>