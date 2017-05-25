#!/bin/bash

directory=/var/www/www.369cms.com/htmlsafe/custom_cron/hourly
logfile=$directory/cron.log

for file in $( find $directory -type f -name '*.php' | sort )
do
	date >> $logfile
	echo $file >> $logfile
	echo "--------" >> $logfile
	/usr/bin/php $file >> $logfile
done  

exit $?
