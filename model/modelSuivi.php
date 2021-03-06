<?php
require_once File::buildPath(array('model', 'model.php'));

class ModelSuivi {
	private $numSuivi;
	private $date;
	private $relance;
	private $cr;
	private $interesse;
	private $present;
	private $commentaire;
	private $numEditeur;
	private $facture;
	private $idFestival;

	public function getNumSuivi(){
		return $this->numSuivi;
	}

	public function getDateSuivi(){
		return $this->datePremierContact;
	}

	public function getRelance(){
		return $this->relanceContact;
	}

	public function getCR(){
		return $this->compteRendu;
	}

	public function getInteresse(){
		return $this->interesse;
	}

	public function getEstPresent(){
		return $this->estPresent;
	}

	public function getCommentaire(){
		return $this->commentaire;
	}

	public function getNumEditeur(){
		return $this->numEditeur;
	}

	public function getFacture(){
		return $this->facture;
	}

	public function getIdFestival(){
		return $this->idFestival;
	}

	// un constructeur
	public function __construct($date = NULL, $relance = NULL, $cr = NULL, $interesse = NULL, $present = NULL, $commentaire = NULL, $numEditeur = NULL, $facture = NULL, $idFestival = NULL) {
		if (!is_null($date) && !is_null($relance) && !is_null($cr) && !is_null($interesse) && !is_null($present) && !is_null($commentaire) && !is_null($numEditeur) && !is_null($facture) && !is_null($idFestival)) {
			$this->datePremierContact = $date;
			$this->relanceContact = $relance;
			$this->compteRendu = $cr;
			$this->interesse = $interesse;
			$this->estPresent = $present;
		    $this->commentaire = $commentaire;
		    $this->numEditeur = $numEditeur;
			$this->facture = $facture;
			$this->idFestival = $idFestival;
		}
	}

	static public function getSuiviByNum($numSuivi) {
		$sql = "SELECT * from suivi WHERE numSuivi=:num_suivi";
		try {
	            // Préparation de la requête
			$req_prep = Model::$pdo->prepare($sql);

			$values = array(
				"num_suivi" => $numSuivi,
			);
	            // On donne les valeurs et on exécute la requête
			$req_prep->execute($values);

			$req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelSuivi');
			$tab_prod = $req_prep->fetchAll();
		} catch (PDOException $e) {
			echo('Error tout casse ( /!\ method getSuiviByNum() /!\ )');
		}

        // Attention, si il n'y a pas de résultats, on renvoie false
		if (empty($tab_prod)) {
			return false;
		}

		return $tab_prod[0];
	}

	public function save() {
		$sql = "INSERT INTO suivi (datePremierContact, relanceContact, compteRendu, interesse, estPresent, commentaire, numEditeur, facture, idFestival) VALUES (:datePremierContact_tag, :relanceContact_tag, :compteRendu_tag, :interesse_tag, :estPresent_tag, :commentaire_tag, :num_Editeur, :facture_tag, :idFestival)";

		try {
			$req_prep = Model::$pdo->prepare($sql);
			$values = array(
				"datePremierContact_tag" => $this->getDateSuivi(),
				"relanceContact_tag" => $this->getRelance(),
				"compteRendu_tag" => $this->getCR(),
				"interesse_tag" => $this->getInteresse(),
		        "estPresent_tag" => $this->getEstPresent(),
		        "commentaire_tag" => $this->getCommentaire(),
				"num_Editeur" => $this->getNumEditeur(),
				"facture_tag" => $this->getFacture(),
				"idFestival" => $this->getIdFestival(),
			);
			$req_prep->execute($values);
		} catch (PDOException $e) {
			echo('Error tout casse ( /!\ methode save /!\ )' . $e);
		}
	}

	public function deleteSuivi() {
		$sql = "DELETE FROM suivi WHERE suivi.numSuivi = :num_suivi";
		try {
			$req_prep = Model::$pdo->prepare($sql);
			$values = array(
				"num_suivi" => $this->getNumSuivi(),
			);
			$req_prep->execute($values);
		} catch (PDOException $e) {
			echo('Error tout casse ( /!\ method delete /!\ )');
		}
	}

