make:
	cd antshs/Figs && bash make.bash
	cd bcover-conn/Figs bash make.bash
	#cd bcover-multi/Figs && bash make.bash
	php index.php > index.html
	#cp * -r /var/www/html/talk
