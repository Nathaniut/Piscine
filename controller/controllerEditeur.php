<?php
	require_once File::buildPath(array('model', 'modelEditeur.php'));

	class ControllerEditeur {

		public static function readAllEditeur() {
			$tab_edit = ModelEditeur::getAllEditeurs();     //appel au modèle pour gerer la BD
			$controller = "editeur";
			$view = "listeEditeur";
			$title = "Liste des editeurs";
			require File::buildPath(array("view", "view.php")); //"redirige" vers la vue
		}

		public static function readEditeur(){
			$editeur = ModelEditeur::getEditeurByNum($_GET['numEditeur']);
	        if ($editeur == false) {
	            $controller = "editeur";
	            $view = "listeEditeur";
	            $error = "Cet editeur n'existe pas !";
	            $title = "Liste des éditeurs";
	            $tab_edit = ModelEditeur::getAllEditeurs();
	            require File::buildPath(array("view", "view.php"));
	        } else {
	            $controller = "editeur";
	            $view = "detailEditeur";
	            $title = "Détails éditeur";
	            require File::buildPath(array("view", "view.php"));
	        }
		}
		
		public static function addEditeur(){
			$controller = "editeur";
			$view = "addEditeur";
			$title = "Ajouter un éditeur";
			require File::buildPath(array("view","view.php"));
		}

		public static function getLastEditeur(){
			return ModelEditeur::getLastNumEditeur();
		}
		
		public static function registerEditeur(){
			$controller = "editeur";
			$view = "listeEditeur";
			$title = "Liste éditeurs";
			if(isset($_POST['nbrJeux'])){
				$nbrJeux = $_POST['nbrJeux'];
			}else{
				$nbrJeux = 0;
			}
			$editeur = new ModelEditeur($_POST['nomEditeur'], $_POST['mailEditeur'], $_POST['telEditeur'], $_POST['siteEditeur'], $_POST['comEditeur'], $nbrJeux);
			$editeur->save();
			$tab_edit = ModelEditeur::getAllEditeurs();


			//On regarde si on vient d'une popup ou non
			if(isset($_POST['popupJS']) && $_POST['popupJS'] == true){
				$lastNum = ModelEditeur::getLastNumEditeur();
				echo $lastNum[0];
				return 0;
			}else{
				require File::buildPath(array("view", "view.php"));
				return 0;
			}
		}
		
		public static function delete() {
			if (!empty(ModelEditeur::getEditeurByNum($_GET['numEditeur']))){
				if(empty(ModelAvoir::getAllJeuxByEditeur($_GET['numEditeur']))){
					$editeur = ModelEditeur::getEditeurByNum($_GET['numEditeur']);
					$editeur->deleteEditeur();
				}else{
					$error = "Cet édieur possède des jeux !";
				}
			}else{$error = "Cet editeur n'existe pas !";}		
			$controller = "editeur";
			$view = "listeEditeur";
			$title = "Liste des éditeurs";
			$tab_edit = ModelEditeur::getAllEditeurs();
			require File::buildPath(array("view", "view.php"));
		} 

		public static function update(){
			if (!empty(ModelEditeur::getEditeurByNum($_GET['numEditeur']))){
				$controller = "editeur";
				$view = "updateEditeur";
				$title = "Modifier un éditeur";
				$editeur = ModelEditeur::getEditeurByNum($_GET['numEditeur']);
				require File::buildPath(array("view", "view.php"));
				return 0; 		
			}else{		
				$error = "Cet editeur n'existe pas !";
			}
			$controller = "editeur";
			$view = "listeEditeur";
			$title = "Liste des éditeurs";
			$tab_edit = ModelEditeur::getAllEditeurs();
			require File::buildPath(array("view", "view.php"));
			return 0;
		}

		public static function updateEditeur(){
			if (!empty(ModelEditeur::getEditeurByNum($_GET['numEditeur']))){
				$editeur = new ModelEditeur($_POST['nomEditeur'], $_POST['mailEditeur'], $_POST['telEditeur'], $_POST['siteEditeur'], $_POST['comEditeur'], $_POST['nbrJeux']);
				$editeur->update($_GET['numEditeur']);
				$tab_edit = ModelEditeur::getAllEditeurs();
				$controller = "editeur";
				$view = "listeEditeur";
				$title = "Liste éditeurs";
				require File::buildPath(array("view", "view.php"));
				return 0;
			}else{
				$error = "Cet editeur n'existe pas !";
			}
			$tab_edit = ModelEditeur::getAllEditeurs();
			$controller = "editeur";
			$view = "listeEditeur";
			$title = "Liste éditeurs";
			require File::buildPath(array("view", "view.php"));
			return 0;
		}
	}
?>