	public function update($numSuivi){
		$sql = "UPDATE suivi SET suivi.datePremierContact = :datePremierContact_tag,
								   suivi.relanceContact = :relanceContact_tag,
								   suivi.compteRendu = :compteRendu_tag,
								   suivi.interesse = :interesse_tag,
								   suivi.estPresent = :estPresent_tag,
                   				   suivi.commentaire = :commentaire_tag,
								   suivi.facture = :facture_tag,
								   suivi.idFestival = :idFestival_tag
							 WHERE suivi.numSuivi = :num_suivi";
		try {
			$req_prep = Model::$pdo->prepare($sql);
			$values = array(
        		"datePremierContact_tag" => $this->getDateSuivi(),
				"relanceContact_tag" => $this->getRelance(),
				"compteRendu_tag" => $this->getCR(),
				"interesse_tag" => $this->getInteresse(),
				"estPresent_tag" => $this->getEstPresent(),
				"commentaire_tag" => $this->getCommentaire(),
				"num_suivi" => $numSuivi,
				"facture_tag" => $this->getFacture(),
				"idFestival_tag" => $this->getIdFestival(),
			);
			$req_prep->execute($values);
		} catch (PDOException $e) {
			echo('Error tout casse ( /!\ method update /!\ )' . $e);
		}
	}

	public static function getLastNumSuivi(){
		try {
			$rep = Model::$pdo->query('SELECT MAX(numSuivi) FROM suivi');
			$maxNum = $rep->fetch();
			return $maxNum;
		} catch (PDOException $e) {
			echo('Error tout casse ( /!\ method getAllEditeurs() /!\ )');
		}
	}

	static public function getNumSuiviByNumEditeur($numEditeur) {
		$sql = "SELECT numSuivi from suivi WHERE numEditeur=:num_editeur AND idFestival = :idFestival";
		try {
							// Préparation de la requête
			$req_prep = Model::$pdo->prepare($sql);

			$values = array(
				"num_editeur" => $numEditeur,
				"idFestival" => $_SESSION['idFestival'],
			);
							// On donne les valeurs et on exécute la requête
			$req_prep->execute($values);

			$req_prep->setFetchMode(PDO::FETCH_ASSOC);
			$result = $req_prep->fetch();
			$numSuivi = $result['numSuivi'];
		} catch (PDOException $e) {
			echo('Error tout casse ( /!\ method getSuiviByNum() /!\ )');
		}
				// Attention, si il n'y a pas de résultats, on renvoie false
		if (empty($numSuivi)) {
			return false;
		}

		return $numSuivi;
		}

		static public function getNomEditeurByNumSuivi($numSuivi) {
			$sql = "SELECT nomEditeur from suivi,editeur WHERE suivi.numSuivi=:num_suivi AND suivi.numEditeur = editeur.numEditeur LIMIT 1";
			try {
								// Préparation de la requête
				$req_prep = Model::$pdo->prepare($sql);

				$values = array(
					"num_suivi" => $numSuivi,
				);
								// On donne les valeurs et on exécute la requête
				$req_prep->execute($values);

				$req_prep->setFetchMode(PDO::FETCH_ASSOC);
				$result = $req_prep->fetch();
				$nomEditeur = $result['nomEditeur'];
			} catch (PDOException $e) {
				echo('Error tout casse ( /!\ method getNomEditeurByNumSuivi() /!\ )');
			}
					// Attention, si il n'y a pas de résultats, on renvoie false
			if (empty($nomEditeur)) {
				return false;
			}

			return $nomEditeur;
			}

	static public function getEditeurInteresseByNum($numEditeur) {
			$sql = "SELECT interesse from suivi WHERE suivi.numEditeur=:num_editeur";
			try {
								// Préparation de la requête
				$req_prep = Model::$pdo->prepare($sql);

				$values = array(
					"num_editeur" => $numEditeur,
				);
								// On donne les valeurs et on exécute la requête
				$req_prep->execute($values);

				$req_prep->setFetchMode(PDO::FETCH_ASSOC);
				$result = $req_prep->fetch();
				$interesse = $result['interesse'];
			} catch (PDOException $e) {
				echo('Error tout casse ( /!\ method getEditeurInteresseByNum() /!\ )');
			}
		return $interesse;
	}

    static public function getAllSuivis() {
		try {
			$rep = Model::$pdo->query('SELECT * FROM suivi where idFestival =' . $_SESSION['idFestival']);
			$rep->setFetchMode(PDO::FETCH_CLASS, 'ModelSuivi');
			$tab_suivi = $rep->fetchAll();
			return $tab_suivi;
		} catch (PDOException $e) {
			echo('Error tout casse ( /!\ method getAllSuivis() /!\ )');
		}
	}
}

?>
