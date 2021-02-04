<?php

$profile_id = $_GET['id'];

if (!empty($profile_id)) {
	/*ladda templatefilen för profil*/
	echo "string";
} else {
	/*ifall inget id bara redirecta till main filen*/
	header('location: /');
}