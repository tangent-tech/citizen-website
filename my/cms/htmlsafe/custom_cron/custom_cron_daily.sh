#!/bin/bash

directory=/var/www/www.369cms.com/htmlsafe/custom_cron/daily
logfile=$directory/cron.log

for file in $( find $directory -type f -name '*.php' | sort )
do
	date >> $logfile
	echo $file >> $logfile
	echo "--------" >> $logfile
	/usr/bin/php $file >> $logfile
	#strings -f $file | grep "$fstring" | sed -e "s%$directory%%"
	#  In the "sed" expression,
	#+ it is necessary to substitute for the normal "/" delimiter
	#+ because "/" happens to be one of the characters filtered out.
	#  Failure to do so gives an error message. (Try it.)
done  

exit $?

#  Exercise (easy):
#  ---------------
#  Convert this script to take command-line parameters
#+ for $directory and $fstring.