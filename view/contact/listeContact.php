<?php if (isset($error)): ?>
	<p class="error">
		<?php echo $error; ?>
	</p>
<?php endif;

echo '<div class="infos">';
if (isset($tab_cont) && isset($tab_cont[0])){
	echo "<table class='liste'>
  <caption>Liste des contacts</caption>
  <thead>
        <tr>
            <th scope='col'>Nom</th>
            <th scope='col'>Prenom</th>
            <th scope='col'>Téléphone</th>
            <th scope='col'>Mail</th>
            <th scope ='col'>Poste</th>
            <th scope ='col'>Privilégié</th>
            <th scope ='col'>Modification</th>
            <th scope ='col'>Suppression</th>
        </tr>
    </thead>
    
    <tbody>";
	foreach ($tab_cont as $contact) {
        $numContact = htmlspecialchars($contact->getNumContact());
        $numEditeur = htmlspecialchars($contact->getNumEditeur());
		$nomContact = htmlspecialchars($contact->getNomContact());
        $prenomContact = htmlspecialchars($contact->getPrenomContact());
        $mailContact = htmlspecialchars($contact->getMailContact());
        $telContact = htmlspecialchars($contact->getTelContact());
        $posteContact = htmlspecialchars($contact->getPoste());
		$estPrivilegie = htmlspecialchars($contact->getEstPrivilegie());
		if($estPrivilegie){
			$estPrivilegie = "oui";
		}else{
			$estPrivilegie = "non";
		}
        
        echo "<tr>
                <td data-label='nomContact'> " . $nomContact . " </td>
                <td data-label='prenomContact'> " . $prenomContact . " </td>
                <td data-label='telContact'> " . $telContact . " </td>
                <td data-label='mailContact'> " . $mailContact ."</td>
                <td data-label='posteContact'> " . $posteContact . " </td>
                <td data-label='privilégie'> " . $estPrivilegie .'</td>
                <td><p><a class="edit-button-table" href="index.php?controller=contact&action=update&numContact=' . rawurlencode($numContact) . '"> Modifier</a></td>' .
            '<td><a class="edit-button-suppr" href="index.php?controller=contact&action=delete&numContact=' . rawurlencode($numContact) . '"> Supprimer</a></td>
            </tr>';
	};
}else{
	echo"<h2>Vous n'avez pas de contact</h2>  ";
}
?>
<br>
<a href="index.php?controller=contact&action=addContact&numEditeur=<?php echo htmlspecialchars($_GET['numEditeur']); ?> ">Ajouter un contact</a>
<?php 
echo '<br><a href=index.php?controller=editeur&action=readEditeur&numEditeur=' . rawurldecode($numEditeur) .'> retour </a>';

echo '</div>'?>