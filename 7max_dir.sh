#!/bin/bash
LOCATION=/root/test
#FILECOUNT=$(find $LOCATION -mindepth 1 -maxdepth 1 -type f | wc -l)
DIRCOUNT=$(find $LOCATION -mindepth 1 -maxdepth 1 -type d | wc -l)
#echo " files are: $FILECOUNT "
echo "directories are: $DIRCOUNT "

for ((a=$DIRCOUNT; a>7; a--))
do
DIRNAME=$(ls -t1 $LOCATION | tail -n 1)
 echo "Directory LOcation : $LOCATION/$DIRNAME"
 sudo rm -rf $LOCATION/$DIRNAME
 echo "Directory Name : $DIRNAME"
 echo " $DIRNAME is delete"
 DIRCOUNT=$(find $LOCATION -mindepth 1 -maxdepth 1 -type d | wc -l)

echo  "Reset-directories are : $DIRCOUNT "
done
echo "it needs more backup"




   
