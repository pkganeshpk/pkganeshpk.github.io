for file in *.tex; do	
	echo $file;	
	png=$(echo $file | sed  's/tex/png/')
	pdf=$(echo $file | sed 's/tex/pdf/')
	rm -f $png;
	pdflatex $file;
	convert -density 150 $pdf -quality 90   $png; 

done
