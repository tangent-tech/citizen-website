<?php

	if (strpos(getcwd(), 'client16/web60') > 0) {
		echo "Demo Codebase: " . getcwd();
	}
	elseif (strpos(getcwd(), 'client16/web50') > 0) {
		echo "Production Codebase: " . getcwd();
	}
?>
